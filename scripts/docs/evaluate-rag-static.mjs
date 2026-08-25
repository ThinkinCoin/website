import { mkdir, readFile, rm, writeFile } from 'node:fs/promises';
import path from 'node:path';

const root = process.cwd();
const cases = [
  {
    id: 'RAG-EVAL-CRIT-001',
    query: 'Can Evidence be Confirmed?',
    file: 'docs/07-evidence/evidence-spec.md',
    expected: 'Evidence DOES NOT use Claim Assessment',
  },
  {
    id: 'RAG-EVAL-CRIT-002',
    query: 'Does wallet ownership prove identity?',
    file: 'docs/01-product/product-principles.md',
    expected: 'Wallet control does NOT establish real-world identity',
  },
  {
    id: 'RAG-EVAL-CRIT-003',
    query: 'Can client tx hash mark payment Paid?',
    file: 'docs/09-payments/private-investigation-payment-spec.md',
    expected: 'Frontend tx hash is NOT payment confirmation',
  },
  {
    id: 'RAG-EVAL-CRIT-004',
    query: 'Can Observatory score publish without methodology version?',
    file: 'docs/08-observatory/rating-model-spec.md',
    expected: 'Rating MUST reference `methodologyVersion`',
  },
  {
    id: 'RAG-EVAL-CRIT-005',
    query: 'Can connected wallet access admin?',
    file: 'docs/01-product/access-model.md',
    expected: '| **Conn. Wallet**   | ALLOW              | DENY',
  },
  {
    id: 'RAG-EVAL-CRIT-006',
    query: 'Which decision blocks backend implementation?',
    file: 'docs/00-governance/open-decisions.md',
    expected: '| DEC-010     | Backend Runtime & Framework? | TBD | Arch | Yes |',
  },
];

const results = [];
for (const testCase of cases) {
  const content = await readFile(path.join(root, testCase.file), 'utf8');
  results.push({
    ...testCase,
    status: content.includes(testCase.expected) ? 'PASS' : 'FAIL',
  });
}

const output = {
  generated_at: new Date().toISOString(),
  mode: 'STATIC_SOURCE_ASSERTIONS_ONLY',
  production_rag_evaluated: false,
  passed: results.filter((item) => item.status === 'PASS').length,
  failed: results.filter((item) => item.status === 'FAIL').length,
  results,
};
const outputRoot = path.join(root, 'docs/19-rag/generated');
await rm(path.join(outputRoot, 'rag-static-evaluation.json'), { force: true });
await mkdir(outputRoot, { recursive: true });
await writeFile(path.join(outputRoot, 'rag-static-evaluation.json'), `${JSON.stringify(output, null, 2)}\n`);
console.log(JSON.stringify(output, null, 2));
if (output.failed) process.exitCode = 1;
