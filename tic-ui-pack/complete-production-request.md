# THINK IN COIN — COMPLETE UI / DESIGN SYSTEM PACK PRODUCTION REQUEST

## Role

Act as the lead product designer and UI systems designer for the **Think in Coin Web3 Intelligence Platform**.

Your job is to create the **complete production UI Pack** that will become the visual source of truth for a separate coding agent.

This is not a request for one homepage mockup.

Produce a coherent, reusable, responsive application design system covering:

- public intelligence platform;
- investigation workflows;
- evidence database;
- research;
- Web3 wallet surfaces;
- user workspace;
- submissions;
- administrative interfaces.

The output must be detailed enough that a frontend engineer can implement the app without inventing visual rules.

---

# 1. Product identity

Product:

**Think in Coin**

Domain:

`thinkincoin.country`

Position:

> Independent Digital Asset Intelligence

Product character:

> Institutional Web3 Intelligence Terminal

It should visually communicate:

- research;
- evidence;
- technical analysis;
- independence;
- transparency;
- blockchain infrastructure;
- institutional credibility.

---

# 2. Avoid generic crypto aesthetics

Do NOT make the product look like:

- an exchange;
- a trading dashboard;
- a token presale;
- a memecoin site;
- a cyberpunk crypto portal;
- a DeFi casino.

Avoid:

- decorative candlestick charts;
- 3D coins;
- rockets;
- excessive neon;
- purple/blue generic crypto gradients;
- constant glow;
- gratuitous glassmorphism.

Web3 functionality must be visible but restrained.

---

# 3. Brand manual

Use the supplied official **Think in Coin Brand Visual Identity Manual** as the authoritative branding reference.

Official foundation includes:

```text
Brand green: #1C413A
Gray: #999999
White: #FFFFFF
Brand typography: Fashion Fetish

```

Use official:

- logo;
- TIC monogram;
- wordmark;
- approved brand proportions.

Do not redesign or replace the Think in Coin mark.

If an exact production SVG is not available, reserve the correct component/asset location and clearly mark where the official asset must replace any temporary representation.

---

# 4. Visual direction already approved

The previously approved dashboard direction should remain the foundation:

- very dark green background;
- institutional green surfaces;
- low-noise borders;
- mint/green interactive accents;
- dense but highly legible information hierarchy;
- structured technical panels;
- restrained charts;
- sidebar + global search + network/wallet header;
- TIC graphic language.

Preserve the strong structure of the approved mockup while extending it to the complete application.

---

# 5. Dark theme

Primary theme is dark.

Develop a systematic palette around a green-black foundation.

Starting direction:

```text
Canvas deepest
#040B09

Canvas
#06110E

Surface 1
#091813

Surface 2
#0D211B

Surface 3
#112B23

Brand
#1C413A

Text primary
near-white

Text secondary
muted neutral

Institutional gray
#999999

```

Derive complete accessible interaction and semantic tokens.

Do not simply use the brand green for everything.

---

# 6. Tokenize semantic colors

Produce semantic tokens for:

```text
background
background-elevated
surface
surface-hover
surface-selected

border-subtle
border
border-emphasis

text-primary
text-secondary
text-muted
text-inverse

brand
brand-hover
brand-active

focus-ring

success
warning
danger
info

```

Also separately define evidence classifications.

---

# 7. Evidence assessment colors

The platform uses:

```text
Confirmed
Strongly Supported
Probable
Possible
Undetermined

```

These must remain distinguishable without becoming visually aggressive.

Every status must use:

```text
icon + text + semantic color

```

Never depend on color alone.

---

# 8. Conceptual claim types

Separately design indicators for:

```text
FACT
INFERENCE
HYPOTHESIS
OPINION

```

Do not visually merge these with evidence assessment.

A user must be able to immediately understand:

> What kind of statement is this?

and separately:

> How strongly is it supported?

---

# 9. Typography system

Use Fashion Fetish as a brand/display typeface where appropriate.

