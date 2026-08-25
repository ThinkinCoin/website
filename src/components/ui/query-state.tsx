import { AlertTriangle, Database, LoaderCircle } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { Card } from '@/components/ui/card';

export function LoadingState({ label = 'Loading intelligence…' }: { label?: string }) {
  return (
    <div className="tic-state" role="status">
      <LoaderCircle aria-hidden="true" className="tic-spin" />
      <span>{label}</span>
    </div>
  );
}

export function EmptyState({ title, description }: { title: string; description: string }) {
  return (
    <Card className="tic-state tic-state--panel">
      <Database aria-hidden="true" />
      <strong>{title}</strong>
      <span>{description}</span>
    </Card>
  );
}

export function ErrorState({ error, retry }: { error: unknown; retry?: () => void }) {
  const message = error instanceof Error ? error.message : 'An unknown error occurred.';
  return (
    <Card className="tic-state tic-state--panel tic-state--error" role="alert">
      <AlertTriangle aria-hidden="true" />
      <strong>Unable to load this intelligence surface</strong>
      <span>{message}</span>
      {retry ? <Button onClick={retry}>Try again</Button> : null}
    </Card>
  );
}
