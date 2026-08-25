import { describe, expect, it } from 'vitest';
import { createVerificationStatement } from '@/web3/types/verification';

describe('address verification statement', () => {
  it('states its domain, expiry, chain, and security boundary', () => {
    const statement = createVerificationStatement({
      address: '0x0000000000000000000000000000000000000001',
      chainId: 1666600000,
      nonce: 'nonce-1',
      appUrl: 'https://thinkincoin.country',
      issuedAt: '2026-08-25T12:00:00.000Z',
      expiresAt: '2026-08-25T12:10:00.000Z',
    });
    expect(statement).toContain('Domain: thinkincoin.country');
    expect(statement).toContain('Chain ID: 1666600000');
    expect(statement).toContain('does not authorize a token transfer');
    expect(statement).toContain('does not establish real-world identity');
  });
});
