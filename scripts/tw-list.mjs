#!/usr/bin/env node

/**
 * List/search Teamwork tasks for GPT Workbench project.
 *
 * Usage:
 *   ./scripts/tw-list.js                          List all open tasks
 *   ./scripts/tw-list.js --bugs                   List bugs only
 *   ./scripts/tw-list.js --backlog                List backlog only
 *   ./scripts/tw-list.js --search="translation"   Search by keyword
 *   ./scripts/tw-list.js --all                    Include completed tasks
 *   ./scripts/tw-list.js --json                   Raw JSON output
 *
 * Output format (default):
 *   #35087073 [BUG] Title here (progress: 50%, priority: high)
 */

import fs from 'fs';
import path from 'path';
import { tw } from './teamwork.mjs';

const IMAGE_EXTS = ['.png', '.jpg', '.jpeg', '.gif', '.webp', '.svg'];
const IMAGES_DIR = path.resolve(process.cwd(), '.tickets', 'images');

/** Extract image URLs from an HTML string */
function extractImageUrls(html) {
    if (!html) return [];
    const urls = [];
    const re = /<img[^>]+src=["']([^"']+)["']/gi;
    let match;
    while ((match = re.exec(html)) !== null) {
        urls.push(match[1]);
    }
    return urls;
}

/** Download an image URL to .tickets/images/, returns local path or null */
async function downloadImage(url, prefix, originalName) {
    try {
        const basename = originalName || path.basename(new URL(url).pathname) || 'image.png';
        const safeName = basename.replace(/[^a-zA-Z0-9._-]/g, '_');
        const destPath = path.join(IMAGES_DIR, `${prefix}-${safeName}`);
        if (fs.existsSync(destPath)) return destPath;
        await tw.downloadFile(url, destPath);
        return destPath;
    } catch {
        return null;
    }
}

