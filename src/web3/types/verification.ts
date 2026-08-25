export type AddressVerificationFlowState =
  | 'wallet_disconnected'
  | 'address_selected'
  | 'statement_review'
  | 'signature_requested'
  | 'signature_verified'
  | 'verification_stored'
  | 'error';

export function createVerificationStatement({
  address,
  chainId,
  nonce,
  appUrl,
  issuedAt,
  expiresAt,
}: {
  address: string;
  chainId: number;
  nonce: string;
  appUrl: string;
  issuedAt: string;
  expiresAt: string;
}) {
  return [
    'Think in Coin address ownership verification',
    '',
    `Address: ${address}`,
    `Chain ID: ${chainId}`,
    `Domain: ${new URL(appUrl).host}`,
    `URI: ${appUrl}`,
    `Nonce: ${nonce}`,
    `Issued At: ${issuedAt}`,
    `Expiration Time: ${expiresAt}`,
    '',
    'This signature verifies address control. It does not authorize a token transfer. It does not establish real-world identity.',
  ].join('\n');
}
