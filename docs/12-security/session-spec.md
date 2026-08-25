---
document_id: SESS-SPEC
title: "Session Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Session Specification


## Issuance & Storage (AUTHN-SESS-001)
* Sessions are issued by the backend upon verified signature.
* Session tokens MUST NOT be stored in `localStorage` for production. HttpOnly, Secure, SameSite cookies MUST be used.
* Expiration and renewal logic is server-managed.

