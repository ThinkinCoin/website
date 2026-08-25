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

# 12. Claim Spec
write_spec "07-evidence/claim-spec.md" "CLAIM-SPEC" "Claim Specification" '
## ClaimKind (CLAIM-001)
* **FACT**: Verifiable reality (e.g. Tx X occurred in Block Y).
* **INFERENCE**: Logical deduction from facts.
* **HYPOTHESIS**: Proposed explanation requiring testing.
* **OPINION**: Subjective evaluation.

## Assessment (CLAIM-002)
* **CONFIRMED**: Irrefutably proven by on-chain or cryptographic evidence.
* **STRONGLY_SUPPORTED**: High probability, multiple corroborating sources.
* **PROBABLE**: More likely than not, some evidence exists.
* **POSSIBLE**: Plausible, but lacks sufficient evidence.
* **UNDETERMINED**: Cannot be evaluated with current evidence.

**Invariant**: ClaimKind and Assessment are independent dimensions. An OPINION cannot be CONFIRMED.
'

# 13. Evidence Spec
write_spec "07-evidence/evidence-spec.md" "EVID-SPEC" "Evidence Specification" '
## Semantic Invariant (EVID-001)
Evidence DOES NOT use Claim Assessment. Evidence represents raw data or artifacts.

## VerificationStatus (EVID-002)
* **VERIFIED**: Provenance and cryptographic signatures are intact.
* **PARTIALLY_VERIFIED**: Sourced from a reputable indexer, but not manually re-verified against raw RPC.
* **UNVERIFIED**: User-submitted screenshot, unauthenticated dump.

## IntegrityStatus (EVID-003)
* **INTACT**: No signs of tampering.
* **UNKNOWN**: Cannot determine tampering.
* **DISPUTED**: Cryptographic mismatch or suspected forgery.
'

# 14. Claim-Evidence Relationship
write_spec "07-evidence/claim-evidence-relationship-spec.md" "REL-SPEC" "Claim-Evidence Relationship Specification" '
## Claim ↔ Evidence Relations (REL-001)
* **SUPPORTS**: Evidence strengthens the Claim assessment.
* **CONTRADICTS**: Evidence weakens or disproves the Claim.
* **CONTEXTUALIZES**: Evidence provides background but does not alter probability.

## Evidence ↔ Evidence Relations (REL-002)
* **DERIVED_FROM**: Output produced from another evidence artifact.
* **CORROBORATES**: Independent evidence matching another artifact.
* **DUPLICATES**: Exact matching evidence.
* **SUPERSEDES**: Newer, higher-fidelity version of older evidence.
'

# 15. Evidence Provenance
write_spec "07-evidence/evidence-provenance-spec.md" "EVID-PROV-SPEC" "Evidence Provenance Specification" '
## Canonical Provenance Record (EVID-PROV-001)
* `source` (String, Required)
* `publisher` (String, Optional)
* `network` (String, Conditional)
* `retrievedAt` (Timestamp, Required)
* `retrievalMethod` (Enum, Required)
* `rpcMethod` (String, Conditional)
* `transactionHash` (String, Conditional)
* `blockNumber` (Number, Conditional)
* `contentSnapshotRef` (String, Required)
* `checksum` (String, Required)
* `archivedLocation` (String, Optional)
* `rawDataRef` (String, Optional)
'

# 16. Evidence Lineage
write_spec "07-evidence/evidence-lineage-spec.md" "EVID-LIN-SPEC" "Evidence Lineage Specification" '
## Lineage Pipeline (EVID-LIN-001)
Lineage tracks reproduction. Example: `RPC response → decoded event → normalized record → dataset → published snapshot`.

## Canonical Record
* `processor`: Name of script or agent.
* `processorVersion`: Commit hash or version of processor.
* `transformation`: Type of change (decode, aggregate).
* `checksum`: Output hash.
* `timestamp`: Run time.
* `sourceEvidenceId`: Parent node.
* `targetEvidenceId`: Child node.
'

# 17. Observatory Product Spec
write_spec "08-observatory/observatory-product-spec.md" "OBS-SPEC" "Observatory Product Specification" '
## Definition (OBS-001)
The Observatory is a structured, auditable technical assessment system for blockchain projects, protocols and tokens.

## Explicit Warnings (OBS-002)
* It is NOT an investment recommendation.
* It is NOT a buy/sell signal.
* It is NOT purely market-price scoring.
* Ratings CAN and WILL change as evidence changes.
'

