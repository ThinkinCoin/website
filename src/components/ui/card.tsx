import type { HTMLAttributes } from 'react';
import { cn } from '@/lib/utils';

export function Card({ className, ...props }: HTMLAttributes<HTMLElement>) {
  return <section className={cn('tic-card', className)} {...props} />;
}

export function DataPanel({ className, ...props }: HTMLAttributes<HTMLElement>) {
  return <section className={cn('tic-panel', className)} {...props} />;
}
