---
document_id: SYS-ARCH
title: "System Architecture"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

