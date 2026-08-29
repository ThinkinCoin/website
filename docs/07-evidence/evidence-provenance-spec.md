---
document_id: EVID-PROV-SPEC
title: Evidence Provenance Specification
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

