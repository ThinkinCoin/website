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

# 8. Authentication & Sessions
write_spec "12-security/authentication-spec.md" "AUTHN-SPEC" "Authentication Architecture" '
## Wallet Flow (AUTHN-001)
```text
Request challenge → Server creates nonce → Client displays statement → Wallet signs → Server verifies → Nonce consumed → Session issued
```

## Wallet Ownership Semantics (AUTHN-002)
A signature proves control of a signing key for the requested challenge. It DOES NOT prove legal identity, real-world identity, beneficial ownership, or historical exclusive control.
'

write_spec "12-security/session-spec.md" "SESS-SPEC" "Session Specification" '
## Issuance & Storage (AUTHN-SESS-001)
* Sessions are issued by the backend upon verified signature.
* Session tokens MUST NOT be stored in `localStorage` for production. HttpOnly, Secure, SameSite cookies MUST be used.
* Expiration and renewal logic is server-managed.
'

# 9. Authorization & Data Classification
write_spec "12-security/authorization-spec.md" "AUTHZ-SPEC" "Authorization Architecture" '
## Capability-Based Access (AUTHZ-001)
APIs enforce capabilities (`evidence.review`, `investigation.publish`), abstracted away from specific roles (`Editor`, `Researcher`) where possible.

## Resource Ownership (AUTHZ-002)
Private Investigations, client uploads, and watchlists require explicit `RESOURCE_OWNER` checks. Admin overrides MUST be audited.
'

write_spec "12-security/data-classification.md" "DATA-CLASS" "Data Classification" '
## Classes (SEC-CLASS-001)
* **PUBLIC**: Unrestricted (Institutional content).
* **GATED**: Requires $Neurons eligibility.
* **PRIVATE_CLIENT**: Requires Resource Owner or Admin capability.
* **INTERNAL**: Drafts, unverified evidence. Researchers/Editors only.
* **SECRET**: API keys, DB credentials. Never leaves backend.
'

# 10. Web3 & $Neurons
write_spec "05-neurons/neurons-architecture.md" "WEB3-NEUR" "$Neurons Technical Architecture" '
## Components (WEB3-001)
* `TokenBalanceAdapter`: Queries blockchain for token balance.
* `PriceProvider`: Abstraction for USD reference price.
* `EligibilityService`: Evaluates `balance * price >= 5.00`.
* `EligibilityPolicy`: Caching and grace period logic (Pending DEC-003).

## Enforcement (WEB3-002)
Eligibility MUST be checked server-side for gated reads, observatory access, and private request creation.
'

write_spec "05-neurons/price-service-contract.md" "WEB3-PRICE" "Price Service Architecture" '
## Adapter Interface (WEB3-PRICE-001)
```typescript
getCurrentPrice(): Promise<number>
getPriceTimestamp(): Promise<Date>
getSource(): string // primary | fallback | stale
```
Must handle provider disagreement, staleness (Pending DEC-009), and unavailability gracefully.
'

write_spec "04-web3/blockchain-adapter-spec.md" "WEB3-ADAPT" "Blockchain Adapter Architecture" '
## Interface (WEB3-ADAPT-001)
Abstracts: balance lookup, tx lookup, receipt lookup, block lookup, event logs, message verification.
External RPC endpoints MUST NOT leak directly across domain services.

## Supported Networks (WEB3-ADAPT-002)
`NetworkCatalog` membership does NOT imply `WalletSupportedNetwork` enablement.
'

write_spec "04-web3/reown-appkit-boundary.md" "WEB3-REOWN" "Reown AppKit Boundary" '
## Boundary (WEB3-REOWN-001)
* **Reown Responsibilities**: Wallet connection UI, connector abstraction, network interaction.
* **Think in Coin Responsibilities**: Sessions, eligibility, authorization, business rules, signing statement semantics.
AppKit is NOT the application identity system.
'

# 11. Payments
write_spec "09-payments/payment-architecture.md" "PAY-ARCH" "Payment Architecture" '
## Verification Requirements (PAYTECH-001)
Server MUST validate: Chain, Token Contract, Recipient, Amount, Transaction Success, Block Inclusion, Confirmation Count (Pending DEC-006), and Expiry rules.

## Idempotency (PAYTECH-002)
Payment confirmation MUST be idempotent. The same tx hash cannot confirm multiple paid services.

## Underpayment (PAYTECH-003)
Architecture MUST represent `UNDERPAID` states natively.
'

# 12. Investigations & Evidence
write_spec "06-investigations/private-investigation-architecture.md" "INV-PRIV-ARCH" "Private Investigation Architecture" '
## Privacy Separation (INV-ARCH-001)
Technical separation between Public and Private investigations. Private files MUST have independent authorization paths preventing URL enumeration.
'

write_spec "07-evidence/evidence-architecture.md" "EVID-ARCH" "Evidence Architecture" '
## Ingestion Pipeline (EVID-ARCH-001)
`Retrieve → Record Provenance → Normalize → Checksum → Store Snapshot → Create Evidence`
All ingestion paths (RPC, User Submission, Manual Research) MUST produce provenance records.

## Verification (EVID-ARCH-002)
Verification status MUST NOT be inferred from Claim assessment. 
'

# 13. Observatory
write_spec "08-observatory/observatory-architecture.md" "OBS-ARCH" "Observatory Architecture" '
## Calculation Contract (OBS-ARCH-001)
A calculator consumes `methodologyVersion`, `factorValues`, `weights`, `normalizationRules` and produces `dimensionScores`, `overallScore`, and a `calculationTrace`. It MUST NOT silently assign confidence.

## Versioning (OBS-ARCH-002)
A rating MUST remain reproducible under its historical methodology. Weight changes (DEC-002) MUST NOT rewrite historical scores.
'

echo "Part 2 Technical Specs generated."
