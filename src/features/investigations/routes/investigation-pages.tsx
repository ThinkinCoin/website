import { useQuery } from '@tanstack/react-query';
import { AlertTriangle, ArrowRight, Eye, FileCheck2, Network } from 'lucide-react';
import { Link, NavLink, Outlet, useOutletContext, useParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { TechnicalIdentifier } from '@/components/shared/technical-identifier';
import {
  AssessmentBadge,
  ClaimKindBadge,
  IntegrityBadge,
  InvestigationStatusBadge,
  VerificationBadge,
} from '@/components/ui/badges';
import { Button } from '@/components/ui/button';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';
import type { InvestigationDetail } from '@/repositories/ports/repositories';
import { summarizePublishedClaims } from '@/domain/semantics/assessment';
import { assessmentLabels, investigationStatusLabels } from '@/domain/semantics/labels';
import { formatDate } from '@/lib/utils';

const tabs = [
  ['', 'Overview'],
  ['timeline', 'Timeline'],
  ['evidence', 'Evidence'],
  ['entities', 'Entities'],
  ['analysis', 'Analysis'],
  ['sources', 'Sources'],
  ['updates', 'Updates'],
] as const;

function InvestigationCard({ item }: { item: InvestigationDetail['investigation'] }) {
  return (
    <Card className="tic-stack">
      <div className="tic-badge-row">
        <InvestigationStatusBadge status={item.status} />
        {item.isSynthetic ? <span className="tic-badge tic-badge--integrity-unknown">Synthetic reference</span> : null}
      </div>
      <div>
        <h2>{item.title}</h2>
        <p className="tic-muted">{item.summary}</p>
      </div>
      <div className="tic-record-meta">
        <span>{item.claimIds.length} claims</span>
        <span>{item.evidenceIds.length} evidence records</span>
        <span>Reviewed {formatDate(item.lastReviewedAt)}</span>
      </div>
      <Link to={`/investigations/${item.slug}`} className="tic-button tic-button--secondary">
        Open dossier <ArrowRight aria-hidden="true" size={15} />
      </Link>
    </Card>
  );
}

export function InvestigationsPage() {
  const { investigations } = useRepositories();
  const result = useQuery({
    queryKey: queryKeys.investigations(),
    queryFn: () => investigations.list(),
  });

  return (
    <div className="tic-page">
      <PageHeader
        eyebrow="Public intelligence"
        title="Investigations"
        description="Dossiers that keep claims, technical material, provenance, and uncertainty visibly connected."
      />
      {result.isPending ? <LoadingState /> : null}
      {result.isError ? <ErrorState error={result.error} retry={() => void result.refetch()} /> : null}
      {result.data?.items.length === 0 ? <EmptyState title="No investigations" description="Published dossiers will appear here." /> : null}
      <div className="tic-grid tic-grid--2">
        {result.data?.items.map((item) => <InvestigationCard key={item.id} item={item} />)}
      </div>
    </div>
  );
}

export function InvestigationLayout() {
  const { slug = '' } = useParams();
  const { investigations } = useRepositories();
  const result = useQuery({
    queryKey: queryKeys.investigation(slug),
    queryFn: () => investigations.getBySlug(slug),
  });

  if (result.isPending) return <div className="tic-page"><LoadingState label="Loading dossier…" /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} retry={() => void result.refetch()} /></div>;

  const { investigation } = result.data;
  return (
    <div className="tic-page">
      {investigation.isSynthetic ? (
        <div className="tic-synthetic-banner"><AlertTriangle aria-hidden="true" size={16} /> This reference dossier combines public network metadata with clearly synthetic investigative narrative.</div>
      ) : null}
      <PageHeader
        eyebrow="Investigation dossier"
        title={investigation.title}
        description={investigation.summary}
        actions={<><Button variant="secondary"><Eye aria-hidden="true" size={15} /> Watch</Button><Button variant="ghost">Share</Button></>}
      />
      <div className="tic-badge-row" style={{ marginBottom: 'var(--tic-space-xl)' }}>
        <InvestigationStatusBadge status={investigation.status} />
        <span className="tic-fine-print">Last reviewed {formatDate(investigation.lastReviewedAt)}</span>
      </div>
      <nav className="tic-tabs" aria-label="Investigation sections">
        {tabs.map(([path, label]) => (
          <NavLink key={label} end={!path} className="tic-tab" to={path}>{label}</NavLink>
        ))}
      </nav>
      <Outlet context={result.data} />
    </div>
  );
}

function useInvestigationDetail() {
  return useOutletContext<InvestigationDetail>();
}

