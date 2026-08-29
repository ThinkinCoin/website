---
document_id: CAP-MAP
title: Capability Map
document_type: SPEC
domain: 03-architecture
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

# Capability Map


## Capabilities (ARCH-CAP-001)
* **Identity & Session**: Manages nonces, wallet signature verification, issuing sessions. (Public/Private)
* **Token Eligibility**: Enforces $Neurons balances against price feeds. (Public/Private)
* **Pricing**: Fetches current exchange rates. (Internal)
* **Investigations**: Manages public/private investigation states. (Gated/Private)
* **Evidence**: Ingestion, normalization, provenance tracking. (Internal/Gated)
* **Observatory**: Rating methodologies and snapshots. (Gated)
* **Payments**: Quote issuance and blockchain verification. (Private)
* **Audit**: Immutable trail of sensitive actions. (Internal)

