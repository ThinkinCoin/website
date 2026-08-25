import type { EvidenceProvenance } from '@/domain/models';
import { formatDate } from '@/lib/utils';
import { DataPanel } from '@/components/ui/card';
import { TechnicalIdentifier } from '@/components/shared/technical-identifier';

export function ProvenancePanel({ provenance }: { provenance: EvidenceProvenance }) {
  const rows = [
    ['Publisher', provenance.publisher],
    ['Retrieved', provenance.retrievedAt ? formatDate(provenance.retrievedAt) : undefined],
    ['Method', provenance.retrievalMethod],
    ['RPC method', provenance.rpcMethod],
    ['Block', provenance.blockNumber],
    ['Snapshot', provenance.contentSnapshotRef],
    ['Archived', provenance.archivedLocation],
  ].filter((row): row is [string, string] => Boolean(row[1]));

  return (
    <DataPanel>
      <div className="tic-section-heading">
        <div>
          <p className="tic-eyebrow">Traceability</p>
          <h2>Provenance</h2>
        </div>
      </div>
      <dl className="tic-definition-grid">
        {rows.map(([label, value]) => (
          <div key={label}>
            <dt>{label}</dt>
            <dd>{value}</dd>
          </div>
        ))}
        {provenance.transactionHash ? (
          <div>
            <dt>Transaction</dt>
            <dd><TechnicalIdentifier value={provenance.transactionHash} /></dd>
          </div>
        ) : null}
        {provenance.checksum ? (
          <div>
            <dt>Checksum</dt>
            <dd><TechnicalIdentifier value={provenance.checksum} /></dd>
          </div>
        ) : null}
      </dl>
    </DataPanel>
  );
}
