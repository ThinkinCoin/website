# Repository Guidelines

## Project Structure & Module Organization

This repository currently contains the `tic-ui-pack/`, the visual production contract for `thinkincoin.country`. Its Markdown files define implementation, responsive, and screen requirements; `design-tokens.css` and `tailwind-v4-theme.css` define semantic styling; `component-contracts.ts` records React/TypeScript interfaces; and `assets/` contains official SVG marks. The PDFs and `visual-direction-board.png` are reference artifacts, not application source. No runnable frontend or automated test suite is configured yet.

## Build, Test, and Development Commands

Run these checks from the repository root:

- `rg --files tic-ui-pack` inventories the package and catches unexpected paths.
- `git diff --check` detects whitespace errors before review.
- `git status --short` confirms that a change set contains only intended files.

There is currently no `package.json`, build command, development server, formatter, or test runner. When the Vite application is scaffolded, add and document its package-manager scripts rather than assuming commands that do not exist.

## Coding Style & Naming Conventions

Use two-space indentation in TypeScript and CSS. Keep TypeScript types and React component contracts in PascalCase (`EvidenceRecord`, `ClaimCardProps`), variables in camelCase, files in kebab-case, and CSS custom properties under the `--tic-` namespace. Prefer semantic tokens over page-level hex values. Preserve the separation between claim kind and assessment. Use the official files in `tic-ui-pack/assets/`; do not redraw or distort brand marks.

## Testing Guidelines

For contract changes, cross-check `README.md`, `CODER-HANDOFF.md`, `screen-matrix.md`, and `responsive-contract.md` for consistency. Future UI work must cover loading, empty, success, and error states, plus wallet- and admin-specific states where applicable. Validate responsive behavior at 375, 768, 1280, and 1440 pixels and include keyboard focus, reduced-motion, and non-color status cues. Name future colocated tests `*.test.ts` or `*.test.tsx`.

## Commit & Pull Request Guidelines

History uses brief subjects and merge commits without a strict convention. Prefer concise, imperative, scoped messages such as `docs: clarify mobile table behavior` or `feat: add evidence card contract`. Pull requests should explain the contract or user-facing impact, link relevant issues, list validation performed, and include screenshots for visual changes at affected breakpoints. Call out new binary assets, font licensing, and any intentional deviations from the authoritative brand manual.

## Security & Asset Handling

Do not commit secrets, wallet keys, RPC credentials, or unlicensed font files. Wallet connection must never gate public research, and frontend roles must not be treated as authorization.
