import { spawn } from 'node:child_process';
import { readFileSync, writeFileSync, rmSync } from 'node:fs';
const base = 'https://objectif-terres.ddev.site';
const session = JSON.parse(readFileSync(new URL('../../storage/logs/nova-session.json', import.meta.url)));
const ids = process.argv.slice(2);
const profile = `/tmp/ot-cdp-ck-${process.pid}`;
const chrome = spawn('google-chrome', ['--headless=new', '--disable-gpu', '--no-first-run', '--ignore-certificate-errors', `--user-data-dir=${profile}`, '--remote-debugging-port=9334', 'about:blank'], { stdio: 'ignore' });
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));
let target;
for (let i = 0; i < 50 && !target; i++) { await sleep(200); try { target = (await (await fetch('http://127.0.0.1:9334/json/list')).json()).find((t) => t.type === 'page'); } catch {} }
const ws = new WebSocket(target.webSocketDebuggerUrl);
await new Promise((r) => ws.addEventListener('open', r));
let id = 0; const waiting = new Map();
ws.addEventListener('message', (m) => { const msg = JSON.parse(m.data); if (msg.id && waiting.has(msg.id)) { waiting.get(msg.id)(msg); waiting.delete(msg.id); } });
const send = (method, params = {}) => new Promise((r) => { const n = ++id; waiting.set(n, r); ws.send(JSON.stringify({ id: n, method, params })); });
await send('Network.setCookie', { name: session.name, value: session.value, domain: 'objectif-terres.ddev.site', path: '/', secure: true, httpOnly: true });
const out = {};
for (const pid of ids) {
    await send('Page.navigate', { url: `${base}/ot-admin/resources/cms-pages/${pid}/edit` });
    await sleep(7000);
    const r = await send('Runtime.evaluate', { expression: "(() => { const el = document.querySelector('.ck-editor__editable'); return el && el.ckeditorInstance ? el.ckeditorInstance.getData() : null; })()", returnByValue: true });
    out[pid] = r.result.result.value;
}
writeFileSync(new URL('../../storage/logs/ckeditor-output.json', import.meta.url), JSON.stringify(out));
ws.close(); chrome.kill(); await sleep(300); rmSync(profile, { recursive: true, force: true });
