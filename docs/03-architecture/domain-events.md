---
document_id: DOM-EVENT
title: Domain Event Specification
document_type: SPEC
domain: 03-architecture
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

# Domain Event Specification


## Events vs Audit (ARCH-EVT-001)
Domain Event = something meaningful happened in the product domain (e.g. `EvidenceVerified`).
Audit Event = trace of who/what changed sensitive/system state.
Activity Feeds SHOULD derive from Domain Events, not the Audit log (which contains sensitive data).