export function InvestigationOverviewPage() {
  const detail = useInvestigationDetail();
  const summary = summarizePublishedClaims(detail.claims);
  const claimEvidenceCount = (claimId: string) => detail.claimEvidenceLinks.filter((link) => link.claimId === claimId).length;
  return (
    <div className="tic-stack">
      <div className="tic-dashboard-grid">
        <DataPanel>
          <p className="tic-eyebrow">Executive summary</p>
          <h2>Evidence-led monitoring without premature attribution</h2>
          <p className="tic-muted">{detail.investigation.summary}</p>
          <div className="tic-alert tic-alert--warning">
            <AlertTriangle aria-hidden="true" size={18} />
            <span>Technical control, network interaction, and wallet signatures do not establish real-world identity.</span>
          </div>
        </DataPanel>
        <DataPanel>
          <p className="tic-eyebrow">Status history</p>
          <h2>{investigationStatusLabels[detail.investigation.status]}</h2>
          <p className="tic-muted">{detail.investigation.statusHistory.at(-1)?.note}</p>
          <span className="tic-fine-print">Changed {formatDate(detail.investigation.statusHistory.at(-1)?.changedAt)}</span>
        </DataPanel>
      </div>
      <section>
        <div className="tic-section-heading"><div><p className="tic-eyebrow">Published claims</p><h2>Assessment distribution</h2></div><span className="tic-fine-print">Dynamic projection · {summary.totalClaims} claims</span></div>
        <div className="tic-grid tic-grid--4">
          {Object.entries(summary.counts).map(([assessment, count]) => (
            <Card className="tic-stat" key={assessment}><span>{assessmentLabels[assessment as keyof typeof assessmentLabels]}</span><strong>{count}</strong><AssessmentBadge assessment={assessment as keyof typeof assessmentLabels} /></Card>
          ))}
        </div>
      </section>
      <section>
        <div className="tic-section-heading"><div><p className="tic-eyebrow">Reasoning ledger</p><h2>Key claims</h2></div></div>
        <div className="tic-grid tic-grid--2">
          {detail.claims.map((claim) => (
            <Card className="tic-claim" key={claim.id}>
              <div className="tic-badge-row"><ClaimKindBadge kind={claim.kind} /><AssessmentBadge assessment={claim.assessment} /></div>
              <blockquote>{claim.statement}</blockquote>
              {claim.reasoningSummary ? <p className="tic-muted">{claim.reasoningSummary}</p> : null}
              <div className="tic-claim-meta"><span>{claimEvidenceCount(claim.id)} linked evidence</span><span>Reviewed {formatDate(claim.lastReviewedAt)}</span></div>
            </Card>
          ))}
        </div>
      </section>
    </div>
  );
}

export function InvestigationTimelinePage() {
  const { timeline } = useInvestigationDetail();
  return (
    <DataPanel>
      <div className="tic-section-heading"><div><p className="tic-eyebrow">Chronology</p><h2>Dossier timeline</h2></div></div>
      <div className="tic-timeline">
        {timeline.map((event) => <article className="tic-timeline-item" key={event.id}><span className="tic-fine-print">{formatDate(event.occurredAt)} · {event.category}</span><h3>{event.title}</h3><p className="tic-muted">{event.description}</p></article>)}
      </div>
    </DataPanel>
  );
}

export function InvestigationEvidencePage() {
  const { evidence } = useInvestigationDetail();
  return (
    <div className="tic-stack">
      <div className="tic-section-heading"><div><p className="tic-eyebrow">Linked material</p><h2>Evidence</h2></div><span className="tic-fine-print">Assessment is intentionally not applied to evidence.</span></div>
      <div className="tic-grid tic-grid--2">
        {evidence.map((item) => <Card className="tic-record-card" key={item.id}><div className="tic-badge-row"><VerificationBadge status={item.verificationStatus} /><IntegrityBadge status={item.integrityStatus} /></div><div><TechnicalIdentifier value={item.id} /><h3>{item.title}</h3><p className="tic-muted">{item.description}</p></div><Link className="tic-button tic-button--secondary" to={`/evidence/${item.id}`}>Inspect provenance <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}
      </div>
    </div>
  );
}

export function InvestigationEntitiesPage() {
  const { entities } = useInvestigationDetail();
  return <div className="tic-grid tic-grid--2">{entities.map((entity) => <Card key={entity.id}><Network aria-hidden="true" /><h2>{entity.name}</h2><p className="tic-muted">{entity.description}</p>{entity.attributionNote ? <p className="tic-fine-print">{entity.attributionNote}</p> : null}<Link className="tic-button tic-button--secondary" to={`/entities/${entity.id}`}>Open entity</Link></Card>)}</div>;
}

export function InvestigationAnalysisPage() {
  const { claims } = useInvestigationDetail();
  return <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Analysis</p><h2>What is known and what remains open</h2></div></div><div className="tic-stack">{claims.map((claim) => <article key={claim.id} className="tic-claim"><div className="tic-badge-row"><ClaimKindBadge kind={claim.kind} /><AssessmentBadge assessment={claim.assessment} /></div><blockquote>{claim.statement}</blockquote><p className="tic-muted">{claim.publicNotes ?? claim.reasoningSummary ?? 'No additional public reasoning recorded.'}</p></article>)}</div></DataPanel>;
}

export function InvestigationSourcesPage() {
  const { sources } = useInvestigationDetail();
  return <div className="tic-grid tic-grid--2">{sources.map((source) => <Card key={source.id}><FileCheck2 aria-hidden="true" /><p className="tic-eyebrow">{source.type}</p><h2>{source.title}</h2><p className="tic-muted">Published by {source.publisher}</p>{source.checksum ? <TechnicalIdentifier value={source.checksum} /> : null}</Card>)}</div>;
}

export function InvestigationUpdatesPage() {
  const { investigation } = useInvestigationDetail();
  return <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Change record</p><h2>Status updates</h2></div></div><div className="tic-timeline">{investigation.statusHistory.map((change) => <article className="tic-timeline-item" key={`${change.to}-${change.changedAt}`}><span className="tic-fine-print">{formatDate(change.changedAt)}</span><h3>{investigationStatusLabels[change.to]}</h3><p className="tic-muted">{change.note}</p></article>)}</div></DataPanel>;
}
