---
document_id: INV-SPEC
title: "Investigation Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Investigation Specification


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

