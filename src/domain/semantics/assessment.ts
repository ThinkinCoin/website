import type { Assessment, AssessmentSummary, Claim } from '@/domain/models';

export const assessmentOrder: Assessment[] = [
  'confirmed',
  'strongly_supported',
  'probable',
  'possible',
  'undetermined',
];

export function summarizePublishedClaims(claims: Claim[]): AssessmentSummary {
  const publishedClaims = claims.filter((claim) => claim.publicationState === 'published');
  const counts = Object.fromEntries(assessmentOrder.map((assessment) => [assessment, 0])) as Record<
    Assessment,
    number
  >;

  for (const claim of publishedClaims) {
    counts[claim.assessment] += 1;
  }

  return {
    basis: 'published_claims',
    totalClaims: publishedClaims.length,
    counts,
  };
}
