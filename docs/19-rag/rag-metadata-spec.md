---
document_id: RAG-META-001
title: Document Metadata Contract
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

# Document Metadata Contract


## Required Frontmatter (RAG-META-002)
All indexable documents MUST contain YAML frontmatter conforming to:
```yaml
document_id: [string]
title: [string]
document_type: [string]
domain: [string]
version: [semver string]
status: [DRAFT | PROPOSED | APPROVED | SUPERSEDED | DEPRECATED | ARCHIVED]
authority: [CANONICAL_NORMATIVE | CANONICAL_REFERENCE | NON_NORMATIVE_REFERENCE]
canonicality: [CURRENT_CANONICAL | SUPERSEDED | DEPRECATED | ARCHIVED | NON_NORMATIVE_REFERENCE]
effective_from: [YYYY-MM-DD]
created_at: [YYYY-MM-DD]
updated_at: [YYYY-MM-DD]
supersedes: [document_id, ...]
superseded_by: [document_id, ...]
related_documents: [document_id, ...]
requirement_ids: [requirement_id, ...]
decision_ids: [decision_id, ...]
tags: [tag, ...]
security_classification: [PUBLIC | INTERNAL | SECRET | GATED | PRIVATE_CLIENT]
rag_priority: [integer]
```
Use empty arrays for fields that do not apply. Do not omit required keys.
