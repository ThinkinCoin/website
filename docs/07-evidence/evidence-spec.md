---
document_id: EVID-SPEC
title: Evidence Specification
document_type: SPEC
domain: 07-evidence
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

