---
document_id: WEB3-ADAPT
title: "Blockchain Adapter Architecture"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Blockchain Adapter Architecture


## Interface (WEB3-ADAPT-001)
Abstracts: balance lookup, tx lookup, receipt lookup, block lookup, event logs, message verification.
External RPC endpoints MUST NOT leak directly across domain services.

## Supported Networks (WEB3-ADAPT-002)
`NetworkCatalog` membership does NOT imply `WalletSupportedNetwork` enablement.

