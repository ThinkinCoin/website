---
document_id: OBS-RAT-SPEC
title: Rating Model Specification
document_type: SPEC
domain: 08-observatory
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

# Rating Model Specification


## Dimensions (OBS-RAT-001)
Candidate dimensions (Weights are PROPOSED pending DEC-002):
* Technology
* Security
* Decentralization
* Transparency
* Governance
* Token Structure
* Liquidity
* Operational Resilience
* Development Activity
* Market Infrastructure

## Invariants (OBS-RAT-002)
* Rating MUST reference `methodologyVersion`.
* Rating MUST preserve factor values, dimension scores, and confidence.
* Published historical ratings MUST NOT be overwritten.

