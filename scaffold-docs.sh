#!/bin/bash
set -e

# Define root
DOCS_ROOT="docs"

# Directories
DIRS=(
  "00-governance" "01-product" "02-domain" "03-architecture"
  "04-web3" "05-neurons" "06-investigations" "07-evidence"
  "08-observatory" "09-payments" "10-api" "11-data"
  "12-security" "13-ui" "14-admin" "15-operations"
  "16-testing" "17-deployment" "18-agents" "19-rag"
  "adr" "glossary" "archive"
)

for d in "${DIRS[@]}"; do
  mkdir -p "$DOCS_ROOT/$d"
done

# Function to write doc
write_doc() {
  local subpath=$1
  local title=$2
  local status=$3
  local content=$4
  
  local basename=$(basename "$subpath" .md)
  # Convert to uppercase for doc ID
  local doc_id=${basename^^}
  
  cat << META > "$DOCS_ROOT/$subpath"
---
document_id: $doc_id
title: "$title"
version: 1.0.0
status: $status
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# $title

$content
META
}

# --- Sprint D0 Documents ---

write_doc '00-governance/documentation-governance.md' 'Documentation Governance' 'APPROVED' '
## 1. Authority and Precedence

Where code and approved documentation disagree, the approved documentation is authoritative unless an ADR explicitly changes the decision.

**Hierarchy of Truth:**
1. Institutional Principles
2. Approved Product Specifications
3. Architecture Specifications
4. Domain Semantics
5. Security / Privacy Policies
6. API & Data Contracts
7. UI / Design System Contract
8. ADRs
9. Operational Procedures
10. Approved Implementation Plans
11. Source Code
12. Fixtures / Examples

## 2. Normative Language

* **MUST / MUST NOT**: Absolute requirements.
* **SHOULD / SHOULD NOT**: Highly recommended, deviations must be documented.
* **MAY**: Optional implementation path.
Ambiguous language (probably, ideally, maybe) is prohibited unless explicitly marking an open decision.

## 3. Status Model

Every document MUST carry one of the following statuses in its metadata:
* `DRAFT`: Work in progress.
* `PROPOSED`: Ready for review.
* `APPROVED`: Authoritative for implementation.
* `SUPERSEDED`: Replaced by a newer document.
* `DEPRECATED`: No longer active.
* `ARCHIVED`: Preserved for historical context.

## 4. Lifecycle & Change Process

`Change Request → Spec Amendment → Review → Approval → Implementation`

Implementation-driven changes to normative requirements MUST follow this process. Code must not silently modify behavior and update documentation afterward.
'

write_doc '00-governance/open-decisions.md' 'Open Decision Registry' 'APPROVED' '
All unresolved issues must be registered here. Do not bury unresolved decisions inside prose.

| decision_id | question | owner | impact | blocking | options | status | target_date |
|-------------|----------|-------|--------|----------|---------|--------|-------------|
| DEC-001     | Neurons Token Contract Address? | TBD | Technical | No | | OPEN | TBD |
| DEC-002     | Rating Methodology Weights? | TBD | Product | No | | OPEN | TBD |
'

write_doc '00-governance/adr-template.md' 'Architecture Decision Record Template' 'APPROVED' '
## Context
[Describe the context and problem statement]

## Decision
[Describe the decision. Use normative language.]

## Consequences
[What becomes easier or more difficult because of this change?]
'

write_doc '00-governance/documentation-gap-report.md' 'Documentation Gap Report' 'DRAFT' '
Classification of current product behaviors against this new documentation foundation.

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_NOT_DOCUMENTED | Reference exists, formal UI contract pending |
'

write_doc '19-rag/rag-architecture.md' 'RAG Architecture & Metadata' 'APPROVED' '
## 1. RAG Metadata Standard
Every indexable document chunk MUST expose:
* `document_id`
* `document_type`
* `version`
* `status`
* `effective_from`

## 2. Status Filtering
RAG systems MUST prioritize `APPROVED` documents.
`SUPERSEDED`, `ARCHIVED`, and `DRAFT` MUST NOT be treated as equally authoritative.

## 3. Precedence
If chunks conflict, the newer `APPROVED` normative document supersedes the older one. Do not resolve conflicts by semantic similarity alone.

## 4. Retrieval Bundles
Task-specific bundles ensure agents retrieve the smallest authoritative set.

**Example: Implement $Neurons gate**
* Product Spec
* Neurons Product Spec
* Neurons Technical Contract
* Eligibility Spec
* Access Matrix
* Security Spec
* API Contract
* UI Contract
* Relevant ADRs
'

write_doc '18-agents/coder-instruction.md' 'Coder Agent Instructions' 'APPROVED' '
The Coder Agent MUST:
1. Retrieve relevant specs before planning.
2. Cite/specify document IDs used.
3. Identify open decisions.
4. Not invent unresolved product rules.
5. Produce implementation plan.
6. Implement.
7. Test.
8. Compare implementation against specs.
9. Document deviations.
10. Stop when a normative conflict exists.
'

