---
document_id: RAG-ARCHITECTURE
title: RAG Architecture & Metadata
document_type: ARCHITECTURE
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

# RAG Architecture & Metadata


## 1. RAG Metadata Standard
Every indexable document chunk MUST expose:
* `document_id`
* `document_type`
* `version`
* `status`
* `effective_from`

## 2. Status Filtering
RAG systems MUST prioritize `APPROVED` documents.
`SUPERSEDED`, `ARCHIVED`, and `DRAFT` MUST NOT be treated as equally authoritative.

## 3. Precedence
If chunks conflict, the newer `APPROVED` normative document supersedes the older one. Do not resolve conflicts by semantic similarity alone.

## 4. Retrieval Bundles
Task-specific bundles ensure agents retrieve the smallest authoritative set.

**Example: Implement $Neurons gate**
* Product Spec
* Neurons Product Spec
* Neurons Technical Contract
* Eligibility Spec
* Access Matrix
* Security Spec
* API Contract
* UI Contract
* Relevant ADRs

