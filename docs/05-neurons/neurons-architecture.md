---
document_id: WEB3-NEUR
title: Technical Architecture
document_type: ARCHITECTURE
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

#  Technical Architecture


## Components (WEB3-001)
* `TokenBalanceAdapter`: Queries blockchain for token balance.
* `PriceProvider`: Abstraction for USD reference price.
* `EligibilityService`: Evaluates `balance * price >= 5.00`.
* `EligibilityPolicy`: Caching and grace period logic (Pending DEC-003).

## Enforcement (WEB3-002)
Eligibility MUST be checked server-side for gated reads, observatory access, and private request creation.

