import { AlertTriangle, CheckCircle2, Eye, ShieldCheck, WalletCards } from 'lucide-react';
import { useMemo, useState } from 'react';
import { useAccount, useSignMessage } from 'wagmi';
import { PageHeader } from '@/components/shared/page-header';
import { TechnicalIdentifier } from '@/components/shared/technical-identifier';
import { Button } from '@/components/ui/button';
import { Card, DataPanel } from '@/components/ui/card';
import { EmptyState } from '@/components/ui/query-state';
import { WalletAccountButton } from '@/web3/components/wallet-account-button';
import { appKitEnabled } from '@/web3/config/appkit';
import { createVerificationStatement } from '@/web3/types/verification';

export function WalletCenterPage() {
  const account = useAccount();
  return (
    <div className="tic-page">
      <PageHeader eyebrow="Web3 workspace" title="Wallet Center" description="Wallet capabilities support verification and contribution; they never gate public research." actions={<WalletAccountButton />} />
      {!appKitEnabled ? <div className="tic-alert tic-alert--warning"><AlertTriangle aria-hidden="true" /><span>Set `VITE_REOWN_PROJECT_ID` to enable AppKit. Public intelligence remains available.</span></div> : null}
      <div style={{ height: 'var(--tic-space-lg)' }} />
      <div className="tic-grid tic-grid--3">
        <Card className="tic-stat"><span>Connection</span><strong>{account.isConnected ? 'Active' : 'Off'}</strong><small className="tic-muted">Harmony wallet network</small></Card>
        <Card className="tic-stat"><span>Verified addresses</span><strong>0</strong><small className="tic-muted">Server storage not connected</small></Card>
        <Card className="tic-stat"><span>Permissions</span><strong>None</strong><small className="tic-muted">Connection is not authorization</small></Card>
      </div>
      {account.address ? <div style={{ marginTop: 'var(--tic-space-lg)' }}><DataPanel><p className="tic-eyebrow">Connected address</p><TechnicalIdentifier value={account.address} /><p className="tic-muted">Connected wallet control is temporary client state and is not a verified real-world identity.</p></DataPanel></div> : null}
    </div>
  );
}

export function AddressesPage() {
  const account = useAccount();
  const signMessage = useSignMessage();
  const [signature, setSignature] = useState<string>();
  const [reviewed, setReviewed] = useState(false);
  const issuedAt = useMemo(() => new Date().toISOString(), []);
  const expiresAt = useMemo(() => new Date(Date.now() + 10 * 60_000).toISOString(), []);
  const statement = account.address
    ? createVerificationStatement({
        address: account.address,
        chainId: account.chainId ?? 1666600000,
        nonce: 'demo-' + issuedAt.replaceAll(/\D/g, '').slice(-12),
        appUrl: import.meta.env.VITE_APP_URL || window.location.origin,
        issuedAt,
        expiresAt,
      })
    : '';

  const requestSignature = () => {
    if (!statement) return;
    signMessage.signMessage(
      { message: statement },
      { onSuccess: (value) => setSignature(value) },
    );
  };

  return (
    <div className="tic-page">
      <PageHeader eyebrow="Address control" title="My Addresses" description="Review the exact statement before requesting a signature." actions={<WalletAccountButton />} />
      {!account.isConnected ? <EmptyState title="Connect a wallet" description="Select a Harmony address before beginning ownership verification." /> : (
        <div className="tic-dashboard-grid">
          <DataPanel>
            <p className="tic-eyebrow">1 · Address selected</p>
            {account.address ? <TechnicalIdentifier value={account.address} /> : null}
            <div style={{ height: 'var(--tic-space-lg)' }} />
            <p className="tic-eyebrow">2 · Review statement</p>
            <pre className="tic-mono" style={{ whiteSpace: 'pre-wrap' }}>{statement}</pre>
            <label className="tic-alert"><input type="checkbox" checked={reviewed} onChange={(event) => setReviewed(event.target.checked)} /><span>I reviewed the address, domain, chain, nonce, purpose, and expiration.</span></label>
          </DataPanel>
          <DataPanel>
            <p className="tic-eyebrow">3 · Sign</p>
            <h2>Verify address control</h2>
            <div className="tic-alert tic-alert--warning"><AlertTriangle aria-hidden="true" /><span>This signature verifies address control. It does not authorize a token transfer or establish real-world identity.</span></div>
            <div style={{ height: 'var(--tic-space-lg)' }} />
            <Button disabled={!reviewed || Boolean(signature)} loading={signMessage.isPending} onClick={requestSignature}><ShieldCheck aria-hidden="true" size={16} /> Request signature</Button>
            {signMessage.error ? <p className="tic-field-error">{signMessage.error.message}</p> : null}
            {signature ? <div className="tic-stack" style={{ marginTop: 'var(--tic-space-lg)' }}><span className="tic-badge tic-badge--verification-verified"><CheckCircle2 aria-hidden="true" size={13} /> Signature returned</span><TechnicalIdentifier value={signature} /><p className="tic-fine-print">Local demonstration only. A future server must verify nonce, domain, expiration, signature, and replay protection before storing verification.</p></div> : null}
          </DataPanel>
        </div>
      )}
    </div>
  );
}

export function WatchlistPage() {
  const [watching, setWatching] = useState(false);
  return <div className="tic-page"><PageHeader eyebrow="Personal workspace" title="Watchlist" description="Follow investigations, networks, addresses, and contracts without converting observations into conclusions." />{watching ? <Card className="tic-record-card"><div className="tic-badge-row"><span className="tic-badge tic-badge--verification-verified"><Eye aria-hidden="true" size={13} /> Watching</span></div><h2>Harmony Network Monitoring — Reference Dossier</h2><p className="tic-muted">Local demonstration preference. Server persistence is not connected.</p><Button variant="secondary" onClick={() => setWatching(false)}>Remove</Button></Card> : <EmptyState title="Nothing watched yet" description="Add a public investigation to demonstrate the workspace state." />}<div style={{ height: 'var(--tic-space-lg)' }} />{!watching ? <Button onClick={() => setWatching(true)}><Eye aria-hidden="true" size={16} /> Watch reference dossier</Button> : null}</div>;
}
