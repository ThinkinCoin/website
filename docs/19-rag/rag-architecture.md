---
document_id: RAG-ARCHITECTURE
title: "RAG Architecture & Metadata"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