Design a supporting typography stack for application use:

### Brand/display

Fashion Fetish.

### UI/body

Highly legible sans-serif.

### Technical/mono

For:

- wallet addresses;
- hashes;
- blocks;
- RPC;
- code;
- timestamps;
- evidence IDs.

Produce typography tokens for:

```text
display-xl
display-lg

heading-1
heading-2
heading-3
heading-4

body-lg
body
body-sm

label
caption

mono
mono-sm

```

Include:

- size;
- weight;
- line height;
- letter spacing;
- intended use.

---

# 10. Spacing system

Create one coherent spacing scale.

Document values and usage.

Cover:

- inline gaps;
- card padding;
- page margins;
- sidebar;
- headers;
- forms;
- data tables;
- mobile layouts.

---

# 11. Radius

Use restrained corner radii.

Institutional software, not bubbly consumer fintech.

Define:

```text
xs
sm
md
lg
round

```

and usage.

---

# 12. Borders and elevation

The dark UI should rely primarily on:

- tonal surfaces;
- subtle borders;
- small elevation differences.

Avoid heavy shadows.

Document:

```text
panel
popover
dialog
selected
focus

```

---

# 13. Iconography

Choose a consistent outline icon language.

Use icons for functional meaning, not decoration.

Create rules for:

- navigation;
- evidence;
- network status;
- wallet;
- admin;
- actions.

The TIC monogram may inspire proprietary markers/loaders, but do not distort the official logo.

---

# 14. App shell — Desktop

Create production design for:

```text
Sidebar
Topbar
Page canvas
Contextual actions

```

Topbar must support:

```text
Global Search
Network Selector
Connect Wallet / Account

```

Sidebar:

```text
Think in Coin

Overview

Investigations
Research
Evidence
Networks
Entities
Timeline
Data & API

WEB3
My Addresses
Watchlist
Submissions

Methodology
About
Corrections

```

---

# 15. Collapsed sidebar

Design:

- expanded;
- collapsed;
- hover/focus tooltip;
- active state;
- notification/status marker.

Use official TIC monogram in collapsed branding.

---

# 16. Mobile shell

Design a genuinely mobile experience.

Header:

```text
TIC
Search
Wallet
Menu

```

Evaluate bottom navigation for core destinations:

```text
Home
Investigate
Evidence
Networks
Wallet

```

Do not merely scale the desktop sidebar down.

---

# 17. Tablet shell

Create intermediate behavior.

Decide:

- compact sidebar;
- drawer;
- content widths;
- panel stacking.

Show the solution explicitly.

---

# 18. Home / Overview

Create complete desktop, tablet and mobile designs.

Sections:

### Hero

> Independent digital asset intelligence.

Supporting:

> Research, evidence and technical analysis for digital assets, blockchain networks and related infrastructure.

Actions:

```text
Explore Investigations
View Research

```

Visual motif should use TIC-inspired on-chain relationships.

---

## Current Investigations

Main example:

`Harmony Network Incident — August 2026`

Fields:

```text
Status
Last update
Confidence
Evidence count
Tags

```

---

## Latest Research

Card variants:

```text
Research
Investigation
Technical Note
Dataset

```

---

## Network Status

Example:

Harmony.

Show:

```text
Latest block
Block time
Validators
24h activity
RPC health
Connectivity
Block production
Bridge status

```

---

## Timeline

Compact recent events.

---

## Latest Evidence

Technical data table.

---

## Evidence Distribution

Accessible chart.

---

# 19. Investigations Library

Design:

`/investigations`

Include:

- search;
- filters;
- network;
- investigation status;
- assessment filter;
- sort;
- card/list toggle if justified.

Cards should communicate:

```text
title
network
status
summary
last updated
evidence count
open questions

```

---

# 20. Investigation Dossier

Design:

`/investigations/:slug`

Header:

```text
Breadcrumb
Title
Status
Last reviewed
Watch
Share

```

Tabs/routes:

