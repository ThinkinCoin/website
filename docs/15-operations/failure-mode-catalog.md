---
document_id: FAIL-MODE
title: "Failure Mode Catalog"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Failure Mode Catalog


## Known Modes (OPER-FAIL-001)
Wallet unavailable, RPC unavailable, Price stale/unavailable, Backend unavailable, DB unavailable, Object storage unavailable, Payment delayed/reverted/underpaid.
Each maps to specific API error codes (e.g., `PRICING_UNAVAILABLE`) and UI fallbacks.

