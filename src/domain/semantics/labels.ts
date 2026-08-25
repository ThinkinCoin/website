import type {
  Assessment,
  ClaimKind,
  EvidenceIntegrityStatus,
  EvidenceVerificationStatus,
  InvestigationStatus,
} from '@/domain/models';

export const assessmentLabels: Record<Assessment, string> = {
  confirmed: 'Confirmed',
  strongly_supported: 'Strongly Supported',
  probable: 'Probable',
  possible: 'Possible',
  undetermined: 'Undetermined',
};

export const claimKindLabels: Record<ClaimKind, string> = {
  fact: 'Fact',
  inference: 'Inference',
  hypothesis: 'Hypothesis',
  opinion: 'Opinion',
};

export const verificationLabels: Record<EvidenceVerificationStatus, string> = {
  verified: 'Verified',
  partially_verified: 'Partially Verified',
  unverified: 'Unverified',
};

export const integrityLabels: Record<EvidenceIntegrityStatus, string> = {
  intact: 'Intact',
  unknown: 'Integrity Unknown',
  disputed: 'Disputed',
};

export const investigationStatusLabels: Record<InvestigationStatus, string> = {
  monitoring: 'Monitoring',
  active_investigation: 'Active Investigation',
  preliminary_findings: 'Preliminary Findings',
  substantially_resolved: 'Substantially Resolved',
  closed: 'Closed',
  reopened: 'Reopened',
};
