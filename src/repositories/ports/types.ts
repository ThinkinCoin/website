export interface PageRequest {
  query?: string;
  page?: number;
  pageSize?: number;
  networkId?: string;
}

export interface Page<T> {
  items: T[];
  page: number;
  pageSize: number;
  total: number;
}

export type RepositoryErrorCode =
  | 'not_found'
  | 'unauthorized'
  | 'validation'
  | 'unavailable'
  | 'rate_limited'
  | 'unknown';

export class RepositoryError extends Error {
  constructor(
    public readonly code: RepositoryErrorCode,
    message: string,
  ) {
    super(message);
  }
}
