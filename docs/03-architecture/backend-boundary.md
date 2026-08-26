---
document_id: BACKEND-BOUND
title: Backend Boundary
document_type: SPEC
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

