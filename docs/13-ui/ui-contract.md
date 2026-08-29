---
document_id: UI-CONT
title: UI Technical Contract
document_type: SPEC
domain: 13-ui
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

# UI Technical Contract


## UI Semantics (UI-TECH-001)
The UI MUST NOT invent domain logic. 
* AssessmentBadge → Claim
* VerificationBadge → Evidence
* IntegrityBadge → Evidence
*(Current frontend violation of Evidence Assessment is a known gap, pending resolution).*

## Dashboard Data Contract (UI-TECH-002)
Metrics aggregations MUST occur server-side for authoritative operational metrics. Charts consume defined data structures (`series`, `labels`), not raw DB layouts.

