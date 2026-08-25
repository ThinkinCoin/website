import {
  AlertCircle,
  Check,
  CircleDashed,
  CircleDot,
  FileQuestion,
  Fingerprint,
  HelpCircle,
  Minus,
  ShieldAlert,
  ShieldCheck,
  ShieldQuestion,
  Sparkles,
  TriangleAlert,
} from 'lucide-react';
import type {
  Assessment,
  ClaimKind,
  EvidenceIntegrityStatus,
  EvidenceVerificationStatus,
  InvestigationStatus,
} from '@/domain/models';
import {
  assessmentLabels,
  claimKindLabels,
  integrityLabels,
  investigationStatusLabels,
  verificationLabels,
} from '@/domain/semantics/labels';
import { cn } from '@/lib/utils';

interface BadgeProps {
  className?: string;
  compact?: boolean;
}

const assessmentIcons = {
  confirmed: Check,
  strongly_supported: Sparkles,
  probable: CircleDot,
  possible: HelpCircle,
  undetermined: Minus,
} satisfies Record<Assessment, typeof Check>;

export function AssessmentBadge({ assessment, className, compact }: BadgeProps & { assessment: Assessment }) {
  const Icon = assessmentIcons[assessment];
  return (
    <span className={cn('tic-badge', `tic-badge--assessment-${assessment}`, className)}>
      <Icon aria-hidden="true" size={13} />
      {compact ? <span className="sr-only">{assessmentLabels[assessment]}</span> : assessmentLabels[assessment]}
    </span>
  );
}

const claimIcons = {
  fact: Fingerprint,
  inference: CircleDashed,
  hypothesis: FileQuestion,
  opinion: HelpCircle,
} satisfies Record<ClaimKind, typeof Fingerprint>;

export function ClaimKindBadge({ kind, className, compact }: BadgeProps & { kind: ClaimKind }) {
  const Icon = claimIcons[kind];
  return (
    <span className={cn('tic-badge', `tic-badge--claim-${kind}`, className)}>
      <Icon aria-hidden="true" size={13} />
      {compact ? <span className="sr-only">{claimKindLabels[kind]}</span> : claimKindLabels[kind]}
    </span>
  );
}

const verificationIcons = {
  verified: ShieldCheck,
  partially_verified: ShieldQuestion,
  unverified: ShieldAlert,
} satisfies Record<EvidenceVerificationStatus, typeof ShieldCheck>;

export function VerificationBadge({ status, className }: BadgeProps & { status: EvidenceVerificationStatus }) {
  const Icon = verificationIcons[status];
  return (
    <span className={cn('tic-badge', `tic-badge--verification-${status}`, className)}>
      <Icon aria-hidden="true" size={13} />
      {verificationLabels[status]}
    </span>
  );
}

const integrityIcons = {
  intact: ShieldCheck,
  unknown: ShieldQuestion,
  disputed: TriangleAlert,
} satisfies Record<EvidenceIntegrityStatus, typeof ShieldCheck>;

export function IntegrityBadge({ status, className }: BadgeProps & { status: EvidenceIntegrityStatus }) {
  const Icon = integrityIcons[status];
  return (
    <span className={cn('tic-badge', `tic-badge--integrity-${status}`, className)}>
      <Icon aria-hidden="true" size={13} />
      {integrityLabels[status]}
    </span>
  );
}

export function InvestigationStatusBadge({ status }: { status: InvestigationStatus }) {
  return (
    <span className="tic-badge tic-badge--status">
      <AlertCircle aria-hidden="true" size={13} />
      {investigationStatusLabels[status]}
    </span>
  );
}
