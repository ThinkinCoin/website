# Architecture Amendment v1.1

This amendment supersedes the original UI Pack where evidence was assigned an epistemic `Assessment`.

1. Web3 package versions are resolved and lockfile-frozen during a compatibility spike; architecture requires AppKit, Wagmi, and Viem but no permanent patch versions.
2. Network catalog, research selection, and wallet-supported networks are distinct types and lifecycles.
3. Investigations expose a dynamic assessment distribution of published claims, not a global assessment. Dynamic summaries omit `calculatedAt`; materialized historical snapshots may include it.
4. Claims use `Assessment`. Evidence uses verification and integrity states.
5. Evidence lineage records `derived_from`, `corroborates`, `duplicates`, or `supersedes`, with optional transformation and processor version.
6. Coverage percentages are indicators. Critical domain, repository, signing/security, and E2E contracts are mandatory gates.
