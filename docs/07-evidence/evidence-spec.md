---
document_id: EVID-SPEC
title: "Evidence Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Evidence Specification


## Semantic Invariant (EVID-001)
Evidence DOES NOT use Claim Assessment. Evidence represents raw data or artifacts.

## VerificationStatus (EVID-002)
* **VERIFIED**: Provenance and cryptographic signatures are intact.
* **PARTIALLY_VERIFIED**: Sourced from a reputable indexer, but not manually re-verified against raw RPC.
* **UNVERIFIED**: User-submitted screenshot, unauthenticated dump.

## IntegrityStatus (EVID-003)
* **INTACT**: No signs of tampering.
* **UNKNOWN**: Cannot determine tampering.
* **DISPUTED**: Cryptographic mismatch or suspected forgery.

