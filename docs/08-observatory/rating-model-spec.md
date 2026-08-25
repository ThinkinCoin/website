---
document_id: OBS-RAT-SPEC
title: "Rating Model Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

