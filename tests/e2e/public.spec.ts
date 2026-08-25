import AxeBuilder from '@axe-core/playwright';
import { expect, test } from '@playwright/test';

test('research path preserves claim and evidence semantics', async ({ page }) => {
  await page.goto('/');
  await expect(page.getByRole('heading', { name: 'Research before conclusion.' })).toBeVisible();
  await page.getByRole('link', { name: /Explore investigations/i }).click();
  await page.getByRole('link', { name: /Open dossier/i }).click();
  await expect(page.getByText(/This reference dossier combines public network metadata/)).toBeVisible();
  await expect(page.getByText('Confirmed', { exact: true }).first()).toBeVisible();
  await page.getByRole('link', { name: 'Evidence', exact: true }).last().click();
  await expect(page.locator('.tic-badge:visible').filter({ hasText: /^Verified$/ }).first()).toBeVisible();
  await expect(page.locator('.tic-badge:visible').filter({ hasText: /^Intact$/ }).first()).toBeVisible();
});

test('deep evidence route and provenance load directly', async ({ page }) => {
  await page.goto('/evidence/TIC-EV-2026-00001');
  await expect(page.getByRole('heading', { name: 'Harmony public network metadata' })).toBeVisible();
  await expect(page.getByRole('heading', { name: 'Provenance' })).toBeVisible();
  await expect(page.getByRole('button', { name: 'Copy sha256:736f43bb2353b90ddca192eca3aaa63b14d8a7e7df3e56ece4e0a716521147de' })).toBeVisible();
});

test('public overview has no automatically detectable critical accessibility violations', async ({ page }) => {
  await page.goto('/');
  const results = await new AxeBuilder({ page }).analyze();
  expect(results.violations.filter(({ impact }) => impact === 'critical')).toEqual([]);
});

test('mobile uses the five-item navigation', async ({ page }) => {
  await page.setViewportSize({ width: 375, height: 812 });
  await page.goto('/');
  const navigation = page.getByRole('navigation', { name: 'Mobile navigation' });
  await expect(navigation).toBeVisible();
  await expect(navigation.getByRole('link')).toHaveCount(5);
});
