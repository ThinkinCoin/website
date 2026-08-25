import { useQuery } from '@tanstack/react-query';
import { Search } from 'lucide-react';
import { Link, useSearchParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { Button } from '@/components/ui/button';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';

export function SearchPage() {
  const [params, setParams] = useSearchParams();
  const query = params.get('q') ?? '';
  const { search } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.search(query), queryFn: () => search.search(query), enabled: query.length > 1 });
  return <div className="tic-page"><PageHeader eyebrow="Global resolver" title="Search" description="Resolve technical identifiers and published intelligence objects." /><form className="tic-search-input" onSubmit={(event) => { event.preventDefault(); const data = new FormData(event.currentTarget); setParams({ q: String(data.get('q') ?? '') }); }}><Search aria-hidden="true" size={16} /><input name="q" defaultValue={query} placeholder="Hash, address, evidence ID, investigation…" /><Button type="submit" size="sm">Search</Button></form><div style={{ height: 'var(--tic-space-xl)' }} />{result.isPending && query.length > 1 ? <LoadingState label="Searching…" /> : null}{result.isError ? <ErrorState error={result.error} /> : null}{result.data?.length === 0 ? <EmptyState title="No results" description="Try a broader research term or another identifier." /> : null}<div className="tic-stack">{result.data?.map((item) => <Link className="tic-command-result tic-card" key={`${item.kind}-${item.id}`} to={item.destination}><span>{item.kind}</span><span><strong>{item.label}</strong><br /><small className="tic-muted">{item.description}</small></span></Link>)}</div></div>;
}
