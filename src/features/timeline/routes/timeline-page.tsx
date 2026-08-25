import { PageHeader } from '@/components/shared/page-header';
import { DataPanel } from '@/components/ui/card';
import { mockDatabase } from '@/mocks/db/mock-database';
import { formatDate } from '@/lib/utils';

export function GlobalTimelinePage() {
  return <div className="tic-page"><PageHeader eyebrow="Chronology" title="Global Timeline" description="Published research, evidence, network, and status events in chronological context." /><DataPanel><div className="tic-timeline">{mockDatabase.timeline.map((event) => <article className="tic-timeline-item" key={event.id}><span className="tic-fine-print">{formatDate(event.occurredAt)} · {event.category}</span><h2>{event.title}</h2><p className="tic-muted">{event.description}</p></article>)}</div></DataPanel></div>;
}
