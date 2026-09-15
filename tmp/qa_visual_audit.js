const { spawn } = require('child_process');
const fs = require('fs');

const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const base = 'http://skillspark.local';
const port = 9333;
const widths = [320, 390, 430, 768, 1024, 1440, 1920];
const routes = [
  { path: '/training', selectors: ['.training-story-media', '.editorial-media-grid--stack'] },
  { path: '/training/programs', selectors: ['.learning-builds-section', '.editorial-media-grid--trio', '.detail-grid'] },
  { path: '/training/program/creative-design', selectors: ['main'] },
  { path: '/services/video-and-media-production', selectors: ['main'] },
  { path: '/training/program/computer-hardware-repairs', selectors: ['.editorial-media-grid--duo'] },
  { path: '/work', selectors: ['#practical-hardware-skills', '#open-practical-learning', '#learner-teamwork-venture', '#community-stakeholder-engagement', '.editorial-media-grid--visitors'] },
  { path: '/work/case-studies', selectors: ['a[href$="/work/case-studies/learner-built-website-project"]'] },
  { path: '/work/case-studies/learner-built-website-project', selectors: ['.case-study-media'] },
  { path: '/founder', selectors: ['.founder-layout', '.founder-editorial', '.founder-book-note'] },
  { path: '/gallery', selectors: ['[data-filter="projects"]', '[data-lightbox-index]'] },
  { path: '/', selectors: ['main'] },
];

function sleep(ms) {
  return new Promise((resolve) => setTimeout(resolve, ms));
}

async function getJson(url, options = undefined) {
  const response = await fetch(url, options);
  if (!response.ok) throw new Error(`${url} returned ${response.status}`);
  return response.json();
}

function wsCall(ws, method, params = {}) {
  const id = ++ws._id;
  return new Promise((resolve, reject) => {
    ws._callbacks.set(id, { resolve, reject });
    ws.send(JSON.stringify({ id, method, params }));
  });
}

async function connect(wsUrl) {
  const ws = new WebSocket(wsUrl);
  ws._id = 0;
  ws._callbacks = new Map();
  ws.onmessage = (event) => {
    const message = JSON.parse(event.data);
    if (!message.id) return;
    const callback = ws._callbacks.get(message.id);
    if (!callback) return;
    ws._callbacks.delete(message.id);
    if (message.error) callback.reject(new Error(JSON.stringify(message.error)));
    else callback.resolve(message.result);
  };
  await new Promise((resolve, reject) => {
    ws.onopen = resolve;
    ws.onerror = reject;
  });
  return ws;
}

async function evaluate(ws, expression) {
  const result = await wsCall(ws, 'Runtime.evaluate', {
    expression,
    awaitPromise: true,
    returnByValue: true,
  });
  if (result.exceptionDetails) {
    throw new Error(result.exceptionDetails.text || 'Evaluation failed');
  }
  return result.result.value;
}

async function newPage(width) {
  const target = await getJson(`http://127.0.0.1:${port}/json/new?about:blank`, { method: 'PUT' });
  const ws = await connect(target.webSocketDebuggerUrl);
  await wsCall(ws, 'Runtime.enable');
  await wsCall(ws, 'Page.enable');
  await wsCall(ws, 'DOM.enable');
  await wsCall(ws, 'Emulation.setDeviceMetricsOverride', {
    width,
    height: 1400,
    deviceScaleFactor: 1,
    mobile: width < 768,
  });
  return { ws, targetId: target.id };
}

async function closePage(targetId) {
  await fetch(`http://127.0.0.1:${port}/json/close/${targetId}`).catch(() => {});
}

async function navigate(ws, url) {
  await wsCall(ws, 'Page.navigate', { url });
  for (let i = 0; i < 80; i++) {
    const ready = await evaluate(ws, 'document.readyState');
    if (ready === 'complete') break;
    await sleep(100);
  }
  await sleep(250);
}

