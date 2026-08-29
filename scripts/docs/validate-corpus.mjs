import { mkdir, readFile, readdir, writeFile } from 'node:fs/promises';
import path from 'node:path';

const root = process.cwd();
const docsRoot = path.join(root, 'docs');
const generatedRoot = path.join(docsRoot, '19-rag', 'generated');
const today = new Date().toISOString();

const requiredMetadataFields = [
  'document_id',
  'title',
  'document_type',
  'domain',
  'version',
  'status',
  'authority',
  'canonicality',
  'effective_from',
  'created_at',
  'updated_at',
  'supersedes',
  'superseded_by',
  'related_documents',
  'requirement_ids',
  'decision_ids',
  'tags',
  'security_classification',
  'rag_priority',
];

const allowedStatuses = new Set(['DRAFT', 'PROPOSED', 'APPROVED', 'SUPERSEDED', 'DEPRECATED', 'ARCHIVED']);
const allowedCanonicality = new Set(['CURRENT_CANONICAL', 'SUPERSEDED', 'DEPRECATED', 'ARCHIVED', 'NON_NORMATIVE_REFERENCE']);
const allowedAuthorities = new Set(['CANONICAL_NORMATIVE', 'CANONICAL_REFERENCE', 'NON_NORMATIVE_REFERENCE']);

function parseFrontmatter(content) {
  if (!content.startsWith('---\n')) return { frontmatter: {}, body: content };
  const end = content.indexOf('\n---\n', 4);
  if (end === -1) return { frontmatter: {}, body: content };
  const frontmatter = {};
  for (const line of content.slice(4, end).split('\n')) {
    const match = line.match(/^([A-Za-z0-9_]+):\s*(.*)$/);
    if (!match) continue;
    const key = match[1];
    const value = match[2].trim();
    if (!value) {
      frontmatter[key] = '';
      continue;
    }
    if (value.startsWith('[') && value.endsWith(']')) {
      try {
        frontmatter[key] = JSON.parse(value);
        continue;
      } catch {
        frontmatter[key] = value;
        continue;
      }
    }
    if ((value.startsWith('"') && value.endsWith('"')) || (value.startsWith("'") && value.endsWith("'"))) {
      frontmatter[key] = value.slice(1, -1);
    } else {
      frontmatter[key] = value;
    }
  }
  return { frontmatter, body: content.slice(end + 5) };
}

function normalizeArray(value) {
  if (Array.isArray(value)) return value;
  if (value === undefined || value === null || value === '') return [];
  return [value];
}

function requiredMissing(value) {
  if (value === undefined || value === null) return true;
  if (typeof value === 'string') return value.trim() === '';
  return false;
}

function extractIds(pattern, text) {
  return [...new Set([...text.matchAll(pattern)].map((match) => match[0]))];
}

async function walk(directory) {
  const entries = await readdir(directory, { withFileTypes: true });
  const collected = [];
  for (const entry of entries) {
    const item = path.join(directory, entry.name);
    if (entry.isDirectory()) {
      if (item.endsWith(path.join('docs', '19-rag', 'generated'))) continue;
      collected.push(...await walk(item));
      continue;
    }
    if (entry.isFile() && entry.name.endsWith('.md') && !item.includes(path.sep + 'generated' + path.sep)) {
      collected.push(item);
    }
  }
  return collected;
}

