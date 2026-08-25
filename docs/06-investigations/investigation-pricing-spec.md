---
document_id: PRICE-SPEC
title: "Investigation Pricing Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Investigation Pricing Specification


## Mechanics (PRICE-001)
* Private investigations are priced in USD, but quoted and paid in $Neurons.
* **Pricing Formula**: OPEN_DECISION (DEC-004)
* **Quote Validity**: A quote locks the $Neurons amount for a specified duration (e.g. 24 hours), regardless of subsequent market price fluctuations.

## Schema
* `quoteId`
* `scopeVersion`
* `amountNeurons`
* `referenceUsd`
* `priceSource`
* `priceTimestamp`
* `expiresAt`
* `quoteStatus`