/** Strip HTML tags and decode common entities */
function stripHtml(html) {
    return (html || '')
        .replace(/<br\s*\/?>/gi, '\n')
        .replace(/<\/p>/gi, '\n')
        .replace(/<[^>]*>/g, '')
        .replace(/&amp;/g, '&')
        .replace(/&lt;/g, '<')
        .replace(/&gt;/g, '>')
        .replace(/&quot;/g, '"')
        .replace(/&#39;/g, "'")
        .replace(/\n{3,}/g, '\n\n')
        .trim();
}

const args = process.argv.slice(2);

let filter = null;     // 'bugs', 'backlog', 'features'
let search = null;
let taskId = null;
let showAll = false;
let jsonOutput = false;
let pageSize = 50;

for (let i = 0; i < args.length; i++) {
    const arg = args[i];
    if (arg === '--bugs') filter = 'bugs';
    else if (arg === '--backlog') filter = 'backlog';
    else if (arg === '--features') filter = 'features';
    else if (arg.startsWith('--search=')) search = arg.slice('--search='.length);
    else if (arg === '--search') search = args[++i];
    else if (arg === '--all') showAll = true;
    else if (arg === '--json') jsonOutput = true;
    else if (arg.startsWith('--limit=')) pageSize = parseInt(arg.split('=')[1], 10);
    else if (arg === '--limit') pageSize = parseInt(args[++i], 10);
    else if (/^\d{6,}$/.test(arg)) taskId = arg;
    else if (arg === '--help' || arg === '-h') {
        console.log(`Usage: ./scripts/tw-list.js [options]

Options:
  <taskId>         Fetch a single task by ID
  --bugs           Show only bugs (tasklist ${tw.TASKLISTS.BUGS})
  --backlog        Show only backlog (tasklist ${tw.TASKLISTS.BACKLOG})
  --features       Show only feature requests (tasklist ${tw.TASKLISTS.FEATURES})
  --search="term"  Search tasks by name
  --all            Include completed tasks
  --json           Output raw JSON
  --limit=N        Max results (default: 50)
`);
        process.exit(0);
    }
}

try {
    // Single task lookup by ID
    if (taskId) {
        const [task, comments, files, taskStageMap] = await Promise.all([
            tw.getTask(taskId),
            tw.getComments(taskId),
            tw.getFiles(taskId),
            tw.buildTaskStageMap(),
        ]);

        if (jsonOutput) {
            console.log(JSON.stringify({ task, comments, files }, null, 2));
            process.exit(0);
        }

        // Task header
        const priority = task.priority ? `priority: ${task.priority}` : '';
        const progress = task.progress > 0 ? `progress: ${task.progress}%` : '';
        const column = taskStageMap[task.id] || 'BACKLOG';
        const meta = [column, progress, priority].filter(Boolean).join(', ');
        console.log(`#${task.id} ${task.name} (${meta})`);

        // Description (text + inline images)
        if (task.description) {
            const desc = stripHtml(task.description);
            if (desc) console.log(`\n${desc.slice(0, 800)}${desc.length > 800 ? '...' : ''}`);

            const descImages = extractImageUrls(task.description);
            for (const url of descImages) {
                const localPath = await downloadImage(url, `${taskId}-desc`);
                if (localPath) console.log(`  [image] ${localPath}`);
            }
        }
        console.log(`\nCreated: ${task.createdAt || '?'}`);

        // Comments (full text + inline images + attachments)
        if (comments.length > 0) {
            console.log(`\n--- Comments (${comments.length}) ---`);
            for (const c of comments) {
                const author = `${c['author-firstname']} ${c['author-lastname']}`;
                const date = c.datetime ? new Date(c.datetime).toLocaleDateString('fr-FR') : '?';
                const body = stripHtml(c['html-body'] || c.body || '');
                console.log(`\n  [${date}] ${author}:`);
                // Show full body, indented
                for (const line of body.split('\n')) {
                    console.log(`    ${line}`);
                }

                // Download inline images from html-body
                const inlineImages = extractImageUrls(c['html-body']);
                for (const url of inlineImages) {
                    const localPath = await downloadImage(url, `${taskId}-c${c.id}`);
                    if (localPath) console.log(`    [image] ${localPath}`);
                }

                // Download comment attachments
                const attachments = c.attachments || [];
                for (const a of attachments) {
                    const name = a.originalName || a.name || 'attachment';
                    const ext = name.slice(name.lastIndexOf('.')).toLowerCase();
                    const isImage = IMAGE_EXTS.includes(ext);
                    console.log(`    [attachment] ${name} (${Math.round((a.size || 0) / 1024)}KB)${isImage ? ' [IMAGE]' : ''}`);

                    if (isImage) {
                        try {
                            const dlUrl = a['download-URL'] || (a.id && (await tw.getFile(a.id))?.['download-URL']);
                            if (dlUrl) {
                                const localPath = await downloadImage(dlUrl, `${taskId}-c${c.id}`, name);
                                if (localPath) console.log(`      -> ${localPath}`);
                            }
                        } catch (dlErr) {
                            console.error(`      -> Download failed: ${dlErr.message}`);
                        }
                    }
                }
            }
        }

        // Task-level file attachments
        if (files.length > 0) {
            console.log(`\n--- Attachments (${files.length}) ---`);
            for (const f of files) {
                const name = f.originalName || f.name || 'unknown';
                const ext = name.slice(name.lastIndexOf('.')).toLowerCase();
                const isImage = IMAGE_EXTS.includes(ext);
                console.log(`  ${name} (${Math.round((f.size || 0) / 1024)}KB)${isImage ? ' [IMAGE]' : ''}`);

                if (isImage) {
                    try {
                        const fileDetail = await tw.getFile(f.id);
                        const downloadUrl = fileDetail?.['download-URL'];
                        if (downloadUrl) {
                            const localPath = await downloadImage(downloadUrl, taskId, name);
                            if (localPath) console.log(`    -> ${localPath}`);
                        }
                    } catch (dlErr) {
                        console.error(`    -> Download failed: ${dlErr.message}`);
                    }
                }
            }
        }

        process.exit(0);
    }

    let data;
    let taskStageMap;

    if (search) {
        [data, taskStageMap] = await Promise.all([
            tw.searchTasks(search, {
                status: showAll ? undefined : 'active',
                pageSize,
            }),
            tw.buildTaskStageMap(),
        ]);
    } else {
        const tasklistId = filter === 'bugs' ? tw.TASKLISTS.BUGS
            : filter === 'backlog' ? tw.TASKLISTS.BACKLOG
            : filter === 'features' ? tw.TASKLISTS.FEATURES
            : undefined;

        [data, taskStageMap] = await Promise.all([
            tw.listTasks({
                tasklistId,
                status: showAll ? undefined : 'active',
                pageSize,
            }),
            tw.buildTaskStageMap(),
        ]);
    }

    const tasks = data.tasks || [];

    if (jsonOutput) {
        console.log(JSON.stringify(tasks, null, 2));
        process.exit(0);
    }

    if (tasks.length === 0) {
        console.log('No tasks found.');
        process.exit(0);
    }

    // Group by tasklist
    const grouped = {};
    for (const task of tasks) {
        const listName = task.taskList?.name || 'Unknown';
        if (!grouped[listName]) grouped[listName] = [];
        grouped[listName].push(task);
    }

    let total = 0;
    for (const [listName, listTasks] of Object.entries(grouped)) {
        console.log(`\n--- ${listName} (${listTasks.length}) ---`);
        for (const task of listTasks) {
            const priority = task.priority ? `, priority: ${task.priority}` : '';
            const progress = task.progress > 0 ? `, progress: ${task.progress}%` : '';
            const created = task.createdAt ? new Date(task.createdAt).toLocaleDateString('fr-FR') : '';
            const column = taskStageMap[task.id] ? ` [${taskStageMap[task.id]}]` : '';
            console.log(`  #${task.id} ${task.name}${column} (${progress.slice(2) || 'new'}${priority}, ${created})`);
            total++;
        }
    }

    console.log(`\nTotal: ${total} task(s)`);

} catch (err) {
    console.error(`Error: ${err.message}`);
    process.exit(1);
}
