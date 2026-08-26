---
document_id: WEB3-PRICE
title: Price Service Architecture
document_type: ARCHITECTURE
domain: 05-neurons
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

# Price Service Architecture


## Adapter Interface (WEB3-PRICE-001)
```typescript
getCurrentPrice(): Promise<number>
getPriceTimestamp(): Promise<Date>
getSource(): string // primary | fallback | stale
```
Must handle provider disagreement, staleness (Pending DEC-009), and unavailability gracefully.

