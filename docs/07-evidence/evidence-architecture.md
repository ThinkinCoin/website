---
document_id: EVID-ARCH
title: Evidence Architecture
document_type: ARCHITECTURE
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

# Evidence Architecture


## Ingestion Pipeline (EVID-ARCH-001)
`Retrieve → Record Provenance → Normalize → Checksum → Store Snapshot → Create Evidence`
All ingestion paths (RPC, User Submission, Manual Research) MUST produce provenance records.

## Verification (EVID-ARCH-002)
Verification status MUST NOT be inferred from Claim assessment. 

