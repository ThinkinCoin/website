# Repository Guidelines

## Project Structure & Module Organization

The Vite React application lives in `src/`. Route-owned UI is grouped under `src/features/`; reusable primitives and brand elements are in `src/components/`; domain semantics are in `src/domain/`; repositories and adapters isolate fixtures, future APIs, and RPC access. Coherent fixtures live in `src/mocks/`. `tic-ui-pack/` remains the visual source of truth, while `docs/ui-pack-deviations.md` records approved production corrections. Browser tests are in `tests/e2e/`, and official public SVGs are copied to `public/assets/`.

## Build, Test, and Development Commands

Use pnpm through Corepack from the repository root:

- `pnpm dev` starts the local Vite server.
- `pnpm build` runs TypeScript checking and creates `dist/`.
- `pnpm lint` runs ESLint with zero warnings allowed.
- `pnpm test` runs Vitest unit and contract tests.
- `pnpm test:e2e` runs Playwright against the production preview.
- `pnpm check` runs the main static, test, and build gates.

## Coding Style & Naming Conventions

Use two-space indentation, single quotes in TypeScript, PascalCase components/types, camelCase values, kebab-case files, and `--tic-` CSS properties. Prefer semantic tokens over raw colors. `Assessment` belongs to claims; evidence uses `verificationStatus` and `integrityStatus`. Preserve official SVG proportions and never recreate brand marks.

## Testing Guidelines

Colocate unit/component tests as `*.test.ts(x)`. Test critical epistemic invariants, repository contracts, signing language, and route flows rather than implementation details. CI must not depend on a live wallet or RPC. Validate critical screens at 375, 768, 1280, and 1440 pixels, including focus, reduced motion, touch targets, and non-color status cues.

## Commit & Pull Request Guidelines

Prefer concise, imperative, scoped subjects such as `feat: add evidence lineage view` or `fix: separate evidence verification`. PRs should explain user/domain impact, list checks, link issues, and include screenshots at affected breakpoints. Call out asset provenance, font licensing, environment changes, and UI Pack deviations.

## Security & Asset Handling

Never commit secrets, wallet keys, private RPC credentials, or unlicensed fonts. Only public configuration may use `VITE_*`. Wallet connection must not gate research; wallet ownership is not identity; client route guards are not server authorization.
