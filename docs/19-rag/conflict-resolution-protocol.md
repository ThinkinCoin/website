---
document_id: GOV-EXEC-001
title: "Conflict Resolution Protocol"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

