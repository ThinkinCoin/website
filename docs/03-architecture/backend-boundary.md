---
document_id: BACKEND-BOUND
title: "Backend Boundary"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Backend Boundary


## Server-Side Mandates (ARCH-BOUND-003)
The following MUST execute server-side:
* Eligibility enforcement for gated resources.
* Session validation and issuance.
* Admin / Private Investigation authorization.
* Quote issuance and payment verification.
* Rating and investigation publication.
* Audit persistence.
* Private file access (Signed URLs or proxied streams).

## Client-Side Affordances
The following MAY execute client-side for UX, but are non-authoritative:
* Wallet balance preview.
* Signature pre-validation / formatting.
* Transaction network monitoring.
* Price display.

