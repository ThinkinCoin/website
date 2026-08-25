---
document_id: GAP-REPORT
title: "Documentation Gap Report v2"
version: 1.1.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Documentation Gap Report v2

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_NOT_DOCUMENTED | Reference exists, formal UI contract pending in D2 |
| AppKit Wallet Conn | COMPLIANT | Wallet != Identity principle maintained |
| UI Assessment Badge| NON_COMPLIANT | UI currently applies Assessment to Evidence (violates EVID-001). |
| Token Gate Route   | IMPLEMENTED_WITHOUT_SPEC | Existing logic lacks DEC-003 grace period and DEC-009 TTL integration |
| Private Inv. Form  | NOT_IMPLEMENTED | Spec defined (INV-REQ-001), UI/API pending |
