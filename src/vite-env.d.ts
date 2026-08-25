/// <reference types="vite/client" />

interface ImportMetaEnv {
  readonly VITE_REOWN_PROJECT_ID?: string;
  readonly VITE_APP_URL?: string;
  readonly VITE_DATA_MODE?: 'mock' | 'api';
  readonly VITE_API_BASE_URL?: string;
  readonly VITE_BUILD_ENV?: 'development' | 'preview' | 'production';
  readonly VITE_ENABLE_ADMIN_DEMO?: 'true' | 'false';
}

interface ImportMeta {
  readonly env: ImportMetaEnv;
}
