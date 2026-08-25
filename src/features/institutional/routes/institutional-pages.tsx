import { AlertTriangle, BookOpenCheck, Braces, Building2, Scale } from 'lucide-react';
import { PageHeader } from '@/components/shared/page-header';
import { Card, DataPanel } from '@/components/ui/card';

function InstitutionalPage({ eyebrow, title, description, children }: { eyebrow: string; title: string; description: string; children: React.ReactNode }) {
  return <div className="tic-page"><PageHeader eyebrow={eyebrow} title={title} description={description} /><DataPanel style={{ maxWidth: 'var(--tic-content-readable)' }}>{children}</DataPanel></div>;
}

export function MethodologyPage() {
  return <InstitutionalPage eyebrow="Research discipline" title="Methodology" description="A transparent framework for claims, evidence, provenance, and uncertainty."><div className="tic-stack"><Card><BookOpenCheck aria-hidden="true" /><h2>Classify the statement</h2><p className="tic-muted">Every published claim is explicitly a fact, inference, hypothesis, or opinion.</p></Card><Card><Scale aria-hidden="true" /><h2>Assess claims, verify evidence</h2><p className="tic-muted">Epistemic assessment applies to claims. Evidence has independent verification, integrity, provenance, and relevance relationships.</p></Card><Card><AlertTriangle aria-hidden="true" /><h2>Avoid identity overreach</h2><p className="tic-muted">Address control and wallet signatures never establish a person's real-world identity by themselves.</p></Card></div></InstitutionalPage>;
}

export function AboutPage() {
  return <InstitutionalPage eyebrow="About Think in Coin" title="Independent by design" description="A qualified research community focused on investigation rather than popularity."><Building2 aria-hidden="true" /><p>Think in Coin grew from a technically qualified Telegram community that followed projects across multiple networks, with sustained attention to Harmony.</p><p>Published work remains open to the public. Contributor and administrative capabilities are separate from wallet connection and future authentication.</p></InstitutionalPage>;
}

export function CorrectionsPage() {
  return <InstitutionalPage eyebrow="Editorial accountability" title="Corrections" description="Research remains reviewable, traceable, and open to correction."><p>Submit a correction with the affected object, supporting source, technical context, and a clear description. A correction enters Pending Review and does not silently rewrite the historical record.</p><p>Accepted corrections should preserve previous publication state, review timestamp, and rationale.</p></InstitutionalPage>;
}

export function DataPage() {
  return <InstitutionalPage eyebrow="Data boundary" title="Data & API" description="The current frontend uses coherent versioned fixtures behind replaceable repositories."><Braces aria-hidden="true" /><p>No production API contract is claimed. Future services will implement the same repository ports and map external DTOs into domain models.</p><pre className="tic-mono">fetch → normalize → validate → hash → snapshot → publish</pre><p>RPC endpoints used by offline tooling remain outside the Vite client bundle.</p></InstitutionalPage>;
}

export function UnauthorizedPage() {
  return <InstitutionalPage eyebrow="Access boundary" title="Administrative access unavailable" description="This client-side route boundary is informational and never substitutes for server authorization."><AlertTriangle aria-hidden="true" /><p>Enable the development-only mock session for local editorial UI review, or connect a future AuthGateway backed by a server session.</p></InstitutionalPage>;
}

export function NotFoundPage() {
  return <InstitutionalPage eyebrow="404" title="Intelligence object not found" description="The requested route or object does not exist in the current repository."><p>Check the identifier or return to the investigation and evidence indexes.</p></InstitutionalPage>;
}