function inferTitle(body, relativePath) {
  const heading = body.match(/^#\s+(.+)$/m);
  if (heading) return heading[1].trim();
  return path.basename(relativePath, '.md').replace(/[-_]/g, ' ');
}

function inferDocumentType(relativePath, title) {
  if (relativePath.startsWith('docs/adr/')) return 'ADR';
  if (/report|validation|readiness|inventory|manifest|evaluation|gap|promotion|consistency/i.test(title)) return 'REPORT';
  if (/template/i.test(title)) return 'TEMPLATE';
  if (/instruction|prompt/i.test(title)) return 'GUIDE';
  if (/architecture/i.test(title)) return 'ARCHITECTURE';
  if (/contract|boundary|spec|specification/i.test(title)) return 'SPEC';
  if (/policy|protocol/i.test(title)) return 'POLICY';
  if (/model/i.test(title)) return 'SPEC';
  if (/matrix|index|registry|bundle|taxonomy|dictionary|schema/i.test(title)) return 'CONTRACT';
  return 'SPEC';
}

function inferDomain(relativePath) {
  const parts = relativePath.split('/');
  if (parts[1] === 'adr') return 'adr';
  return parts[1] || 'root';
}

async function main() {
  const files = await walk(docsRoot);
  const inventory = [];
  const byId = new Map();
  const duplicateDocumentIds = [];
  const requirementRefs = new Map();
  const decisionRefs = new Map();

  for (const file of files) {
    const relativePath = path.relative(root, file).replaceAll(path.sep, '/');
    const content = await readFile(file, 'utf8');
    const { frontmatter, body } = parseFrontmatter(content);
    const title = frontmatter.title || inferTitle(body, relativePath);
    const documentType = frontmatter.document_type || inferDocumentType(relativePath, title);
    const domain = frontmatter.domain || inferDomain(relativePath);
    const metadata = {
      document_id: frontmatter.document_id || '',
      title,
      document_type: documentType,
      domain,
      version: frontmatter.version || '',
      status: frontmatter.status || '',
      authority: frontmatter.authority || '',
      canonicality: frontmatter.canonicality || '',
      effective_from: frontmatter.effective_from || '',
      created_at: frontmatter.created_at || '',
      updated_at: frontmatter.updated_at || '',
      supersedes: normalizeArray(frontmatter.supersedes),
      superseded_by: normalizeArray(frontmatter.superseded_by),
      related_documents: normalizeArray(frontmatter.related_documents),
      requirement_ids: normalizeArray(frontmatter.requirement_ids),
      decision_ids: normalizeArray(frontmatter.decision_ids),
      tags: normalizeArray(frontmatter.tags),
      security_classification: frontmatter.security_classification || '',
      rag_priority: frontmatter.rag_priority === undefined ? '' : frontmatter.rag_priority,
    };

    const missing = requiredMetadataFields.filter((field) => requiredMissing(metadata[field]));
    const entry = {
      path: relativePath,
      ...metadata,
      missing_required_metadata: missing,
      body_heading: body.match(/^#{1,6}\s+(.+)$/m)?.[1]?.trim() || title,
      active: metadata.canonicality === 'CURRENT_CANONICAL',
    };

    if (byId.has(entry.document_id)) duplicateDocumentIds.push(entry.document_id);
    byId.set(entry.document_id, entry);
    inventory.push(entry);

    for (const requirementId of extractIds(/\b(?:PRIN|PROD|ACCESS|NEUR|INV|CLAIM|EVID|OBS|PAY|ARCH|API|DATA|AUTHN|AUTHZ|WEB3|SEC|AUDIT|SEARCH|TEST|DEPLOY|RAG|AGENT|GOV-EXEC)-[A-Z0-9-]*\d{3}\b/g, content)) {
      if (!requirementRefs.has(requirementId)) requirementRefs.set(requirementId, []);
      requirementRefs.get(requirementId).push(entry.document_id);
    }
    for (const decisionId of extractIds(/\bDEC-\d{3}\b/g, content)) {
      if (!decisionRefs.has(decisionId)) decisionRefs.set(decisionId, []);
      decisionRefs.get(decisionId).push(entry.document_id);
    }
  }

  inventory.sort((a, b) => a.path.localeCompare(b.path));

  const unresolvedSupersessionTargets = [];
  for (const doc of inventory) {
    for (const target of doc.supersedes) {
      if (!byId.has(target)) {
        unresolvedSupersessionTargets.push({ path: doc.path, target });
      }
    }
  }

  const invalidStatusDocuments = inventory.filter((doc) => !allowedStatuses.has(doc.status)).map((doc) => doc.path);
  const invalidCanonicalityDocuments = inventory.filter((doc) => !allowedCanonicality.has(doc.canonicality)).map((doc) => doc.path);
  const invalidAuthorityDocuments = inventory.filter((doc) => !allowedAuthorities.has(doc.authority)).map((doc) => doc.path);
  const missingRequiredMetadata = inventory.filter((doc) => doc.missing_required_metadata.length > 0);

  const requirementRegistryPath = path.join(docsRoot, '00-governance', 'requirement-registry.json');
  const bundleRegistryPath = path.join(docsRoot, '19-rag', 'retrieval-bundles.json');
  const openDecisionsPath = path.join(docsRoot, '00-governance', 'open-decisions.md');

  const requirementRegistry = JSON.parse(await readFile(requirementRegistryPath, 'utf8'));
  const bundleRegistry = JSON.parse(await readFile(bundleRegistryPath, 'utf8'));
  const openDecisionDoc = await readFile(openDecisionsPath, 'utf8');
  const openDecisionIds = extractIds(/\bDEC-\d{3}\b/g, openDecisionDoc);

  const duplicateRequirementIds = [];
  const requirementOwners = new Map();
  const requirementProblems = [];
  for (const entry of requirementRegistry) {
    if (requirementOwners.has(entry.requirement_id)) duplicateRequirementIds.push(entry.requirement_id);
    requirementOwners.set(entry.requirement_id, entry);
    if (!byId.has(entry.owner_document)) {
      requirementProblems.push({ requirement_id: entry.requirement_id, problem: 'missing_owner_document', owner_document: entry.owner_document });
    }
    if (entry.status !== 'ACTIVE' && entry.status !== 'LEGACY_REFERENCE') {
      requirementProblems.push({ requirement_id: entry.requirement_id, problem: 'inactive_requirement', status: entry.status });
    }
  }

  const duplicateBundleIds = [];
  const bundleIds = new Set();
  const bundleProblems = [];
  for (const bundle of bundleRegistry) {
    if (bundleIds.has(bundle.bundle_id)) duplicateBundleIds.push(bundle.bundle_id);
    bundleIds.add(bundle.bundle_id);
    for (const requiredDoc of bundle.documents?.required || []) {
      if (!byId.has(requiredDoc.document_id)) {
        bundleProblems.push({ bundle_id: bundle.bundle_id, problem: 'missing_document', document_id: requiredDoc.document_id });
      }
    }
    for (const decisionId of bundle.decisions?.required || []) {
      if (!openDecisionIds.includes(decisionId)) {
        bundleProblems.push({ bundle_id: bundle.bundle_id, problem: 'missing_decision', decision_id: decisionId });
      }
    }
    for (const requirementId of bundle.requirements || []) {
      if (!requirementOwners.has(requirementId)) {
        bundleProblems.push({ bundle_id: bundle.bundle_id, problem: 'missing_requirement', requirement_id: requirementId });
      }
    }
  }

  const observedDecisionIds = [...decisionRefs.keys()].sort();
  const unknownDecisionIds = observedDecisionIds.filter((id) => !openDecisionIds.includes(id));

  const report = {
    generated_at: today,
    source_commit: process.env.GIT_COMMIT || 'working-tree',
    document_count: inventory.length,
    approved_count: inventory.filter((entry) => entry.status === 'APPROVED').length,
    proposed_count: inventory.filter((entry) => entry.status === 'PROPOSED').length,
    draft_count: inventory.filter((entry) => entry.status === 'DRAFT').length,
    superseded_count: inventory.filter((entry) => entry.status === 'SUPERSEDED').length,
    missing_required_metadata_count: missingRequiredMetadata.length,
    duplicate_document_ids: [...new Set(duplicateDocumentIds)],
    invalid_status_documents: invalidStatusDocuments,
    invalid_canonicality_documents: invalidCanonicalityDocuments,
    invalid_authority_documents: invalidAuthorityDocuments,
    missing_supersession_targets: unresolvedSupersessionTargets,
    duplicate_requirement_ids: [...new Set(duplicateRequirementIds)],
    requirement_registry_problems: requirementProblems,
    duplicate_bundle_ids: [...new Set(duplicateBundleIds)],
    bundle_problems: bundleProblems,
    unknown_decision_ids: unknownDecisionIds,
    open_decision_count: openDecisionIds.length,
    requirement_registry_size: requirementRegistry.length,
    bundle_registry_size: bundleRegistry.length,
    production_corpus_count: inventory.filter((entry) => entry.status === 'APPROVED' && entry.canonicality === 'CURRENT_CANONICAL').length,
    review_corpus_count: inventory.filter((entry) => entry.status === 'PROPOSED' || entry.status === 'DRAFT').length,
  };

  await mkdir(generatedRoot, { recursive: true });
  await writeFile(path.join(generatedRoot, 'validation-report.json'), JSON.stringify(report, null, 2) + '\n');
  await writeFile(path.join(generatedRoot, 'corpus-inventory.json'), JSON.stringify(inventory, null, 2) + '\n');

  const blocking =
    report.missing_required_metadata_count > 0 ||
    report.duplicate_document_ids.length > 0 ||
    report.invalid_status_documents.length > 0 ||
    report.invalid_canonicality_documents.length > 0 ||
    report.invalid_authority_documents.length > 0 ||
    report.missing_supersession_targets.length > 0 ||
    report.duplicate_requirement_ids.length > 0 ||
    report.requirement_registry_problems.length > 0 ||
    report.duplicate_bundle_ids.length > 0 ||
    report.bundle_problems.length > 0 ||
    report.unknown_decision_ids.length > 0;

  console.log(JSON.stringify(report, null, 2));
  if (blocking) process.exitCode = 1;
}

await main();
