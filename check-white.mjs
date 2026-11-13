import { chromium } from 'playwright';

const base = 'http://127.0.0.1:8010';
const dir = '.impeccable/review/captures/white';
const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1440, height: 900 } });

// storefront user session
await page.goto(base + '/sign-in.php', { waitUntil: 'networkidle' });
await page.fill('input[name="username"]', 'kriss');
await page.fill('input[name="pass"]', '123');
await Promise.all([
  page.waitForNavigation({ waitUntil: 'networkidle' }).catch(() => {}),
  page.click('button[type="submit"]'),
]);

const shots = async (url, name) => {
  await page.goto(base + url, { waitUntil: 'networkidle' });
  // settle entrance motion (AOS) so full-page captures show real content
  await page.addStyleTag({ content: '[data-aos]{opacity:1!important;transform:none!important}' });
  await page.evaluate(() => window.scrollTo(0, document.body.scrollHeight));
  await page.waitForTimeout(400);
  await page.evaluate(() => window.scrollTo(0, 0));
  await page.waitForTimeout(200);
  await page.screenshot({ path: `${dir}/${name}.png`, fullPage: true });
  console.log(name, 'ok');
};

await shots('/index.php', 'home');
await shots('/products', 'catalog');
await shots('/products?category=female', 'catalog-female');
await shots('/search?search=parfum', 'search');
await shots('/contact', 'contact');
await shots('/about', 'about');
await shots('/sign-up.php', 'register');
await shots('/product.php?pid=1', 'product-detail');
await shots('/cart.php', 'cart');
await shots('/checkout.php', 'checkout');
await shots('/purchase-history.php', 'orders');
await shots('/users-profile.php', 'profile');

await browser.close();

// admin session
const b2 = await chromium.launch();
const p2 = await b2.newPage({ viewport: { width: 1440, height: 900 } });
await p2.goto(base + '/sign-in.php', { waitUntil: 'networkidle' });
await p2.fill('input[name="username"]', 'admin');
await p2.fill('input[name="pass"]', '123');
await Promise.all([
  p2.waitForNavigation({ waitUntil: 'networkidle' }).catch(() => {}),
  p2.click('button[type="submit"]'),
]);

const ashots = async (url, name) => {
  await p2.goto(base + url, { waitUntil: 'networkidle' });
  await p2.addStyleTag({ content: '[data-aos]{opacity:1!important;transform:none!important}' });
  await p2.screenshot({ path: `${dir}/${name}.png`, fullPage: true });
  console.log(name, 'ok');
};

await ashots('/Admin/index.php', 'admin-dashboard');
await ashots('/Admin/penjualan-list-produk.php', 'admin-products');
await ashots('/Admin/penjualan-history-pesanan.php', 'admin-orders');
await ashots('/Admin/users.php', 'admin-users');

await b2.close();
console.log('done');
