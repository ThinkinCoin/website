---
document_id: D4-VALIDATION-REPORT
title: D4 Documentation Validation Report
document_type: REPORT
domain: GOVERNANCE
version: 1.0.0
status: APPROVED
authority: CANONICAL_REFERENCE
canonicality: CURRENT_CANONICAL
effective_from: 2026-08-25
created_at: 2026-08-25
updated_at: 2026-08-26
supersedes: []
superseded_by: []
related_documents: []
requirement_ids: []
decision_ids: []
tags: []
security_classification: INTERNAL
rag_priority: high
---

# D4 Documentation Validation Report

## Baseline and Scope

| Phase | Commit | Classification |
| --- | --- | --- |
| D0/D1 | `9aeff88a2c3c442cabd3bf1406cfd85a0e0b9e2f` | D0 was not committed separately; this is the first combined D0/D1 documentation baseline. |
| D2 | `6eef1b79c9b4b9b0728c415644323e1a714975b1` | Supplied D2 baseline. |
| D3 | `37089cff85d01e76625a3fa08706b0e5a1f2228a` | Supplied D3 baseline. |
| Post-D3 | `82650cd8ea` | Pre-validation D4 changes. Validated but not accepted as a production baseline. |

The validation inventory contains 127 Markdown files and is generated at
`docs/19-rag/generated/corpus-inventory.json`.

## Validation Results

| Check | Result | Finding |
| --- | --- | --- |
| Metadata | FAIL | 120/127 documents miss at least one required D3 metadata field. |
| Status values | FAIL | Four legacy documents have no parseable frontmatter/status. |
| Document identity | PASS | No duplicate `document_id` remains after the earlier `AUDIT-SPEC` collision was reconciled. |
| Requirement integrity | FAIL | 125 requirement-like IDs are observable, but no machine-readable owner/source registry distinguishes definitions from references. |
| Supersession graph | WARNING | No broken declared target exists, but no active explicit supersession graph resolves parallel legacy documents. |
| Production corpus | FAIL | No product/domain/technical specification currently satisfies the D3 production-eligibility gate. |
| Review corpus | PASS WITH WARNING | The source corpus can be inspected with `APPROVED`/`DRAFT` labels, but labels alone are not authority. |

## Cross-Document and Institutional Invariants

| Subject | Result | Evidence |
| --- | --- | --- |
| Claim assessment vs evidence semantics | PASS | Active evidence, UI, architecture, and RAG documents state assessment is claim-only. |
| Wallet vs identity | PASS | Product principles and authentication spec state wallet control does not prove identity. |
| Eligibility vs payment | PASS | $Neurons product and payment specs keep eligibility separate from paid service. |
| Payment confirmation | PASS | Payment spec requires server/indexer verification; client transaction hash is insufficient. |
| Rating score vs confidence | PASS | Rating confidence is independently defined; methodology version is required. |
| Private data boundary | PARTIAL | Security intent is documented, but complete API/storage contracts remain DRAFT. |

## Static Implementation Audit

The source currently applies `AssessmentBadge` to claims and uses
`VerificationBadge`/`IntegrityBadge` for evidence. The historical gap report
claim that this code was non-compliant is corrected in Gap Report v5. This is a
documentation correction; it does not authorize any product implementation.

## D4 Disposition

**DOCUMENTATION READINESS: NOT_READY**

The corpus is useful as a review draft, but it cannot become a production
authority corpus until metadata, supersession, requirement registry, and bundle
completeness defects are remediated and revalidated.
