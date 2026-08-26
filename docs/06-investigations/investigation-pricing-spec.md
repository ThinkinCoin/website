---
document_id: PRICE-SPEC
title: Investigation Pricing Specification
document_type: SPEC
domain: 06-investigations
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

