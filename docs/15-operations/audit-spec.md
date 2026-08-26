---
document_id: AUDIT-SPEC
title: Audit Architecture
document_type: ARCHITECTURE
domain: 15-operations
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

# Audit Architecture


## Canonical AuditEvent (AUDIT-001)
`actor`, `action`, `objectType`, `objectId`, `before`, `after`, `reason`, `timestamp`, `correlationId`.

## Mandatory Audit Operations (AUDIT-002)
Claim assessment change, evidence verification change, integrity change, publication, quote issuance, payment change, rating change, admin access to private data.

