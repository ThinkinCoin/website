import {
  createColumnHelper,
  createSortedRowModel,
  flexRender,
  rowSortingFeature,
  tableFeatures,
  useTable,
  type SortingState,
} from '@tanstack/react-table';
import { useQuery } from '@tanstack/react-query';
import { ArrowDownUp, ArrowRight, GitBranch, Search } from 'lucide-react';
import { useMemo, useState } from 'react';
import { Link, useParams, useSearchParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { ProvenancePanel } from '@/components/shared/provenance-panel';
import { TechnicalIdentifier } from '@/components/shared/technical-identifier';
import { IntegrityBadge, VerificationBadge } from '@/components/ui/badges';
import { Button } from '@/components/ui/button';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';
import type { Evidence } from '@/domain/models';
import { formatDate } from '@/lib/utils';

const evidenceTableFeatures = tableFeatures({
  rowSortingFeature,
  sortedRowModel: createSortedRowModel(),
});
const evidenceColumnHelper = createColumnHelper<typeof evidenceTableFeatures, Evidence>();

function EvidenceMobileCard({ item }: { item: Evidence }) {
  return (
    <Card className="tic-record-card">
      <div className="tic-badge-row"><VerificationBadge status={item.verificationStatus} /><IntegrityBadge status={item.integrityStatus} /></div>
      <div><TechnicalIdentifier value={item.id} /><h3>{item.title}</h3><p className="tic-muted">{item.description}</p></div>
      <div className="tic-record-meta"><span>{item.type.replace('_', ' ')}</span><span>{formatDate(item.createdAt)}</span></div>
      <Link to={`/evidence/${item.id}`} className="tic-button tic-button--secondary">Open record <ArrowRight aria-hidden="true" size={15} /></Link>
    </Card>
  );
}

function EvidenceTable({ records }: { records: Evidence[] }) {
  const [sorting, setSorting] = useState<SortingState>([]);
  const columns = useMemo(
    () => evidenceColumnHelper.columns([
      evidenceColumnHelper.accessor('id', {
        header: 'ID',
        cell: ({ row }) => <TechnicalIdentifier value={row.original.id} />,
      }),
      evidenceColumnHelper.accessor('type', {
        header: 'Type',
        cell: ({ getValue }) => String(getValue()).replace('_', ' '),
      }),
      evidenceColumnHelper.accessor('verificationStatus', {
        header: 'Verification',
        cell: ({ row }) => <VerificationBadge status={row.original.verificationStatus} />,
      }),
      evidenceColumnHelper.accessor('integrityStatus', {
        header: 'Integrity',
        cell: ({ row }) => <IntegrityBadge status={row.original.integrityStatus} />,
      }),
      evidenceColumnHelper.accessor('createdAt', {
        header: 'Added',
        cell: ({ getValue }) => formatDate(String(getValue())),
      }),
      evidenceColumnHelper.display({
        id: 'action',
        header: 'Action',
        cell: ({ row }) => <Link className="tic-button tic-button--ghost tic-button--sm" to={`/evidence/${row.original.id}`}>Inspect</Link>,
      }),
    ]),
    [],
  );
  const table = useTable({
    features: evidenceTableFeatures,
    data: records,
    columns,
    state: { sorting },
    onSortingChange: setSorting,
  });

  return (
    <>
      <div className="tic-table-wrap tic-desktop-table">
        <table className="tic-table">
          <thead>{table.getHeaderGroups().map((group) => <tr key={group.id}>{group.headers.map((header) => <th key={header.id}>{header.isPlaceholder ? null : <button className="tic-button tic-button--ghost tic-button--sm" type="button" onClick={header.column.getToggleSortingHandler()} disabled={!header.column.getCanSort()}>{flexRender(header.column.columnDef.header, header.getContext())}{header.column.getCanSort() ? <ArrowDownUp aria-hidden="true" size={12} /> : null}</button>}</th>)}</tr>)}</thead>
          <tbody>{table.getRowModel().rows.map((row) => <tr key={row.id}>{row.getAllCells().map((cell) => <td key={cell.id}>{flexRender(cell.column.columnDef.cell, cell.getContext())}</td>)}</tr>)}</tbody>
        </table>
      </div>
      <div className="tic-mobile-records">{records.map((item) => <EvidenceMobileCard key={item.id} item={item} />)}</div>
    </>
  );
}

export function EvidenceExplorerPage() {
  const { evidence } = useRepositories();
  const [params, setParams] = useSearchParams();
  const query = params.get('q') ?? '';
  const result = useQuery({
    queryKey: queryKeys.evidenceList(query),
    queryFn: () => evidence.list({ query }),
  });

  return (
    <div className="tic-page">
      <PageHeader eyebrow="Evidence database" title="Evidence Explorer" description="Technical material with independent verification, integrity, and provenance dimensions." />
      <form className="tic-search-input" onSubmit={(event) => { event.preventDefault(); const data = new FormData(event.currentTarget); const value = data.get('q'); setParams({ q: typeof value === 'string' ? value : '' }); }}>
        <Search aria-hidden="true" size={16} /><input name="q" defaultValue={query} placeholder="Evidence ID, hash, address, block…" /><Button type="submit" size="sm">Search</Button>
      </form>
      <div style={{ height: 'var(--tic-space-xl)' }} />
      {result.isPending ? <LoadingState /> : null}
      {result.isError ? <ErrorState error={result.error} retry={() => void result.refetch()} /> : null}
      {result.data?.items.length === 0 ? <EmptyState title="No evidence found" description="Change the identifier or remove the filter." /> : null}
      {result.data?.items ? <EvidenceTable records={result.data.items} /> : null}
    </div>
  );
}

export function EvidenceDetailPage() {
  const { id = '' } = useParams();
  const { evidence } = useRepositories();
  const record = useQuery({ queryKey: queryKeys.evidence(id), queryFn: () => evidence.getById(id) });
  const lineage = useQuery({ queryKey: queryKeys.evidenceLineage(id), queryFn: () => evidence.getLineage(id) });

  if (record.isPending) return <div className="tic-page"><LoadingState label="Loading evidence record…" /></div>;
  if (record.isError) return <div className="tic-page"><ErrorState error={record.error} retry={() => void record.refetch()} /></div>;
  const item = record.data;
  return (
    <div className="tic-page">
      <PageHeader eyebrow={item.type.replace('_', ' ')} title={item.title} description={item.description} actions={<TechnicalIdentifier value={item.id} />} />
      <div className="tic-badge-row" style={{ marginBottom: 'var(--tic-space-xl)' }}><VerificationBadge status={item.verificationStatus} /><IntegrityBadge status={item.integrityStatus} /></div>
      <div className="tic-dashboard-grid">
        <div className="tic-stack">
          <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Technical record</p><h2>Identifiers</h2></div></div><dl className="tic-definition-grid">{Object.entries(item.identifiers).map(([key, value]) => <div key={key}><dt>{key}</dt><dd><TechnicalIdentifier value={value} /></dd></div>)}</dl></DataPanel>
          <ProvenancePanel provenance={item.provenance} />
        </div>
        <DataPanel>
          <div className="tic-section-heading"><div><p className="tic-eyebrow">Lineage</p><h2>Derived and corroborating records</h2></div><GitBranch aria-hidden="true" /></div>
          {lineage.isPending ? <LoadingState label="Tracing lineage…" /> : null}
          {lineage.data?.length === 0 ? <EmptyState title="No lineage links" description="This record has no derived or corroborating records." /> : null}
          <div className="tic-stack">{lineage.data?.map((link) => <Card key={`${link.sourceEvidenceId}-${link.targetEvidenceId}-${link.kind}`}><span className="tic-badge tic-badge--status">{link.kind.replace('_', ' ')}</span><p><TechnicalIdentifier value={link.sourceEvidenceId} /> → <TechnicalIdentifier value={link.targetEvidenceId} /></p>{link.transformation ? <p className="tic-muted">{link.transformation} {link.transformationVersion ? `v${link.transformationVersion}` : ''}</p> : null}</Card>)}</div>
        </DataPanel>
      </div>
    </div>
  );
}
