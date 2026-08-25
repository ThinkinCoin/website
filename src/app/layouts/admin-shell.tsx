import { useQuery } from '@tanstack/react-query';
import { Navigate } from 'react-router';
import { AppChrome } from '@/app/layouts/app-chrome';
import { queryKeys } from '@/app/config/query-keys';
import { useRepositories } from '@/app/providers/repository-provider';
import { LoadingState } from '@/components/ui/query-state';

export function AdminShell() {
  const { auth } = useRepositories();
  const session = useQuery({ queryKey: queryKeys.session, queryFn: () => auth.getSession(), staleTime: 30_000 });
  if (session.isPending) return <LoadingState label="Checking administrative access…" />;
  if (!session.data?.capabilities.includes('admin:read')) return <Navigate to="/unauthorized" replace />;
  return <AppChrome variant="admin" />;
}
