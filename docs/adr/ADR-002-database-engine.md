---
document_id: ADR-002
title: Database Engine
document_type: ADR
domain: adr
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
security_classification: INTERNAL
rag_priority: 1
---

# Database Engine
## Context
We need a robust, relational data store capable of enforcing strict integrity constraints (DATA-DB-002).
## Decision
PostgreSQL is PROPOSED as the canonical relational database.
## Consequences
Enables strict foreign keys for evidence lineage and immutable historical tracking.
