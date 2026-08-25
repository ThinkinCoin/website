import { AlertTriangle } from 'lucide-react';
import { isRouteErrorResponse, Link, useRouteError } from 'react-router';
import { PageHeader } from '@/components/shared/page-header';
import { Card } from '@/components/ui/card';

export function RouteErrorPage() {
  const error = useRouteError();
  const title = isRouteErrorResponse(error) ? `${error.status} ${error.statusText}` : 'Route unavailable';
  const message = error instanceof Error ? error.message : 'The requested intelligence surface could not be loaded.';
  return <div className="tic-page"><PageHeader eyebrow="Recovery" title={title} description={message} /><Card className="tic-state tic-state--panel tic-state--error"><AlertTriangle aria-hidden="true" /><Link className="tic-button tic-button--secondary" to="/">Return to overview</Link></Card></div>;
}
