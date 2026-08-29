#!/bin/bash
set -e

DOCS="docs"

write_spec() {
  local path=$1
  local doc_id=$2
  local title=$3
  local content=$4
  
  cat << META > "$DOCS/$path"
---
document_id: $doc_id
title: "$title"
version: 1.0.0
status: PROPOSED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# $title

$content
META
}

# 6. Retrieval Bundles
write_spec "19-rag/retrieval-bundles.md" "RAG-BUNDLE-001" "Retrieval Bundles" '
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
'

# 7. Conflict & Decision Protocols
write_spec "19-rag/conflict-resolution-protocol.md" "GOV-EXEC-001" "Conflict Resolution Protocol" '
## Resolution Steps (GOV-EXEC-002)
If retrieved documents conflict:
1. Compare `status` (APPROVED wins).
2. Compare `authority` (CANONICAL_NORMATIVE wins).
3. Inspect `supersession`.
4. Inspect effective version & amendments.
5. Inspect related ADRs.
6. Report unresolved conflict if parity exists.
**Agents MUST NOT arbitrarily select the more convenient rule.**
'

write_spec "00-governance/open-decision-protocol.md" "GOV-EXEC-003" "Open Decision Execution Protocol" '
## Rules (GOV-EXEC-004)
* **OPEN + BLOCKING**: Implementation MUST STOP.
* **OPEN + NON_BLOCKING**: Implementation MAY use a documented abstraction/placeholder.
* **RESOLVED**: Retrieve resolution + ADR/spec amendment.
Agents MUST NOT silently resolve product or architecture decisions.
'

write_spec "00-governance/spec-deviation-protocol.md" "GOV-EXEC-005" "Spec Change / Deviation Protocol" '
## Deviation Process (GOV-EXEC-006)
If implementation cannot conform to spec, the agent MUST NOT silently change behavior.
Process: `Identify Deviation → Document Technical Reason → Create Spec Change Request / ADR → Review → Approval → Implementation`.
'

write_spec "00-governance/implementation-unlock-protocol.md" "GOV-EXEC-007" "Implementation Unlock Protocol" '
## Unlock Criteria (GOV-EXEC-008)
Implementation can only be unlocked after D4 completion.
The unlock mandate MUST identify:
* Documentation commit hash.
* Approved corpus version.
* Authorized implementation scope (e.g., specific bundle/slice).
* Status of blocking decisions affecting the scope.
No automatic partial unlock is permitted without explicit mandate.
'

# 8. Agent Instructions v2
write_spec "18-agents/coder-agent.md" "AGENT-CODER-002" "Coder Agent Instructions v2" '
## Workflow (AGENT-001)
1. Classify task.
2. Retrieve bundle.
3. Validate document authority.
4. Build Implementation Manifest.
5. Identify blockers.
6. Produce technical plan.
7. Implement smallest complete vertical slice.
8. Test against requirement IDs.
9. Produce Spec Compliance Report.
10. Record deviations.

## Prohibitions (AGENT-002)
Coder MUST NOT: invent token economics, invent rating weights, invent access rules, merge wallet with identity, assign Assessment to Evidence, or confirm blockchain payment from client tx hash alone.
'

write_spec "18-agents/work-agent.md" "AGENT-WORK-002" "WORK Agent Instructions v2" '
## Mandate (AGENT-003)
WORK MUST retrieve Brand reference, UI Contract, Product Spec, Access Model, and Semantic rules.
WORK MAY decide visual composition.
WORK MUST NOT invent domain semantics or override accessibility/security boundaries.
'

write_spec "18-agents/research-agent.md" "AGENT-RES-002" "Research Agent Instructions v2" '
## Mandate (AGENT-004)
Outputs MUST be compatible with Claim, Evidence, Source, Provenance, Entity, and Timeline models.
Outputs MUST explicitly label FACT, INFERENCE, HYPOTHESIS, OPINION.
MUST NOT mark evidence as VERIFIED without a defined verification basis or equate wallet control with identity.
'

write_spec "18-agents/qa-agent.md" "AGENT-QA-002" "QA Agent Instructions v2" '
## Mandate (AGENT-005)
QA MUST validate implementation behavior + requirement compliance + security boundaries + UI semantic compliance.
QA reports MUST explicitly reference requirement IDs.
Modes include Functional, Spec Compliance, Security, Data Integrity, UI Contract, and Regression QA.
'

echo "D3 Part 2 Generated (Bundles & Protocols)"
