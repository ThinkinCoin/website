---
document_id: OBJ-STORE
title: "Object Storage Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

