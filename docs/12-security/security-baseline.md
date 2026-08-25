---
document_id: SEC-BASE
title: "Security Baseline"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Security Baseline


## Requirements (SEC-BASE-001)
* **Transport**: HTTPS mandatory.
* **Cookies**: Secure, HttpOnly, SameSite=Strict/Lax.
* **Headers**: Strict CSP, HSTS.
* **Wallet Signatures**: Must prevent replay (Nonces bound to sessions/timestamps).

