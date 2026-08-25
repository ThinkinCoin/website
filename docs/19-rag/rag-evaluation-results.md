---
document_id: D4-RAG-EVALUATION
title: "D4 Static RAG Evaluation Results"
document_type: REPORT
domain: RAG
version: 1.0.0
status: APPROVED
authority: CANONICAL_REFERENCE
canonicality: CANONICAL_REFERENCE
effective_from: 2026-08-25
created_at: 2026-08-25
updated_at: 2026-08-25
related_documents:
  - RAG-EVAL-001
  - RAG-AUTH-001
security_classification: INTERNAL
rag_priority: high
---

# D4 Static RAG Evaluation Results

This evaluation checks source-level authoritative statements. It is **not** a
vector/index retrieval test: no embedding/index provider has been selected and
the production corpus has not passed metadata validation.

| Query | Expected authority result | Static result |
| --- | --- | --- |
| Can Evidence be Confirmed? | No; assessment is claim-only. | PASS |
| Does wallet ownership prove identity? | No. | PASS |
| Does $Neurons balance authenticate a user? | No; eligibility and session are separate. | PASS |
| Can client tx hash mark payment Paid? | No; server/indexer verifies. | PASS |
| Can a rating publish without methodology version? | No. | PASS |
| Can a connected wallet access admin? | No; capability/admin authorization required. | PASS |
| Which decision blocks backend implementation? | DEC-010. | PASS |
| What governs $Neurons eligibility? | Product, eligibility, technical, security, and decision constraints. | PARTIAL — no complete identifier-level bundle exists. |
| Evidence AssessmentBadge | Claim-only semantic correction wins. | PASS |
| Historical Evidence assessment behavior | Must be labelled historical/non-authoritative. | FAIL — no explicit supersession metadata links the legacy UI reference to the amendment. |

**Production RAG evaluation result: FAIL.** The static answers are consistent,
but authority-aware retrieval cannot be certified without a valid corpus and
complete retrieval bundles.
