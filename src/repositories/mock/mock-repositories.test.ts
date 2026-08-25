import { describe, expect, it } from 'vitest';
import { createMockRepositoryRegistry } from '@/repositories/mock/mock-repositories';

describe('mock repository contracts', () => {
  it('resolves the investigation graph through repository boundaries', async () => {
    const repositories = createMockRepositoryRegistry();
    const detail = await repositories.investigations.getBySlug('harmony-reference-dossier');
    expect(detail.investigation.isSynthetic).toBe(true);
    expect(detail.claims).toHaveLength(3);
    expect(detail.evidence).toHaveLength(3);
    expect(detail.claimEvidenceLinks).toHaveLength(3);
  });

  it('searches across coherent destinations', async () => {
    const repositories = createMockRepositoryRegistry();
    const results = await repositories.search.search('Harmony');
    expect(results.some(({ destination }) => destination === '/investigations/harmony-reference-dossier')).toBe(true);
    expect(results.some(({ destination }) => destination === '/networks/harmony-one')).toBe(true);
  });

  it('keeps a submission pending until editorial action', async () => {
    const repositories = createMockRepositoryRegistry();
    const submission = await repositories.submissions.create({
      type: 'technical_observation',
      title: 'A sufficiently descriptive observation',
      description: 'A deliberately detailed synthetic observation submitted for editorial review and no automatic confirmation.',
    });
    expect(submission.status).toBe('pending_review');
    expect((await repositories.submissions.updateStatus(submission.id, 'accepted_for_analysis')).status).toBe('accepted_for_analysis');
  });
});
