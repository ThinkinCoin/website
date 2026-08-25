import { zodResolver } from '@hookform/resolvers/zod';
import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query';
import { AlertTriangle, ArrowRight, CheckCircle2, Send } from 'lucide-react';
import { useEffect, useState } from 'react';
import { useForm, useWatch } from 'react-hook-form';
import { Link, useNavigate, useParams } from 'react-router';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { PageHeader } from '@/components/shared/page-header';
import { Button } from '@/components/ui/button';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState, ErrorState, LoadingState } from '@/components/ui/query-state';
import { submissionSchema, type SubmissionInput } from '@/domain/validation/submission';
import { formatDate } from '@/lib/utils';

const draftKey = 'tic-submission-draft-v1';

function readSubmissionDraft(): Partial<SubmissionInput> | undefined {
  const stored = sessionStorage.getItem(draftKey);
  if (!stored) return undefined;
  try {
    const result = submissionSchema.partial().safeParse(JSON.parse(stored));
    return result.success ? result.data : undefined;
  } catch {
    return undefined;
  }
}

export function SubmissionsPage() {
  const { submissions } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.submissions, queryFn: () => submissions.list() });
  return <div className="tic-page"><PageHeader eyebrow="Contributor workspace" title="Submissions" description="Contributed material enters editorial review and is never automatically promoted to confirmed evidence." actions={<Link className="tic-button tic-button--primary" to="/submissions/new"><Send aria-hidden="true" size={15} /> New submission</Link>} />{result.isPending ? <LoadingState /> : null}{result.isError ? <ErrorState error={result.error} /> : null}{result.data?.items.length === 0 ? <EmptyState title="No submissions" description="Submitted material and review status will appear here." /> : null}<div className="tic-stack">{result.data?.items.map((item) => <Card className="tic-record-card" key={item.id}><div className="tic-badge-row"><span className="tic-badge tic-badge--assessment-probable">{item.status.replaceAll('_', ' ')}</span><span className="tic-badge tic-badge--integrity-unknown">{item.type.replaceAll('_', ' ')}</span></div><h2>{item.title}</h2><p className="tic-muted">{item.description}</p><div className="tic-record-meta"><span>Submitted {formatDate(item.createdAt)}</span></div><Link className="tic-button tic-button--secondary" to={`/submissions/${item.id}`}>View status <ArrowRight aria-hidden="true" size={15} /></Link></Card>)}</div></div>;
}

export function NewSubmissionPage() {
  const { submissions } = useRepositories();
  const queryClient = useQueryClient();
  const navigate = useNavigate();
  const [draft] = useState(readSubmissionDraft);
  const form = useForm<SubmissionInput>({
    resolver: zodResolver(submissionSchema),
    defaultValues: {
      type: draft?.type ?? 'technical_observation',
      title: draft?.title ?? '',
      description: draft?.description ?? '',
      relatedObjectId: draft?.relatedObjectId ?? 'investigation-harmony-reference',
    },
  });
  const watched = useWatch({ control: form.control });
  useEffect(() => { sessionStorage.setItem(draftKey, JSON.stringify(watched)); }, [watched]);
  const create = useMutation({
    mutationFn: (input: SubmissionInput) => submissions.create(input),
    onSuccess: async (submission) => {
      sessionStorage.removeItem(draftKey);
      await queryClient.invalidateQueries({ queryKey: queryKeys.submissions });
      await navigate(`/submissions/${submission.id}`);
    },
  });

  return <div className="tic-page"><PageHeader eyebrow="Submission wizard" title="Submit material for review" description="Wallet signature is optional. Submission does not imply verification or confirmation." /><form className="tic-form" onSubmit={form.handleSubmit((input) => create.mutate(input))}><div className="tic-dashboard-grid"><DataPanel><div className="tic-field"><label htmlFor="submission-type">1 · Type</label><select id="submission-type" className="tic-select" {...form.register('type')}><option value="evidence">Evidence</option><option value="correction">Correction</option><option value="additional_source">Additional Source</option><option value="technical_observation">Technical Observation</option></select></div><div className="tic-field"><label htmlFor="related-object">2 · Related object</label><input id="related-object" className="tic-input" {...form.register('relatedObjectId')} /></div><div className="tic-field"><label htmlFor="submission-title">3 · Title</label><input id="submission-title" className="tic-input" {...form.register('title')} />{form.formState.errors.title ? <span className="tic-field-error">{form.formState.errors.title.message}</span> : null}</div><div className="tic-field"><label htmlFor="submission-description">4 · Evidence, source, and context</label><textarea id="submission-description" className="tic-textarea" {...form.register('description')} />{form.formState.errors.description ? <span className="tic-field-error">{form.formState.errors.description.message}</span> : null}</div></DataPanel><DataPanel><p className="tic-eyebrow">5 · Review</p><h2>Editorial boundary</h2><div className="tic-alert tic-alert--warning"><AlertTriangle aria-hidden="true" /><span>A submission is not evidence. Evidence is not automatically confirmed. Editors may request clarification, link existing material, reject, or accept for analysis.</span></div><p className="tic-muted">6 · Optional signature will be enabled when a server-defined signing challenge and persistence boundary exist.</p><Button type="submit" loading={create.isPending}><Send aria-hidden="true" size={16} /> Submit for review</Button>{create.error ? <p className="tic-field-error">{create.error.message}</p> : null}</DataPanel></div></form></div>;
}

export function SubmissionDetailPage() {
  const { id = '' } = useParams();
  const { submissions } = useRepositories();
  const result = useQuery({ queryKey: queryKeys.submission(id), queryFn: () => submissions.getById(id) });
  if (result.isPending) return <div className="tic-page"><LoadingState /></div>;
  if (result.isError) return <div className="tic-page"><ErrorState error={result.error} /></div>;
  const item = result.data;
  return <div className="tic-page"><PageHeader eyebrow="Submission status" title={item.title} description={item.description} /><DataPanel><span className="tic-badge tic-badge--assessment-probable"><CheckCircle2 aria-hidden="true" size={13} /> {item.status.replaceAll('_', ' ')}</span><h2 style={{ marginTop: 'var(--tic-space-lg)' }}>Editorial review pending</h2><p className="tic-muted">The submitted material has not been converted into evidence or a confirmed claim.</p><dl className="tic-definition-grid"><div><dt>Type</dt><dd>{item.type.replaceAll('_', ' ')}</dd></div><div><dt>Created</dt><dd>{formatDate(item.createdAt)}</dd></div><div><dt>Related object</dt><dd>{item.relatedObjectId ?? 'None'}</dd></div><div><dt>Signature</dt><dd>{item.signature ? 'Attached' : 'Not provided'}</dd></div></dl></DataPanel></div>;
}
