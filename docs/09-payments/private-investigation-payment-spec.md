---
document_id: PAY-SPEC
title: "Private Investigation Payment Specification"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
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