write_doc '18-agents/work-instruction.md' 'WORK Sites Agent Instructions' 'APPROVED' '
The WORK Agent MUST use:
* Brand manual
* UI contract
* Product spec
* Domain semantics
* Access rules

The WORK Agent MUST NOT invent: token economics, evidence semantics, access policies, rating methodology, or investigation workflows.
'

write_doc '18-agents/research-instruction.md' 'Research Agent Instructions' 'APPROVED' '
Research agents MUST distinguish between Fact, Inference, Hypothesis, and Opinion.
Outputs must be compatible with the evidence provenance model.
'

write_doc '18-agents/qa-instruction.md' 'QA Agent Instructions' 'APPROVED' '
The QA Agent MUST verify implementation against approved documentation, not simply "does the screen work".
Produce spec-compliance QA checklists based on normative requirements.
'

write_doc '18-agents/implementation-manifest-template.md' 'Implementation Manifest Template' 'APPROVED' '
Required manifest before any implementation task.
'

# --- Sprint D1-D3 Stubs (DRAFT) ---

write_doc '01-product/product-spec.md' 'Canonical Product Specification' 'DRAFT' 'Define mission, users, access model, public surfaces, token-gated surfaces, research, investigations, private investigations, observatory, workspace, admin, payments, API, institutional boundaries.'

write_doc '01-product/institutional-principles.md' 'Institutional Principles' 'DRAFT' 'Covers analytical independence, evidence proportionality, no unsupported attribution, fact/inference/hypothesis/opinion separation, wallet control ≠ identity, token ownership ≠ credibility, payment ≠ investigative outcome, public utility, traceability.'

write_doc '05-neurons/neurons-product-spec.md' '$Neurons Product Specification' 'DRAFT' 'Defines access rules (wallet connected AND $Neurons value >= USD 5).'

write_doc '05-neurons/neurons-technical-contract.md' '$Neurons Technical Contract' 'DRAFT' 'Technical details. Includes OPEN_DECISION placeholders for contract, chainId, etc.'

write_doc '05-neurons/eligibility-spec.md' 'Eligibility Specification' 'DRAFT' 'Wallet balance × reference price = USD eligibility value.'

write_doc '01-product/access-matrix.md' 'Canonical Access Matrix' 'DRAFT' 'Matrix of Actors (Visitor, Connected Wallet, Eligible User, Admin, etc.) vs Resources.'

write_doc '12-security/auth-vs-wallet-spec.md' 'Authentication vs Wallet Specification' 'DRAFT' 'Separates wallet connection, wallet ownership verification, token eligibility, user session, identity, admin auth.'

write_doc '06-investigations/investigation-spec.md' 'Investigation Specification' 'DRAFT' 'Defines public/private investigations, lifecycle, scope, claims, evidence, review, publication.'

write_doc '06-investigations/private-investigation-service-spec.md' 'Private Investigation Service Spec' 'DRAFT' 'Pipeline: REQUEST → TRIAGE → SCOPE → QUOTE → PAYMENT → ACCEPTED → INVESTIGATION → REVIEW → DELIVERY → CLOSED.'

write_doc '06-investigations/private-investigation-request-schema.md' 'Private Investigation Request Schema' 'DRAFT' 'Formal schema covering subject, question, network, context, confidentiality, deadline.'

write_doc '09-payments/pricing-spec.md' 'Investigation Pricing Specification' 'DRAFT' 'Defines that private investigations are charged in $Neurons. Separates access eligibility from service payment.'

write_doc '09-payments/private-investigation-payment-spec.md' 'Payment Specification' 'DRAFT' 'State machine: AwaitingPayment, TransactionSubmitted, Confirming, Paid, Underpaid, Expired, Failed, RefundPending, Refunded.'

write_doc '07-evidence/evidence-spec.md' 'Evidence Specification' 'DRAFT' 'Defines Evidence, VerificationStatus, IntegrityStatus, Provenance, Lineage.'

write_doc '07-evidence/claim-spec.md' 'Claim Specification' 'DRAFT' 'Defines FACT, INFERENCE, HYPOTHESIS, OPINION and CONFIRMED, STRONGLY_SUPPORTED, PROBABLE, POSSIBLE, UNDETERMINED.'

write_doc '07-evidence/relationship-contract.md' 'Evidence Relationship Contract' 'DRAFT' 'Claim ↔ Evidence (supports, contradicts, contextualizes), Evidence ↔ Evidence (derived_from, corroborates, duplicates, supersedes).'

write_doc '07-evidence/lineage-spec.md' 'Evidence Lineage Specification' 'DRAFT' 'Reproduction chain (RPC Response → Decoded Event → Normalized Record → Dataset → Published Snapshot).'

write_doc '08-observatory/observatory-product-spec.md' 'Observatory Product Specification' 'DRAFT' 'A structured and auditable technical assessment system (not an investment recommendation).'

