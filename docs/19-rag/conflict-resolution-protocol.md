---
document_id: GOV-EXEC-001
title: Conflict Resolution Protocol
document_type: POLICY
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

# Conflict Resolution Protocol


## Resolution Steps (GOV-EXEC-002)
If retrieved documents conflict:
1. Compare `status` (APPROVED wins).
2. Compare `authority` (CANONICAL_NORMATIVE wins).
3. Inspect `supersession`.
4. Inspect effective version & amendments.
5. Inspect related ADRs.
6. Report unresolved conflict if parity exists.
**Agents MUST NOT arbitrarily select the more convenient rule.**

