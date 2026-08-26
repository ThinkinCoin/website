---
document_id: OBSERVE-SPEC
title: Observability Specification
document_type: SPEC
domain: 15-operations
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

# Observability Specification


## Metrics (OPER-OBS-001)
* **Technical**: API latency, error rate, DB health, RPC failures, price provider failures.
* **Integrity**: Claims without evidence, ratings stale, evidence without provenance, overdue private investigations.
* **Correlation**: All requests MUST generate a `Correlation-ID`.