```text
Overview
Timeline
Evidence
Entities
Analysis
Sources
Updates

```

Design desktop, mobile and tablet behavior.

---

# 21. Dossier Overview

Design sections for:

```text
Executive Summary
Current Assessment
Confirmed Facts
Inferences
Hypotheses
Unknowns
Key Evidence
Related Entities

```

Make FACT / INFERENCE / HYPOTHESIS visually explicit.

---

# 22. Claim component

Design a sophisticated reusable Claim Card.

Must support:

```text
Claim Kind
Assessment
Statement
Evidence count
Sources
Last reviewed
Related entities

```

Variants:

- compact;
- normal;
- expanded;
- admin editable.

---

# 23. Timeline

Create:

- dossier timeline;
- global timeline;
- compact dashboard timeline.

Event design must support:

```text
timestamp
category
description
source
evidence refs
entities
transaction

```

---

# 24. Evidence Explorer

Design a dense intelligence database page.

Desktop:

technical table.

Filters:

```text
Type
Assessment
Network
Source
Date

```

Search:

```text
Evidence ID, tx hash, address, block...

```

---

# 25. Evidence mobile

Rows must transform into structured cards.

Do not compress the desktop table.

---

# 26. Evidence detail

Design:

`/evidence/:id`

Header example:

```text
TIC-EV-2026-00482
Transaction
Confirmed
Harmony

```

Sections:

```text
Description
Identifiers
Verification
Provenance
Related Claims
Related Investigations
Related Entities
Source
Raw Data reference

```

Technical values should use mono typography.

---

# 27. Source / provenance component

Design reusable provenance panel.

Example:

```text
Source
Harmony RPC

Retrieved
24 Aug 2026 18:32 UTC

Method
eth_getTransactionReceipt

Block
...

Checksum
...

```

---

# 28. Research Library

Design cards/list for:

```text
Research
Investigation Report
Technical Note
Incident Analysis
Dataset
Methodology

```

Include filters and responsive state.

---

# 29. Research article

Create publication layout suitable for substantial technical analysis.

Support:

```text
title
category
authors
published
last reviewed
summary
table of contents
facts
analysis
hypotheses
unknowns
sources
related evidence
related investigations

```

Optimize long-form readability.

---

# 30. Entities

Design entity explorer.

Entity types:

```text
Address
Contract
Token
Protocol
Network
Exchange
Organization
Incident

```

---

# 31. Address/entity detail

Example:

```text
0xAC0248...
Harmony

Attribution:
Not Determined

```

Tabs:

```text
Overview
Activity
Evidence
Relationships
Investigations

```

Include a clear neutral note where relevant:

> Wallet control does not by itself establish real-world identity.

---

# 32. Relationship graph

Create visual design for an entity relationship graph.

Nodes may include:

```text
address
contract
protocol
exchange
incident

```

Edges:

```text
sent to
deployed
owns
called
minted
bridged
referenced by

```

The design must differentiate:

technical relationship

from

identity attribution.

---

# 33. Networks

Design:

`/networks`

and

`/networks/:slug`

Network card states:

```text
Operational
Degraded
Incident
Unknown

```

Detail sections:

```text
Network Status
Block Production
RPC Health
Validators
Supply
Contracts
Bridge Status
Incidents
Research

```

---

# 34. Global search

Design:

- header search;
- expanded search;
- command palette.

Search categories:

```text
Transactions
Addresses
Contracts
Evidence
Investigations
Research
Networks
Entities

```

Show zero-result state.

---

# 35. REOWN wallet entry point

The product uses **Reown AppKit**.

The custom Think in Coin UI surrounding AppKit must feel native to the design system.

Header state:

### Disconnected

`Connect Wallet`

### Connected

```text
Network
0x7A3F...91C2

```

---

# 36. Wallet disconnected panel

Design:

```text
Connect to Think in Coin

Use your wallet to:
- verify address ownership
- monitor addresses
- submit signed evidence
- access contributor features

[ Connect Wallet ]

```

