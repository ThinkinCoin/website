---
document_id: RAG-BUNDLE-001
title: "Retrieval Bundles"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Retrieval Bundles


## Bundle Schema Example (RAG-BUNDLE-002)
```yaml
bundle_id: IMPLEMENT_NEURONS_GATE
task_domains: [ACCESS_ELIGIBILITY, FRONTEND_WEB3]
required_documents: [PROD-SPEC, ACCESS-MODEL, NEUR-SPEC, NEUR-ELIG-SPEC, WEB3-NEUR, API-ARCH, SEC-BASE, UI-CONT]
required_decisions: [DEC-001, DEC-003, DEC-008, DEC-009]
stop_if_open: [DEC-001]
```

## Mandatory Bundles
* **Evidence Bundle**: Retrieves Claim Spec, Evidence Spec, Provenance, Lineage, Evidence Architecture, UI Contract. MUST enforce "AssessmentBadge is Claim-only".
* **Observatory Bundle**: Retrieves Observatory Product Spec, Rating Model, Governance, Architecture. MUST stop if weights required and DEC-002 is open.
* **Payment Bundle**: Retrieves Private Investigation Service, Pricing, Payment Product/Arch, Threat Model, Failure Modes.

