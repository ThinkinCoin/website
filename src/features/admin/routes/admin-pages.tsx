import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import {
  AlertTriangle,
  ArrowRight,
  BookOpen,
  CheckCircle2,
  Database,
  FileSearch,
  FolderKanban,
  Network,
  Save,
  Send,
  Users,
} from 'lucide-react';
import { useState } from 'react';
import { Link, useParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { ProvenancePanel } from '@/components/shared/provenance-panel';
import { TechnicalIdentifier } from '@/components/shared/technical-identifier';
import { AssessmentBadge, ClaimKindBadge, IntegrityBadge, VerificationBadge } from '@/components/ui/badges';
import { Button } from '@/components/ui/button';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';
import type { SubmissionStatus } from '@/domain/models';
import { formatDate } from '@/lib/utils';

function AdminBoundaryNotice() {
  return <div className="tic-alert tic-alert--warning"><AlertTriangle aria-hidden="true" size={18} /><span>Development repository adapter active. Client roles and buttons do not provide server authorization.</span></div>;
}

export function AdminDashboardPage() {
  const { admin } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.adminDashboard, queryFn: () => admin.getDashboard() });
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  const cards = [
    ['Active investigations', result.data.activeInvestigations, FolderKanban, '/admin/investigations'],
    ['Draft research', result.data.draftResearch, BookOpen, '/admin/research'],
    ['Evidence requiring review', result.data.pendingEvidence, Database, '/admin/evidence'],
    ['Pending submissions', result.data.pendingSubmissions, Send, '/admin/submissions'],
    ['Corrections', result.data.corrections, FileSearch, '/admin/submissions'],
    ['Network alerts', result.data.networkAlerts, Network, '/admin/networks'],
  ] as const;
  return <div className="tic-page"><PageHeader eyebrow="Research operations" title="Admin Dashboard" description="Editorial queues and publication controls remain distinct from public intelligence." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-grid tic-grid--3">{cards.map(([label, value, Icon, destination]) => <Link to={destination} key={label}><Card className="tic-stat"><Icon aria-hidden="true" /><strong>{value}</strong><span>{label}</span></Card></Link>)}</div></div>;
}

export function AdminInvestigationsPage() {
  const { investigations } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.investigations('admin'), queryFn: () => investigations.list({ pageSize: 100 }) });
  return <div className="tic-page"><PageHeader eyebrow="Admin" title="Investigations" description="High-density management of dossier state, claims, evidence, and publication." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} />{result.isPending ? <LoadingState /> : null}<div className="tic-table-wrap"><table className="tic-table"><thead><tr><th>Title</th><th>Status</th><th>Visibility</th><th>Updated</th><th>Evidence</th><th>Claims</th><th>Action</th></tr></thead><tbody>{result.data?.items.map((item) => <tr key={item.id}><td>{item.title}</td><td>{item.status.replaceAll('_', ' ')}</td><td>{item.publicationState}</td><td>{formatDate(item.lastReviewedAt)}</td><td>{item.evidenceIds.length}</td><td>{item.claimIds.length}</td><td><Link className="tic-button tic-button--ghost tic-button--sm" to={`/admin/investigations/${item.slug}`}>Edit</Link></td></tr>)}</tbody></table></div></div>;
}

export function AdminInvestigationEditorPage() {
  const { id = '' } = useParams();
  const { investigations } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.investigation(id), queryFn: () => investigations.getBySlug(id) });
  const [saved, setSaved] = useState(false);
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  return <div className="tic-page"><PageHeader eyebrow="Investigation editor" title={result.data.investigation.title} description="Claims and evidence retain separate semantic controls." actions={<><Button variant="secondary" onClick={() => setSaved(true)}><Save aria-hidden="true" size={15} /> Save draft</Button><Button>Review & publish</Button></>} />{saved ? <div className="tic-alert"><CheckCircle2 aria-hidden="true" /><span>Draft state saved locally for UI demonstration; no server mutation is claimed.</span></div> : <AdminBoundaryNotice />}<div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-dashboard-grid"><DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Claims</p><h2>Reasoning ledger</h2></div><Button size="sm">New claim</Button></div><div className="tic-stack">{result.data.claims.map((claim) => <Card className="tic-claim" key={claim.id}><div className="tic-badge-row"><ClaimKindBadge kind={claim.kind} /><AssessmentBadge assessment={claim.assessment} /></div><textarea className="tic-textarea" defaultValue={claim.statement} aria-label={`Edit claim ${claim.id}`} /><div className="tic-record-meta"><span>{result.data.claimEvidenceLinks.filter((link) => link.claimId === claim.id).length} evidence links</span><span>{claim.publicationState}</span></div></Card>)}</div></DataPanel><DataPanel><div className="tic-section-heading"><div><p className="tic-eyebrow">Evidence linked</p><h2>Verification review</h2></div></div><div className="tic-stack">{result.data.evidence.map((item) => <Card key={item.id}><TechnicalIdentifier value={item.id} /><h3>{item.title}</h3><div className="tic-badge-row"><VerificationBadge status={item.verificationStatus} /><IntegrityBadge status={item.integrityStatus} /></div></Card>)}</div></DataPanel></div></div>;
}

