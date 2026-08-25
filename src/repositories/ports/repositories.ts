import type {
  Claim,
  ClaimEvidenceLink,
  Entity,
  Evidence,
  EvidenceLineageLink,
  Investigation,
  NetworkCatalogEntry,
  Relationship,
  ResearchItem,
  Source,
  Submission,
  TimelineEvent,
  User,
} from '@/domain/models';
import type { Page, PageRequest } from '@/repositories/ports/types';

export interface InvestigationDetail {
  investigation: Investigation;
  claims: Claim[];
  evidence: Evidence[];
  sources: Source[];
  entities: Entity[];
  timeline: TimelineEvent[];
  claimEvidenceLinks: ClaimEvidenceLink[];
}

export interface InvestigationRepository {
  list(request?: PageRequest): Promise<Page<Investigation>>;
  getBySlug(slug: string): Promise<InvestigationDetail>;
}

export interface EvidenceRepository {
  list(request?: PageRequest): Promise<Page<Evidence>>;
  getById(id: string): Promise<Evidence>;
  getLineage(id: string): Promise<EvidenceLineageLink[]>;
}

export interface ResearchRepository {
  list(request?: PageRequest): Promise<Page<ResearchItem>>;
  getBySlug(slug: string): Promise<ResearchItem>;
}

export interface EntityRepository {
  list(request?: PageRequest): Promise<Page<Entity>>;
  getById(id: string): Promise<Entity>;
  relationships(id: string): Promise<Relationship[]>;
}

export interface NetworkRepository {
  list(request?: PageRequest): Promise<Page<NetworkCatalogEntry>>;
  getBySlug(slug: string): Promise<NetworkCatalogEntry>;
}

export interface SubmissionRepository {
  list(request?: PageRequest): Promise<Page<Submission>>;
  getById(id: string): Promise<Submission>;
  create(input: Omit<Submission, 'id' | 'status' | 'createdAt' | 'updatedAt'>): Promise<Submission>;
  updateStatus(id: string, status: Submission['status']): Promise<Submission>;
}

export interface AdminDashboardSummary {
  activeInvestigations: number;
  draftResearch: number;
  pendingEvidence: number;
  pendingSubmissions: number;
  corrections: number;
  networkAlerts: number;
}

export interface AdminUserView {
  user: User;
  roles: string[];
  capabilities: string[];
}

export interface AdminRepository {
  getDashboard(): Promise<AdminDashboardSummary>;
  listUsers(): Promise<AdminUserView[]>;
}

export type SearchResultKind =
  | 'transaction'
  | 'address'
  | 'contract'
  | 'block'
  | 'evidence'
  | 'investigation'
  | 'research'
  | 'network'
  | 'entity';

export interface SearchResult {
  id: string;
  kind: SearchResultKind;
  label: string;
  description: string;
  destination: string;
  identifier?: string;
}

export interface SearchRepository {
  search(query: string): Promise<SearchResult[]>;
}

export interface AuthSession {
  user: User;
  capabilities: string[];
}

export interface AuthGateway {
  getSession(): Promise<AuthSession | null>;
}

export interface RepositoryRegistry {
  investigations: InvestigationRepository;
  evidence: EvidenceRepository;
  research: ResearchRepository;
  entities: EntityRepository;
  networks: NetworkRepository;
  submissions: SubmissionRepository;
  search: SearchRepository;
  auth: AuthGateway;
  admin: AdminRepository;
}
