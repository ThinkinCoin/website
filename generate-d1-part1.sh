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

# 1. Product Spec
write_spec "01-product/product-spec.md" "PROD-SPEC" "Canonical Product Specification" '
## Mission
Think in Coin is an independent digital asset intelligence platform for research, investigations, evidence analysis, blockchain/network intelligence, project/token observatory, and private investigation services.

## Explicit Non-Goals
Think in Coin is **NOT**:
* an exchange;
* a broker;
* a trading terminal;
* a token issuer;
* law enforcement;
* a regulator;
* an investment advisory service.

## Product Surfaces
* **Public Institutional Surface**: Landing, methodology, about.
* **Token-Gated Intelligence Surface**: In-depth research, evidence, observatory data.
* **User Workspace**: Connected wallet profile, saved items.
* **Investigation Surface**: Public intelligence reports.
* **Private Investigation Surface**: Client-specific requests and deliverables.
* **Observatory**: Token/Project ratings and evaluations.
* **Admin/Operations Surface**: Internal review, publishing, configuration.

## User Classes
* **Visitor**: Unauthenticated, no wallet.
* **Connected Wallet**: Authenticated by wallet, balance not yet verified.
* **Eligible User**: Wallet connected AND meets $Neurons balance criteria.
* **Private Investigation Client**: Requests and pays for bespoke investigations.
* **Contributor**: Submits evidence/claims.
* **Researcher**: Internal analyst.
* **Reviewer**: Internal peer review.
* **Editor**: Final publishing authority.
* **Admin**: Platform operations.

**Requirement IDs**: PROD-001
'

# 2. Product Principles
write_spec "01-product/product-principles.md" "PRIN-SPEC" "Product Principles" '
## Normative Principles
* **PRIN-INDEP-001**: Analytical independence is absolute.
* **PRIN-PROP-001**: Conclusions must be strictly proportional to verified evidence.
* **PRIN-SEP-001**: Explicit separation of Fact, Inference, Hypothesis, and Opinion MUST be maintained.
* **PRIN-ATTR-001**: No unsupported criminal or real-world identity attribution is permitted.
* **PRIN-ID-001**: Wallet control does NOT establish real-world identity.
* **PRIN-CRED-001**: Token ownership does NOT establish analytical credibility.
* **PRIN-PAY-001**: Payment for a private investigation does NOT guarantee a desired investigative conclusion.
* **PRIN-PRIV-001**: Private investigation clients DO NOT control research findings.
* **PRIN-RATE-001**: Ratings MUST be traceable to methodology and evidence.
* **PRIN-REV-001**: Corrections and review history MUST be preserved permanently.
'

# 3. Access Model
write_spec "01-product/access-model.md" "ACCESS-SPEC" "Access Model" '
## Access Requirement
**ACCESS-001**: Any user who wants to interact with the platform, consume gated content, or make requests MUST connect a wallet AND hold a balance of $Neurons whose reference value is >= USD 5.

## Access Matrix

| Actor / Capability | View Institutional | View Gated | View Observatory | Submit Request | Pay Quote | View Private Inv | Download Deliverable | Submit Evidence | Review/Publish | Administer |
|--------------------|--------------------|------------|------------------|----------------|-----------|------------------|----------------------|-----------------|----------------|------------|
| **Visitor**        | ALLOW              | DENY       | DENY             | DENY           | DENY      | DENY             | DENY                 | DENY            | DENY           | DENY       |
| **Conn. Wallet**   | ALLOW              | DENY       | DENY             | DENY           | ALLOW     | DENY             | DENY                 | DENY            | DENY           | DENY       |
| **Eligible User**  | ALLOW              | ALLOW      | ALLOW            | ALLOW          | ALLOW     | CONDITIONAL      | CONDITIONAL          | ALLOW           | DENY           | DENY       |
| **Private Client** | ALLOW              | ALLOW      | ALLOW            | ALLOW          | ALLOW     | ALLOW            | ALLOW                | ALLOW           | DENY           | DENY       |
| **Editor/Admin**   | ALLOW              | ALLOW      | ALLOW            | ALLOW          | ALLOW     | ALLOW            | ALLOW                | ALLOW           | ALLOW          | ALLOW      |

*CONDITIONAL: Only if they are the owner/client of that specific private request.*
'

# 4. Overview Dashboard
write_spec "01-product/overview-dashboard-spec.md" "DASH-SPEC" "Overview Dashboard Specification" '
## Sections
* **Intelligence Snapshot**: High-level metrics on platform coverage (answers "What is the scale of intelligence?").
* **Investigation Portfolio**: Summary of Active, Closed, and Monitoring investigations.
* **Evidence Intelligence**: Metrics on verified vs unverified evidence submissions.
* **Claim Intelligence**: Breakdown of claim types (Fact, Inference, Hypothesis, Opinion).
* **Network Coverage**: Chains and ecosystems currently monitored.
* **Research Portfolio**: Published macro-research outputs.
* **Observatory Coverage**: Number of projects rated and average confidence levels.
* **Current Focus**: The most actively updated or trending investigations.
* **Activity Feed**: Real-time verifiable timeline of platform events.

