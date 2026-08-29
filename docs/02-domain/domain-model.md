---
document_id: DOM-TECH
title: Domain Technical Model
document_type: SPEC
domain: 02-domain
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

