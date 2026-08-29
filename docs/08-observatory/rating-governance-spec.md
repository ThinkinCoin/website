---
document_id: OBS-GOV-SPEC
title: Rating Governance Specification
document_type: SPEC
domain: 08-observatory
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

# Rating Governance Specification


## Audit Trail (OBS-GOV-001)
Every manual rating change MUST capture:
* `actor`
* `reason`
* `before` state
* `after` state
* `supporting evidence` ID
* `timestamp`

Manual overrides without evidence traces are PROHIBITED.

