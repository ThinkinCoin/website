export type Id = string;
export type IsoDateTime = string;

export type ClaimKind = 'fact' | 'inference' | 'hypothesis' | 'opinion';

export type Assessment =
  | 'confirmed'
  | 'strongly_supported'
  | 'probable'
  | 'possible'
  | 'undetermined';

export type InvestigationStatus =
  | 'monitoring'
  | 'active_investigation'
  | 'preliminary_findings'
  | 'substantially_resolved'
  | 'closed'
  | 'reopened';

export type PublicationState = 'draft' | 'in_review' | 'published' | 'archived';
export type EvidenceType =
  | 'transaction'
  | 'event_log'
  | 'document'
  | 'screenshot'
  | 'rpc_response'
  | 'dataset';
export type EvidenceVerificationStatus = 'verified' | 'partially_verified' | 'unverified';
export type EvidenceIntegrityStatus = 'intact' | 'unknown' | 'disputed';
export type EntityType =
  | 'address'
  | 'contract'
  | 'token'
  | 'protocol'
  | 'network'
  | 'exchange'
  | 'organization'
  | 'incident';
export type RelationshipKind =
  | 'sent_to'
  | 'received_from'
  | 'deployed'
  | 'owns'
  | 'called'
  | 'minted'
  | 'bridged'
  | 'referenced_by';
export type ClaimEvidenceRelation = 'supports' | 'contradicts' | 'contextualizes';
export type EvidenceLineageKind = 'derived_from' | 'corroborates' | 'duplicates' | 'supersedes';
export type SubmissionType = 'evidence' | 'correction' | 'additional_source' | 'technical_observation';
export type SubmissionStatus = 'draft' | 'pending_review' | 'needs_clarification' | 'accepted_for_analysis' | 'rejected';
export type RoleName = 'admin' | 'editor' | 'researcher' | 'reviewer' | 'contributor';

export interface AssessmentSummary {
  basis: 'published_claims';
  totalClaims: number;
  counts: Record<Assessment, number>;
}

export interface HistoricalAssessmentSummary extends AssessmentSummary {
  calculatedAt: IsoDateTime;
}

export interface InvestigationStatusChange {
  from?: InvestigationStatus;
  to: InvestigationStatus;
  changedAt: IsoDateTime;
  changedByUserId?: Id;
  note?: string;
}

export interface Investigation {
  id: Id;
  slug: string;
  title: string;
  summary: string;
  status: InvestigationStatus;
  statusHistory: InvestigationStatusChange[];
  publicationState: PublicationState;
  networkIds: Id[];
  claimIds: Id[];
  evidenceIds: Id[];
  sourceIds: Id[];
  entityIds: Id[];
  timelineEventIds: Id[];
  lastReviewedAt: IsoDateTime;
  publishedAt?: IsoDateTime;
  isSynthetic: boolean;
}

export interface Claim {
  id: Id;
  investigationId: Id;
  kind: ClaimKind;
  assessment: Assessment;
  statement: string;
  reasoningSummary?: string;
  publicNotes?: string;
  internalNotes?: string;
  relatedEntityIds: Id[];
  lastReviewedAt: IsoDateTime;
  publicationState: PublicationState;
}

export interface EvidenceProvenance {
  sourceId?: Id;
  publisher?: string;
  networkId?: Id;
  retrievedAt?: IsoDateTime;
  retrievalMethod?: string;
  rpcMethod?: string;
  transactionHash?: `0x${string}`;
  blockNumber?: string;
  contentSnapshotRef?: string;
  checksum?: string;
  archivedLocation?: string;
  rawDataRef?: string;
}

export interface Evidence {
  id: Id;
  type: EvidenceType;
  title: string;
  description: string;
  verificationStatus: EvidenceVerificationStatus;
  integrityStatus: EvidenceIntegrityStatus;
  networkId?: Id;
  identifiers: Record<string, string>;
  provenance: EvidenceProvenance;
  relatedInvestigationIds: Id[];
  relatedEntityIds: Id[];
  createdAt: IsoDateTime;
}

