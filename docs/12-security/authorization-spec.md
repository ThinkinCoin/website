---
document_id: AUTHZ-SPEC
title: Authorization Architecture
document_type: ARCHITECTURE
domain: 12-security
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

# Authorization Architecture


## Capability-Based Access (AUTHZ-001)
APIs enforce capabilities (`evidence.review`, `investigation.publish`), abstracted away from specific roles (`Editor`, `Researcher`) where possible.

## Resource Ownership (AUTHZ-002)
Private Investigations, client uploads, and watchlists require explicit `RESOURCE_OWNER` checks. Admin overrides MUST be audited.