AppKit itself will own its connection modal where appropriate.

Do not redesign the third-party wallet chooser as a fake custom implementation.

---

# 37. Wallet connected menu

Design:

```text
Account
Network

Address
Copy
Explorer

My Addresses
Watchlist
Submissions

Disconnect

```

Also design:

- pending connection;
- connection error;
- wrong network.

---

# 38. Wallet Center

Design:

`/wallet`

Sections:

```text
Connected Wallet
Network
Native Balance
Verified Addresses
Signatures
Permissions
Recent Activity

```

Do not turn it into a portfolio/trading dashboard.

---

# 39. My Addresses

Design:

`/me/addresses`

Rows/cards:

```text
Label
Address
Network
Verification
Watch status
Actions

```

States:

```text
Unverified
Connected
Signature Verified

```

---

# 40. Address verification flow

Design complete wizard:

```text
1 Select Address
2 Review Statement
3 Sign
4 Verify
5 Success

```

Signing screen must clearly state:

> This signature verifies address control. It does not authorize a token transfer.

---

# 41. Watchlist

Design:

`/me/watchlist`

Watchable:

```text
addresses
contracts
investigations
networks

```

Include:

- empty state;
- populated state;
- filters.

---

# 42. Submissions

Design:

`/submissions`

and

`/submissions/new`

Submission types:

```text
Evidence
Correction
Additional Source
Technical Observation

```

---

# 43. Submission wizard

Design:

```text
Step 1 Type
Step 2 Related object
Step 3 Evidence/source
Step 4 Description
Step 5 Review
Step 6 Optional signature

```

Initial state:

`Pending Review`

Do not visually imply that submitted information is validated evidence.

---

# 44. Methodology

Create a strong institutional methodology page explaining:

```text
FACT
INFERENCE
HYPOTHESIS
OPINION

```

and separately:

```text
CONFIRMED
STRONGLY SUPPORTED
PROBABLE
POSSIBLE
UNDETERMINED

```

This page is a major part of institutional trust.

---

# 45. About

Design institutional page:

```text
What Think in Coin is
Independence
Public Utility
Transparency
What Think in Coin is not

```

---

# 46. Corrections

Design:

```text
Corrections Policy
Public Correction Log
Submit Correction

```

---

# 47. Data & API

Design developer/researcher surface:

```text
Datasets
Evidence Bundles
API
Exports
Documentation

```

May initially represent future functionality.

---

# 48. ADMIN UI

Create a dedicated admin system using the same visual language but optimized for dense editorial/research operations.

Admin sidebar should be clearly distinguishable from public navigation.

---

# 49. Admin dashboard

Cards/queues:

```text
Active Investigations
Draft Research
Pending Evidence
Pending Submissions
Corrections
Network Alerts
Recent Changes

```

Quick actions:

```text
New Investigation
New Evidence
New Research
Create Dataset

```

---

# 50. Admin investigations

Design high-density management table.

Columns:

```text
Title
Status
Owner
Visibility
Updated
Evidence
Claims

```

Actions:

```text
Open
Edit
Duplicate
Archive

```

---

# 51. Investigation editor

Design admin workspace:

```text
Overview
Claims
Evidence
Entities
Timeline
Sources
Publishing

```

Consider a contextual side panel for save/publish/review information.

---

# 52. Claim editor

Fields:

```text
Claim text

Kind
Fact
Inference
Hypothesis
Opinion

Assessment
Confirmed
Strongly Supported
Probable
Possible
Undetermined

Evidence links
Reasoning summary
Public notes
Internal notes

```

Create validation/error examples.

---

# 53. Evidence admin

Design:

- evidence list;
- evidence editor;
- source linking;
- provenance;
- related claims;
- investigation linking.

---

# 54. Submission review

Design side-by-side workflow:

```text
Submitted Material | Review

```

Actions:

```text
Request clarification
Link existing evidence
Create evidence
Mark duplicate
Reject
Accept for analysis

```

