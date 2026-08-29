---
document_id: RAG-BUNDLE-001
title: Retrieval Bundles
document_type: CONTRACT
domain: 19-rag
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

# Retrieval Bundles

The canonical machine-readable registry lives in `docs/19-rag/retrieval-bundles.json`.
This Markdown file describes the bundle contract and a readable example only.

## Bundle Schema Example (RAG-BUNDLE-002)
```yaml
bundle_id: IMPLEMENT_NEURONS_GATE
task_domains: [ACCESS_ELIGIBILITY, FRONTEND_WEB3]
required_documents: [PROD-SPEC, ACCESS-SPEC, NEUR-SPEC, NEUR-ELIG-SPEC, WEB3-REOWN, WEB3-PRICE, API-ARCH, AUTHN-SPEC, AUTHZ-SPEC, SEC-BASE, THREAT-MOD, UI-CONT]
required_decisions: [DEC-001, DEC-003, DEC-008, DEC-009]
stop_if_open: [DEC-001]
```

## Mandatory Bundles
* The JSON registry defines executable bundles with real document IDs, decision IDs, and test IDs.
* Evidence bundles MUST preserve the claim-only / evidence-verification split.
* Observatory bundles MUST stop when DEC-002 blocks methodology-dependent work.
* Payment bundles MUST include audit and security contracts.

