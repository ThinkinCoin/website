# UI Pack Deviations

## Evidence semantics

The original UI Pack applied `Assessment` directly to evidence records. Architecture Amendment v1.1 supersedes that representation because epistemic assessment belongs to claims, while evidence needs verification and integrity dimensions.

Production behavior:

- `AssessmentBadge` is used only for claims.
- `VerificationBadge` represents `verified`, `partially_verified`, or `unverified` evidence.
- `IntegrityBadge` represents `intact`, `unknown`, or `disputed` evidence.
- Evidence tables and cards replace the original Assessment column with Verification and expose Integrity where relevant.
- Claim-to-evidence meaning remains explicit through `supports`, `contradicts`, or `contextualizes` links.

This is a semantic correction, not a visual redesign. The new badges reuse the UI Pack's shape, typography, icon-plus-label accessibility pattern, and restrained palette.
