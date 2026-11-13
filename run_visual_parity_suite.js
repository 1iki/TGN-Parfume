import { chromium } from 'playwright';
import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';
import pixelmatch from 'pixelmatch';
import { PNG } from 'pngjs';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const baseLegacy = 'http://127.0.0.1:8080';
const baseLaravel = 'http://127.0.0.1:8000';

const outDir = path.join(__dirname, 'docs/parity-visual');
const legacyDir = path.join(outDir, 'legacy');
const laravelDir = path.join(outDir, 'laravel');
const diffDir = path.join(outDir, 'diff');
const reportsDir = path.join(outDir, 'reports');

[outDir, legacyDir, laravelDir, diffDir, reportsDir].forEach(dir => {
    if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
});

const routes = [
    { id: 'home', legacy: '/index.php', laravel: '/index.php', auth: 'guest' },
    { id: 'about', legacy: '/index.php#about', laravel: '/index.php#about', auth: 'guest' },
    { id: 'contact', legacy: '/index.php#contact', laravel: '/index.php#contact', auth: 'guest' },
    { id: 'products', legacy: '/product.php?pid=1', laravel: '/product.php?pid=1', auth: 'guest' },
    { id: 'product_detail', legacy: '/product.php?pid=1', laravel: '/product.php?pid=1', auth: 'guest' },
    { id: 'login', legacy: '/sign-in.php', laravel: '/sign-in.php', auth: 'guest' },
    { id: 'forgot_password', legacy: '/forgot-password.php', laravel: '/forgot-password.php', auth: 'guest' },
    { id: 'reset_password', legacy: '/reset-password.php', laravel: '/reset-password.php', auth: 'guest' },
    { id: 'cart', legacy: '/cart.php', laravel: '/cart.php', auth: 'customer' },
    { id: 'checkout', legacy: '/checkout.php', laravel: '/checkout.php', auth: 'customer' },
    { id: 'order_history', legacy: '/purchase-history.php', laravel: '/purchase-history.php', auth: 'customer' },
    { id: 'profile', legacy: '/users-profile.php', laravel: '/users-profile.php', auth: 'customer' },
    { id: 'admin_dashboard', legacy: '/Admin/index.php', laravel: '/Admin/index.php', auth: 'admin' },
    { id: 'admin_products', legacy: '/Admin/penjualan-list-produk.php', laravel: '/Admin/penjualan-list-produk.php', auth: 'admin' },
    { id: 'admin_orders', legacy: '/Admin/penjualan-history-pesanan.php', laravel: '/Admin/penjualan-history-pesanan.php', auth: 'admin' },
    { id: 'admin_users', legacy: '/Admin/users.php', laravel: '/Admin/users.php', auth: 'admin' }
];

const viewports = [
    { name: 'desktop', width: 1440, height: 900 },
    { name: 'mobile', width: 375, height: 812 }
];

async function loginUser(page, baseUrl, username, password) {
    try {
        await page.goto(`${baseUrl}/sign-in.php`, { waitUntil: 'domcontentloaded', timeout: 15000 });
        await page.fill('input[name="username"]', username);
        await page.fill('input[name="pass"]', password);
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded', timeout: 15000 }).catch(() => {}),
            page.click('button[type="submit"]')
        ]);
        await page.waitForTimeout(500);
    } catch (e) {
        console.error(`Failed to login at ${baseUrl}: ${e.message}`);
    }
}

function comparePNGs(legacyPath, laravelPath, diffPath) {
    if (!fs.existsSync(legacyPath) || !fs.existsSync(laravelPath)) {
        return { totalPixels: 0, mismatchPixels: 0, pct: 100 };
    }

    const img1 = PNG.sync.read(fs.readFileSync(legacyPath));
    const img2 = PNG.sync.read(fs.readFileSync(laravelPath));

    const width = Math.min(img1.width, img2.width);
    const height = Math.min(img1.height, img2.height);

    const diff = new PNG({ width, height });

    const mismatchPixels = pixelmatch(
        img1.data,
        img2.data,
        diff.data,
        width,
        height,
        { threshold: 0.1 }
    );

    fs.writeFileSync(diffPath, PNG.sync.write(diff));

    const totalPixels = width * height;
    const pct = ((mismatchPixels / totalPixels) * 100).toFixed(2);

    return { totalPixels, mismatchPixels, pct: parseFloat(pct) };
}

