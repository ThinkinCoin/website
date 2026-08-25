---
document_id: GAP-REPORT
title: "Documentation Gap Report v3"
version: 1.2.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---
# Documentation Gap Report v3

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_WITHOUT_CONTRACT | UI specs drafted in D2, implementations not yet audited against them. |
| AppKit Wallet Conn | PARTIALLY_COMPLIANT | Missing server-side session/nonce challenge verification (AUTHN-001). |
| UI Assessment Badge| NON_COMPLIANT | UI currently applies Assessment to Evidence (violates EVID-001/UI-TECH-001). |
| Token Gate Route   | IMPLEMENTED_WITHOUT_CONTRACT| Lacks server-side enforcement (WEB3-002). Client-only routing exists. |
| Backend & Database | NOT_IMPLEMENTED | Awaiting DEC-010 resolution. |
