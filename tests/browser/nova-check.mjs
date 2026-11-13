import { spawn } from 'node:child_process';
import { readFileSync, rmSync } from 'node:fs';

const base = 'https://objectif-terres.ddev.site';
const session = JSON.parse(readFileSync(new URL('../../storage/logs/nova-session.json', import.meta.url)));
const pages = [
    ['/ot-admin/dashboards/main', ['Objectif Terres', 'Terre de Liens | All right reserved']],
    ['/ot-admin/resources/ads', []],
    ['/ot-admin/resources/users', []],
    [`/ot-admin/resources/users/${session.user}`, []],
    ['/ot-admin/resources/attribution-ads/1', []],
    [`/ot-admin/resources/cms-pages/${session.cms}/edit`, ['ck-editor']],
    ['/ot-admin/resources/cms-faqs/1/edit', ['ck-editor']],
    ['/ot-admin/resources/cms-common-contents/1/edit', ['ck-editor']],
    ['/ot-admin/resources/images', []],
];

const profile = `/tmp/ot-cdp-${process.pid}`;
const chrome = spawn('google-chrome', ['--headless=new', '--disable-gpu', '--no-first-run', '--ignore-certificate-errors',
    `--user-data-dir=${profile}`, '--remote-debugging-port=9333', 'about:blank'], { stdio: 'ignore' });

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
let target;
for (let i = 0; i < 50 && !target; i++) {
    await sleep(200);
    try {
        const list = await (await fetch('http://127.0.0.1:9333/json/list')).json();
        target = list.find((t) => t.type === 'page');
    } catch {}
}
if (!target) throw new Error('Chrome DevTools introuvable');

const ws = new WebSocket(target.webSocketDebuggerUrl);
await new Promise((r) => ws.addEventListener('open', r));
let id = 0;
const waiting = new Map();
const events = [];
ws.addEventListener('message', (m) => {
    const msg = JSON.parse(m.data);
    if (msg.id && waiting.has(msg.id)) { waiting.get(msg.id)(msg); waiting.delete(msg.id); }
    else if (msg.method) events.push(msg);
});
const send = (method, params = {}) => new Promise((r) => { const n = ++id; waiting.set(n, r); ws.send(JSON.stringify({ id: n, method, params })); });

await send('Runtime.enable');
await send('Log.enable');
await send('Network.enable');
await send('Network.setCookie', { name: session.name, value: session.value, domain: 'objectif-terres.ddev.site', path: '/', secure: true, httpOnly: true });

let failures = 0;
for (const [path, expected] of pages) {
    events.length = 0;
    await send('Page.navigate', { url: base + path });
    await sleep(6000);
    const res = await send('Runtime.evaluate', { expression: 'JSON.stringify({url: location.pathname, html: document.documentElement.outerHTML.length, text: document.body.innerText.slice(0, 20000), dom: document.documentElement.outerHTML})', returnByValue: true });
    const page = JSON.parse(res.result.result.value);
    const errors = events
        .filter((e) => e.method === 'Runtime.exceptionThrown' || (e.method === 'Runtime.consoleAPICalled' && e.params.type === 'error') || (e.method === 'Log.entryAdded' && e.params.entry.level === 'error'))
        .map((e) => e.params.exceptionDetails?.exception?.description?.split('\n')[0] ?? e.params.args?.map((a) => a.value ?? a.description).join(' ') ?? ((e.params.entry?.text ?? '') + ' ' + (e.params.entry?.url ?? '')))
        .filter((t) => t && !/favicon|google|gtag|recaptcha/i.test(t));
    const missing = expected.filter((needle) => !page.dom.includes(needle));
    const ok = page.url === path.split('?')[0] && errors.length === 0 && missing.length === 0;
    if (!ok) failures++;
    console.log(`${ok ? 'OK ' : 'KO '} ${path} -> ${page.url} dom=${page.html}${missing.length ? ' manquant=' + missing.join(',') : ''}`);
    [...new Set(errors)].slice(0, 4).forEach((e) => console.log('     ' + String(e).slice(0, 220)));
}

ws.close();
chrome.kill();
await sleep(300);
rmSync(profile, { recursive: true, force: true });
process.exit(failures ? 1 : 0);
