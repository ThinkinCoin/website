---
document_id: REL-SPEC
title: Claim-Evidence Relationship Specification
document_type: SPEC
domain: 07-evidence
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

# Claim-Evidence Relationship Specification


## Claim ↔ Evidence Relations (REL-001)
* **SUPPORTS**: Evidence strengthens the Claim assessment.
* **CONTRADICTS**: Evidence weakens or disproves the Claim.
* **CONTEXTUALIZES**: Evidence provides background but does not alter probability.

## Evidence ↔ Evidence Relations (REL-002)
* **DERIVED_FROM**: Output produced from another evidence artifact.
* **CORROBORATES**: Independent evidence matching another artifact.
* **DUPLICATES**: Exact matching evidence.
* **SUPERSEDES**: Newer, higher-fidelity version of older evidence.

