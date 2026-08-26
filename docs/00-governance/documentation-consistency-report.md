---
document_id: D4-CONSISTENCY-REPORT
title: D4 Documentation Consistency Report
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

# D4 Documentation Consistency Report

## PASS

| Rule | Validation result |
| --- | --- |
| Claim assessment is distinct from evidence verification/integrity. | PASS |
| Wallet control is distinct from identity, authentication, and authorization. | PASS |
| $Neurons eligibility is distinct from payment for a private investigation. | PASS |
| Client transaction hash is not payment confirmation. | PASS |
| Rating score is distinct from rating confidence. | PASS |
| Rating publication retains methodology version and historical snapshots. | PASS |

## WARNING

| Subject | Finding |
| --- | --- |
| Private data | The technical intent is present, but API authorization and storage reference contracts are still DRAFT/parallel documents. |
| Search | The architecture supports access filtering, but API/search contracts are not complete enough for a production vertical slice. |
| Decision register | The registry has all known decisions, but classifications and dependency links live in a separate D4 reference rather than in the canonical registry itself. |

## FAIL

| Subject | Finding | Impact |
| --- | --- | --- |
| Metadata authority | 120 of 126 documents lack required corpus metadata. | Production retrieval cannot determine authority reliably. |
| Supersession | Parallel legacy documents have no declared supersession graph. | Historical retrieval can mix competing terminology. |
| Retrieval bundles | The D3 bundle document contains examples, not all mandatory executable bundles. | Agents cannot retrieve deterministic minimal context. |
| Traceability | The matrix is illustrative rather than a complete requirement registry. | Requirement-to-test/agent traceability is incomplete. |

## Open Decisions

The exact active register contains DEC-001 through DEC-011. Their D4
classification and implementation dependencies are in
`decision-dependency-map.yml`. No decision was resolved during validation.