Avoid any button implying automatic "Confirm as fact".

---

# 55. Research editor

Create sophisticated editorial UI for:

```text
Title
Summary
Body
Sources
Claims
Evidence
Related investigations
SEO metadata
Preview
Publishing

```

---

# 56. Networks admin

Design management for:

```text
Network metadata
RPC endpoints
Explorer
Icon
Status
Monitoring configuration

```

Secrets must never appear exposed in mock UI.

---

# 57. Roles

Design roles/permissions management surface for future backend integration:

```text
Admin
Editor
Researcher
Reviewer
Contributor

```

Do not imply the frontend alone controls authorization.

---

# 58. Design system documentation screen

Produce a dedicated master UI Pack page showing all tokens and components.

Sections:

```text
Brand
Colors
Typography
Spacing
Grid
Radius
Borders
Icons

Buttons
Inputs
Selects
Checkboxes
Switches

Badges
Tabs
Breadcrumbs

Cards
Panels
Tables

Navigation

Dialogs
Drawers
Popovers
Tooltips

Alerts

Evidence components
Claim components
Network components

Wallet components

Admin components

Skeletons
Empty states
Error states

```

---

# 59. Buttons

Produce complete variants:

```text
Primary
Secondary
Ghost
Outline
Danger
Link
Icon

```

States:

```text
default
hover
active
focus
disabled
loading

```

Sizes.

---

# 60. Inputs

Produce:

```text
Text
Search
Textarea
Select
Combobox
Checkbox
Radio
Switch
Date
Date range

```

States:

```text
default
focus
filled
disabled
error
success

```

---

# 61. Tags and badges

Create systematic components for:

- investigation status;
- assessment;
- claim type;
- network;
- research type;
- entity type.

Avoid an uncontrolled proliferation of colors.

---

# 62. Cards

Create reusable variants:

```text
Basic Card
Metric Card
Investigation Card
Research Card
Evidence Card
Network Card
Entity Card
Action Card

```

Document structure.

---

# 63. Tables

Create desktop table system.

Support:

```text
header
sortable header
selection
filtering
pagination
row actions
expanded row
loading
empty
error

```

Technical hashes require mono treatment and truncation rules.

---

# 64. Mobile data cards

Every major table must have a specified mobile transformation.

Produce reusable mobile row/card pattern.

---

# 65. Dialogs / drawers / popovers

Create:

```text
Modal
Confirmation
Danger confirmation
Drawer
Wallet/account popover
Filter drawer
Context menu
Tooltip

```

Specify mobile differences.

---

# 66. Feedback

Create:

```text
Toast
Inline alert
Banner
Success
Warning
Error
Informational

```

---

# 67. Loading

Create skeletons for:

```text
Dashboard
Card
Table
Dossier
Article
Wallet
Network status
Admin editor

```

Avoid relying on global spinners.

---

# 68. Empty states

Create meaningful examples:

```text
No evidence found
No investigations match
No verified addresses
No watched entities
No submissions
No search results

```

---

# 69. Error states

Create:

```text
Generic Error
API Unavailable
RPC Unavailable
Wallet Error
Wrong Network
Invalid Address
Evidence Source Unavailable
404
Unauthorized

```

---

# 70. Responsive widths

Design at minimum:

```text
375px mobile reference
768px tablet reference
1280/1440 desktop reference
wide desktop behavior

```

Also ensure conceptual compatibility down to 320px.

---

# 71. Responsive rules

Document explicitly:

```text
what disappears
what stacks
what becomes drawer
what becomes horizontal scroll
what transforms to cards
what remains sticky

```

Do not leave responsive interpretation entirely to the developer.

---

# 72. Accessibility

Visual specification must support:

- WCAG contrast;
- visible focus;
- non-color status indicators;
- minimum target sizes;
- reduced motion;
- accessible forms;
- readable technical data.

---

# 73. Motion specification

Create only restrained motion tokens/patterns:

