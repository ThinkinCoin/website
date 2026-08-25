import { createContext, useContext, type PropsWithChildren } from 'react';
import { repositoryRegistry } from '@/app/config/composition-root';
import type { RepositoryRegistry } from '@/repositories/ports/repositories';

const RepositoryContext = createContext<RepositoryRegistry | null>(null);

export function RepositoryProvider({ children }: PropsWithChildren) {
  return <RepositoryContext.Provider value={repositoryRegistry}>{children}</RepositoryContext.Provider>;
}

export function useRepositories() {
  const repositories = useContext(RepositoryContext);
  if (!repositories) throw new Error('useRepositories must be used inside RepositoryProvider.');
  return repositories;
}
