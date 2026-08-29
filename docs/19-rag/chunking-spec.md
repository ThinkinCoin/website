---
document_id: RAG-CHUNK-001
title: Chunking Specification
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

# Chunking Specification


## Semantic Chunking (RAG-CHUNK-002)
Chunk by semantic unit, not character count. Preferred units: Normative Requirement, Invariant, State Machine, API Operation, Schema, Decision, Acceptance Criteria.

## Chunk Identity (RAG-CHUNK-003)
Stable chunk IDs (e.g., `NEUR-ELIG-001::boundary-rule`) MUST be preserved. 
Tables and Schema (JSON/YAML) MUST NOT be split if it destroys row/column/field relationships.

## Parent Metadata (RAG-CHUNK-004)
Every chunk MUST retain its parent `document_id`, `version`, `status`, `authority`, `requirement_ids`, and `decision_ids`.

