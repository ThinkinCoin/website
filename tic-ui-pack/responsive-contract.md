# Think in Coin Responsive Contract

Breakpoints are implementation contracts, not rough references.

- Mobile: 320-767px. Reference width 375px.
- Tablet: 768-1023px. Reference width 768px.
- Desktop: 1024-1439px. Reference widths 1280px and 1440px.
- Wide: 1440px and above. Content remains bounded; data tables may expand.

| Element | Desktop / Wide | Tablet | Mobile |
| --- | --- | --- | --- |
| Navigation | Persistent 232px expanded sidebar | 64px compact sidebar with tooltips | Compact header, navigation drawer, five-item bottom navigation |
| Topbar search | Persistent field | Search icon opens command palette | Full-screen search sheet |
| Data tables | Comfortable or compact density | Priority columns; controlled horizontal scroll only when unavoidable | Transform into structured data cards |
| Dossier tabs | Sticky inline tabs | Sticky horizontal scroll | Sticky horizontal scroll; labels never wrap |
| Filters | Inline row | Compact popover | Bottom filter drawer |
| Context actions | Inline right side | Overflow menu for secondary actions | Sticky action bar or action drawer |
| Two-column admin review | 7/5 split | Stacked with sticky review summary | Queue card opens full review route |
| Wallet/account menu | Anchored popover | Anchored popover | Bottom sheet around AppKit entry point |
| Dialog | Centered modal | Centered modal | Full-width bottom sheet or full-screen route for long flows |

## Mobile table transformation

Every major table needs a named mobile card, not a compressed table row. The card keeps the record ID, object type, network, assessment icon + label, source/date context and primary action visible. Secondary fields move into an expandable details region or detail route.

## Persistent UI

- Keep network state and wallet access visible in every shell.
- Keep dossier route tabs sticky after the page title leaves the viewport.
- Keep admin save/review state available in the contextual action region.
- Never hide claim kind or assessment when card content is collapsed.

## Accessibility

- Use at least 44x44px interactive targets on touch layouts.
- Do not encode status with color alone.
- Preserve keyboard-visible focus rings.
- Provide full values in accessible labels and copy controls when hashes or addresses are visually truncated.
- Honor reduced motion. Network pulse becomes static; selection still changes state.
