---
document_id: AUTHN-SPEC
title: "Authentication Architecture"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Authentication Architecture


## Wallet Flow (AUTHN-001)
```text
Request challenge → Server creates nonce → Client displays statement → Wallet signs → Server verifies → Nonce consumed → Session issued
```

## Wallet Ownership Semantics (AUTHN-002)
A signature proves control of a signing key for the requested challenge. It DOES NOT prove legal identity, real-world identity, beneficial ownership, or historical exclusive control.