write_doc '08-observatory/taxonomy.md' 'Observatory Taxonomy' 'DRAFT' 'Entities: Project, Protocol, Token, Contract, Organization, Network. Never define token == project as a universal assumption.'

write_doc '08-observatory/rating-methodology.md' 'Rating Methodology Specification' 'DRAFT' 'Dimensions: Technology, Security, Decentralization, Transparency, Governance, etc.'

write_doc '08-observatory/rating-model.md' 'Rating Model' 'DRAFT' 'factor, metric, raw value, normalized score, weight, dimension score, overall score, confidence.'

write_doc '08-observatory/rating-confidence-model.md' 'Rating Confidence Model' 'DRAFT' 'HIGH, MEDIUM, LOW, INSUFFICIENT_DATA.'

write_doc '08-observatory/rating-provenance.md' 'Rating Provenance' 'DRAFT' 'Rating → Dimensions → Factors → Claims → Evidence → Sources.'

write_doc '08-observatory/rating-versioning.md' 'Rating Versioning' 'DRAFT' 'Never overwrite historical ratings. Snapshot model.'

write_doc '08-observatory/rating-governance.md' 'Rating Governance' 'DRAFT' 'Manual changes require reason, actor, review, supporting evidence, timestamp.'

write_doc '01-product/overview-dashboard-spec.md' 'Overview / Portfolio Specification' 'DRAFT' 'Operational dashboard sections.'

write_doc '11-data/dashboard-metric-dictionary.md' 'Dashboard Metric Dictionary' 'DRAFT' 'Formal definitions for all metrics.'

write_doc '13-ui/chart-spec.md' 'Chart Specification' 'DRAFT' 'question answered, data source, aggregation, x/y semantics, filters.'

write_doc '02-domain/domain-model-spec.md' 'Domain Model Specification' 'DRAFT' 'Canonical domain model including all entities and relationships.'

write_doc '11-data/data-dictionary.md' 'Data Dictionary' 'DRAFT' 'Machine-readable structured dictionary for major fields.'

write_doc '10-api/api-contracts.md' 'API Contract Documentation' 'DRAFT' 'Contracts for public API, eligible-user API, private API, admin API, payments, observatory.'

write_doc '10-api/api-authorization-matrix.md' 'API Authorization Matrix' 'DRAFT' 'anonymous, wallet connected, eligible user, owner, reviewer, admin.'

write_doc '10-api/api-error-taxonomy.md' 'API Error Taxonomy' 'DRAFT' 'Canonical errors: not_found, unauthorized, forbidden, etc.'

write_doc '12-security/security-baseline.md' 'Security Specification' 'DRAFT' 'sessions, wallet signatures, replay, CSP, RPC credentials, etc.'

write_doc '11-data/data-classification.md' 'Data Classification' 'DRAFT' 'PUBLIC, GATED, PRIVATE_CLIENT, INTERNAL, SECRET.'

write_doc '12-security/public-private-boundary.md' 'Public/Private Boundary' 'DRAFT' 'Server-enforced separation of public research, private client data, and internal data.'

write_doc '12-security/audit-spec.md' 'Audit Specification' 'DRAFT' 'Canonical AuditEvent model.'

write_doc '03-architecture/backend-architecture-spec.md' 'Backend Architecture Specification' 'DRAFT' 'API, database, object storage, blockchain adapters, jobs, audit, search.'

write_doc '11-data/database-spec.md' 'Database Specification' 'DRAFT' 'Conceptual and logical models.'

write_doc '11-data/storage-spec.md' 'Storage Specification' 'DRAFT' 'PostgreSQL data, Object Storage, Snapshots, etc.'

write_doc '03-architecture/event-model.md' 'Event Model' 'DRAFT' 'Domain events: EvidenceVerified, ClaimAssessmentChanged, etc.'

write_doc '13-ui/ui-contract.md' 'UI Specification Governance' 'DRAFT' 'Maps screen, component, domain entity, state, API dependency, access rule.'

write_doc '13-ui/semantic-amendment.md' 'UI Semantic Amendment' 'DRAFT' 'AssessmentBadge → Claim only; VerificationBadge/IntegrityBadge → Evidence.'

write_doc '16-testing/test-specification.md' 'Test Specification' 'DRAFT' 'Test requirements before implementation.'

write_doc '15-operations/failure-mode-catalog.md' 'Failure-Mode Catalog' 'DRAFT' 'Map each failure (e.g. RPC unavailable) to UI + API + operational response.'

write_doc '15-operations/observability-spec.md' 'Observability Specification' 'DRAFT' 'Required logs, metrics, traces, alerts.'

write_doc '00-governance/traceability-matrix.md' 'Traceability Matrix' 'DRAFT' 'Requirement → Spec → UI → API → Domain → Test → Implementation status.'

echo "Documentation foundation scaffolded successfully."
