---
document_id: SESS-SPEC
title: Session Specification
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

# Session Specification


## Issuance & Storage (AUTHN-SESS-001)
* Sessions are issued by the backend upon verified signature.
* Session tokens MUST NOT be stored in `localStorage` for production. HttpOnly, Secure, SameSite cookies MUST be used.
* Expiration and renewal logic is server-managed.