(async () => {
    console.log('Starting Playwright Forensic Visual Regression Suite...');
    const browser = await chromium.launch({ headless: true });
    const results = [];

    for (const vp of viewports) {
        for (const route of routes) {
            const contextLegacy = await browser.newContext({ viewport: { width: vp.width, height: vp.height } });
            const contextLaravel = await browser.newContext({ viewport: { width: vp.width, height: vp.height } });

            const pageLegacy = await contextLegacy.newPage();
            const pageLaravel = await contextLaravel.newPage();

            if (route.auth === 'customer') {
                await loginUser(pageLegacy, baseLegacy, 'kriss', '123');
                await loginUser(pageLaravel, baseLaravel, 'kriss', '123');
            } else if (route.auth === 'admin') {
                await loginUser(pageLegacy, baseLegacy, 'admin', '123');
                await loginUser(pageLaravel, baseLaravel, 'admin', '123');
            }

            const legacyUrl = baseLegacy + route.legacy;
            const laravelUrl = baseLaravel + route.laravel;

            const legacyFile = path.join(legacyDir, `${route.id}_${vp.name}.png`);
            const laravelFile = path.join(laravelDir, `${route.id}_${vp.name}.png`);
            const diffFile = path.join(diffDir, `${route.id}_${vp.name}_diff.png`);

            try {
                await pageLegacy.goto(legacyUrl, { waitUntil: 'domcontentloaded', timeout: 15000 });
                await pageLegacy.waitForTimeout(500);
            } catch (e) {
                console.log(`Legacy navigation warning for ${route.id}: ${e.message}`);
            }
            await pageLegacy.screenshot({ path: legacyFile, fullPage: false });

            try {
                await pageLaravel.goto(laravelUrl, { waitUntil: 'domcontentloaded', timeout: 15000 });
                await pageLaravel.waitForTimeout(500);
            } catch (e) {
                console.log(`Laravel navigation warning for ${route.id}: ${e.message}`);
            }
            await pageLaravel.screenshot({ path: laravelFile, fullPage: false });

            await contextLegacy.close();
            await contextLaravel.close();

            const diffResult = comparePNGs(legacyFile, laravelFile, diffFile);
            let status = 'REVIEW';
            if (diffResult.pct <= 0.05) {
                status = 'PASS';
            } else if (diffResult.pct <= 1.00) {
                status = 'MINOR';
            }

            results.push({
                page: route.id,
                viewport: `${vp.width}x${vp.height} (${vp.name})`,
                legacyUrl: route.legacy,
                laravelUrl: route.laravel,
                mismatchPixels: diffResult.mismatchPixels,
                pct: `${diffResult.pct}%`,
                status: status,
                legacyPath: legacyFile,
                laravelPath: laravelFile,
                diffPath: diffFile
            });

            console.log(`Captured ${route.id} [${vp.name}] -> Mismatch: ${diffResult.mismatchPixels} px (${diffResult.pct}%) -> ${status}`);
        }
    }

    await browser.close();

    // Generate PARITY_VISUAL_REPORT.md
    let reportMd = `# PARITY VISUAL REGRESSION REPORT — TGN PARFUME\n\n`;
    reportMd += `## 1. Environment & Engine Configuration\n\n`;
    reportMd += `- **Engine**: Playwright Chromium Headless + Pixelmatch Engine\n`;
    reportMd += `- **Legacy Server Target**: \`${baseLegacy}\`\n`;
    reportMd += `- **Laravel Server Target**: \`${baseLaravel}\`\n`;
    reportMd += `- **Execution Date**: ${new Date().toISOString()}\n\n`;
    reportMd += `---\n\n## 2. Screenshot Evidence & Comparison Summary\n\n`;
    reportMd += `| Page ID | Viewport | Legacy Endpoint | Laravel Endpoint | Differing Pixels | Mismatch % | Status |\n`;
    reportMd += `|---|---|---|---|---|---|---|\n`;

    let totalPass = 0;
    let totalMinor = 0;
    let totalReview = 0;

    results.forEach(r => {
        if (r.status === 'PASS') totalPass++;
        else if (r.status === 'MINOR') totalMinor++;
        else totalReview++;
        reportMd += `| \`${r.page}\` | ${r.viewport} | \`${r.legacyUrl}\` | \`${r.laravelUrl}\` | ${r.mismatchPixels} px | ${r.pct} | **${r.status}** |\n`;
    });

    reportMd += `\n---\n\n## 3. Visual Triage Summary\n\n`;
    reportMd += `- **Total Pages Captured**: ${results.length}\n`;
    reportMd += `- **Exact Visual Structure PASS**: ${totalPass}\n`;
    reportMd += `- **MINOR (Antialiasing/Font Diff <=1.0%)**: ${totalMinor}\n`;
    reportMd += `- **REVIEW / Discrepancy Held**: ${totalReview}\n\n`;
    reportMd += `## 4. Final Visual Decision\n\n`;
    if (totalReview === 0) {
        reportMd += `# **PARITY VERIFIED**\n`;
    } else {
        reportMd += `# **PARITY NOT YET VERIFIED**\n*(${totalReview} items held at REVIEW for visual asset/dynamic rendering verification).*`;
    }

    const reportPath = path.join(reportsDir, 'PARITY_VISUAL_REPORT.md');
    fs.writeFileSync(reportPath, reportMd);
    console.log(`\nVisual Report written to: ${reportPath}`);
})();
