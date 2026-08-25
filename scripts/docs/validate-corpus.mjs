import { mkdir, readdir, readFile, rm, writeFile } from 'node:fs/promises';
import path from 'node:path';

const root = process.cwd();
const docsRoot = path.join(root, 'docs');
const outputRoot = path.join(docsRoot, '19-rag', 'generated');
const requiredMetadata = [
  'document_id',
  'title',
  'document_type',
  'domain',
  'version',
  'status',
  'authority',
  'canonicality',
  'updated_at',
];
const allowedStatuses = new Set([
  'DRAFT',
  'PROPOSED',
  'APPROVED',
  'SUPERSEDED',
  'DEPRECATED',
  'ARCHIVED',
]);
const requirementPattern = /\b(?:PRIN|PROD|ACCESS|NEUR|INV|CLAIM|EVID|OBS|PAY|ARCH|API|DATA|AUTHN|AUTHZ|WEB3|SEC|AUDIT|SEARCH|TEST|DEPLOY|RAG|AGENT|GOV-EXEC)-[A-Z0-9-]*\d{3}\b/g;
const decisionPattern = /\bDEC-\d{3}\b/g;
const markdownLinkPattern = /\[[^\]]*\]\(([^)#][^)]*)\)/g;

async function markdownFiles(directory) {
  const entries = await readdir(directory, { withFileTypes: true });
  const nested = await Promise.all(entries.map(async (entry) => {
    const item = path.join(directory, entry.name);
    if (entry.isDirectory()) return markdownFiles(item);
    return entry.isFile() && entry.name.endsWith('.md') ? [item] : [];
  }));
  return nested.flat();
}

function parseFrontmatter(content) {
  if (!content.startsWith('---\n')) return {};
  const end = content.indexOf('\n---', 4);
  if (end === -1) return {};
  return Object.fromEntries(content.slice(4, end).split('\n')
    .filter((line) => line.includes(':'))
    .map((line) => {
      const [key, ...value] = line.split(':');
      return [key.trim(), value.join(':').trim().replace(/^"|"$/g, '')];
    }));
}

function matches(pattern, text) {
  return [...text.matchAll(pattern)].map((match) => match[0]);
}

const files = await markdownFiles(docsRoot);
const inventory = [];
const idMap = new Map();
const requirementUse = new Map();
const decisionUse = new Map();
const brokenLinks = [];

for (const file of files) {
  const content = await readFile(file, 'utf8');
  const metadata = parseFrontmatter(content);
  const relativePath = path.relative(root, file).replaceAll(path.sep, '/');
  const missingMetadata = requiredMetadata.filter((key) => !metadata[key]);
  const requirements = [...new Set(matches(requirementPattern, content))];
  const decisions = [...new Set(matches(decisionPattern, content))];
  for (const match of content.matchAll(markdownLinkPattern)) {
    const target = match[1].replace(/<|>/g, '');
    if (target.startsWith('http://') || target.startsWith('https://') || target.startsWith('mailto:')) continue;
    const targetPath = path.resolve(path.dirname(file), target.split('#')[0]);
    try {
      await readFile(targetPath);
    } catch {
      brokenLinks.push({ path: relativePath, target });
    }
  }
  const entry = {
    path: relativePath,
    document_id: metadata.document_id ?? null,
    title: metadata.title ?? null,
    document_type: metadata.document_type ?? null,
    domain: metadata.domain ?? null,
    version: metadata.version ?? null,
    status: metadata.status ?? null,
    authority: metadata.authority ?? null,
    canonicality: metadata.canonicality ?? null,
    requirements,
    decisions,
    supersedes: metadata.supersedes ?? null,
    superseded_by: metadata.superseded_by ?? null,
    security_classification: metadata.security_classification ?? null,
    missing_metadata: missingMetadata,
    status_valid: allowedStatuses.has(metadata.status),
  };
  inventory.push(entry);
  if (entry.document_id) idMap.set(entry.document_id, [...(idMap.get(entry.document_id) ?? []), relativePath]);
  for (const requirement of requirements) requirementUse.set(requirement, [...(requirementUse.get(requirement) ?? []), relativePath]);
  for (const decision of decisions) decisionUse.set(decision, [...(decisionUse.get(decision) ?? []), relativePath]);
}

const duplicateDocumentIds = [...idMap.entries()]
  .filter(([, paths]) => paths.length > 1)
  .map(([id, paths]) => ({ id, paths }));
const invalidStatus = inventory.filter((entry) => !entry.status_valid).map((entry) => entry.path);
const missingMetadata = inventory.filter((entry) => entry.missing_metadata.length > 0)
  .map((entry) => ({ path: entry.path, missing: entry.missing_metadata }));
const missingSupersessionTargets = inventory
  .filter((entry) => entry.supersedes && !idMap.has(entry.supersedes))
  .map((entry) => ({ path: entry.path, supersedes: entry.supersedes }));

const report = {
  generated_at: new Date().toISOString(),
  source_commit: process.env.GIT_COMMIT ?? 'working-tree',
  document_count: inventory.length,
  approved_count: inventory.filter((entry) => entry.status === 'APPROVED').length,
  proposed_count: inventory.filter((entry) => entry.status === 'PROPOSED').length,
  draft_count: inventory.filter((entry) => entry.status === 'DRAFT').length,
  missing_required_metadata_count: missingMetadata.length,
  duplicate_document_ids: duplicateDocumentIds,
  invalid_status_documents: invalidStatus,
  missing_supersession_targets: missingSupersessionTargets,
  broken_internal_links: brokenLinks,
  requirement_ids_observed: requirementUse.size,
  decision_ids_observed: decisionUse.size,
};

await rm(outputRoot, { recursive: true, force: true });
await mkdir(outputRoot, { recursive: true });
await writeFile(path.join(outputRoot, 'corpus-inventory.json'), `${JSON.stringify(inventory, null, 2)}\n`);
await writeFile(path.join(outputRoot, 'validation-report.json'), `${JSON.stringify(report, null, 2)}\n`);

console.log(JSON.stringify(report, null, 2));
if (missingMetadata.length || duplicateDocumentIds.length || invalidStatus.length || missingSupersessionTargets.length || brokenLinks.length) {
  process.exitCode = 1;
}
