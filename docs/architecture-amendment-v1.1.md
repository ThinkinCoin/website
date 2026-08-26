---
document_id: ARCH-AMENDMENT-V1-1
title: Architecture Amendment v1.1
document_type: AMENDMENT
domain: architecture
version: 1.1.0
status: SUPERSEDED
authority: NON_NORMATIVE_REFERENCE
canonicality: SUPERSEDED
effective_from: 2026-08-25
created_at: 2026-08-25
updated_at: 2026-08-26
supersedes: []
superseded_by: ["UI-PACK-DEVIATIONS","SYS-ARCH","WEB3-NEUR","EVID-SPEC","EVID-LIN-SPEC","REL-SPEC"]
related_documents: ["UI-PACK-DEVIATIONS","SYS-ARCH"]
requirement_ids: ["ARCH-001","ARCH-002","ARCH-003"]
decision_ids: ["DEC-001","DEC-003","DEC-006"]
tags: ["architecture","amendment","legacy"]
security_classification: INTERNAL
rag_priority: 3
---

# Architecture Amendment v1.1

This amendment supersedes the original UI Pack where evidence was assigned an epistemic `Assessment`.

1. Web3 package versions are resolved and lockfile-frozen during a compatibility spike; architecture requires AppKit, Wagmi, and Viem but no permanent patch versions.
2. Network catalog, research selection, and wallet-supported networks are distinct types and lifecycles.
3. Investigations expose a dynamic assessment distribution of published claims, not a global assessment. Dynamic summaries omit `calculatedAt`; materialized historical snapshots may include it.
4. Claims use `Assessment`. Evidence uses verification and integrity states.
5. Evidence lineage records `derived_from`, `corroborates`, `duplicates`, or `supersedes`, with optional transformation and processor version.
6. Coverage percentages are indicators. Critical domain, repository, signing/security, and E2E contracts are mandatory gates.
