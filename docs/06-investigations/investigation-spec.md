---
document_id: INV-SPEC
title: Investigation Specification
document_type: SPEC
domain: 06-investigations
version: 1.0.0
status: APPROVED
authority: CANONICAL_NORMATIVE
canonicality: CURRENT_CANONICAL
effective_from: 2026-08-26
created_at: 2026-08-25
updated_at: 2026-08-26
supersedes: []
superseded_by: []
related_documents: []
requirement_ids: []
decision_ids: []
tags: []
security_classification: PUBLIC
rag_priority: 1
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

