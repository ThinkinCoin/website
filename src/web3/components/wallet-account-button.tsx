import { useAppKit, useAppKitAccount, useDisconnect } from '@reown/appkit/react';
import { CircleOff, LogOut, WalletCards } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { appKitEnabled, appKitUnavailableReason } from '@/web3/config/appkit';
import { truncateIdentifier } from '@/lib/utils';

function EnabledWalletAccountButton() {
  const { open } = useAppKit();
  const { address, isConnected, status } = useAppKitAccount();
  const { disconnect } = useDisconnect();

  if (!isConnected) {
    return (
      <Button variant="secondary" onClick={() => open()} loading={status === 'connecting'}>
        <WalletCards aria-hidden="true" size={16} />
        Connect Wallet
      </Button>
    );
  }

  return (
    <div className="tic-inline-actions">
      <Button variant="secondary" onClick={() => open({ view: 'Account' })}>
        <WalletCards aria-hidden="true" size={16} />
        {address ? truncateIdentifier(address, 6, 4) : 'Account'}
      </Button>
      <Button variant="ghost" size="icon" onClick={() => disconnect()} aria-label="Disconnect wallet">
        <LogOut aria-hidden="true" size={16} />
      </Button>
    </div>
  );
}

export function WalletAccountButton() {
  if (!appKitEnabled) {
    return (
      <Button variant="ghost" disabled title={appKitUnavailableReason}>
        <CircleOff aria-hidden="true" size={16} />
        Wallet unavailable
      </Button>
    );
  }
  return <EnabledWalletAccountButton />;
}
