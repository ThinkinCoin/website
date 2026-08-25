import type { Submission } from '@/domain/models';
import { mockDatabase, type MockDatabase } from '@/mocks/db/mock-database';
import type {
  AuthGateway,
  AuthSession,
  AdminRepository,
  EntityRepository,
  EvidenceRepository,
  InvestigationDetail,
  InvestigationRepository,
  NetworkRepository,
  RepositoryRegistry,
  ResearchRepository,
  SearchRepository,
  SearchResult,
  SubmissionRepository,
} from '@/repositories/ports/repositories';
import { RepositoryError, type Page, type PageRequest } from '@/repositories/ports/types';

function matchesText(values: Array<string | undefined>, query?: string) {
  if (!query?.trim()) return true;
  const normalized = query.trim().toLowerCase();
  return values.some((value) => value?.toLowerCase().includes(normalized));
}

function paginate<T>(items: T[], request: PageRequest = {}): Page<T> {
  const page = Math.max(request.page ?? 1, 1);
  const pageSize = Math.min(Math.max(request.pageSize ?? 20, 1), 100);
  const start = (page - 1) * pageSize;
  return { items: items.slice(start, start + pageSize), page, pageSize, total: items.length };
}

function notFound(label: string, id: string): never {
  throw new RepositoryError('not_found', `${label} ${id} was not found.`);
}

class MockInvestigationRepository implements InvestigationRepository {
  constructor(private readonly database: MockDatabase) {}

  async list(request: PageRequest = {}) {
    const items = this.database.investigations.filter(
      (item) =>
        matchesText([item.title, item.summary, item.slug], request.query) &&
        (!request.networkId || item.networkIds.includes(request.networkId)),
    );
    return Promise.resolve(paginate(items, request));
  }

  async getBySlug(slug: string): Promise<InvestigationDetail> {
    const investigation = this.database.investigations.find((item) => item.slug === slug);
    if (!investigation) notFound('Investigation', slug);
    return Promise.resolve({
      investigation,
      claims: this.database.claims.filter((item) => investigation.claimIds.includes(item.id)),
      evidence: this.database.evidence.filter((item) => investigation.evidenceIds.includes(item.id)),
      sources: this.database.sources.filter((item) => investigation.sourceIds.includes(item.id)),
      entities: this.database.entities.filter((item) => investigation.entityIds.includes(item.id)),
      timeline: this.database.timeline.filter((item) => investigation.timelineEventIds.includes(item.id)),
      claimEvidenceLinks: this.database.claimEvidenceLinks.filter((link) =>
        investigation.claimIds.includes(link.claimId),
      ),
    });
  }
}

class MockEvidenceRepository implements EvidenceRepository {
  constructor(private readonly database: MockDatabase) {}

  async list(request: PageRequest = {}) {
    const items = this.database.evidence.filter(
      (item) =>
        matchesText([item.id, item.title, item.description, ...Object.values(item.identifiers)], request.query) &&
        (!request.networkId || item.networkId === request.networkId),
    );
    return Promise.resolve(paginate(items, request));
  }

  async getById(id: string) {
    const item = this.database.evidence.find((evidence) => evidence.id === id);
    return Promise.resolve(item ?? notFound('Evidence', id));
  }

  async getLineage(id: string) {
    return Promise.resolve(
      this.database.evidenceLineage.filter(
        (link) => link.sourceEvidenceId === id || link.targetEvidenceId === id,
      ),
    );
  }
}

class MockResearchRepository implements ResearchRepository {
  constructor(private readonly database: MockDatabase) {}

  async list(request: PageRequest = {}) {
    const items = this.database.research.filter((item) =>
      matchesText([item.title, item.summary, item.body], request.query),
    );
    return Promise.resolve(paginate(items, request));
  }

  async getBySlug(slug: string) {
    const item = this.database.research.find((research) => research.slug === slug);
    return Promise.resolve(item ?? notFound('Research item', slug));
  }
}

class MockEntityRepository implements EntityRepository {
  constructor(private readonly database: MockDatabase) {}

  async list(request: PageRequest = {}) {
    const items = this.database.entities.filter((item) =>
      matchesText([item.name, item.description, ...item.identifiers.map(({ value }) => value)], request.query),
    );
    return Promise.resolve(paginate(items, request));
  }

  async getById(id: string) {
    const item = this.database.entities.find((entity) => entity.id === id);
    return Promise.resolve(item ?? notFound('Entity', id));
  }

  async relationships(id: string) {
    return Promise.resolve(
      this.database.relationships.filter(
        (relationship) => relationship.fromEntityId === id || relationship.toEntityId === id,
      ),
    );
  }
}

class MockNetworkRepository implements NetworkRepository {
  constructor(private readonly database: MockDatabase) {}

  async list(request: PageRequest = {}) {
    const items = this.database.networks.filter((item) =>
      matchesText([item.name, item.description, item.slug, item.chainId?.toString()], request.query),
    );
    return Promise.resolve(paginate(items, request));
  }

  async getBySlug(slug: string) {
    const item = this.database.networks.find((network) => network.slug === slug);
    return Promise.resolve(item ?? notFound('Network', slug));
  }
}

class MockSubmissionRepository implements SubmissionRepository {
  private readonly items: Submission[];

