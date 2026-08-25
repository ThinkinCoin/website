---
document_id: DOM-EVENT
title: "Domain Event Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Domain Event Specification


## Events vs Audit (ARCH-EVT-001)
Domain Event = something meaningful happened in the product domain (e.g. `EvidenceVerified`).
Audit Event = trace of who/what changed sensitive/system state.
Activity Feeds SHOULD derive from Domain Events, not the Audit log (which contains sensitive data).

