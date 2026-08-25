---
document_id: DB-SPEC
title: "Database Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

