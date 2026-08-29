---
document_id: FRONTEND-ARCHITECTURE
title: Frontend Architecture
document_type: ARCHITECTURE
domain: architecture
version: 1.0.0
status: SUPERSEDED
authority: NON_NORMATIVE_REFERENCE
canonicality: SUPERSEDED
effective_from: 2026-08-25
created_at: 2026-08-25
updated_at: 2026-08-26
supersedes: []
superseded_by: ["SYS-ARCH","BACKEND-BOUND","UI-CONT"]
related_documents: ["SYS-ARCH","BACKEND-BOUND","UI-CONT"]
requirement_ids: ["ARCH-001","ARCH-002"]
decision_ids: ["DEC-010"]
tags: ["frontend","architecture","legacy"]
security_classification: INTERNAL
rag_priority: 3
---

# Frontend Architecture

Think in Coin is a browser-only Vite React application with three shells: public intelligence, account/Web3, and administration. React Router owns navigation and deep links; TanStack Query owns repository-backed server state; Wagmi/AppKit owns wallet state; forms and transient UI remain local.

## Boundaries

Features depend on TypeScript domain models and repository ports. Mock repositories currently read a coherent normalized fixture database. Future API adapters must map external DTOs into domain models rather than exposing wire contracts to components.

Network concepts remain separate:

- `NetworkCatalogEntry`: networks known to research.
- `ResearchNetworkSelection`: current filter/context.
- `WalletSupportedNetwork`: AppKit-enabled operations, initially Harmony by configuration.

Wallet connection is not authentication. Address control is not real-world identity. Admin route guards are presentation boundaries only; a future server must own authorization.

## Evidence model

Claims have `ClaimKind` and `Assessment`. Evidence instead has `verificationStatus`, `integrityStatus`, provenance, and lineage. Claim/evidence links express support, contradiction, or context. Evidence/evidence links express derivation, corroboration, duplication, or supersession and may record a transformation version.

## Rendering and deployment

Public routes are lazy-loaded SPA routes with Vercel deep-link rewrites. Client-rendered metadata does not provide server-rendered indexing parity. Reviewed prerendering may be added later for published public routes without moving to Next.js.
