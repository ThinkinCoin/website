#!/bin/bash
set -e

DOCS="docs"

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

# 14. Operations, Security, and UI
write_spec "15-operations/audit-spec.md" "AUDIT-SPEC" "Audit Architecture" '
## Canonical AuditEvent (AUDIT-001)
`actor`, `action`, `objectType`, `objectId`, `before`, `after`, `reason`, `timestamp`, `correlationId`.

## Mandatory Audit Operations (AUDIT-002)
Claim assessment change, evidence verification change, integrity change, publication, quote issuance, payment change, rating change, admin access to private data.
'

write_spec "03-architecture/domain-events.md" "DOM-EVENT" "Domain Event Specification" '
## Events vs Audit (ARCH-EVT-001)
Domain Event = something meaningful happened in the product domain (e.g. `EvidenceVerified`).
Audit Event = trace of who/what changed sensitive/system state.
Activity Feeds SHOULD derive from Domain Events, not the Audit log (which contains sensitive data).
'

write_spec "03-architecture/search-architecture.md" "SEARCH-ARCH" "Search Architecture" '
## Abstraction (SEARCH-001)
Database-backed initially. Architecture MUST allow abstraction to a dedicated search index later.

## Security (SEARCH-SEC-001)
Search MUST respect access classification. Private investigation material MUST NEVER appear in public/gated global results.
'

write_spec "12-security/security-baseline.md" "SEC-BASE" "Security Baseline" '
## Requirements (SEC-BASE-001)
* **Transport**: HTTPS mandatory.
* **Cookies**: Secure, HttpOnly, SameSite=Strict/Lax.
* **Headers**: Strict CSP, HSTS.
* **Wallet Signatures**: Must prevent replay (Nonces bound to sessions/timestamps).
'

write_spec "12-security/threat-model.md" "THREAT-MOD" "Threat Model" '
## Modeled Threats (SEC-THREAT-001)
* **Token-gate bypass**: Handled by server-side eligibility checks.
* **Price Manipulation/Staleness**: Handled by strict Price TTLs (Pending DEC-009).
* **Malicious Uploads**: Handled by storage isolation, download disposition, malware scanning.
* **Rating Tampering**: Handled by immutable snapshots and Audit Trails.
'

write_spec "12-security/secrets-management.md" "SECRETS-MGT" "Secrets Management" '
## Boundary (SEC-SEC-001)
Public `VITE_*` values MUST NOT contain server configuration, RPC credentials, admin keys, or storage credentials.
'

write_spec "15-operations/observability-spec.md" "OBSERVE-SPEC" "Observability Specification" '
## Metrics (OPER-OBS-001)
* **Technical**: API latency, error rate, DB health, RPC failures, price provider failures.
* **Integrity**: Claims without evidence, ratings stale, evidence without provenance, overdue private investigations.
* **Correlation**: All requests MUST generate a `Correlation-ID`.
'

write_spec "15-operations/failure-mode-catalog.md" "FAIL-MODE" "Failure Mode Catalog" '
## Known Modes (OPER-FAIL-001)
Wallet unavailable, RPC unavailable, Price stale/unavailable, Backend unavailable, DB unavailable, Object storage unavailable, Payment delayed/reverted/underpaid.
Each maps to specific API error codes (e.g., `PRICING_UNAVAILABLE`) and UI fallbacks.
'

write_spec "13-ui/ui-contract.md" "UI-CONT" "UI Technical Contract" '
## UI Semantics (UI-TECH-001)
The UI MUST NOT invent domain logic. 
* AssessmentBadge → Claim
* VerificationBadge → Evidence
* IntegrityBadge → Evidence
*(Current frontend violation of Evidence Assessment is a known gap, pending resolution).*

## Dashboard Data Contract (UI-TECH-002)
Metrics aggregations MUST occur server-side for authoritative operational metrics. Charts consume defined data structures (`series`, `labels`), not raw DB layouts.
'

write_spec "16-testing/testing-strategy.md" "TEST-STRAT" "Testing Contract" '
## Layers (TEST-001)
Domain, Repository Contract, API Contract, Integration, Security, Web3, Payment, E2E, Accessibility, Performance.

## Critical Security/Integrity Tests (TEST-002)
* Gated API access without eligibility.
* Expired signature challenge / replayed nonce.
* Unauthorized private investigation access.
* Spoofed payment tx / underpayment.
* Claim assessment does not mutate evidence verification.
'

write_spec "17-deployment/deployment-architecture.md" "DEPLOY-ARCH" "Deployment Architecture" '
## Environments (DEPLOY-001)
* **Development**: Local.
* **Preview/Staging**: Ephemeral/branch.
* **Production**: Main.

## Deep-Link Contract (DEPLOY-002)
SPA route support must be preserved via rewrite behavior.
'

