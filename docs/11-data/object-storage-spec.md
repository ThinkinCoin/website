---
document_id: OBJ-STORE
title: Object Storage Specification
document_type: SPEC
domain: 11-data
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

# Object Storage Specification


## Storage Classes (DATA-OBJ-001)
* **Evidence Snapshots**: Raw artifacts proving claims.
* **Source Archives**: Web page snapshots.
* **Datasets**: Structured CSV/JSON dumps.
* **Private Attachments**: Client uploads.
* **Generated Reports**: PDF deliverables.

## Security (DATA-OBJ-002)
Private objects MUST require server-authorized access (e.g., pre-signed URLs with short expirations). We DO NOT rely on secret-looking permanent URLs.

