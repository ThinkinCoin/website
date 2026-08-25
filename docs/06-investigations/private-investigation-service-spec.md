---
document_id: INV-PRIV-SPEC
title: "Private Investigation Service Spec"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Private Investigation Service Spec


## Lifecycle
`REQUEST → TRIAGE → SCOPE → QUOTE → PAYMENT → ACCEPTED → INVESTIGATION → REVIEW → DELIVERY → CLOSED`

## Boundaries (INV-PRIV-001)
* **No guaranteed outcome**: The platform investigates facts, it does not manufacture desired narratives.
* **No guaranteed attribution**: Identities are only attributed if cryptographically or legally verifiable.
* **No guaranteed recovery**: Think in Coin is intelligence, not asset recovery.
* **No client control**: Clients do not control factual conclusions.
* **Right to decline**: The platform may reject any request (e.g. conflict of interest).
* **Reporting Constraints**: OPEN_DECISION (Legal reporting obligations).

