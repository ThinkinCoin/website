import { QueryClientProvider } from '@tanstack/react-query';
import type { PropsWithChildren } from 'react';
import { WagmiProvider } from 'wagmi';
import { queryClient } from '@/app/config/composition-root';
import '@/i18n/config';
import { RepositoryProvider } from '@/app/providers/repository-provider';
import { wagmiConfig } from '@/web3/config/appkit';

export function AppProviders({ children }: PropsWithChildren) {
  return (
    <WagmiProvider config={wagmiConfig} reconnectOnMount={false}>
      <QueryClientProvider client={queryClient}>
        <RepositoryProvider>{children}</RepositoryProvider>
      </QueryClientProvider>
    </WagmiProvider>
  );
}
