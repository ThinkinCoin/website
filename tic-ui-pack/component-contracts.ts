export type Assessment =
  | "confirmed"
  | "strongly-supported"
  | "probable"
  | "possible"
  | "undetermined";

export type ClaimKind = "fact" | "inference" | "hypothesis" | "opinion";

export interface AssessmentBadgeProps {
  assessment: Assessment;
  size?: "sm" | "md";
  showLabel?: boolean;
  /** Always true in production UI. Icon + label prevents color-only meaning. */
  showIcon?: true;
}

export interface ClaimKindBadgeProps {
  kind: ClaimKind;
  size?: "sm" | "md";
  showLabel?: boolean;
}

export interface ClaimCardProps {
  id: string;
  kind: ClaimKind;
  assessment: Assessment;
  statement: string;
  evidenceCount: number;
  sourceCount?: number;
  lastReviewed: string;
  relatedEntityIds?: string[];
  variant?: "compact" | "normal" | "expanded" | "admin-editable";
}

export interface EvidenceRecord {
  id: string;
  type: "transaction" | "event-log" | "document" | "screenshot" | "rpc-response" | "dataset";
  network: string;
  assessment: Assessment;
  source: string;
  retrievedAt: string;
  identifiers: Record<string, string>;
}

export interface NetworkStatusCardProps {
  network: string;
  state: "operational" | "degraded" | "incident" | "unknown";
  latestBlock?: string;
  blockTime?: string;
  validators?: number;
  rpcHealth?: string;
  bridgeStatus?: string;
}

export interface WalletStatePanelProps {
  state: "disconnected" | "connecting" | "connected" | "error" | "wrong-network";
  address?: `0x${string}`;
  network?: string;
  onOpenAppKit?: () => void;
}

export interface EvidenceTableProps {
  records: EvidenceRecord[];
  density?: "comfortable" | "compact";
  loading?: boolean;
  error?: string;
  /** At <768px render EvidenceMobileCard; never squeeze the desktop row. */
  mobileMode?: "cards";
}

export const applicationShells = {
  public: "PublicShell",
  account: "AccountShell",
  admin: "AdminShell",
} as const;

export const requiredDomainComponents = [
  "AssessmentBadge", "ClaimKindBadge", "ClaimCard", "EvidenceTable",
  "EvidenceMobileCard", "ProvenancePanel", "InvestigationCard",
  "ResearchCard", "NetworkStatusCard", "EntityCard", "TimelineEvent",
  "RelationshipGraph", "TechnicalIdentifier", "WalletAccountButton",
  "WalletAccountPopover", "WalletStatePanel", "AddressVerificationStep",
  "WatchlistCard", "SubmissionStepper", "SubmissionReviewSplit",
] as const;
