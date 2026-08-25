---
document_id: EVID-ARCH
title: "Evidence Architecture"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Evidence Architecture


## Ingestion Pipeline (EVID-ARCH-001)
`Retrieve → Record Provenance → Normalize → Checksum → Store Snapshot → Create Evidence`
All ingestion paths (RPC, User Submission, Manual Research) MUST produce provenance records.

## Verification (EVID-ARCH-002)
Verification status MUST NOT be inferred from Claim assessment. 

