---
document_id: INV-REQ-SPEC
title: "Private Investigation Request Schema"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

