---
document_id: RAG-META-001
title: "Document Metadata Contract"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Document Metadata Contract


## Required Frontmatter (RAG-META-002)
All indexable documents MUST contain YAML frontmatter conforming to:
```yaml
document_id: [string]
title: [string]
document_type: [SPEC | ADR | GUIDE | etc]
domain: [string]
version: [semver]
status: [APPROVED | PROPOSED | DRAFT | SUPERSEDED | DEPRECATED | ARCHIVED]
authority: [CANONICAL_NORMATIVE | etc]
effective_from: [date]
supersedes: [document_id or none]
```
Optional fields: `requirement_ids`, `decision_ids`, `tags`, `rag_priority`.

