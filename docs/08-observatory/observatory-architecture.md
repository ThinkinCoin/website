---
document_id: OBS-ARCH
title: Observatory Architecture
document_type: ARCHITECTURE
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

# Observatory Architecture


## Calculation Contract (OBS-ARCH-001)
A calculator consumes `methodologyVersion`, `factorValues`, `weights`, `normalizationRules` and produces `dimensionScores`, `overallScore`, and a `calculationTrace`. It MUST NOT silently assign confidence.

## Versioning (OBS-ARCH-002)
A rating MUST remain reproducible under its historical methodology. Weight changes (DEC-002) MUST NOT rewrite historical scores.