```text
micro
standard
panel
modal

```

Use for:

- focus;
- tab transition;
- panel reveal;
- wallet status;
- graph selection.

No decorative infinite animation.

---

# 74. Content density

Create density modes/patterns where needed:

```text
Comfortable
Compact

```

Admin and evidence tables may use compact density.

Long-form research should remain comfortable.

---

# 75. Logo usage

Define exact UI contexts:

### Full lockup

Expanded sidebar, institutional pages.

### TIC monogram

Collapsed sidebar, favicon-like contexts, mobile.

### Watermark

Only where brand rules permit and never at the expense of readability.

---

# 76. Implementation target

The frontend will ultimately be:

```text
Vite
React
TypeScript
React Router
Tailwind CSS
Reown AppKit
Wagmi
Viem
TanStack Query

```

The UI Pack should therefore be practical to translate into reusable React components.

Do not generate Next.js-specific design assumptions.

---

# 77. Component naming contract

For every reusable component, provide a stable semantic name.

Prefer names like:

```text
AssessmentBadge
ClaimCard
EvidenceTable
NetworkStatusCard
WalletAccountButton

```

rather than names tied to one page such as:

```text
GreenBox23
HomepageCard2

```

---

# 78. Component anatomy

For important components document:

```text
Name
Purpose
Anatomy
Props/variants concept
States
Responsive behavior
Accessibility note
Usage example
Do / Don't

```

This is critical for handoff.

---

# 79. Token handoff

Produce implementation-ready token documentation.

At minimum:

```text
color tokens
typography tokens
spacing
radius
border
shadow/elevation
motion
breakpoints
z-index strategy

```

Prefer semantic tokens over raw page-specific values.

---

# 80. CSS variable mapping

Provide a proposed CSS custom property map compatible with implementation.

Example style:

```css
--tic-bg-canvas:
--tic-bg-surface:
--tic-bg-elevated:

--tic-text-primary:
--tic-text-secondary:

--tic-border-subtle:

--tic-brand:
--tic-focus:

--tic-assessment-confirmed:
...

```

Do not limit the pack to Figma-like visual values without an implementation mapping.

---

# 81. Tailwind handoff

Where useful, document how semantic tokens should map conceptually into Tailwind theme utilities.

Do not hardcode a unique random hex value in every component.

---

# 82. Required complete screen pack

Produce, at minimum:

```text
PUBLIC

01 Overview Desktop
02 Overview Tablet
03 Overview Mobile

04 Investigations
05 Investigation Overview
06 Investigation Timeline
07 Investigation Evidence
08 Investigation Entities
09 Investigation Analysis
10 Investigation Sources
11 Investigation Updates

12 Research Library
13 Research Article

14 Evidence Explorer
15 Evidence Detail

16 Entity Explorer
17 Entity / Address Detail
18 Relationship Graph

19 Networks
20 Network Detail

21 Search Results
22 Search Command Palette

23 Methodology
24 About
25 Corrections
26 Data & API


WEB3 / ACCOUNT

27 Wallet Disconnected
28 Wallet Connected
29 Wallet Error
30 Wrong Network
31 Wallet Center

32 My Addresses
33 Verify Address — Review
34 Verify Address — Signing
35 Verify Address — Success

36 Watchlist

37 Submissions
38 New Submission Step 1
39 New Submission Step 2
40 New Submission Step 3
41 New Submission Review
42 Submission Pending


ADMIN

43 Admin Dashboard
44 Admin Investigations
45 Admin Investigation Editor
46 Admin Claim Editor
47 Admin Evidence
48 Admin Evidence Editor
49 Admin Submissions
50 Admin Submission Review
51 Admin Research
52 Admin Research Editor
53 Admin Networks
54 Admin Users / Roles


SYSTEM

55 Design System
56 Loading/Skeleton Examples
57 Empty States
58 Error States
59 404
60 Mobile Admin Review

```

