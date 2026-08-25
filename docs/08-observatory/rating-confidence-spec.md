---
document_id: OBS-CONF-SPEC
title: "Rating Confidence Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Rating Confidence Specification


## Confidence Levels (OBS-CONF-001)
* **HIGH**: Extensive verification, multiple independent sources.
* **MEDIUM**: Standard verification, mostly reliable sources.
* **LOW**: High reliance on self-reported data, minimal verification.
* **INSUFFICIENT_DATA**: Cannot generate a reliable rating.

**Invariant**: Confidence reflects evidence quality/coverage, NOT project quality. A terrible project can have a HIGH confidence rating.

