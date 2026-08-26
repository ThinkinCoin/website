---
document_id: PAY-SPEC
title: Private Investigation Payment Specification
document_type: SPEC
domain: 09-payments
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

# Private Investigation Payment Specification


## State Machine (PAY-001)
* `AwaitingPayment`: Quote issued, pending tx.
* `TransactionSubmitted`: Client provided tx hash.
* `Confirming`: Backend awaiting indexer block depth.
* `Paid`: Required confirmations met.
* `Underpaid`: Tx confirmed, but amount < quoted amount.
* `Expired`: Quote TTL exceeded before payment.
* `Failed`: Tx reverted.
* `RefundPending`: Manual/Auto refund flagged.
* `Refunded`: Funds returned.

## Invariants (PAY-002)
* Denominated in $Neurons.
* Frontend tx hash is NOT payment confirmation.
* Backend/indexer verification is REQUIRED.
* Underpayment DOES NOT automatically unlock investigation.
* Required Confirmations: OPEN_DECISION (DEC-006).
* Refund Policy: OPEN_DECISION (DEC-005).