Where multiple screens share an identical template, create reusable templates rather than wastefully duplicating them—but demonstrate every materially different state.

---

# 83. Responsive examples

For the most critical screens, explicitly produce all three:

```text
Desktop
Tablet
Mobile

```

Mandatory:

```text
Home
Investigation
Evidence Explorer
Evidence Detail
Wallet
My Addresses
Submission
Admin Dashboard
Admin Review

```

---

# 84. Prototype interactions

Where possible, make navigation/interactions demonstrable:

```text
Sidebar
Tabs
Dropdowns
Filters
Wallet menu
Dialogs
Drawers
Mobile menu
Submission wizard
Admin editor tabs

```

The pack should communicate behavior, not just static appearance.

---

# 85. Content realism

Use realistic Think in Coin content based on the current Harmony investigation context, but do not invent criminal attribution.

Safe mock language:

```text
Anomalous activity
Observed flow
Control relationship
Unresolved attribution
Possible relationship
Identity not determined

```

---

# 86. Evidence integrity in UI

Whenever the UI shows an allegation, clearly differentiate:

```text
FACT
INFERENCE
HYPOTHESIS
OPINION

```

Do not allow presentation hierarchy to turn a hypothesis into an apparent fact.

---

# 87. Admin integrity

Admin workflows should reinforce review discipline.

A submission is not automatically evidence.

Evidence is not automatically confirmed.

A technical wallet relationship is not automatically identity attribution.

These distinctions should be reflected in component hierarchy and microcopy.

---

# 88. Deliverables

The final UI Pack must include:

## A. Brand-to-digital interpretation

How official identity maps into the software.

## B. Design tokens

Complete reusable token system.

## C. Typography specification

Brand, UI and mono.

## D. Grid/layout specification

Desktop/tablet/mobile.

## E. Application shells

Public, account/Web3 and admin.

## F. Component library

All reusable primitives and domain components.

## G. Page templates

All major product layouts.

## H. Screen pack

The complete screen/state list.

## I. Responsive specification

Explicit transformations.

## J. Interaction specification

Menus, tabs, dialogs, wallet states etc.

## K. Accessibility guidance

Per system/component where relevant.

## L. CSS variable reference

Implementation-ready.

## M. Component inventory

Stable component names.

## N. Asset manifest

List all required brand/icons/illustration assets and which are official vs newly created UI assets.

## O. Handoff notes for Coder

Implementation constraints and non-negotiable visual rules.

---

# 89. Coder handoff manifest

Finish with a concise manifest that the Coder can consume.

Example structure:

```text
FOUNDATIONS
- tokens
- typography
- breakpoints
- layouts

PRIMITIVES
- buttons
- inputs
- modal
...

DOMAIN COMPONENTS
- ClaimCard
- AssessmentBadge
...

SHELLS
- PublicShell
- AccountShell
- AdminShell

PAGE TEMPLATES
- Dossier
- Evidence Detail
...

ASSETS
- brand logo
- TIC monogram
...

RESPONSIVE CONTRACT
...

INTERACTION CONTRACT
...

```

---

# 90. Do not prematurely build backend functionality

This task concerns the **UI Pack and product interface**.

Do not invent:

- backend APIs;
- databases;
- production auth;
- blockchain indexers.

Represent required frontend states and contracts only.

---

# 91. Quality bar

The pack is complete only when a frontend engineer can answer from it:

- Which token do I use?
- Which component do I use?
- What variants exist?
- What is the mobile behavior?
- What is the loading state?
- What is the error state?
- How should wallet connection look?
- How does admin differ from public UI?
- How are evidence levels represented?
- How are claim types represented?
- What spacing/radius/type scale applies?
- What happens at tablet width?
- Which official brand asset belongs here?

without inventing a new design decision.

---

# 92. Final instruction

Produce the Think in Coin UI Pack as a cohesive design system and complete application mockup library.

Do not stop after designing the homepage.

The deliverable is the **visual production contract** for the entire Vite/React application.