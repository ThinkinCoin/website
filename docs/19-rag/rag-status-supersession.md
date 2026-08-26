---
document_id: RAG-AUTH-001
title: Authority & Supersession Rules
document_type: SPEC
domain: 19-rag
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

# Authority & Supersession Rules


## Status Priority (RAG-AUTH-002)
1. `APPROVED`: Default production retrieval target.
2. `PROPOSED`: Retrieved only with explicit provisional warnings.
3. `DRAFT`: MUST NOT govern implementation.
4. `SUPERSEDED` / `ARCHIVED`: Historical context only.

## Supersession & Amendments (RAG-AUTH-003)
If Document B `supersedes` Document A, Document A MUST NOT contribute conflicting normative instructions. For partial amendments, the amendment supersedes ONLY the affected sections; the unaffected baseline remains valid. The composite authority MUST be indicated in generated bundles.

## Production Eligibility Gate (RAG-AUTH-004)

`status: APPROVED` is necessary but not sufficient for the production corpus. A
document is production-eligible only when its required RAG metadata validates,
its identity is unique, and its supersession references resolve. Documents that
fail corpus validation MUST be excluded from production authority mode even if
their frontmatter declares `APPROVED`.
