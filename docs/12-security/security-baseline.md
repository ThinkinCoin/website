---
document_id: SEC-BASE
title: Security Baseline
document_type: SPEC
domain: 12-security
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

# Security Baseline


## Requirements (SEC-BASE-001)
* **Transport**: HTTPS mandatory.
* **Cookies**: Secure, HttpOnly, SameSite=Strict/Lax.
* **Headers**: Strict CSP, HSTS.
* **Wallet Signatures**: Must prevent replay (Nonces bound to sessions/timestamps).

