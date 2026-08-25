---
document_id: DOCUMENTATION-GOVERNANCE
title: "Documentation Governance"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Documentation Governance


## 1. Authority and Precedence

Where code and approved documentation disagree, the approved documentation is authoritative unless an ADR explicitly changes the decision.

**Hierarchy of Truth:**
1. Institutional Principles
2. Approved Product Specifications
3. Architecture Specifications
4. Domain Semantics
5. Security / Privacy Policies
6. API & Data Contracts
7. UI / Design System Contract
8. ADRs
9. Operational Procedures
10. Approved Implementation Plans
11. Source Code
12. Fixtures / Examples

## 2. Normative Language

* **MUST / MUST NOT**: Absolute requirements.
* **SHOULD / SHOULD NOT**: Highly recommended, deviations must be documented.
* **MAY**: Optional implementation path.
Ambiguous language (probably, ideally, maybe) is prohibited unless explicitly marking an open decision.

## 3. Status Model

Every document MUST carry one of the following statuses in its metadata:
* `DRAFT`: Work in progress.
* `PROPOSED`: Ready for review.
* `APPROVED`: Authoritative for implementation.
* `SUPERSEDED`: Replaced by a newer document.
* `DEPRECATED`: No longer active.
* `ARCHIVED`: Preserved for historical context.

## 4. Lifecycle & Change Process

`Change Request → Spec Amendment → Review → Approval → Implementation`

Implementation-driven changes to normative requirements MUST follow this process. Code must not silently modify behavior and update documentation afterward.

