import * as Dialog from '@radix-ui/react-dialog';
import {
  Activity,
  BookOpen,
  ChartNoAxesCombined,
  CircleUserRound,
  Database,
  FileSearch,
  FolderKanban,
  House,
  Landmark,
  Menu,
  Network,
  Search,
  Send,
  ShieldCheck,
  Users,
  WalletCards,
  X,
} from 'lucide-react';
import type { ComponentType } from 'react';
import { NavLink, Outlet } from 'react-router';
import { useTranslation } from 'react-i18next';
import { Button } from '@/components/ui/button';
import { GlobalSearch } from '@/components/shared/global-search';
import { WalletAccountButton } from '@/web3/components/wallet-account-button';

interface NavItem {
  to: string;
  label: string;
  icon: ComponentType<{ size?: number; 'aria-hidden'?: boolean }>;
  end?: boolean;
}

const publicNav: NavItem[] = [
  { to: '/', label: 'Overview', icon: House, end: true },
  { to: '/investigations', label: 'Investigations', icon: FolderKanban },
  { to: '/research', label: 'Research', icon: BookOpen },
  { to: '/evidence', label: 'Evidence', icon: Database },
  { to: '/networks', label: 'Networks', icon: Activity },
  { to: '/entities', label: 'Entities', icon: Network },
  { to: '/timeline', label: 'Timeline', icon: ChartNoAxesCombined },
  { to: '/data', label: 'Data & API', icon: FileSearch },
];

const workspaceNav: NavItem[] = [
  { to: '/wallet', label: 'Wallet', icon: WalletCards },
  { to: '/me/addresses', label: 'My Addresses', icon: CircleUserRound },
  { to: '/me/watchlist', label: 'Watchlist', icon: ShieldCheck },
  { to: '/submissions', label: 'Submissions', icon: Send },
];

const adminNav: NavItem[] = [
  { to: '/admin', label: 'Dashboard', icon: House, end: true },
  { to: '/admin/investigations', label: 'Investigations', icon: FolderKanban },
  { to: '/admin/evidence', label: 'Evidence', icon: Database },
  { to: '/admin/research', label: 'Research', icon: BookOpen },
  { to: '/admin/submissions', label: 'Submissions', icon: Send },
  { to: '/admin/networks', label: 'Networks', icon: Landmark },
  { to: '/admin/users', label: 'Users & Roles', icon: Users },
];

function Navigation({ items, onNavigate }: { items: NavItem[]; onNavigate?: () => void }) {
  return (
    <nav aria-label="Primary navigation">
      {items.map(({ to, label, icon: Icon, end }) => (
        <NavLink key={to} to={to} end={end} className="tic-nav-link" onClick={onNavigate} title={label}>
          <Icon aria-hidden="true" size={17} />
          <span>{label}</span>
        </NavLink>
      ))}
    </nav>
  );
}

function MobileDrawer({ variant }: { variant: 'public' | 'account' | 'admin' }) {
  const items = variant === 'admin' ? adminNav : [...publicNav, ...workspaceNav];
  return (
    <Dialog.Root>
      <Dialog.Trigger asChild>
        <Button variant="ghost" size="icon" aria-label="Open navigation">
          <Menu aria-hidden="true" size={20} />
        </Button>
      </Dialog.Trigger>
      <Dialog.Portal>
        <Dialog.Overlay className="tic-drawer-overlay" />
        <Dialog.Content className="tic-drawer-content" aria-describedby={undefined}>
          <div className="tic-section-heading">
            <Dialog.Title>Navigation</Dialog.Title>
            <Dialog.Close asChild>
              <Button variant="ghost" size="icon" aria-label="Close navigation"><X aria-hidden="true" /></Button>
            </Dialog.Close>
          </div>
          <Dialog.Close asChild><div><Navigation items={items} /></div></Dialog.Close>
        </Dialog.Content>
      </Dialog.Portal>
    </Dialog.Root>
  );
}

export function AppChrome({ variant = 'public' }: { variant?: 'public' | 'account' | 'admin' }) {
  useTranslation();
  const isAdmin = variant === 'admin';
  const mainItems = isAdmin ? adminNav : publicNav;

  return (
    <div className="tic-app">
      <a href="#main-content" className="tic-skip-link">Skip to content</a>
      <div className="tic-shell">
        <aside className={`tic-sidebar${isAdmin ? ' tic-sidebar--admin' : ''}`}>
          <NavLink className="tic-brand-lockup" to={isAdmin ? '/admin' : '/'} aria-label="Think in Coin home">
            <img src="/assets/think-in-coin-lockup-light.svg" alt="Think in Coin" />
          </NavLink>
          {isAdmin ? <p className="tic-nav-group-label">Research operations</p> : null}
          <Navigation items={mainItems} />
          {!isAdmin ? (
            <>
              <p className="tic-nav-group-label">Web3 workspace</p>
              <Navigation items={workspaceNav} />
            </>
          ) : null}
          <div className="tic-sidebar-footer">Independent Digital Asset Intelligence</div>
        </aside>
        <div className="tic-shell-main">
          <header className="tic-topbar">
            <GlobalSearch />
            <div className="tic-topbar-actions">
              <Button variant="ghost"><Activity aria-hidden="true" size={16} /> Harmony research</Button>
              <WalletAccountButton />
            </div>
          </header>
          <header className="tic-mobile-header">
            <NavLink to="/" aria-label="Think in Coin home"><img src="/assets/tic-monogram-light.svg" alt="" /></NavLink>
            <div className="tic-inline-actions">
              <NavLink to="/search" aria-label="Search"><Search aria-hidden="true" /></NavLink>
              <MobileDrawer variant={variant} />
            </div>
          </header>
          <main id="main-content" tabIndex={-1}><Outlet /></main>
        </div>
      </div>
      {!isAdmin ? (
        <nav className="tic-bottom-nav" aria-label="Mobile navigation">
          {[
            { to: '/', label: 'Home', icon: House, end: true },
            { to: '/investigations', label: 'Investigate', icon: FolderKanban },
            { to: '/evidence', label: 'Evidence', icon: Database },
            { to: '/networks', label: 'Networks', icon: Activity },
            { to: '/wallet', label: 'Wallet', icon: WalletCards },
          ].map(({ to, label, icon: Icon, end }) => (
            <NavLink key={to} to={to} end={end}><Icon aria-hidden="true" size={18} /><span>{label}</span></NavLink>
          ))}
        </nav>
      ) : null}
    </div>
  );
}
