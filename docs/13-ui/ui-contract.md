---
document_id: UI-CONT
title: "UI Technical Contract"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

