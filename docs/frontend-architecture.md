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
