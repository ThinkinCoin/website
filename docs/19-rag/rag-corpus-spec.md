---
document_id: RAG-CORPUS-001
title: "Canonical RAG Corpus Specification"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Canonical RAG Corpus Specification


## Inputs (RAG-CORP-001)
D3 explicitly builds upon the documentation established in:
* D1 Baseline Commit: `9aeff88a2c3c442cabd3bf1406cfd85a0e0b9e2f`
* D2 Baseline Commit: `6eef1b79c9b4b9b0728c415644323e1a714975b1`

## Corpus Membership (RAG-CORP-002)
Authoritative documents include: Governance, Product Specs, Domain Specs, Architecture Specs, Security Specs, API/Data Contracts, UI Contracts, Testing Specs, ADRs, Open Decisions, Agent Instructions, Runbooks.
The following MUST NOT be treated as normative by default: source code, fixtures, screenshots, chat logs, generated summaries, archived docs, superseded specs, build artifacts.

## Canonical Classes (RAG-CORP-003)
* `CANONICAL_NORMATIVE`: Product Specs, API Contracts.
* `CANONICAL_REFERENCE`: Brand Manual.
* `NON_NORMATIVE_REFERENCE`: Old UI mockups.
* `GENERATED_DERIVATIVE`: RAG summaries, context packs.
* `ARCHIVED`: Historical context only.

