---
document_id: NEUR-SPEC
title: Product Specification
document_type: SPEC
domain: 05-neurons
version: 1.0.0
status: APPROVED
authority: CANONICAL_NORMATIVE
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

#  Product Specification


## Purpose
$Neurons serves two INDEPENDENT product functions:
1. **NEUR-001**: Access eligibility asset (Token Gate).
2. **NEUR-002**: Payment denomination for private investigations.

## Anti-Conflation Invariant
**NEUR-003**: The Token Gate and Private Investigation Payment MUST NOT be conflated. Eligibility does not grant free private investigations. Paying for an investigation does not bypass the eligibility gate if the user wallet lacks the required holding balance.

