#!/bin/bash
set -e

DOCS="docs"
mkdir -p "$DOCS/adr"

write_spec() {
  local path=$1
  local doc_id=$2
  local title=$3
  local content=$4
  
  cat << META > "$DOCS/$path"
---
document_id: $doc_id
title: "$title"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# $title

$content
META
}

# 1. Architecture Overview
write_spec "03-architecture/system-architecture.md" "SYS-ARCH" "System Architecture" '
## Conceptual Architecture (ARCH-001)

```text
Browser / Vite App
        │
        ▼
Think in Coin API
        │
 ┌──────┼─────────────┬──────────────┐
 │      │             │              │
 ▼      ▼             ▼              ▼
Auth   Domain       Blockchain      Price
       Services      Adapters        Service
 │      │             │              │
 └──────┼─────────────┼──────────────┘
        ▼
    Database (RDBMS)
        │
        ├── Object Storage
        ├── Jobs / Events
        └── Audit
```

## Architecture Principles
* **ARCH-BOUND-001**: Frontend MUST remain backend-agnostic.
* **ARCH-BOUND-002**: Server is authoritative for all protected operations.
* **ARCH-SEC-001**: Secrets MUST NEVER enter the Vite bundle.
* **ARCH-DATA-001**: Immutable/historical records MUST NOT be overwritten when versioning is required.
'

# 2. Capability Map
write_spec "03-architecture/capability-map.md" "CAP-MAP" "Capability Map" '
## Capabilities (ARCH-CAP-001)
* **Identity & Session**: Manages nonces, wallet signature verification, issuing sessions. (Public/Private)
* **Token Eligibility**: Enforces $Neurons balances against price feeds. (Public/Private)
* **Pricing**: Fetches current exchange rates. (Internal)
* **Investigations**: Manages public/private investigation states. (Gated/Private)
* **Evidence**: Ingestion, normalization, provenance tracking. (Internal/Gated)
* **Observatory**: Rating methodologies and snapshots. (Gated)
* **Payments**: Quote issuance and blockchain verification. (Private)
* **Audit**: Immutable trail of sensitive actions. (Internal)
'

# 3. Backend Boundary
write_spec "03-architecture/backend-boundary.md" "BACKEND-BOUND" "Backend Boundary" '
## Server-Side Mandates (ARCH-BOUND-003)
The following MUST execute server-side:
* Eligibility enforcement for gated resources.
* Session validation and issuance.
* Admin / Private Investigation authorization.
* Quote issuance and payment verification.
* Rating and investigation publication.
* Audit persistence.
* Private file access (Signed URLs or proxied streams).

## Client-Side Affordances
The following MAY execute client-side for UX, but are non-authoritative:
* Wallet balance preview.
* Signature pre-validation / formatting.
* Transaction network monitoring.
* Price display.
'

# 4. Domain Technical Model
write_spec "02-domain/domain-model.md" "DOM-TECH" "Domain Technical Model" '
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
'

# 5. Database Specification
write_spec "11-data/database-spec.md" "DB-SPEC" "Database Specification" '
## Logical Model (DATA-DB-001)
Pending ADR-002, the logical model relies on a Relational Database Management System (RDBMS).

## Required Integrity Constraints (DATA-DB-002)
* Claims MUST reference a valid Investigation.
* Claim-Evidence links CANNOT reference missing records (Foreign Key enforced).
* Rating Snapshots MUST reference a Methodology Version.
* Payments MUST reference a valid Quote.
* Private Investigations MUST reference an owning client.

## Historical Data (DATA-DB-003)
Mutable state (e.g., drafts) vs Immutable state:
* Claim assessments, Evidence verification transitions, Rating snapshots, and Payment transitions MUST append history or use temporal tables. They MUST NOT overwrite historical truth.
'

# 6. Object Storage Specification
write_spec "11-data/object-storage-spec.md" "OBJ-STORE" "Object Storage Specification" '
## Storage Classes (DATA-OBJ-001)
* **Evidence Snapshots**: Raw artifacts proving claims.
* **Source Archives**: Web page snapshots.
* **Datasets**: Structured CSV/JSON dumps.
* **Private Attachments**: Client uploads.
* **Generated Reports**: PDF deliverables.

## Security (DATA-OBJ-002)
Private objects MUST require server-authorized access (e.g., pre-signed URLs with short expirations). We DO NOT rely on secret-looking permanent URLs.
'

# 7. API Architecture
write_spec "10-api/api-architecture.md" "API-ARCH" "API Architecture" '
## Conventions (API-001)
* **Style**: RESTful JSON over HTTPS (Pending ADR-004).
* **Pagination**: Cursor-based for large/continuous datasets (e.g., activity feeds, evidence logs). Page-based for administrative tables.
* **Correlation**: All requests MUST generate and pass a `X-Correlation-ID`.
* **Idempotency**: Mutation endpoints (Payments, Publish) MUST support idempotency keys.

## Error Contract (API-ERR-001)
Standardized JSON payload:
`{ "code": "INSUFFICIENT_NEURONS", "message": "...", "details": {}, "correlationId": "..." }`
Canonical codes: `NOT_FOUND`, `UNAUTHENTICATED`, `FORBIDDEN`, `VALIDATION_ERROR`, `ELIGIBILITY_REQUIRED`, `INSUFFICIENT_NEURONS`, `PRICING_UNAVAILABLE`, `PAYMENT_REQUIRED`, `QUOTE_EXPIRED`, `CONFLICT`, `RATE_LIMITED`.

## API Access Policy (API-SEC-001)
Every endpoint maps strictly to one capability tier:
`PUBLIC`, `ELIGIBILITY_REQUIRED`, `AUTHENTICATED_USER`, `RESOURCE_OWNER`, `CAPABILITY_REQUIRED`, `ADMIN_ONLY`.
'

echo "Part 1 Technical Specs generated."