# 18. Observatory Taxonomy
write_spec "08-observatory/observatory-taxonomy.md" "OBS-TAX-SPEC" "Observatory Taxonomy" '
## Domain Separation (OBS-TAX-001)
* **Project**: The conceptual business or community effort.
* **Protocol**: The technical ruleset and mechanics.
* **Token**: The digital asset.
* **Contract**: On-chain compiled bytecode.
* **Organization**: The legal/human entity.
* **Network**: The base blockchain layer.

**Invariant**: Do NOT require `Token == Project`. A Project may issue multiple tokens, or none.
'

# 19. Rating Model
write_spec "08-observatory/rating-model-spec.md" "OBS-RAT-SPEC" "Rating Model Specification" '
## Dimensions (OBS-RAT-001)
Candidate dimensions (Weights are PROPOSED pending DEC-002):
* Technology
* Security
* Decentralization
* Transparency
* Governance
* Token Structure
* Liquidity
* Operational Resilience
* Development Activity
* Market Infrastructure

## Invariants (OBS-RAT-002)
* Rating MUST reference `methodologyVersion`.
* Rating MUST preserve factor values, dimension scores, and confidence.
* Published historical ratings MUST NOT be overwritten.
'

# 20. Rating Confidence
write_spec "08-observatory/rating-confidence-spec.md" "OBS-CONF-SPEC" "Rating Confidence Specification" '
## Confidence Levels (OBS-CONF-001)
* **HIGH**: Extensive verification, multiple independent sources.
* **MEDIUM**: Standard verification, mostly reliable sources.
* **LOW**: High reliance on self-reported data, minimal verification.
* **INSUFFICIENT_DATA**: Cannot generate a reliable rating.

**Invariant**: Confidence reflects evidence quality/coverage, NOT project quality. A terrible project can have a HIGH confidence rating.
'

# 21. Rating Governance
write_spec "08-observatory/rating-governance-spec.md" "OBS-GOV-SPEC" "Rating Governance Specification" '
## Audit Trail (OBS-GOV-001)
Every manual rating change MUST capture:
* `actor`
* `reason`
* `before` state
* `after` state
* `supporting evidence` ID
* `timestamp`

Manual overrides without evidence traces are PROHIBITED.
'

# 22. Payments
write_spec "09-payments/private-investigation-payment-spec.md" "PAY-SPEC" "Private Investigation Payment Specification" '
## State Machine (PAY-001)
* `AwaitingPayment`: Quote issued, pending tx.
* `TransactionSubmitted`: Client provided tx hash.
* `Confirming`: Backend awaiting indexer block depth.
* `Paid`: Required confirmations met.
* `Underpaid`: Tx confirmed, but amount < quoted amount.
* `Expired`: Quote TTL exceeded before payment.
* `Failed`: Tx reverted.
* `RefundPending`: Manual/Auto refund flagged.
* `Refunded`: Funds returned.

## Invariants (PAY-002)
* Denominated in $Neurons.
* Frontend tx hash is NOT payment confirmation.
* Backend/indexer verification is REQUIRED.
* Underpayment DOES NOT automatically unlock investigation.
* Required Confirmations: OPEN_DECISION (DEC-006).
* Refund Policy: OPEN_DECISION (DEC-005).
'

# Update Open Decisions
cat << 'META' > "$DOCS/00-governance/open-decisions.md"
---
document_id: OPEN-DECISIONS
title: "Open Decision Registry"
version: 1.1.0
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
META

# Update Gap Report
cat << 'META' > "$DOCS/00-governance/documentation-gap-report.md"
---
document_id: GAP-REPORT
title: "Documentation Gap Report v2"
version: 1.1.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Documentation Gap Report v2

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_NOT_DOCUMENTED | Reference exists, formal UI contract pending in D2 |
| AppKit Wallet Conn | COMPLIANT | Wallet != Identity principle maintained |
| UI Assessment Badge| NON_COMPLIANT | UI currently applies Assessment to Evidence (violates EVID-001). |
| Token Gate Route   | IMPLEMENTED_WITHOUT_SPEC | Existing logic lacks DEC-003 grace period and DEC-009 TTL integration |
| Private Inv. Form  | NOT_IMPLEMENTED | Spec defined (INV-REQ-001), UI/API pending |
META

# Build Requirement Index
cat << 'META' > "$DOCS/00-governance/requirement-index.md"
---
document_id: REQ-INDEX
title: "Requirement Index"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Requirement Index
META
grep -rohE '[A-Z]+-[A-Z]*[0-9]{3}' "$DOCS" | sort | uniq | grep -v 'DEC-00' >> "$DOCS/00-governance/requirement-index.md"

