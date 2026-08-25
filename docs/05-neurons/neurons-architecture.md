---
document_id: WEB3-NEUR
title: " Technical Architecture"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

#  Technical Architecture


## Components (WEB3-001)
* `TokenBalanceAdapter`: Queries blockchain for token balance.
* `PriceProvider`: Abstraction for USD reference price.
* `EligibilityService`: Evaluates `balance * price >= 5.00`.
* `EligibilityPolicy`: Caching and grace period logic (Pending DEC-003).

## Enforcement (WEB3-002)
Eligibility MUST be checked server-side for gated reads, observatory access, and private request creation.