**Requirement IDs**: DASH-001
'

# 5. Neurons Product Spec
write_spec "05-neurons/neurons-product-spec.md" "NEUR-SPEC" "$Neurons Product Specification" '
## Purpose
$Neurons serves two INDEPENDENT product functions:
1. **NEUR-001**: Access eligibility asset (Token Gate).
2. **NEUR-002**: Payment denomination for private investigations.

## Anti-Conflation Invariant
**NEUR-003**: The Token Gate and Private Investigation Payment MUST NOT be conflated. Eligibility does not grant free private investigations. Paying for an investigation does not bypass the eligibility gate if the user wallet lacks the required holding balance.
'

# 6. Neurons Technical Contract
write_spec "05-neurons/neurons-technical-contract.md" "NEUR-TECH-SPEC" "$Neurons Technical Contract" '
## Parameters
* **tokenContract**: OPEN_DECISION (DEC-001)
* **chainId**: OPEN_DECISION (DEC-001)
* **decimals**: OPEN_DECISION (DEC-001)
* **ticker**: $Neurons
* **primaryPriceSource**: OPEN_DECISION (DEC-008)
* **fallbackPriceSource**: OPEN_DECISION (DEC-008)
* **priceTTL**: OPEN_DECISION (DEC-009)
* **eligibilityTTL**: OPEN_DECISION (DEC-003)

**Requirement IDs**: NEUR-TECH-001
'

# 7. Eligibility Spec
write_spec "05-neurons/eligibility-spec.md" "NEUR-ELIG-SPEC" "Eligibility Specification" '
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
'

# 8. Investigation Spec
write_spec "06-investigations/investigation-spec.md" "INV-SPEC" "Investigation Specification" '
## Domain
**INV-001**: An Investigation encapsulates an investigated question, scope, methodology, timeline, entities, and sources. 
Public and private investigations MUST share identical analytical semantics (Claim/Evidence structures) while preserving strict access/privacy separation.

## Investigation Status
* **Monitoring**: Gathering preliminary data; no active active analytical thesis.
* **Active Investigation**: Dedicated resources, active claim generation and evidence review.
* **Preliminary Findings**: Initial report generated, awaiting final peer review.
* **Substantially Resolved**: Core thesis proven/disproven, wrapping up loose ends.
* **Closed**: Investigation concluded. Published for public, Delivered for private.
* **Reopened**: New material evidence invalidates previous conclusions.
'

# 9. Private Investigation Service Spec
write_spec "06-investigations/private-investigation-service-spec.md" "INV-PRIV-SPEC" "Private Investigation Service Spec" '
## Lifecycle
`REQUEST → TRIAGE → SCOPE → QUOTE → PAYMENT → ACCEPTED → INVESTIGATION → REVIEW → DELIVERY → CLOSED`

## Boundaries (INV-PRIV-001)
* **No guaranteed outcome**: The platform investigates facts, it does not manufacture desired narratives.
* **No guaranteed attribution**: Identities are only attributed if cryptographically or legally verifiable.
* **No guaranteed recovery**: Think in Coin is intelligence, not asset recovery.
* **No client control**: Clients do not control factual conclusions.
* **Right to decline**: The platform may reject any request (e.g. conflict of interest).
* **Reporting Constraints**: OPEN_DECISION (Legal reporting obligations).
'

# 10. Private Request Spec
write_spec "06-investigations/private-investigation-request-spec.md" "INV-REQ-SPEC" "Private Investigation Request Schema" '
## Canonical Schema (INV-REQ-001)
* **subject** (String, Required): Target of the investigation.
* **question** (String, Required): Specific query to resolve.
* **networks** (Array, Optional): Target blockchains.
* **addresses** (Array, Optional): Known addresses.
* **contracts** (Array, Optional): Known smart contracts.
* **transactions** (Array, Optional): Seed tx hashes.
* **context** (String, Optional): Client narrative.
* **attachments** (Array, Optional): Provided evidence.
* **confidentiality** (Enum, Required): Standard, High.
* **desired_deadline** (Date, Optional).
* **requested_deliverables** (Array, Required): Report, Raw Data, Network Graph.
'

# 11. Investigation Pricing
write_spec "06-investigations/investigation-pricing-spec.md" "PRICE-SPEC" "Investigation Pricing Specification" '
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
'

