---
document_id: FAIL-MODE
title: Failure Mode Catalog
document_type: SPEC
domain: 15-operations
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

# Failure Mode Catalog


## Known Modes (OPER-FAIL-001)
Wallet unavailable, RPC unavailable, Price stale/unavailable, Backend unavailable, DB unavailable, Object storage unavailable, Payment delayed/reverted/underpaid.
Each maps to specific API error codes (e.g., `PRICING_UNAVAILABLE`) and UI fallbacks.

