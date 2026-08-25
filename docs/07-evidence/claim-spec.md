---
document_id: CLAIM-SPEC
title: "Claim Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Claim Specification


## ClaimKind (CLAIM-001)
* **FACT**: Verifiable reality (e.g. Tx X occurred in Block Y).
* **INFERENCE**: Logical deduction from facts.
* **HYPOTHESIS**: Proposed explanation requiring testing.
* **OPINION**: Subjective evaluation.

## Assessment (CLAIM-002)
* **CONFIRMED**: Irrefutably proven by on-chain or cryptographic evidence.
* **STRONGLY_SUPPORTED**: High probability, multiple corroborating sources.
* **PROBABLE**: More likely than not, some evidence exists.
* **POSSIBLE**: Plausible, but lacks sufficient evidence.
* **UNDETERMINED**: Cannot be evaluated with current evidence.

**Invariant**: ClaimKind and Assessment are independent dimensions. An OPINION cannot be CONFIRMED.

