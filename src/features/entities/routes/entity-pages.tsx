import { Background, Controls, ReactFlow, type Edge, type Node } from '@xyflow/react';
import '@xyflow/react/dist/style.css';
import { useQuery } from '@tanstack/react-query';
import { ArrowRight, Network as NetworkIcon } from 'lucide-react';
import { Link, useParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { TechnicalIdentifier } from '@/components/shared/technical-identifier';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';

export function EntityExplorerPage() {
  const { entities } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.entities(), queryFn: () => entities.list() });
  return (
    <div className="tic-page">
      <PageHeader eyebrow="Entity registry" title="Entities" description="Technical and institutional objects described without conflating address control with human identity." />
      {result.isPending ? <LoadingState /> : null}
      {result.isError ? <ErrorState error={result.error} retry={() => void result.refetch()} /> : null}
      <div className="tic-grid tic-grid--2">{result.data?.items.map((entity) => <Card className="tic-stack" key={entity.id}><NetworkIcon aria-hidden="true" /><div><p className="tic-eyebrow">{entity.type}</p><h2>{entity.name}</h2><p className="tic-muted">{entity.description}</p></div>{entity.identifiers[0] ? <TechnicalIdentifier value={entity.identifiers[0].value} /> : null}<Link className="tic-button tic-button--secondary" to={`/entities/${entity.id}`}>Open entity <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}</div>
    </div>
  );
}

export function EntityDetailPage() {
  const { id = '' } = useParams();
  const { entities } = useRepositories();
  const entity = useQuery({ queryKey: queryKeys.entity(id), queryFn: () => entities.getById(id) });
  const relationships = useQuery({ queryKey: queryKeys.relationships(id), queryFn: () => entities.relationships(id) });
  if (entity.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (entity.isError) return <div className="tic-page"><ErrorState error={entity.error} /></div>;
  return (
    <div className="tic-page">
      <PageHeader eyebrow={entity.data.type} title={entity.data.name} description={entity.data.description} actions={<Link className="tic-button tic-button--secondary" to="relationships">Relationship graph</Link>} />
      {entity.data.attributionNote ? <div className="tic-alert tic-alert--warning"><span>{entity.data.attributionNote}</span></div> : null}
      <div style={{ height: 'var(--tic-space-lg)' }} />
      <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Registry</p><h2>Identifiers</h2></div></div><div className="tic-stack">{entity.data.identifiers.map((identifier) => <div key={`${identifier.kind}-${identifier.value}`}><span className="tic-fine-print">{identifier.kind}</span><br /><TechnicalIdentifier value={identifier.value} /></div>)}</div></DataPanel>
      <div style={{ height: 'var(--tic-space-lg)' }} />
      <DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Observed links</p><h2>Relationships</h2></div></div>{relationships.data?.length ? relationships.data.map((relationship) => <Card key={relationship.id}><span className="tic-badge tic-badge--status">{relationship.kind.replace('_', ' ')}</span><p className="tic-muted">{relationship.note}</p></Card>) : <EmptyState title="No relationships" description="No evidence-backed relationship has been recorded." />}</DataPanel>
    </div>
  );
}

export function EntityRelationshipGraphPage() {
  const { id = '' } = useParams();
  const { entities } = useRepositories();
  const entity = useQuery({ queryKey: queryKeys.entity(id), queryFn: () => entities.getById(id) });
  const links = useQuery({ queryKey: queryKeys.relationships(id), queryFn: () => entities.relationships(id) });
  if (entity.isPending || links.isPending) return <div className="tic-page"><LoadingState label="Building evidence-backed graph…" /></div>;
  if (entity.isError || links.isError) return <div className="tic-page"><ErrorState error={entity.error ?? links.error} /></div>;
  const relatedIds = [...new Set(links.data.flatMap((link) => [link.fromEntityId, link.toEntityId]))];
  const nodes: Node[] = relatedIds.map((entityId, index) => ({ id: entityId, position: { x: index * 280, y: index % 2 ? 180 : 30 }, data: { label: entityId === entity.data.id ? entity.data.name : entityId }, style: { background: '#0d211b', color: '#f3f6f4', border: '1px solid rgba(126,170,150,.38)', borderRadius: 8, padding: 12 } }));
  const edges: Edge[] = links.data.map((link) => ({ id: link.id, source: link.fromEntityId, target: link.toEntityId, label: link.kind.replace('_', ' '), animated: false, style: { stroke: '#4edbc6' }, labelStyle: { fill: '#a6b1ac' } }));
  return <div className="tic-page"><PageHeader eyebrow="Evidence-backed graph" title={`${entity.data.name} relationships`} description="Technical relationships do not establish human identity or control beyond the cited evidence." /><div className="tic-graph"><ReactFlow nodes={nodes} edges={edges} fitView><Background color="#1c413a" gap={28} /><Controls /></ReactFlow></div></div>;
}
