---
document_id: EVID-LIN-SPEC
title: "Evidence Lineage Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

