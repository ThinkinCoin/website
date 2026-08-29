---
document_id: GAP-REPORT
title: Documentation Gap Report v5
document_type: REPORT
domain: 00-governance
version: 1.5.0
status: APPROVED
authority: CANONICAL_REFERENCE
canonicality: CURRENT_CANONICAL
effective_from: 2026-08-26
created_at: 2026-08-25
updated_at: 2026-08-26
supersedes: []
superseded_by: []
related_documents: []
requirement_ids: []
decision_ids: []
tags: []
security_classification: PUBLIC
rag_priority: 1
---

# Documentation Gap Report v5

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_WITHOUT_CONTRACT | UI technical contract is declared but fails the D4 metadata gate. |
| AppKit Wallet Conn | PARTIALLY_COMPLIANT | Missing server-side session nonce. |
| Evidence semantic badges | COMPLIANT | D4 static source audit found `AssessmentBadge` on claims and `VerificationBadge`/`IntegrityBadge` on evidence. The previous NON_COMPLIANT entry was a documentation error, not a current code finding. |
| Token Gate Route   | IMPLEMENTED_WITHOUT_CONTRACT| Client-only routing exists. Needs API integration. |
| Backend & Database | NOT_IMPLEMENTED | Awaiting DEC-010 resolution. |
| RAG Corpus Index   | NOT_IMPLEMENTED | A review manifest and static inventory exist; no production-eligible authority corpus exists. |
| Agent Workflows    | PARTIALLY_COMPLIANT | Templates exist, but bundle completeness and execution simulation have not passed D4. |
| Documentation metadata | COMPLIANT | The D4-R corpus normalization pass repaired required metadata across the Markdown corpus and emitted the machine-readable registry. |