  constructor(database: MockDatabase) {
    this.items = [...database.submissions];
  }

  async list(request: PageRequest = {}) {
    const items = this.items.filter((item) =>
      matchesText([item.title, item.description, item.id], request.query),
    );
    return Promise.resolve(paginate(items, request));
  }

  async getById(id: string) {
    const item = this.items.find((submission) => submission.id === id);
    return Promise.resolve(item ?? notFound('Submission', id));
  }

  async create(input: Omit<Submission, 'id' | 'status' | 'createdAt' | 'updatedAt'>) {
    const now = new Date().toISOString();
    const submission: Submission = {
      ...input,
      id: `submission-${crypto.randomUUID()}`,
      status: 'pending_review',
      createdAt: now,
      updatedAt: now,
    };
    this.items.unshift(submission);
    return Promise.resolve(submission);
  }

  async updateStatus(id: string, status: Submission['status']) {
    const item = this.items.find((submission) => submission.id === id);
    if (!item) notFound('Submission', id);
    item.status = status;
    item.updatedAt = new Date().toISOString();
    return Promise.resolve(item);
  }
}

class MockSearchRepository implements SearchRepository {
  constructor(private readonly database: MockDatabase) {}

  async search(query: string): Promise<SearchResult[]> {
    if (!query.trim()) return Promise.resolve([]);
    const results: SearchResult[] = [];

    for (const item of this.database.investigations) {
      if (matchesText([item.title, item.summary, item.slug], query)) {
        results.push({ id: item.id, kind: 'investigation', label: item.title, description: item.summary, destination: `/investigations/${item.slug}` });
      }
    }
    for (const item of this.database.evidence) {
      if (matchesText([item.id, item.title, ...Object.values(item.identifiers)], query)) {
        results.push({ id: item.id, kind: 'evidence', label: item.title, description: item.description, destination: `/evidence/${item.id}`, identifier: item.id });
      }
    }
    for (const item of this.database.entities) {
      if (matchesText([item.name, item.description, ...item.identifiers.map(({ value }) => value)], query)) {
        results.push({ id: item.id, kind: 'entity', label: item.name, description: item.description, destination: `/entities/${item.id}` });
      }
    }
    for (const item of this.database.research) {
      if (matchesText([item.title, item.summary], query)) {
        results.push({ id: item.id, kind: 'research', label: item.title, description: item.summary, destination: `/research/${item.slug}` });
      }
    }
    for (const item of this.database.networks) {
      if (matchesText([item.name, item.slug, item.chainId?.toString()], query)) {
        results.push({ id: item.id, kind: 'network', label: item.name, description: item.description, destination: `/networks/${item.slug}`, identifier: item.chainId?.toString() });
      }
    }

    return Promise.resolve(results.slice(0, 20));
  }
}

class MockAuthGateway implements AuthGateway {
  constructor(private readonly database: MockDatabase) {}

  async getSession(): Promise<AuthSession | null> {
    const buildEnvironment = import.meta.env.VITE_BUILD_ENV ?? (import.meta.env.DEV ? 'development' : 'production');
    const demoEnabled = import.meta.env.VITE_ENABLE_ADMIN_DEMO === 'true' || import.meta.env.DEV || import.meta.env.MODE === 'test';
    if (buildEnvironment === 'production' || !demoEnabled) return null;
    const user = this.database.users.find(({ id }) => id === 'user-demo-researcher');
    if (!user) return null;
    const capabilities = this.database.roles
      .filter(({ id }) => user.roleIds.includes(id))
      .flatMap(({ capabilities: roleCapabilities }) => roleCapabilities);
    return Promise.resolve({ user, capabilities: [...new Set(capabilities)] });
  }
}

class MockAdminRepository implements AdminRepository {
  constructor(private readonly database: MockDatabase) {}

  async getDashboard() {
    return Promise.resolve({
      activeInvestigations: this.database.investigations.filter(({ status }) => status === 'active_investigation').length,
      draftResearch: this.database.research.filter(({ publicationState }) => publicationState === 'draft').length,
      pendingEvidence: this.database.evidence.filter(({ verificationStatus }) => verificationStatus !== 'verified').length,
      pendingSubmissions: this.database.submissions.filter(({ status }) => status === 'pending_review').length,
      corrections: this.database.submissions.filter(({ type }) => type === 'correction').length,
      networkAlerts: this.database.networks.filter(({ status }) => status === 'degraded' || status === 'incident').length,
    });
  }

  async listUsers() {
    return Promise.resolve(
      this.database.users.map((user) => {
        const roles = this.database.roles.filter(({ id }) => user.roleIds.includes(id));
        return {
          user,
          roles: roles.map(({ name }) => name),
          capabilities: [...new Set(roles.flatMap(({ capabilities }) => capabilities))],
        };
      }),
    );
  }
}

export function createMockRepositoryRegistry(database = mockDatabase): RepositoryRegistry {
  return {
    investigations: new MockInvestigationRepository(database),
    evidence: new MockEvidenceRepository(database),
    research: new MockResearchRepository(database),
    entities: new MockEntityRepository(database),
    networks: new MockNetworkRepository(database),
    submissions: new MockSubmissionRepository(database),
    search: new MockSearchRepository(database),
    auth: new MockAuthGateway(database),
    admin: new MockAdminRepository(database),
  };
}
