---
document_id: OBS-CONF-SPEC
title: Rating Confidence Specification
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

# Rating Confidence Specification


## Confidence Levels (OBS-CONF-001)
* **HIGH**: Extensive verification, multiple independent sources.
* **MEDIUM**: Standard verification, mostly reliable sources.
* **LOW**: High reliance on self-reported data, minimal verification.
* **INSUFFICIENT_DATA**: Cannot generate a reliable rating.

**Invariant**: Confidence reflects evidence quality/coverage, NOT project quality. A terrible project can have a HIGH confidence rating.

