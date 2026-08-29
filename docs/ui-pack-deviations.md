---
document_id: UI-PACK-DEVIATIONS
title: UI Pack Deviations
document_type: SPEC
domain: ui
version: 1.0.0
status: APPROVED
authority: CANONICAL_NORMATIVE
canonicality: CURRENT_CANONICAL
effective_from: 2026-08-25
created_at: 2026-08-25
updated_at: 2026-08-26
supersedes: ["SEMANTIC-AMENDMENT"]
superseded_by: []
related_documents: ["UI-CONT","TRACE-MATRIX"]
requirement_ids: ["EVID-001","CLAIM-001"]
decision_ids: []
tags: ["ui","evidence","semantics","badge"]
security_classification: PUBLIC
rag_priority: 1
---

# UI Pack Deviations

## Evidence semantics

The original UI Pack applied `Assessment` directly to evidence records. Architecture Amendment v1.1 supersedes that representation because epistemic assessment belongs to claims, while evidence needs verification and integrity dimensions.

Production behavior:

- `AssessmentBadge` is used only for claims.
- `VerificationBadge` represents `verified`, `partially_verified`, or `unverified` evidence.
- `IntegrityBadge` represents `intact`, `unknown`, or `disputed` evidence.
- Evidence tables and cards replace the original Assessment column with Verification and expose Integrity where relevant.
- Claim-to-evidence meaning remains explicit through `supports`, `contradicts`, or `contextualizes` links.

This is a semantic correction, not a visual redesign. The new badges reuse the UI Pack's shape, typography, icon-plus-label accessibility pattern, and restrained palette.