function auditExpression(route) {
  return `(() => {
    const selectors = ${JSON.stringify(route.selectors)};
    const doc = document.documentElement;
    const body = document.body;
    const viewportH = window.innerHeight;
    const selected = selectors.map((selector) => {
      const elements = Array.from(document.querySelectorAll(selector));
      const rects = elements.slice(0, 4).map((el) => {
        const rect = el.getBoundingClientRect();
        const imgs = Array.from(el.querySelectorAll('img'));
        return {
          width: Math.round(rect.width),
          height: Math.round(rect.height),
          top: Math.round(rect.top + window.scrollY),
          tag: el.tagName.toLowerCase(),
          imageCount: imgs.length,
          imagesLoaded: imgs.every((img) => img.complete && img.naturalWidth > 0),
          imageRects: imgs.slice(0, 4).map((img) => {
            const ir = img.getBoundingClientRect();
            return { width: Math.round(ir.width), height: Math.round(ir.height), src: img.currentSrc || img.src };
          })
        };
      });
      return { selector, count: elements.length, rects };
    });
    const ids = Array.from(document.querySelectorAll('[id]')).map((el) => el.id);
    const duplicateIds = ids.filter((id, index) => ids.indexOf(id) !== index);
    const h1 = document.querySelectorAll('h1').length;
    const missingAlts = Array.from(document.images).filter((img) => !img.hasAttribute('alt')).length;
    const jsonLdValid = Array.from(document.querySelectorAll('script[type="application/ld+json"]')).every((node) => {
      try { JSON.parse(node.textContent); return true; } catch { return false; }
    });
    const robots = document.querySelector('meta[name="robots"]')?.content || '';
    const title = document.title;
    const description = document.querySelector('meta[name="description"]')?.content || '';
    const canonical = document.querySelector('link[rel="canonical"]')?.href || '';
    const localPathLeak = /C:\\\\|Desktop\\\\hmm|Desktop\\/hmm|Users\\\\SkillsPark Tech Hub/.test(document.documentElement.outerHTML);
    const overflowX = Math.ceil(Math.max(doc.scrollWidth, body.scrollWidth)) > window.innerWidth + 1;
    const tallestImg = Math.max(0, ...Array.from(document.images).map((img) => img.getBoundingClientRect().height));
    return {
      url: location.pathname,
      width: window.innerWidth,
      scrollWidth: Math.ceil(Math.max(doc.scrollWidth, body.scrollWidth)),
      overflowX,
      h1,
      missingAlts,
      duplicateIds: Array.from(new Set(duplicateIds)),
      jsonLdValid,
      robots,
      title,
      description,
      canonical,
      localPathLeak,
      selected,
      tallestImg: Math.round(tallestImg),
      tallestImgViewportRatio: Number((tallestImg / viewportH).toFixed(2)),
    };
  })()`;
}

async function main() {
  if (!fs.existsSync(chromePath)) throw new Error(`Chrome not found at ${chromePath}`);
  const userDataDir = `${process.cwd()}\\tmp\\chrome-qa-profile`;
  const chrome = spawn(chromePath, [
    '--headless=new',
    `--remote-debugging-port=${port}`,
    `--user-data-dir=${userDataDir}`,
    '--disable-gpu',
    '--no-first-run',
    '--no-default-browser-check',
    'about:blank',
  ], { stdio: 'ignore' });

  try {
    for (let i = 0; i < 80; i++) {
      try { await getJson(`http://127.0.0.1:${port}/json/version`); break; }
      catch { await sleep(100); }
    }

    const output = {};
    for (const width of widths) {
      output[width] = {};
      const page = await newPage(width);
      try {
        for (const route of routes) {
          await navigate(page.ws, `${base}${route.path}`);
          output[width][route.path] = await evaluate(page.ws, auditExpression(route));
        }
      } finally {
        page.ws.close();
        await closePage(page.targetId);
      }
    }

    const sitemap = await fetch(`${base}/sitemap.xml`).then((r) => r.text());
    const robots = await fetch(`${base}/robots.txt`).then((r) => r.text());
    output.sitemap = {
      hasLearnerCaseStudy: sitemap.includes('/work/case-studies/learner-built-website-project'),
      hasFounder: sitemap.includes('/founder'),
    };
    output.robotsTxt = { hasSitemap: /Sitemap:/i.test(robots) };
    console.log(JSON.stringify(output, null, 2));
  } finally {
    chrome.kill();
  }
}

main().catch((error) => {
  console.error(error);
  process.exit(1);
});



