---
document_id: WEB3-ADAPT
title: Blockchain Adapter Architecture
document_type: ARCHITECTURE
domain: 04-web3
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

# Blockchain Adapter Architecture


## Interface (WEB3-ADAPT-001)
Abstracts: balance lookup, tx lookup, receipt lookup, block lookup, event logs, message verification.
External RPC endpoints MUST NOT leak directly across domain services.

## Supported Networks (WEB3-ADAPT-002)
`NetworkCatalog` membership does NOT imply `WalletSupportedNetwork` enablement.