export function AdminEvidencePage() {
  const { evidence } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.evidenceList('admin'), queryFn: () => evidence.list({ pageSize: 100 }) });
  return <div className="tic-page"><PageHeader eyebrow="Admin" title="Evidence" description="Review verification, integrity, provenance, claim links, and lineage." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-grid tic-grid--2">{result.data?.items.map((item) => <Card className="tic-record-card" key={item.id}><TechnicalIdentifier value={item.id} /><h2>{item.title}</h2><div className="tic-badge-row"><VerificationBadge status={item.verificationStatus} /><IntegrityBadge status={item.integrityStatus} /></div><Link className="tic-button tic-button--secondary" to={`/admin/evidence/${item.id}`}>Review record <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}</div></div>;
}

export function AdminEvidenceEditorPage() {
  const { id = '' } = useParams();
  const { evidence } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.evidence(id), queryFn: () => evidence.getById(id) });
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  const item = result.data;
  return <div className="tic-page"><PageHeader eyebrow="Evidence editor" title={item.title} description="Evidence uses verification and integrity — never claim assessment." actions={<Button variant="secondary"><Save aria-hidden="true" size={15} /> Save draft</Button>} /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-dashboard-grid"><DataPanel><div className="tic-field"><label>Verification</label><select className="tic-select" defaultValue={item.verificationStatus}><option value="verified">Verified</option><option value="partially_verified">Partially Verified</option><option value="unverified">Unverified</option></select></div><div className="tic-field"><label>Integrity</label><select className="tic-select" defaultValue={item.integrityStatus}><option value="intact">Intact</option><option value="unknown">Unknown</option><option value="disputed">Disputed</option></select></div><div className="tic-field"><label>Description</label><textarea className="tic-textarea" defaultValue={item.description} /></div></DataPanel><ProvenancePanel provenance={item.provenance} /></div></div>;
}

export function AdminResearchPage() {
  const { research } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.researchList('admin'), queryFn: () => research.list({ pageSize: 100 }) });
  return <div className="tic-page"><PageHeader eyebrow="Admin" title="Research" description="Editorial metadata, claims, evidence, preview, and publication state." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-grid tic-grid--2">{result.data?.items.map((item) => <Card key={item.id}><p className="tic-eyebrow">{item.publicationState}</p><h2>{item.title}</h2><p className="tic-muted">{item.summary}</p><Link className="tic-button tic-button--secondary" to={`/admin/research/${item.slug}`}>Edit research</Link></Card>)}</div></div>;
}

export function AdminResearchEditorPage() {
  const { id = '' } = useParams();
  const { research } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.research(id), queryFn: () => research.getBySlug(id) });
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  return <div className="tic-page"><PageHeader eyebrow="Research editor" title={result.data.title} description="Draft, preview, review, and publishing remain explicit states." actions={<><Button variant="secondary"><Save aria-hidden="true" size={15} /> Save draft</Button><Button>Request review</Button></>} /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><DataPanel><div className="tic-field"><label>Title</label><input className="tic-input" defaultValue={result.data.title} /></div><div className="tic-field"><label>Summary</label><textarea className="tic-textarea" defaultValue={result.data.summary} /></div><div className="tic-field"><label>Body</label><textarea className="tic-textarea" style={{ minHeight: 320 }} defaultValue={result.data.body} /></div></DataPanel></div>;
}

