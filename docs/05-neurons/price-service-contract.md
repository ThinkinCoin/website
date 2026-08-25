---
document_id: WEB3-PRICE
title: "Price Service Architecture"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Price Service Architecture


## Adapter Interface (WEB3-PRICE-001)
```typescript
getCurrentPrice(): Promise<number>
getPriceTimestamp(): Promise<Date>
getSource(): string // primary | fallback | stale
```
Must handle provider disagreement, staleness (Pending DEC-009), and unavailability gracefully.

