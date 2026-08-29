#!/bin/bash
set -e

DOCS="docs"

write_spec() {
  local path=$1
  local doc_id=$2
  local title=$3
  local content=$4
  
  cat << META > "$DOCS/$path"
---
document_id: $doc_id
title: "$title"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# $title

$content
META
}

# 1. RAG Corpus Spec
write_spec "19-rag/rag-corpus-spec.md" "RAG-CORPUS-001" "Canonical RAG Corpus Specification" '
## Inputs (RAG-CORP-001)
D3 explicitly builds upon the documentation established in:
* D1 Baseline Commit: `9aeff88a2c3c442cabd3bf1406cfd85a0e0b9e2f`
* D2 Baseline Commit: `6eef1b79c9b4b9b0728c415644323e1a714975b1`

## Corpus Membership (RAG-CORP-002)
Authoritative documents include: Governance, Product Specs, Domain Specs, Architecture Specs, Security Specs, API/Data Contracts, UI Contracts, Testing Specs, ADRs, Open Decisions, Agent Instructions, Runbooks.
The following MUST NOT be treated as normative by default: source code, fixtures, screenshots, chat logs, generated summaries, archived docs, superseded specs, build artifacts.

## Canonical Classes (RAG-CORP-003)
* `CANONICAL_NORMATIVE`: Product Specs, API Contracts.
* `CANONICAL_REFERENCE`: Brand Manual.
* `NON_NORMATIVE_REFERENCE`: Old UI mockups.
* `GENERATED_DERIVATIVE`: RAG summaries, context packs.
* `ARCHIVED`: Historical context only.
'

# 2. Metadata Contract
write_spec "19-rag/rag-metadata-spec.md" "RAG-META-001" "Document Metadata Contract" '
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
'

# 3. Status & Supersession Rules
write_spec "19-rag/rag-status-supersession.md" "RAG-AUTH-001" "Authority & Supersession Rules" '
## Status Priority (RAG-AUTH-002)
1. `APPROVED`: Default production retrieval target.
2. `PROPOSED`: Retrieved only with explicit provisional warnings.
3. `DRAFT`: MUST NOT govern implementation.
4. `SUPERSEDED` / `ARCHIVED`: Historical context only.

## Supersession & Amendments (RAG-AUTH-003)
If Document B `supersedes` Document A, Document A MUST NOT contribute conflicting normative instructions. For partial amendments, the amendment supersedes ONLY the affected sections; the unaffected baseline remains valid. The composite authority MUST be indicated in generated bundles.
'

# 4. Chunking Spec
write_spec "19-rag/chunking-spec.md" "RAG-CHUNK-001" "Chunking Specification" '
## Semantic Chunking (RAG-CHUNK-002)
Chunk by semantic unit, not character count. Preferred units: Normative Requirement, Invariant, State Machine, API Operation, Schema, Decision, Acceptance Criteria.

## Chunk Identity (RAG-CHUNK-003)
Stable chunk IDs (e.g., `NEUR-ELIG-001::boundary-rule`) MUST be preserved. 
Tables and Schema (JSON/YAML) MUST NOT be split if it destroys row/column/field relationships.

## Parent Metadata (RAG-CHUNK-004)
Every chunk MUST retain its parent `document_id`, `version`, `status`, `authority`, `requirement_ids`, and `decision_ids`.
'

# 5. Context Budget & Task Classification
write_spec "19-rag/context-budget-spec.md" "RAG-BUDGET-001" "Context Budget Rules" '
## Budget Priority (RAG-BUDGET-002)
Retrieve the SMALLEST authoritative set needed. Priority:
1. Exact requirement
2. Exact domain spec
3. Exact technical contract
4. Relevant security requirements
5. Relevant ADR/open decision
6. UI/test contracts
7. Supporting reference
'

write_spec "19-rag/task-classification.md" "RAG-TASK-001" "Task Classification" '
## Task Domains (RAG-TASK-002)
Tasks MUST be classified into one or more domains:
`FRONTEND_UI`, `FRONTEND_WEB3`, `BACKEND_API`, `ACCESS_ELIGIBILITY`, `AUTHENTICATION`, `AUTHORIZATION`, `INVESTIGATIONS`, `PRIVATE_INVESTIGATIONS`, `EVIDENCE`, `OBSERVATORY`, `RATINGS`, `PAYMENTS`, `SEARCH`, `DATA`, `SECURITY`, `OPERATIONS`, `DEPLOYMENT`, `DOCUMENTATION`.
'

echo "D3 Part 1 Generated (RAG Foundations)"
