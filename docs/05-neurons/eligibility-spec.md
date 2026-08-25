---
document_id: NEUR-ELIG-SPEC
title: "Eligibility Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Eligibility Specification


## Definition
**NEUR-ELIG-001**: 
`eligible = walletConnected AND supportedContext AND validBalance AND validReferencePrice AND tokenBalanceValueUsd >= 5`

* **Decimal Handling**: Standard ERC20/EVM decimal shifting applies.
* **Rounding**: Token value in USD is truncated at 2 decimal places.
* **Exact Boundary**: USD 4.99 is DENIED. USD 5.00 is ALLOWED.
* **Grace Period**: OPEN_DECISION (DEC-003)

## Eligibility Truth Table

| Condition | Result |
|-----------|--------|
| No wallet | DISCONNECTED |
| Wallet connected / zero balance | INELIGIBLE |
| $4.99 value | INELIGIBLE |
| $5.00 value | ELIGIBLE |
| $5.01 value | ELIGIBLE |
| Price unavailable | TEMPORARILY_UNAVAILABLE |
| Price stale | TEMPORARILY_UNAVAILABLE |
| RPC unavailable | TEMPORARILY_UNAVAILABLE |
| Unsupported chain/context | DISCONNECTED |
| Wallet switched | INELIGIBLE (Requires re-eval) |

