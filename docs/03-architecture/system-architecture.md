---
document_id: SYS-ARCH
title: System Architecture
document_type: ARCHITECTURE
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

# System Architecture


## Conceptual Architecture (ARCH-001)

```text
Browser / Vite App
        │
        ▼
Think in Coin API
        │
 ┌──────┼─────────────┬──────────────┐
 │      │             │              │
 ▼      ▼             ▼              ▼
Auth   Domain       Blockchain      Price
       Services      Adapters        Service
 │      │             │              │
 └──────┼─────────────┼──────────────┘
        ▼
    Database (RDBMS)
        │
        ├── Object Storage
        ├── Jobs / Events
        └── Audit
```

## Architecture Principles
* **ARCH-BOUND-001**: Frontend MUST remain backend-agnostic.
* **ARCH-BOUND-002**: Server is authoritative for all protected operations.
* **ARCH-SEC-001**: Secrets MUST NEVER enter the Vite bundle.
* **ARCH-DATA-001**: Immutable/historical records MUST NOT be overwritten when versioning is required.

