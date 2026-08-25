import { createAppKit } from '@reown/appkit/react';
import { WagmiAdapter } from '@reown/appkit-adapter-wagmi';
import { createConfig, http, type Config } from 'wagmi';
import { harmonyOne as viemHarmonyOne } from 'viem/chains';
import { walletSupportedNetworks } from '@/web3/config/networks';

const configuredProjectId = import.meta.env.VITE_REOWN_PROJECT_ID?.trim();
const appUrl = import.meta.env.VITE_APP_URL?.trim() || window.location.origin;

export const appKitEnabled = Boolean(configuredProjectId);
export const appKitUnavailableReason = appKitEnabled
  ? undefined
  : 'Wallet connection is not configured in this environment.';

const wagmiAdapter = configuredProjectId
  ? new WagmiAdapter({
      networks: walletSupportedNetworks,
      projectId: configuredProjectId,
    })
  : null;

if (wagmiAdapter && configuredProjectId) {
  createAppKit({
    adapters: [wagmiAdapter],
    networks: walletSupportedNetworks,
    projectId: configuredProjectId,
    metadata: {
      name: 'Think in Coin',
      description: 'Independent Digital Asset Intelligence',
      url: appUrl,
      icons: [`${appUrl.replace(/\/$/, '')}/assets/tic-monogram-green.svg`],
    },
    features: {
      analytics: false,
    },
  });
}

const fallbackConfig = createConfig({
  chains: [viemHarmonyOne],
  transports: {
    [viemHarmonyOne.id]: http(),
  },
});

export const wagmiConfig: Config = wagmiAdapter?.wagmiConfig ?? fallbackConfig;
