import { render, screen } from '@testing-library/react';
import { describe, expect, it } from 'vitest';
import { AssessmentBadge, IntegrityBadge, VerificationBadge } from '@/components/ui/badges';

describe('semantic badges', () => {
  it('renders independent claim and evidence semantics', () => {
    render(<><AssessmentBadge assessment="confirmed" /><VerificationBadge status="verified" /><IntegrityBadge status="intact" /></>);
    expect(screen.getByText('Confirmed')).toBeInTheDocument();
    expect(screen.getByText('Verified')).toBeInTheDocument();
    expect(screen.getByText('Intact')).toBeInTheDocument();
  });
});
