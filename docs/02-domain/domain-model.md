---
document_id: DOM-TECH
title: "Domain Technical Model"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Domain Technical Model


## Technical Aggregates & Entities (DATA-DOM-001)
* **Identity**: `User`, `Wallet`, `Session`. (Blockchain addresses are external IDs, not primary internal keys).
* **Taxonomy**: `Network`, `Project`, `Protocol`, `Token`, `Contract`, `Organization`.
* **Investigation**: `Investigation`, `PrivateInvestigation`, `InvestigationRequest`.
* **Evidence**: `Claim`, `Evidence`, `EvidenceProvenance`, `ClaimEvidenceLink`, `EvidenceLineageLink`, `Source`.
* **Observatory**: `Rating`, `RatingSnapshot`, `RatingDimension`, `RatingFactor`.
* **Commerce**: `Quote`, `Payment`.
* **System**: `AuditEvent`, `DomainEvent`.

## Identifiers (DATA-ID-001)
* Internal IDs MUST be opaque (e.g., UUIDv7 or NanoID).
* External Blockchain addresses/hashes are secondary lookup keys, never primary keys.
* Time semantics MUST use UTC (`createdAt`, `updatedAt`, `publishedAt`, `effectiveAt`, `retrievedAt`).

