import { QueryClient } from '@tanstack/react-query';
import { createMockRepositoryRegistry } from '@/repositories/mock/mock-repositories';

if (import.meta.env.VITE_DATA_MODE && import.meta.env.VITE_DATA_MODE !== 'mock') {
  throw new Error('Only the mock repository adapter is implemented. Configure VITE_DATA_MODE=mock.');
}

export const repositoryRegistry = createMockRepositoryRegistry();

export const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      staleTime: 60_000,
      retry: 1,
      refetchOnWindowFocus: false,
    },
    mutations: { retry: 0 },
  },
});
