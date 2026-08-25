import { describe, expect, it } from 'vitest';
import { mockDatabase } from '@/mocks/db/mock-database';
import { validateMockDatabase } from '@/mocks/db/validate-database';

describe('mock database contract', () => {
  it('has complete referential integrity', () => {
    expect(validateMockDatabase(mockDatabase)).toEqual({ valid: true, errors: [] });
  });

  it('uses verification and integrity for evidence and versions transformations', () => {
    for (const evidence of mockDatabase.evidence) {
      expect(evidence).not.toHaveProperty('assessment');
      expect(evidence.verificationStatus).toBeTruthy();
      expect(evidence.integrityStatus).toBeTruthy();
    }
    expect(mockDatabase.evidenceLineage.find(({ kind }) => kind === 'derived_from')).toMatchObject({
      transformationVersion: '1.0.0',
    });
  });
});
