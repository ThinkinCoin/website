import { useQuery } from '@tanstack/react-query';
import { Activity, ArrowRight, Database, Network, ScanSearch } from 'lucide-react';
import { Link } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { AssessmentBadge, ClaimKindBadge, VerificationBadge } from '@/components/ui/badges';
import { Card, DataPanel } from '@/components/ui/card';
import { LoadingState } from '@/components/ui/query-state';
import { mockDatabase } from '@/mocks/db/mock-database';

export function OverviewPage() {
  const repositories = useRepositories();
  const investigations = useQuery({ queryKey: queryKeys.investigations(), queryFn: () => repositories.investigations.list({ pageSize: 3 }) });
  const evidence = useQuery({ queryKey: queryKeys.evidenceList(), queryFn: () => repositories.evidence.list({ pageSize: 3 }) });
  const research = useQuery({ queryKey: queryKeys.researchList(), queryFn: () => repositories.research.list({ pageSize: 3 }) });
  const networks = useQuery({ queryKey: queryKeys.networks, queryFn: () => repositories.networks.list({ pageSize: 3 }) });
  const loading = investigations.isPending || evidence.isPending || research.isPending || networks.isPending;

  return (
    <div className="tic-page">
      <PageHeader
        eyebrow="Independent Digital Asset Intelligence"
        title="Research before conclusion."
        description="A public intelligence terminal for investigations, claims, evidence, provenance, and blockchain infrastructure."
        actions={<><Link className="tic-button tic-button--primary" to="/investigations">Explore investigations</Link><Link className="tic-button tic-button--secondary" to="/research">View research</Link></>}
      />
      {loading ? <LoadingState label="Preparing the intelligence overview…" /> : null}
      {!loading ? (
        <div className="tic-stack">
          <div className="tic-dashboard-grid">
            <DataPanel>
              <div className="tic-section-heading"><div><p className="tic-eyebrow">Current investigations</p><h2>Open dossiers</h2></div><Link to="/investigations" className="tic-fine-print">View all →</Link></div>
              <div className="tic-stack">{investigations.data?.items.map((item) => <Card key={item.id}><div className="tic-badge-row"><span className="tic-badge tic-badge--status">{item.status.replaceAll('_', ' ')}</span>{item.isSynthetic ? <span className="tic-badge tic-badge--integrity-unknown">Synthetic reference</span> : null}</div><h3>{item.title}</h3><p className="tic-muted">{item.summary}</p><Link className="tic-button tic-button--ghost" to={`/investigations/${item.slug}`}>Open dossier <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}</div>
            </DataPanel>
            <div className="tic-stack">
              <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Network status</p><h2>Research catalog</h2></div><Activity aria-hidden="true" /></div>{networks.data?.items.map((network) => <div className="tic-record-meta" key={network.id}><strong>{network.name}</strong><span>{network.status}</span><span>{network.slug === 'harmony-one' ? 'Wallet enabled' : 'Catalog only'}</span></div>)}</DataPanel>
              <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Evidence integrity</p><h2>Separate dimensions</h2></div><Database aria-hidden="true" /></div><p className="tic-muted">Claims receive epistemic assessments. Evidence records receive verification and integrity states.</p></DataPanel>
            </div>
          </div>
          <section>
            <div className="tic-section-heading"><div><p className="tic-eyebrow">Latest evidence</p><h2>Traceable technical material</h2></div><Link to="/evidence" className="tic-fine-print">Evidence Explorer →</Link></div>
            <div className="tic-grid tic-grid--3">{evidence.data?.items.map((item) => <Card key={item.id}><VerificationBadge status={item.verificationStatus} /><p className="tic-fine-print">{item.id}</p><h3>{item.title}</h3><p className="tic-muted">{item.description}</p><Link className="tic-button tic-button--ghost" to={`/evidence/${item.id}`}>Inspect provenance</Link></Card>)}</div>
          </section>
          <section>
            <div className="tic-section-heading"><div><p className="tic-eyebrow">Latest research</p><h2>Methods and analysis</h2></div><Link to="/research" className="tic-fine-print">Research library →</Link></div>
            <div className="tic-grid tic-grid--2">{research.data?.items.map((item) => <Card key={item.id}><ScanSearch aria-hidden="true" /><h3>{item.title}</h3><p className="tic-muted">{item.summary}</p><Link className="tic-button tic-button--secondary" to={`/research/${item.slug}`}>Read article</Link></Card>)}</div>
          </section>
          <section>
            <div className="tic-section-heading"><div><p className="tic-eyebrow">Epistemic model</p><h2>Claims remain explicit</h2></div><Network aria-hidden="true" /></div>
            <div className="tic-grid tic-grid--3">{mockDatabase.claims.map((claim) => <Card className="tic-claim" key={claim.id}><div className="tic-badge-row"><ClaimKindBadge kind={claim.kind} /><AssessmentBadge assessment={claim.assessment} /></div><blockquote>{claim.statement}</blockquote></Card>)}</div>
          </section>
        </div>
      ) : null}
    </div>
  );
}
