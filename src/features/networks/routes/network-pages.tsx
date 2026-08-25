import { useQuery } from '@tanstack/react-query';
import { Activity, ArrowRight, CircleGauge } from 'lucide-react';
import { Link, useParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { Card, DataPanel } from '@/components/ui/card';
import { ErrorState, LoadingState } from '@/components/ui/query-state';

export function NetworksPage() {
  const { networks } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.networks, queryFn: () => networks.list() });
  return <div className="tic-page"><PageHeader eyebrow="Network catalog" title="Networks" description="Research catalog coverage is independent from wallet-supported networks." />{result.isPending ? <LoadingState /> : null}{result.isError ? <ErrorState error={result.error} /> : null}<div className="tic-grid tic-grid--2">{result.data?.items.map((network) => <Card className="tic-stack" key={network.id}><div className="tic-badge-row"><span className={`tic-badge ${network.status === 'operational' ? 'tic-badge--verification-verified' : 'tic-badge--integrity-unknown'}`}><Activity aria-hidden="true" size={13} /> {network.status}</span></div><div><p className="tic-eyebrow">{network.namespace}:{network.chainId ?? 'catalog'}</p><h2>{network.name}</h2><p className="tic-muted">{network.description}</p></div><Link className="tic-button tic-button--secondary" to={`/networks/${network.slug}`}>Network detail <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}</div></div>;
}

export function NetworkDetailPage() {
  const { slug = '' } = useParams();
  const { networks } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.network(slug), queryFn: () => networks.getBySlug(slug) });
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  const network = result.data;
  return <div className="tic-page"><PageHeader eyebrow="Network detail" title={network.name} description={network.description} /><div className="tic-dashboard-grid"><DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Catalog metadata</p><h2>Technical identity</h2></div><CircleGauge aria-hidden="true" /></div><dl className="tic-definition-grid"><div><dt>Namespace</dt><dd>{network.namespace}</dd></div><div><dt>Chain ID</dt><dd className="tic-mono">{network.chainId ?? 'Not applicable'}</dd></div><div><dt>Native currency</dt><dd>{network.nativeCurrency?.symbol ?? 'Not recorded'}</dd></div><div><dt>Research status</dt><dd>{network.status}</dd></div></dl></DataPanel><DataPanel><p className="tic-eyebrow">Wallet boundary</p><h2>{network.slug === 'harmony-one' ? 'Enabled in v1' : 'Catalog only'}</h2><p className="tic-muted">Catalog presence never enables wallet operations automatically.</p></DataPanel></div></div>;
}
