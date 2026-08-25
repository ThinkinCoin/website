import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { RouterProvider } from 'react-router';
import { AppProviders } from '@/app/providers/app-providers';
import { router } from '@/app/router/router';
import '@/styles/app.css';

const root = document.getElementById('root');
if (!root) throw new Error('Root element was not found.');

createRoot(root).render(
  <StrictMode>
    <AppProviders>
      <RouterProvider router={router} />
    </AppProviders>
  </StrictMode>,
);