export interface ClaimEvidenceLink {
  claimId: Id;
  evidenceId: Id;
  relation: ClaimEvidenceRelation;
  note?: string;
}

export interface EvidenceLineageLink {
  sourceEvidenceId: Id;
  targetEvidenceId: Id;
  kind: EvidenceLineageKind;
  transformation?: string;
  transformationVersion?: string;
  createdAt: IsoDateTime;
}

export interface Source {
  id: Id;
  type: 'rpc' | 'explorer' | 'document' | 'repository' | 'website' | 'dataset';
  title: string;
  publisher: string;
  url?: string;
  archivedUrl?: string;
  publishedAt?: IsoDateTime;
  retrievedAt?: IsoDateTime;
  checksum?: string;
}

export interface ResearchItem {
  id: Id;
  slug: string;
  title: string;
  summary: string;
  body: string;
  bodyFormat: 'markdown';
  authorIds: Id[];
  investigationIds: Id[];
  claimIds: Id[];
  evidenceIds: Id[];
  sourceIds: Id[];
  publicationState: PublicationState;
  publishedAt?: IsoDateTime;
  updatedAt: IsoDateTime;
}

export interface EntityIdentifier {
  kind: 'address' | 'contract' | 'symbol' | 'website' | 'registry_id';
  value: string;
  networkId?: Id;
}

export interface Entity {
  id: Id;
  type: EntityType;
  name: string;
  description: string;
  identifiers: EntityIdentifier[];
  networkIds: Id[];
  attributionNote?: string;
}

export interface Relationship {
  id: Id;
  kind: RelationshipKind;
  fromEntityId: Id;
  toEntityId: Id;
  evidenceIds: Id[];
  networkId?: Id;
  observedAt?: IsoDateTime;
  note?: string;
}

export interface TimelineEvent {
  id: Id;
  investigationId?: Id;
  category: 'network' | 'evidence' | 'research' | 'status' | 'publication';
  title: string;
  description: string;
  occurredAt: IsoDateTime;
  precision: 'exact' | 'day' | 'approximate';
  evidenceIds: Id[];
  entityIds: Id[];
  sourceIds: Id[];
}

export interface NativeCurrency {
  name: string;
  symbol: string;
  decimals: number;
}

export interface NetworkCatalogEntry {
  id: Id;
  slug: string;
  namespace: 'eip155' | 'solana' | 'bip122';
  chainId?: number;
  name: string;
  description: string;
  nativeCurrency?: NativeCurrency;
  explorerUrls: string[];
  status: 'operational' | 'degraded' | 'incident' | 'unknown';
}

export interface ResearchNetworkSelection {
  networkIds: Id[];
}

export interface Dataset {
  id: Id;
  name: string;
  version: string;
  schemaVersion: string;
  generatedAt: IsoDateTime;
  checksum: string;
  sourceIds: Id[];
  evidenceIds: Id[];
  downloadRef?: string;
}

export interface SignatureEnvelope {
  address: `0x${string}`;
  chainId: number;
  message: string;
  signature: `0x${string}`;
  signedAt: IsoDateTime;
}

export interface Submission {
  id: Id;
  type: SubmissionType;
  title: string;
  description: string;
  relatedObjectId?: Id;
  submitterUserId?: Id;
  status: SubmissionStatus;
  signature?: SignatureEnvelope;
  createdAt: IsoDateTime;
  updatedAt: IsoDateTime;
}

export interface WalletVerification {
  id: Id;
  address: `0x${string}`;
  chainId: number;
  statement: string;
  nonce: string;
  issuedAt: IsoDateTime;
  expiresAt: IsoDateTime;
  signature?: `0x${string}`;
  status: 'address_selected' | 'signature_requested' | 'signature_verified' | 'verification_stored';
}

export interface Role {
  id: Id;
  name: RoleName;
  capabilities: string[];
}

export interface User {
  id: Id;
  displayName: string;
  status: 'active' | 'invited' | 'suspended';
  roleIds: Id[];
  verifiedAddressIds: Id[];
}
