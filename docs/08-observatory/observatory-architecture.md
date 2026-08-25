---
document_id: OBS-ARCH
title: "Observatory Architecture"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Observatory Architecture


## Calculation Contract (OBS-ARCH-001)
A calculator consumes `methodologyVersion`, `factorValues`, `weights`, `normalizationRules` and produces `dimensionScores`, `overallScore`, and a `calculationTrace`. It MUST NOT silently assign confidence.

## Versioning (OBS-ARCH-002)
A rating MUST remain reproducible under its historical methodology. Weight changes (DEC-002) MUST NOT rewrite historical scores.

