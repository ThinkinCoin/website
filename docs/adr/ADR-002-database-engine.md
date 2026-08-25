---
document_id: ADR-002
title: "Database Engine"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
---
# Database Engine
## Context
We need a robust, relational data store capable of enforcing strict integrity constraints (DATA-DB-002).
## Decision
PostgreSQL is PROPOSED as the canonical relational database.
## Consequences
Enables strict foreign keys for evidence lineage and immutable historical tracking.
