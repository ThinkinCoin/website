---
document_id: SEARCH-ARCH
title: Search Architecture
document_type: ARCHITECTURE
domain: 03-architecture
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

# Search Architecture


## Abstraction (SEARCH-001)
Database-backed initially. Architecture MUST allow abstraction to a dedicated search index later.

## Security (SEARCH-SEC-001)
Search MUST respect access classification. Private investigation material MUST NEVER appear in public/gated global results.

