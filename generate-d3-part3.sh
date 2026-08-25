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

# 9. Templates
write_spec "18-agents/implementation-manifest-template.md" "TMPL-MANIFEST-02" "Implementation Manifest Template v2" '
## Manifest Schema
* **Task**:
* **Scope**:
* **Task Classification**:
* **Authoritative Docs**:
* **Document Versions**:
* **Requirement IDs**:
* **Open Decisions**:
* **Relevant ADRs**:
* **Affected Domain Objects**:
* **Affected APIs**:
* **Affected UI**:
* **Security Impact**:
* **Privacy Impact**:
* **Migration Impact**:
* **Testing Requirements**:
* **Known Gaps**:
* **Blocking Conditions**:
'

write_spec "18-agents/spec-compliance-report-template.md" "TMPL-COMPLY-01" "Spec Compliance Report Template" '
## Compliance Report
* **Implementation**: (Feature/Slice)
* **Commit**:
* **Requirements Tested**: (List IDs)
* **Compliant**: 
* **Partially Compliant**: 
* **Non-Compliant**: 
* **Not Applicable**: 
* **Deviations**: 
* **Open Decisions Encountered**:
* **Security Findings**:
* **Follow-ups**:
'

write_spec "18-agents/coder-task-prompt-template.md" "TMPL-PROMPT-CODER" "Coder Task Prompt Template" '
## Instructions for Coder
Use attached Implementation Manifest.
Retrieve only the specified authoritative bundle.
Do not change documented product behavior.
Do not resolve Open Decisions.
Implement the complete vertical slice.
Run specified verification.
Return Spec Compliance Report.
'

write_spec "18-agents/work-task-prompt-template.md" "TMPL-PROMPT-WORK" "WORK Task Prompt Template" '
## Instructions for WORK
Review UI task, target screen/component, domain semantics, and access rules.
Apply responsive requirements and brand sources.
Forbidden: inventing semantic behavior that conflicts with domain contracts.
'

# 10. RAG Eval Suite & Manifest
write_spec "19-rag/rag-evaluation-suite.md" "RAG-EVAL-001" "RAG Evaluation Suite" '
## Test Queries (RAG-EVAL-002)
* **"Can Evidence be Confirmed?"** Expected: No. Assessment applies to Claims. Evidence uses Verification/Integrity.
* **"Does holding $Neurons prove identity?"** Expected: No. Proves token control for eligibility only.
* **"Can Observatory publish a score without methodology version?"** Expected: No. Methodology version is required.
* **"Which decision blocks backend implementation?"** Expected: DEC-010 is open/blocking.
'

write_spec "19-rag/rag-build-manifest-spec.md" "RAG-BUILD-001" "RAG Build Manifest Spec" '
## Manifest Requirements (RAG-BUILD-002)
Generated corpus manifest MUST contain: `build_timestamp`, `source_commit`, `document_count`, `chunk_count`, `approved_count`, `proposed_count`, `excluded_docs`, `warnings`.
'

# 11. Governance / Gap Updates
cat << 'META' > "$DOCS/00-governance/documentation-gap-report.md"
---
document_id: GAP-REPORT
title: "Documentation Gap Report v4"
version: 1.3.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---
# Documentation Gap Report v4

| Behavior / Feature | Classification | Notes |
|--------------------|----------------|-------|
| Frontend UI layout | IMPLEMENTED_WITHOUT_CONTRACT | UI specs drafted in D2. |
| AppKit Wallet Conn | PARTIALLY_COMPLIANT | Missing server-side session nonce. |
| UI Assessment Badge| NON_COMPLIANT | Violates EVID-001/UI-TECH-001. |
| Token Gate Route   | IMPLEMENTED_WITHOUT_CONTRACT| Client-only routing exists. |
| Backend & Database | NOT_IMPLEMENTED | Awaiting DEC-010 resolution. |
| RAG Corpus Index   | NOT_IMPLEMENTED | Specs drafted in D3; index generation pending D4/Approval. |
| Agent Workflows    | NOT_IMPLEMENTED | Prompts and manifests defined; agents lack CI hooks. |
META

cat << 'META' > "$DOCS/00-governance/traceability-matrix.md"
---
document_id: TRACE-MATRIX
title: "Traceability Matrix v3"
version: 1.2.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---
# Traceability Matrix v3

| Requirement | Product Spec | Technical Contract | Test Requirement | Retrieval Bundle | Agent Instruction | Impl Status |
|-------------|--------------|--------------------|------------------|------------------|-------------------|-------------|
| ACCESS-001  | ACCESS-SPEC  | ARCH-BOUND-003     | TEST-002         | RAG-BUNDLE-001   | AGENT-CODER-002   | BLOCKED     |
| EVID-001    | EVID-SPEC    | EVID-ARCH-002      | TEST-002         | EVIDENCE-BUNDLE  | AGENT-RES-002     | NON_COMPLIANT |
| NEUR-003    | NEUR-SPEC    | PAYTECH-001        | TEST-002         | PAYMENT-BUNDLE   | AGENT-CODER-002   | BLOCKED     |
META

# Update Requirement Index
grep -rohE '[A-Z]+-[A-Z]*[0-9]{3}' "$DOCS" | sort | uniq | grep -v 'DEC-00' > "$DOCS/00-governance/requirement-index.md"
sed -i '1i ---\ndocument_id: REQ-INDEX\ntitle: "Requirement Index v3"\nversion: 1.2.0\nstatus: APPROVED\nowner: Architecture Team\n---\n\n# Requirement Index\n' "$DOCS/00-governance/requirement-index.md"

echo "D3 Part 3 Generated (Templates, Evals, Traceability)"
