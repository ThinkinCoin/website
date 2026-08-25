import { createBrowserRouter, type LoaderFunctionArgs } from 'react-router';
import { queryClient, repositoryRegistry } from '@/app/config/composition-root';
import { queryKeys } from '@/app/config/query-keys';
import { AccountShell } from '@/app/layouts/account-shell';
import { AdminShell } from '@/app/layouts/admin-shell';
import { PublicShell } from '@/app/layouts/public-shell';
import { RouteErrorPage } from '@/app/router/route-error';

const listInvestigationsLoader = () => queryClient.ensureQueryData({ queryKey: queryKeys.investigations(), queryFn: () => repositoryRegistry.investigations.list() });
const investigationLoader = ({ params }: LoaderFunctionArgs) => queryClient.ensureQueryData({ queryKey: queryKeys.investigation(params.slug ?? params.id ?? ''), queryFn: () => repositoryRegistry.investigations.getBySlug(params.slug ?? params.id ?? '') });
const evidenceListLoader = () => queryClient.ensureQueryData({ queryKey: queryKeys.evidenceList(), queryFn: () => repositoryRegistry.evidence.list() });
const evidenceLoader = ({ params }: LoaderFunctionArgs) => queryClient.ensureQueryData({ queryKey: queryKeys.evidence(params.id ?? ''), queryFn: () => repositoryRegistry.evidence.getById(params.id ?? '') });
const researchListLoader = () => queryClient.ensureQueryData({ queryKey: queryKeys.researchList(), queryFn: () => repositoryRegistry.research.list() });
const researchLoader = ({ params }: LoaderFunctionArgs) => queryClient.ensureQueryData({ queryKey: queryKeys.research(params.slug ?? params.id ?? ''), queryFn: () => repositoryRegistry.research.getBySlug(params.slug ?? params.id ?? '') });
const entityListLoader = () => queryClient.ensureQueryData({ queryKey: queryKeys.entities(), queryFn: () => repositoryRegistry.entities.list() });
const entityLoader = ({ params }: LoaderFunctionArgs) => queryClient.ensureQueryData({ queryKey: queryKeys.entity(params.id ?? ''), queryFn: () => repositoryRegistry.entities.getById(params.id ?? '') });
const networkListLoader = () => queryClient.ensureQueryData({ queryKey: queryKeys.networks, queryFn: () => repositoryRegistry.networks.list() });
const networkLoader = ({ params }: LoaderFunctionArgs) => queryClient.ensureQueryData({ queryKey: queryKeys.network(params.slug ?? ''), queryFn: () => repositoryRegistry.networks.getBySlug(params.slug ?? '') });
const submissionListLoader = () => queryClient.ensureQueryData({ queryKey: queryKeys.submissions, queryFn: () => repositoryRegistry.submissions.list() });
const submissionLoader = ({ params }: LoaderFunctionArgs) => queryClient.ensureQueryData({ queryKey: queryKeys.submission(params.id ?? ''), queryFn: () => repositoryRegistry.submissions.getById(params.id ?? '') });

