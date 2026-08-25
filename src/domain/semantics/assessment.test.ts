import { describe, expect, it } from 'vitest';
import { mockDatabase } from '@/mocks/db/mock-database';
import { summarizePublishedClaims } from '@/domain/semantics/assessment';

describe('summarizePublishedClaims', () => {
  it('returns a dynamic distribution without a calculatedAt timestamp', () => {
    const summary = summarizePublishedClaims(mockDatabase.claims);
    expect(summary).toEqual({
      basis: 'published_claims',
      totalClaims: 3,
      counts: {
        confirmed: 1,
        strongly_supported: 0,
        probable: 1,
        possible: 0,
        undetermined: 1,
      },
    });
    expect(summary).not.toHaveProperty('calculatedAt');
  });
});
