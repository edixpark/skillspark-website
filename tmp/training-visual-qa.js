const { chromium } = require('playwright');

const base = process.argv[2] || 'http://127.0.0.1:8000';
const outDir = 'tmp/training-qa-current';
const programsWidths = [320, 390, 430, 768, 1024, 1280, 1440, 1920];
const detailWidths = [390, 768, 1440];
const detailSlugs = [
  'digital-skills-switch',
  'digital-skills-masterclass',
  'technical-skills-program',
  'business-in-the-digital-age',
  'train-the-trainers',
  'special-classes',
];

async function auditPage(page, path, width) {
  await page.setViewportSize({ width, height: 1100 });
  await page.goto(`${base}${path}`, { waitUntil: 'networkidle' });
  const height = await page.evaluate(() => document.documentElement.scrollHeight);
  for (let y = 0; y <= height; y += 700) {
    await page.evaluate((scrollY) => window.scrollTo(0, scrollY), y);
    await page.waitForTimeout(60);
  }
  await page.evaluate(() => window.scrollTo(0, 0));
  await page.screenshot({ path: `${outDir}/${path.replaceAll('/', '-').replace(/^-/, '')}-${width}.png`, fullPage: true });
  return await page.evaluate(() => {
    const text = (el) => (el.textContent || '').replace(/\s+/g, ' ').trim();
    const ids = [...document.querySelectorAll('[id]')].map((el) => el.id);
    const duplicateIds = [...new Set(ids.filter((id, index) => ids.indexOf(id) !== index))];
    const linksWithoutText = [...document.querySelectorAll('a')].filter((a) => !text(a) && !a.getAttribute('aria-label')).length;
    const brokenImages = [...document.images].filter((img) => !img.complete || img.naturalWidth === 0).map((img) => img.currentSrc || img.src);
    const emptyAlt = [...document.images].filter((img) => !img.alt.trim()).map((img) => img.currentSrc || img.src);
    const h1 = [...document.querySelectorAll('h1')].map(text);
    const headings = [...document.querySelectorAll('h1,h2,h3,h4')].map((el) => `${el.tagName}:${text(el)}`);
    const overflow = Math.max(document.documentElement.scrollWidth, document.body.scrollWidth) - window.innerWidth;
    const cards = document.querySelectorAll('.program-selector-card').length;
    const catalogue = document.querySelectorAll('.course-category-card').length;
    const miniCourses = document.querySelectorAll('.course-mini-card').length;
    const sections = [...document.querySelectorAll('section')].map((section) => {
      const heading = section.querySelector('h1,h2,h3');
      return heading ? text(heading) : section.className;
    });
    return { title: document.title, h1, h1Count: h1.length, headings, duplicateIds, linksWithoutText, brokenImages, emptyAlt, overflow, cards, catalogue, miniCourses, sections };
  });
}

(async () => {
  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.route('**/*', async (route) => {
    const requestUrl = new URL(route.request().url());
    if (requestUrl.hostname === 'skillspark.local') {
      const localBase = new URL(base);
      requestUrl.protocol = localBase.protocol;
      requestUrl.hostname = localBase.hostname;
      requestUrl.port = localBase.port;
      await route.continue({ url: requestUrl.toString() });
      return;
    }
    await route.continue();
  });
  const results = [];

  for (const width of programsWidths) {
    results.push({ path: '/training/programs', width, audit: await auditPage(page, '/training/programs', width) });
  }
  for (const slug of detailSlugs) {
    for (const width of detailWidths) {
      results.push({ path: `/training/program/${slug}`, width, audit: await auditPage(page, `/training/program/${slug}`, width) });
    }
  }

  await browser.close();
  for (const result of results) {
    const a = result.audit;
    console.log(`${result.width} ${result.path}`);
    console.log(`  title=${a.title}`);
    console.log(`  h1=${a.h1Count} ${a.h1.join(' | ')}`);
    console.log(`  overflow=${a.overflow} cards=${a.cards} catalogue=${a.catalogue} miniCourses=${a.miniCourses}`);
    console.log(`  duplicateIds=${a.duplicateIds.length} linksWithoutText=${a.linksWithoutText} brokenImages=${a.brokenImages.length} emptyAlt=${a.emptyAlt.length}`);
    console.log(`  sections=${a.sections.join(' / ')}`);
  }
})().catch((error) => {
  console.error(error);
  process.exit(1);
});