export const router = createBrowserRouter([
  {
    element: <PublicShell />,
    errorElement: <RouteErrorPage />,
    children: [
      { index: true, lazy: async () => ({ Component: (await import('@/features/overview/routes/overview-page')).OverviewPage }) },
      { path: 'investigations', loader: listInvestigationsLoader, lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationsPage }) },
      {
        path: 'investigations/:slug',
        loader: investigationLoader,
        lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationLayout }),
        children: [
          { index: true, lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationOverviewPage }) },
          { path: 'timeline', lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationTimelinePage }) },
          { path: 'evidence', lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationEvidencePage }) },
          { path: 'entities', lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationEntitiesPage }) },
          { path: 'analysis', lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationAnalysisPage }) },
          { path: 'sources', lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationSourcesPage }) },
          { path: 'updates', lazy: async () => ({ Component: (await import('@/features/investigations/routes/investigation-pages')).InvestigationUpdatesPage }) },
        ],
      },
      { path: 'research', loader: researchListLoader, lazy: async () => ({ Component: (await import('@/features/research/routes/research-pages')).ResearchLibraryPage }) },
      { path: 'research/:slug', loader: researchLoader, lazy: async () => ({ Component: (await import('@/features/research/routes/research-pages')).ResearchArticlePage }) },
      { path: 'evidence', loader: evidenceListLoader, lazy: async () => ({ Component: (await import('@/features/evidence/routes/evidence-pages')).EvidenceExplorerPage }) },
      { path: 'evidence/:id', loader: evidenceLoader, lazy: async () => ({ Component: (await import('@/features/evidence/routes/evidence-pages')).EvidenceDetailPage }) },
      { path: 'entities', loader: entityListLoader, lazy: async () => ({ Component: (await import('@/features/entities/routes/entity-pages')).EntityExplorerPage }) },
      { path: 'entities/:id', loader: entityLoader, lazy: async () => ({ Component: (await import('@/features/entities/routes/entity-pages')).EntityDetailPage }) },
      { path: 'entities/:id/relationships', loader: entityLoader, lazy: async () => ({ Component: (await import('@/features/entities/routes/entity-pages')).EntityRelationshipGraphPage }) },
      { path: 'networks', loader: networkListLoader, lazy: async () => ({ Component: (await import('@/features/networks/routes/network-pages')).NetworksPage }) },
      { path: 'networks/:slug', loader: networkLoader, lazy: async () => ({ Component: (await import('@/features/networks/routes/network-pages')).NetworkDetailPage }) },
      { path: 'timeline', lazy: async () => ({ Component: (await import('@/features/timeline/routes/timeline-page')).GlobalTimelinePage }) },
      { path: 'search', lazy: async () => ({ Component: (await import('@/features/search/routes/search-page')).SearchPage }) },
      { path: 'data', lazy: async () => ({ Component: (await import('@/features/institutional/routes/institutional-pages')).DataPage }) },
      { path: 'methodology', lazy: async () => ({ Component: (await import('@/features/institutional/routes/institutional-pages')).MethodologyPage }) },
      { path: 'about', lazy: async () => ({ Component: (await import('@/features/institutional/routes/institutional-pages')).AboutPage }) },
      { path: 'corrections', lazy: async () => ({ Component: (await import('@/features/institutional/routes/institutional-pages')).CorrectionsPage }) },
      { path: 'unauthorized', lazy: async () => ({ Component: (await import('@/features/institutional/routes/institutional-pages')).UnauthorizedPage }) },
      { path: '__dev/design-system', lazy: async () => ({ Component: (await import('@/features/institutional/routes/design-system-page')).DesignSystemPage }) },
      { path: '*', lazy: async () => ({ Component: (await import('@/features/institutional/routes/institutional-pages')).NotFoundPage }) },
    ],
  },
  {
    element: <AccountShell />,
    errorElement: <RouteErrorPage />,
    children: [
      { path: 'wallet', lazy: async () => ({ Component: (await import('@/features/wallet/routes/wallet-pages')).WalletCenterPage }) },
      { path: 'me/addresses', lazy: async () => ({ Component: (await import('@/features/wallet/routes/wallet-pages')).AddressesPage }) },
      { path: 'me/watchlist', lazy: async () => ({ Component: (await import('@/features/wallet/routes/wallet-pages')).WatchlistPage }) },
      { path: 'submissions', loader: submissionListLoader, lazy: async () => ({ Component: (await import('@/features/submissions/routes/submission-pages')).SubmissionsPage }) },
      { path: 'submissions/new', lazy: async () => ({ Component: (await import('@/features/submissions/routes/submission-pages')).NewSubmissionPage }) },
      { path: 'submissions/:id', loader: submissionLoader, lazy: async () => ({ Component: (await import('@/features/submissions/routes/submission-pages')).SubmissionDetailPage }) },
    ],
  },
  {
    path: 'admin',
    element: <AdminShell />,
    errorElement: <RouteErrorPage />,
    children: [
      { index: true, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminDashboardPage }) },
      { path: 'investigations', loader: listInvestigationsLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminInvestigationsPage }) },
      { path: 'investigations/:id', loader: investigationLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminInvestigationEditorPage }) },
      { path: 'evidence', loader: evidenceListLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminEvidencePage }) },
      { path: 'evidence/:id', loader: evidenceLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminEvidenceEditorPage }) },
      { path: 'research', loader: researchListLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminResearchPage }) },
      { path: 'research/:id', loader: researchLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminResearchEditorPage }) },
      { path: 'submissions', loader: submissionListLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminSubmissionsPage }) },
      { path: 'submissions/:id', loader: submissionLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminSubmissionReviewPage }) },
      { path: 'networks', loader: networkListLoader, lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminNetworksPage }) },
      { path: 'users', lazy: async () => ({ Component: (await import('@/features/admin/routes/admin-pages')).AdminUsersPage }) },
    ],
  },
]);
