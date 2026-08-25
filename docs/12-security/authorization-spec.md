---
document_id: AUTHZ-SPEC
title: "Authorization Architecture"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Authorization Architecture


## Capability-Based Access (AUTHZ-001)
APIs enforce capabilities (`evidence.review`, `investigation.publish`), abstracted away from specific roles (`Editor`, `Researcher`) where possible.

## Resource Ownership (AUTHZ-002)
Private Investigations, client uploads, and watchlists require explicit `RESOURCE_OWNER` checks. Admin overrides MUST be audited.

