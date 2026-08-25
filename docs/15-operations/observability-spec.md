---
document_id: OBSERVE-SPEC
title: "Observability Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Observability Specification


## Metrics (OPER-OBS-001)
* **Technical**: API latency, error rate, DB health, RPC failures, price provider failures.
* **Integrity**: Claims without evidence, ratings stale, evidence without provenance, overdue private investigations.
* **Correlation**: All requests MUST generate a `Correlation-ID`.

