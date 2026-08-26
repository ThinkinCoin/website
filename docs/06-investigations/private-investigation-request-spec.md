---
document_id: INV-REQ-SPEC
title: Private Investigation Request Schema
document_type: CONTRACT
domain: 06-investigations
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

# Private Investigation Request Schema


## Canonical Schema (INV-REQ-001)
* **subject** (String, Required): Target of the investigation.
* **question** (String, Required): Specific query to resolve.
* **networks** (Array, Optional): Target blockchains.
* **addresses** (Array, Optional): Known addresses.
* **contracts** (Array, Optional): Known smart contracts.
* **transactions** (Array, Optional): Seed tx hashes.
* **context** (String, Optional): Client narrative.
* **attachments** (Array, Optional): Provided evidence.
* **confidentiality** (Enum, Required): Standard, High.
* **desired_deadline** (Date, Optional).
* **requested_deliverables** (Array, Required): Report, Raw Data, Network Graph.