export function AdminSubmissionsPage() {
  const { submissions } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.submissions, queryFn: () => submissions.list({ pageSize: 100 }) });
  return <div className="tic-page"><PageHeader eyebrow="Admin" title="Submission Review" description="Submitted material is reviewed before it can become an evidence record or source." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} />{result.data?.items.length === 0 ? <EmptyState title="Queue empty" description="Pending submissions will appear here." /> : <div className="tic-stack">{result.data?.items.map((item) => <Card key={item.id}><span className="tic-badge tic-badge--assessment-probable">{item.status.replaceAll('_', ' ')}</span><h2>{item.title}</h2><p className="tic-muted">{item.description}</p><Link className="tic-button tic-button--secondary" to={`/admin/submissions/${item.id}`}>Open review</Link></Card>)}</div>}</div>;
}

export function AdminSubmissionReviewPage() {
  const { id = '' } = useParams();
  const repositories = useRepositories();
  const queryClient = useQueryClient();
  const result = useQuery({ queryKey: queryKeys.submission(id), queryFn: () => repositories.submissions.getById(id) });
  const update = useMutation({ mutationFn: (status: SubmissionStatus) => repositories.submissions.updateStatus(id, status), onSuccess: async () => { await queryClient.invalidateQueries({ queryKey: queryKeys.submission(id) }); await queryClient.invalidateQueries({ queryKey: queryKeys.submissions }); } });
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  return <div className="tic-page"><PageHeader eyebrow="Submission review" title={result.data.title} description="Review does not contain any action named Confirm as Fact." /><div className="tic-dashboard-grid"><DataPanel><p className="tic-eyebrow">Submitted material</p><p>{result.data.description}</p><dl className="tic-definition-grid"><div><dt>Type</dt><dd>{result.data.type}</dd></div><div><dt>Status</dt><dd>{result.data.status}</dd></div><div><dt>Submitted</dt><dd>{formatDate(result.data.createdAt)}</dd></div><div><dt>Signature</dt><dd>{result.data.signature ? 'Attached' : 'Not provided'}</dd></div></dl></DataPanel><DataPanel><p className="tic-eyebrow">Review</p><h2>Editorial action</h2><div className="tic-stack"><Button variant="secondary" onClick={() => update.mutate('needs_clarification')}>Request clarification</Button><Button variant="secondary" onClick={() => update.mutate('accepted_for_analysis')}>Accept for analysis</Button><Button variant="danger" onClick={() => update.mutate('rejected')}>Reject</Button></div>{update.isSuccess ? <p className="tic-alert"><CheckCircle2 aria-hidden="true" /> Status updated in the mock repository.</p> : null}</DataPanel></div></div>;
}

export function AdminNetworksPage() {
  const { networks } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.networks, queryFn: () => networks.list({ pageSize: 100 }) });
  return <div className="tic-page"><PageHeader eyebrow="Admin" title="Networks" description="Catalog metadata is independent from wallet-supported configuration." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-grid tic-grid--2">{result.data?.items.map((network) => <Card key={network.id}><p className="tic-eyebrow">{network.namespace}:{network.chainId}</p><h2>{network.name}</h2><p className="tic-muted">{network.description}</p><div className="tic-record-meta"><span>{network.status}</span><span>{network.slug === 'harmony-one' ? 'Wallet enabled by config' : 'Catalog only'}</span></div></Card>)}</div></div>;
}

export function AdminUsersPage() {
  const { admin } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.adminUsers, queryFn: () => admin.listUsers() });
  return <div className="tic-page"><PageHeader eyebrow="Admin" title="Users & Roles" description="A future server owns identity, sessions, capabilities, and authorization." /><AdminBoundaryNotice /><div style={{ height: 'var(--tic-space-lg)' }} /><div className="tic-grid tic-grid--2">{result.data?.map(({ user, roles, capabilities }) => <Card key={user.id}><Users aria-hidden="true" /><h2>{user.displayName}</h2><p className="tic-muted">{roles.join(', ')}</p><div className="tic-badge-row">{capabilities.map((capability) => <span className="tic-badge tic-badge--status" key={capability}>{capability}</span>)}</div></Card>)}</div></div>;
}
