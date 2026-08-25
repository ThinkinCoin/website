---
document_id: OBS-GOV-SPEC
title: "Rating Governance Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Rating Governance Specification


## Audit Trail (OBS-GOV-001)
Every manual rating change MUST capture:
* `actor`
* `reason`
* `before` state
* `after` state
* `supporting evidence` ID
* `timestamp`

Manual overrides without evidence traces are PROHIBITED.

