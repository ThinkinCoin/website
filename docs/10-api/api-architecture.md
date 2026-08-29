---
document_id: API-ARCH
title: API Architecture
document_type: ARCHITECTURE
domain: 10-api
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

# API Architecture


## Conventions (API-001)
* **Style**: RESTful JSON over HTTPS (Pending ADR-004).
* **Pagination**: Cursor-based for large/continuous datasets (e.g., activity feeds, evidence logs). Page-based for administrative tables.
* **Correlation**: All requests MUST generate and pass a `X-Correlation-ID`.
* **Idempotency**: Mutation endpoints (Payments, Publish) MUST support idempotency keys.

## Error Contract (API-ERR-001)
Standardized JSON payload:
`{ "code": "INSUFFICIENT_NEURONS", "message": "...", "details": {}, "correlationId": "..." }`
Canonical codes: `NOT_FOUND`, `UNAUTHENTICATED`, `FORBIDDEN`, `VALIDATION_ERROR`, `ELIGIBILITY_REQUIRED`, `INSUFFICIENT_NEURONS`, `PRICING_UNAVAILABLE`, `PAYMENT_REQUIRED`, `QUOTE_EXPIRED`, `CONFLICT`, `RATE_LIMITED`.

## API Access Policy (API-SEC-001)
Every endpoint maps strictly to one capability tier:
`PUBLIC`, `ELIGIBILITY_REQUIRED`, `AUTHENTICATED_USER`, `RESOURCE_OWNER`, `CAPABILITY_REQUIRED`, `ADMIN_ONLY`.

