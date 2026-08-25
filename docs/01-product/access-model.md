---
document_id: ACCESS-SPEC
title: "Access Model"
version: 1.0.0
status: APPROVED
owner: Architecture Team
created_at: 2026-08-25
updated_at: 2026-08-25
---

# Access Model


## Access Requirement
**ACCESS-001**: Any user who wants to interact with the platform, consume gated content, or make requests MUST connect a wallet AND hold a balance of $Neurons whose reference value is >= USD 5.

## Access Matrix

| Actor / Capability | View Institutional | View Gated | View Observatory | Submit Request | Pay Quote | View Private Inv | Download Deliverable | Submit Evidence | Review/Publish | Administer |
|--------------------|--------------------|------------|------------------|----------------|-----------|------------------|----------------------|-----------------|----------------|------------|
| **Visitor**        | ALLOW              | DENY       | DENY             | DENY           | DENY      | DENY             | DENY                 | DENY            | DENY           | DENY       |
| **Conn. Wallet**   | ALLOW              | DENY       | DENY             | DENY           | ALLOW     | DENY             | DENY                 | DENY            | DENY           | DENY       |
| **Eligible User**  | ALLOW              | ALLOW      | ALLOW            | ALLOW          | ALLOW     | CONDITIONAL      | CONDITIONAL          | ALLOW           | DENY           | DENY       |
| **Private Client** | ALLOW              | ALLOW      | ALLOW            | ALLOW          | ALLOW     | ALLOW            | ALLOW                | ALLOW           | DENY           | DENY       |
| **Editor/Admin**   | ALLOW              | ALLOW      | ALLOW            | ALLOW          | ALLOW     | ALLOW            | ALLOW                | ALLOW           | ALLOW          | ALLOW      |

*CONDITIONAL: Only if they are the owner/client of that specific private request.*

