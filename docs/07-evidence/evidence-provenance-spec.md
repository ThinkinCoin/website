---
document_id: EVID-PROV-SPEC
title: "Evidence Provenance Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Evidence Provenance Specification


## Canonical Provenance Record (EVID-PROV-001)
* `source` (String, Required)
* `publisher` (String, Optional)
* `network` (String, Conditional)
* `retrievedAt` (Timestamp, Required)
* `retrievalMethod` (Enum, Required)
* `rpcMethod` (String, Conditional)
* `transactionHash` (String, Conditional)
* `blockNumber` (Number, Conditional)
* `contentSnapshotRef` (String, Required)
* `checksum` (String, Required)
* `archivedLocation` (String, Optional)
* `rawDataRef` (String, Optional)

