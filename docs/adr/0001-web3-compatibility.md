# ADR 0001: Web3 Compatibility Set

- Status: accepted for implementation
- Date: 2026-08-25

## Decision

The initial lockfile resolves Reown AppKit and its Wagmi adapter together, with a compatible Wagmi 2 and Viem 2 pair. Package versions are implementation evidence, not permanent architectural requirements; upgrades require repeating connect, disconnect, reconnect, network, signing, typecheck, build, and preview checks.

`WagmiAdapter` deliberately omits `ssr`. Think in Coin is a browser-only Vite SPA and has no cookie hydration or server-rendered React tree. SSR configuration must not be introduced without a measured requirement and a replacement ADR.

AppKit initialization is performed once at module scope. If `VITE_REOWN_PROJECT_ID` is absent, the application keeps public research available and presents wallet functionality as unavailable rather than using a production-unsafe placeholder credential.
