import { Check, Copy } from 'lucide-react';
import { useState } from 'react';
import { Button } from '@/components/ui/button';
import { truncateIdentifier } from '@/lib/utils';

export function TechnicalIdentifier({ value }: { value: string }) {
  const [copied, setCopied] = useState(false);

  const copy = async () => {
    await navigator.clipboard.writeText(value);
    setCopied(true);
    window.setTimeout(() => setCopied(false), 1600);
  };

  return (
    <span className="tic-technical" title={value}>
      <code aria-label={value}>{truncateIdentifier(value)}</code>
      <Button variant="ghost" size="icon" onClick={() => void copy()} aria-label={`Copy ${value}`}>
        {copied ? <Check aria-hidden="true" size={14} /> : <Copy aria-hidden="true" size={14} />}
      </Button>
      <span className="sr-only" aria-live="polite">{copied ? 'Copied' : ''}</span>
    </span>
  );
}
