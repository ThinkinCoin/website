---
document_id: EVID-LIN-SPEC
title: Evidence Lineage Specification
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

# Evidence Lineage Specification


## Lineage Pipeline (EVID-LIN-001)
Lineage tracks reproduction. Example: `RPC response → decoded event → normalized record → dataset → published snapshot`.

## Canonical Record
* `processor`: Name of script or agent.
* `processorVersion`: Commit hash or version of processor.
* `transformation`: Type of change (decode, aggregate).
* `checksum`: Output hash.
* `timestamp`: Run time.
* `sourceEvidenceId`: Parent node.
* `targetEvidenceId`: Child node.

