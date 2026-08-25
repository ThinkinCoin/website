---
document_id: RAG-CHUNK-001
title: "Chunking Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Chunking Specification


## Semantic Chunking (RAG-CHUNK-002)
Chunk by semantic unit, not character count. Preferred units: Normative Requirement, Invariant, State Machine, API Operation, Schema, Decision, Acceptance Criteria.

## Chunk Identity (RAG-CHUNK-003)
Stable chunk IDs (e.g., `NEUR-ELIG-001::boundary-rule`) MUST be preserved. 
Tables and Schema (JSON/YAML) MUST NOT be split if it destroys row/column/field relationships.

## Parent Metadata (RAG-CHUNK-004)
Every chunk MUST retain its parent `document_id`, `version`, `status`, `authority`, `requirement_ids`, and `decision_ids`.

