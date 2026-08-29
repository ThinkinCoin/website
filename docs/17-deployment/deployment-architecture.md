---
document_id: DEPLOY-ARCH
title: Deployment Architecture
document_type: ARCHITECTURE
domain: 17-deployment
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

# Deployment Architecture


## Environments (DEPLOY-001)
* **Development**: Local.
* **Preview/Staging**: Ephemeral/branch.
* **Production**: Main.

## Deep-Link Contract (DEPLOY-002)
SPA route support must be preserved via rewrite behavior.

