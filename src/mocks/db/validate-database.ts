import type { MockDatabase } from '@/mocks/db/mock-database';

export interface DatabaseValidationResult {
  valid: boolean;
  errors: string[];
}

export function validateMockDatabase(database: MockDatabase): DatabaseValidationResult {
  const errors: string[] = [];
  const assertUnique = (label: string, ids: string[]) => {
    if (new Set(ids).size !== ids.length) errors.push(`${label} IDs must be unique.`);
  };
  const assertReferences = (label: string, ids: string[], available: Set<string>) => {
    for (const id of ids) if (!available.has(id)) errors.push(`${label} references missing ID ${id}.`);
  };

  const investigationIds = new Set(database.investigations.map(({ id }) => id));
  const claimIds = new Set(database.claims.map(({ id }) => id));
  const evidenceIds = new Set(database.evidence.map(({ id }) => id));
  const sourceIds = new Set(database.sources.map(({ id }) => id));
  const entityIds = new Set(database.entities.map(({ id }) => id));
  const timelineIds = new Set(database.timeline.map(({ id }) => id));
  const networkIds = new Set(database.networks.map(({ id }) => id));

  assertUnique('Investigation', [...investigationIds]);
  assertUnique('Claim', [...claimIds]);
  assertUnique('Evidence', [...evidenceIds]);
  assertUnique('Source', [...sourceIds]);
  assertUnique('Entity', [...entityIds]);

  for (const investigation of database.investigations) {
    assertReferences(`Investigation ${investigation.id} claimIds`, investigation.claimIds, claimIds);
    assertReferences(`Investigation ${investigation.id} evidenceIds`, investigation.evidenceIds, evidenceIds);
    assertReferences(`Investigation ${investigation.id} sourceIds`, investigation.sourceIds, sourceIds);
    assertReferences(`Investigation ${investigation.id} entityIds`, investigation.entityIds, entityIds);
    assertReferences(`Investigation ${investigation.id} timelineEventIds`, investigation.timelineEventIds, timelineIds);
    assertReferences(`Investigation ${investigation.id} networkIds`, investigation.networkIds, networkIds);
  }

  for (const link of database.claimEvidenceLinks) {
    assertReferences('ClaimEvidenceLink claim', [link.claimId], claimIds);
    assertReferences('ClaimEvidenceLink evidence', [link.evidenceId], evidenceIds);
  }

  for (const link of database.evidenceLineage) {
    assertReferences('EvidenceLineage source', [link.sourceEvidenceId], evidenceIds);
    assertReferences('EvidenceLineage target', [link.targetEvidenceId], evidenceIds);
    if (link.sourceEvidenceId === link.targetEvidenceId) errors.push('Evidence lineage cannot reference itself.');
  }

  for (const relationship of database.relationships) {
    assertReferences('Relationship source entity', [relationship.fromEntityId], entityIds);
    assertReferences('Relationship target entity', [relationship.toEntityId], entityIds);
    assertReferences('Relationship evidence', relationship.evidenceIds, evidenceIds);
  }

  return { valid: errors.length === 0, errors };
}
