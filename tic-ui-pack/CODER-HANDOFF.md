# Think in Coin UI Pack - Coder Handoff

This package is the visual production contract for the Think in Coin Vite, React and TypeScript application. It defines the rules the frontend must follow; it does not define backend APIs, databases, authentication policy or blockchain indexing.

## Product character

Build an institutional Web3 intelligence terminal: evidence-led, technically credible, dense but legible, and publicly useful. It must not resemble an exchange, a trading dashboard, a token presale, a memecoin portal or a DeFi casino.

## Implementation order

1. Foundations: import `design-tokens.css`, register production font files, add the semantic Tailwind mapping and global focus treatment.
2. Primitives: buttons, inputs, selects, tabs, overlays, tables, feedback and skeletons.
3. Domain semantics: `AssessmentBadge`, `ClaimKindBadge`, `ClaimCard`, evidence, provenance, network and relationship components.
4. Shells: `PublicShell`, `AccountShell` and `AdminShell`.
5. Page templates: dossier, evidence explorer/detail, research article, entity detail, wallet, submission and admin editors.
6. States: loading, empty, error, disconnected, connecting, wrong-network, pending-review and unauthorized.
7. Responsive and accessibility validation.

## Non-negotiable rules

- Use the official SVGs in `assets/`; do not redraw, distort or replace them.
- Obtain and self-host the licensed Fashion Fetish production font. The fallback in the token file is only a safe development fallback.
- Claim kind and assessment are independent systems. Show both when both apply.
- Every assessment uses an icon, text label and semantic color. Color alone is insufficient.
- A submission is not automatically evidence. Evidence is not automatically confirmed.
- A technical relationship between wallets does not establish real-world identity.
- Wallet connection adds account and contributor capabilities but never gates public research.
- Reown AppKit owns the wallet chooser modal. Build only the surrounding Think in Coin UI.
- Every technical table has an explicit mobile-card transformation.
- Use semantic tokens. Do not add arbitrary page-level hex values.
- No decorative candlesticks, coins, rockets, generic purple gradients, excessive glow or glassmorphism.

## Shell contracts

### PublicShell

Expanded sidebar on desktop; compact sidebar on tablet; mobile header, drawer and five-item bottom navigation. Topbar includes global search, network selector and wallet/account access. Public research is always available.

### AccountShell

Extends `PublicShell`. Adds account state, verified addresses, watchlist, submissions and contributor actions. Disconnected, connecting, connected, error and wrong-network states must be explicit.

### AdminShell

Uses the same system but a denser research-operations hierarchy and a subtly warm admin marker. Navigation is visibly distinct. Save, review and publishing status stay contextual. Frontend roles never imply frontend-only authorization.

## Integrity microcopy

- Address verification: "This signature verifies address control. It does not authorize a token transfer."
- Entity attribution: "Wallet control does not by itself establish real-world identity."
- Submission state: "Pending Review" - never "Confirmed" before editorial review.
- Review discipline: "A submission is not evidence. Evidence is not automatically confirmed."

## Required state matrix

Each data-driven page needs loading, empty, success and error states. Wallet surfaces additionally require connecting, disconnected, error and wrong-network. Evidence and network pages require source-unavailable, RPC-unavailable and partial-data states. Admin editors require dirty, saving, saved, validation-error, review-required and publish-ready states.

## Asset authority

Files in `assets/` are official brand assets supplied for this pack. Generated screen imagery is directional. The brand manual and the textual production request remain authoritative if a visual approximation conflicts with official identity.