# ADRs
cat << 'META' > "$DOCS/adr/ADR-001-backend-framework.md"
---
document_id: ADR-001
title: "Backend Framework Decision"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
---
# Backend Framework Decision
## Context
A backend framework is required to enforce the strict server-side boundaries (API-001, ARCH-BOUND-003).
## Decision
OPEN_DECISION (DEC-010). Must support robust HTTP processing, cookie management, and separation of concerns.
META

cat << 'META' > "$DOCS/adr/ADR-002-database-engine.md"
---
document_id: ADR-002
title: "Database Engine"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
---
# Database Engine
## Context
We need a robust, relational data store capable of enforcing strict integrity constraints (DATA-DB-002).
## Decision
PostgreSQL is PROPOSED as the canonical relational database.
## Consequences
Enables strict foreign keys for evidence lineage and immutable historical tracking.
META

# Updates to Governance Files
cat << 'META' > "$DOCS/00-governance/open-decisions.md"
---
document_id: OPEN-DECISIONS
title: "Open Decision Registry"
version: 1.2.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---
# Open Decision Registry

| decision_id | question | owner | impact | blocking | options | status | target_date |
|-------------|----------|-------|--------|----------|---------|--------|-------------|
| DEC-001     | Neurons Token Contract Address/Chain? | TBD | Technical | No | | OPEN | TBD |
| DEC-002     | Rating Methodology Weights? | TBD | Product | No | | OPEN | TBD |
| DEC-003     | Eligibility Grace Period duration? | TBD | Product | No | | OPEN | TBD |
| DEC-004     | Private Investigation Pricing Formula? | TBD | Product | No | | OPEN | TBD |
| DEC-005     | Private Investigation Refund Policy? | TBD | Policy | No | | OPEN | TBD |
| DEC-006     | Required Payment Confirmations? | TBD | Security | No | | OPEN | TBD |
| DEC-007     | Observatory Rating Band Labels? | TBD | UI/UX | No | | OPEN | TBD |
| DEC-008     | Primary/Fallback Price Provider? | TBD | Technical | No | | OPEN | TBD |
| DEC-009     | Price TTL (staleness threshold)? | TBD | Technical | No | | OPEN | TBD |
| DEC-010     | Backend Runtime & Framework? | TBD | Arch | Yes | Node/Go/Rust/Python | OPEN | TBD |
| DEC-011     | Search Infrastructure? | TBD | Arch | No | DB vs Elastic/Algolia | OPEN | TBD |
META

cat << 'META' > "$DOCS/00-governance/documentation-gap-report.md"
---
document_id: GAP-REPORT
title: "Documentation Gap Report v3"
version: 1.2.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---
# Documentation Gap Report v3

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_WITHOUT_CONTRACT | UI specs drafted in D2, implementations not yet audited against them. |
| AppKit Wallet Conn | PARTIALLY_COMPLIANT | Missing server-side session/nonce challenge verification (AUTHN-001). |
| UI Assessment Badge| NON_COMPLIANT | UI currently applies Assessment to Evidence (violates EVID-001/UI-TECH-001). |
| Token Gate Route   | IMPLEMENTED_WITHOUT_CONTRACT| Lacks server-side enforcement (WEB3-002). Client-only routing exists. |
| Backend & Database | NOT_IMPLEMENTED | Awaiting DEC-010 resolution. |
META

# Build Traceability Matrix v2
cat << 'META' > "$DOCS/00-governance/traceability-matrix.md"
---
document_id: TRACE-MATRIX
title: "Traceability Matrix v2"
version: 1.1.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---
# Traceability Matrix v2

| D1 Requirement | D2 Architecture | D2 Data | D2 API | D2 Security | D2 Test | Impl Status |
|----------------|-----------------|---------|--------|-------------|---------|-------------|
| ACCESS-001 (Gate)| ARCH-BOUND-003 | - | API-SEC-001 | SEC-THREAT-001 | TEST-002 | BLOCKED |
| EVID-001 (No Ass.)| EVID-ARCH-002 | DATA-DB-002| - | - | TEST-002 | NON_COMPLIANT |
| NEUR-003 (Sep) | PAYTECH-001 | DATA-DB-002 | API-ERR-001 | SEC-THREAT-001 | TEST-002 | BLOCKED |
META

# Update Requirement Index
grep -rohE '[A-Z]+-[A-Z]*[0-9]{3}' "$DOCS" | sort | uniq | grep -v 'DEC-00' > "$DOCS/00-governance/requirement-index.md"
sed -i '1i ---\ndocument_id: REQ-INDEX\ntitle: "Requirement Index v2"\nversion: 1.1.0\nstatus: APPROVED\nowner: Architecture Team\n---\n\n# Requirement Index\n' "$DOCS/00-governance/requirement-index.md"

