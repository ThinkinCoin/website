import { useQuery } from '@tanstack/react-query';
import { ArrowRight, BookOpenCheck } from 'lucide-react';
import { Link, useParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';
import { formatDate } from '@/lib/utils';

export function ResearchLibraryPage() {
  const { research } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.researchList(), queryFn: () => research.list() });
  return (
    <div className="tic-page">
      <PageHeader eyebrow="Editorial research" title="Research Library" description="Published analysis connected to claims, evidence, sources, and investigations." />
      {result.isPending ? <LoadingState /> : null}
      {result.isError ? <ErrorState error={result.error} retry={() => void result.refetch()} /> : null}
      {result.data?.items.length === 0 ? <EmptyState title="No research published" description="Reviewed articles will appear here." /> : null}
      <div className="tic-grid tic-grid--2">{result.data?.items.map((item) => <Card className="tic-stack" key={item.id}><BookOpenCheck aria-hidden="true" /><div><p className="tic-eyebrow">Published {formatDate(item.publishedAt)}</p><h2>{item.title}</h2><p className="tic-muted">{item.summary}</p></div><Link className="tic-button tic-button--secondary" to={`/research/${item.slug}`}>Read research <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}</div>
    </div>
  );
}

export function ResearchArticlePage() {
  const { slug = '' } = useParams();
  const { research } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.research(slug), queryFn: () => research.getBySlug(slug) });
  if (result.isPending) return <div className="tic-page"><LoadingState label="Loading research…" /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} retry={() => void result.refetch()} /></div>;
  const item = result.data;
  return (
    <article className="tic-page">
      <PageHeader eyebrow="Research article" title={item.title} description={item.summary} />
      <DataPanel style={{ maxWidth: 'var(--tic-content-readable)' }}>
        <p className="tic-fine-print">Published {formatDate(item.publishedAt)} · Updated {formatDate(item.updatedAt)}</p>
        {item.body.split('\n\n').map((paragraph) => <p key={paragraph}>{paragraph}</p>)}
        <div className="tic-alert"><BookOpenCheck aria-hidden="true" size={18} /><span>This article references {item.claimIds.length} claims, {item.evidenceIds.length} evidence records, and {item.sourceIds.length} sources.</span></div>
      </DataPanel>
    </article>
  );
}
