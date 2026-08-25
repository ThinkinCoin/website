import { harmonyOne } from '@reown/appkit/networks';
import type { AppKitNetwork } from '@reown/appkit/networks';

export type WalletSupportedNetwork = AppKitNetwork;

export const walletSupportedNetworks: [WalletSupportedNetwork, ...WalletSupportedNetwork[]] = [
  harmonyOne,
];
