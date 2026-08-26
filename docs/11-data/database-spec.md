---
document_id: DB-SPEC
title: Database Specification
document_type: SPEC
domain: 11-data
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

# Database Specification


## Logical Model (DATA-DB-001)
Pending ADR-002, the logical model relies on a Relational Database Management System (RDBMS).

## Required Integrity Constraints (DATA-DB-002)
* Claims MUST reference a valid Investigation.
* Claim-Evidence links CANNOT reference missing records (Foreign Key enforced).
* Rating Snapshots MUST reference a Methodology Version.
* Payments MUST reference a valid Quote.
* Private Investigations MUST reference an owning client.

## Historical Data (DATA-DB-003)
Mutable state (e.g., drafts) vs Immutable state:
* Claim assessments, Evidence verification transitions, Rating snapshots, and Payment transitions MUST append history or use temporal tables. They MUST NOT overwrite historical truth.

