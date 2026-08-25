# Think in Coin Web

Production frontend foundation for the Think in Coin Web3 intelligence platform. It is a Vite React SPA built around public research, evidence provenance, an optional Harmony wallet workspace, and a future server-governed admin boundary.

## Local development

```bash
corepack enable
pnpm install
cp .env.example .env.local
pnpm dev
```

`VITE_REOWN_PROJECT_ID` enables Reown AppKit. Without it, public research remains functional and wallet surfaces explain that connection is unavailable.

## Quality commands

```bash
pnpm typecheck
pnpm lint
pnpm test
pnpm build
pnpm test:e2e
```

## Data boundary

The initial app uses coherent fixtures through repository interfaces. Evidence uses `verificationStatus` and `integrityStatus`; epistemic `Assessment` belongs to claims only. `docs/ui-pack-deviations.md` records this normative correction.

Harmony snapshot refresh is an offline, review-gated operation:

```bash
HARMONY_RPC_URL=... pnpm fixtures:refresh:harmony
HARMONY_RPC_URL=... pnpm fixtures:refresh:harmony -- --write
```

Never expose private RPC credentials with a `VITE_` prefix.

## Deployment and SEO

`vercel.json` configures Vite output and SPA deep-link rewrites. Public route metadata is client-rendered; this SPA does not claim server-rendered indexing parity. If indexing becomes release-critical, add reviewed Vite-compatible prerendering for published public routes.
