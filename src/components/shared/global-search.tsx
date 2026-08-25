import * as Dialog from '@radix-ui/react-dialog';
import { useQuery } from '@tanstack/react-query';
import { Search, X } from 'lucide-react';
import { useState } from 'react';
import { Link } from 'react-router';
import { useRepositories } from '@/app/providers/repository-provider';
import { queryKeys } from '@/app/config/query-keys';
import { Button } from '@/components/ui/button';
import { EmptyState, LoadingState } from '@/components/ui/query-state';

export function GlobalSearch() {
  const { search } = useRepositories();
  const [open, setOpen] = useState(false);
  const [query, setQuery] = useState('');
  const searchQuery = useQuery({
    queryKey: queryKeys.search(query),
    queryFn: () => search.search(query),
    enabled: query.trim().length > 1,
  });

  return (
    <Dialog.Root open={open} onOpenChange={setOpen}>
      <Dialog.Trigger asChild>
        <button className="tic-search-input" type="button">
          <Search aria-hidden="true" size={16} />
          <span>Search hashes, addresses, evidence, research…</span>
        </button>
      </Dialog.Trigger>
      <Dialog.Portal>
        <Dialog.Overlay className="tic-dialog-overlay" />
        <Dialog.Content className="tic-dialog-content" aria-describedby="global-search-description">
          <div className="tic-section-heading">
            <div>
              <p className="tic-eyebrow">Command palette</p>
              <Dialog.Title>Global search</Dialog.Title>
            </div>
            <Dialog.Close asChild>
              <Button variant="ghost" size="icon" aria-label="Close search">
                <X aria-hidden="true" size={18} />
              </Button>
            </Dialog.Close>
          </div>
          <Dialog.Description id="global-search-description" className="tic-muted">
            Resolve investigations, evidence IDs, entities, networks, and technical identifiers.
          </Dialog.Description>
          <label className="tic-search-input">
            <Search aria-hidden="true" size={16} />
            <span className="sr-only">Search intelligence</span>
            <input autoFocus value={query} onChange={(event) => setQuery(event.target.value)} placeholder="Try Harmony or TIC-EV-2026…" />
          </label>
          <div className="tic-command-results" aria-live="polite">
            {searchQuery.isFetching ? <LoadingState label="Searching…" /> : null}
            {query.length > 1 && searchQuery.data?.length === 0 ? (
              <EmptyState title="No results" description="Try another identifier or research term." />
            ) : null}
            {searchQuery.data?.map((result) => (
              <Dialog.Close asChild key={`${result.kind}-${result.id}`}>
                <Link className="tic-command-result" to={result.destination}>
                  <span>{result.kind}</span>
                  <span><strong>{result.label}</strong><br /><small className="tic-muted">{result.description}</small></span>
                </Link>
              </Dialog.Close>
            ))}
          </div>
        </Dialog.Content>
      </Dialog.Portal>
    </Dialog.Root>
  );
}
