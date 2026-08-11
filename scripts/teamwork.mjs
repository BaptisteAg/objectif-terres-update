#!/usr/bin/env node

/**
 * Teamwork API helper library + CLI
 *
 * Reads credentials from .env:
 *   TEAMWORK_API_URL=https://ideagency.teamwork.com
 *   TEAMWORK_API_TOKEN=tkn.v1_...
 *
 * Usage as CLI:
 *   ./scripts/teamwork.mjs get /projects/api/v3/tasks/12345.json
 *   ./scripts/teamwork.mjs patch /projects/api/v3/tasks/12345.json '{"task":{"progress":100}}'
 *   ./scripts/teamwork.mjs post /projects/api/v3/tasks/12345/comments.json '{"comment":{"body":"Done"}}'
 *
 * Usage as library:
 *   import { tw } from './teamwork.mjs';
 *   const task = await tw.getTask(12345);
 *   await tw.updateTask(12345, { progress: 100 });
 *   await tw.commentOnTask(12345, 'Résolu.');
 */

import fs from 'fs';
import path from 'path';
import { fileURLToPath } from 'url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const ROOT = path.resolve(__dirname, '..');

// ---------------------------------------------------------------------------
// Config
// ---------------------------------------------------------------------------

function loadEnv() {
    const envPath = path.join(ROOT, '.env');
    if (!fs.existsSync(envPath)) {
        throw new Error('.env file not found at ' + envPath);
    }
    const env = {};
    for (const line of fs.readFileSync(envPath, 'utf8').split('\n')) {
        const trimmed = line.trim();
        if (!trimmed || trimmed.startsWith('#')) continue;
        const eqIdx = trimmed.indexOf('=');
        if (eqIdx === -1) continue;
        const key = trimmed.slice(0, eqIdx);
        let val = trimmed.slice(eqIdx + 1);
        if ((val.startsWith('"') && val.endsWith('"')) || (val.startsWith("'") && val.endsWith("'"))) {
            val = val.slice(1, -1);
        }
        env[key] = val;
    }
    return env;
}

const env = loadEnv();
const API_URL = env.TEAMWORK_API_URL;
const API_TOKEN = env.TEAMWORK_API_TOKEN;

if (!API_URL || !API_TOKEN) {
    console.error('Missing TEAMWORK_API_URL or TEAMWORK_API_TOKEN in .env');
    process.exit(1);
}

// Objectif Terres project ID
const PROJECT_ID = 653749;

// Tasklist IDs (à compléter au besoin — voir tw-list.js)
const TASKLISTS = {};

// Kanban workflow
const WORKFLOW_ID = 59578;

// Board column (stage) IDs — à compléter via tw.getStages()
const STAGES = {};

// Reverse map: stage ID → display name
const STAGE_NAMES = {};

// ---------------------------------------------------------------------------
// HTTP layer
// ---------------------------------------------------------------------------

async function request(method, endpoint, body) {
    const url = `${API_URL}${endpoint}`;
    const headers = {
        'Authorization': `Bearer ${API_TOKEN}`,
        'Content-Type': 'application/json',
    };

    const opts = { method, headers };
    if (body && method !== 'GET') {
        opts.body = typeof body === 'string' ? body : JSON.stringify(body);
    }

    const res = await fetch(url, opts);
    const text = await res.text();

    if (!res.ok) {
        throw new Error(`Teamwork API ${res.status}: ${text.slice(0, 300)}`);
    }

    return text ? JSON.parse(text) : null;
}

// ---------------------------------------------------------------------------
// High-level API
// ---------------------------------------------------------------------------

const tw = {
    PROJECT_ID,
    TASKLISTS,
    WORKFLOW_ID,
    STAGES,
    STAGE_NAMES,

    /** Raw API call */
    request,

    /** Get a single task */
    async getTask(taskId) {
        const data = await request('GET', `/projects/api/v3/tasks/${taskId}.json`);
        return data.task;
    },

    /** Update task fields (progress, description, priority, etc.) */
    async updateTask(taskId, fields) {
        const data = await request('PATCH', `/projects/api/v3/tasks/${taskId}.json`, {
            task: fields,
        });
        return data.task;
    },

    /** Add a comment to a task (uses v1 API - v3 returns 404) */
    async commentOnTask(taskId, body) {
        const data = await request('POST', `/tasks/${taskId}/comments.json`, {
            comment: { body, 'content-type': 'text' },
        });
        return { id: data.commentId || data.id };
    },

    /** List tasks for the project, with optional filters */
    async listTasks(opts = {}) {
        const params = new URLSearchParams();
        if (opts.tasklistId) params.set('tasklistIds', opts.tasklistId);
        if (opts.status) params.set('statuses', opts.status);
        if (opts.page) params.set('page', opts.page);
        params.set('pageSize', opts.pageSize || 50);
        params.set('include', 'tags');
        const qs = params.toString();
        const data = await request('GET', `/projects/api/v3/projects/${PROJECT_ID}/tasks.json?${qs}`);
        return data;
    },

    /** Search tasks by name */
    async searchTasks(searchTerm, opts = {}) {
        const params = new URLSearchParams();
        params.set('searchTerm', searchTerm);
        if (opts.status) params.set('statuses', opts.status);
        params.set('pageSize', opts.pageSize || 20);
        const qs = params.toString();
        const data = await request('GET', `/projects/api/v3/projects/${PROJECT_ID}/tasks.json?${qs}`);
        return data;
    },

    /** Complete a task (mark as done, uses v1 API) */
    async completeTask(taskId) {
        return await request('PUT', `/tasks/${taskId}/complete.json`, {});
    },

    /** Set task progress (0-100) */
    async setProgress(taskId, progress) {
        return tw.updateTask(taskId, { progress });
    },

    /** Get comments for a task (v1 API) */
    async getComments(taskId) {
        const data = await request('GET', `/tasks/${taskId}/comments.json`);
        return data.comments || [];
    },

    /** Get files attached to a task (v1 API) */
    async getFiles(taskId) {
        const data = await request('GET', `/tasks/${taskId}/files.json`);
        return data.project?.files || [];
    },

    /** Get single file details including download URL */
    async getFile(fileId) {
        const data = await request('GET', `/files/${fileId}.json`);
        return data.file || null;
    },

    /** Download a file to disk (uses bearer token auth) */
    async downloadFile(downloadUrl, destPath) {
        const res = await fetch(downloadUrl, {
            headers: { 'Authorization': `Bearer ${API_TOKEN}` },
            redirect: 'follow',
        });
        if (!res.ok) throw new Error(`Download failed: ${res.status}`);
        const buffer = Buffer.from(await res.arrayBuffer());
        const dir = path.dirname(destPath);
        if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true });
        fs.writeFileSync(destPath, buffer);
        return destPath;
    },

    /** Add a tag to a task (merges with existing tags) */
    async addTag(taskId, tagId) {
        const task = await tw.getTask(taskId);
        const existingTagIds = (task.tags || []).map(t => t.id);
        if (existingTagIds.includes(tagId)) return task;
        return tw.updateTask(taskId, { tagIds: [...existingTagIds, tagId] });
    },

    /** Remove a tag from a task */
    async removeTag(taskId, tagId) {
        const task = await tw.getTask(taskId);
        const existingTagIds = (task.tags || []).map(t => t.id);
        if (!existingTagIds.includes(tagId)) return task;
        return tw.updateTask(taskId, { tagIds: existingTagIds.filter(id => id !== tagId) });
    },

    /** Well-known tag IDs (à compléter pour ce projet) */
    TAGS: {},

    /** Resolve a ticket: set 100%, add comment, optionally complete */
    async resolveTask(taskId, comment, opts = {}) {
        const results = {};
        results.task = await tw.updateTask(taskId, { progress: 100 });
        if (comment) {
            results.comment = await tw.commentOnTask(taskId, comment);
        }
        if (opts.complete) {
            results.completed = await tw.completeTask(taskId);
        }
        return results;
    },

    /** Move task(s) to a board column (stage) */
    async moveToStage(taskIds, stageId) {
        const ids = Array.isArray(taskIds) ? taskIds : [taskIds];
        return await request('POST', `/projects/api/v3/workflows/${WORKFLOW_ID}/stages/${stageId}/tasks.json`, {
            taskIds: ids.map(Number),
        });
    },

    /** Get all workflow stages (for resolving stage names) */
    async getStages() {
        const data = await request('GET', `/projects/api/v3/workflows/${WORKFLOW_ID}/stages.json`);
        return data.stages || [];
    },

    /** Build a map of task ID → stage name from current workflow state */
    async buildTaskStageMap() {
        const stages = await tw.getStages();
        const map = {};
        for (const stage of stages) {
            if (stage.taskIds) {
                for (const tid of stage.taskIds) {
                    map[tid] = stage.name;
                }
            }
        }
        return map;
    },
};

// ---------------------------------------------------------------------------
// CLI mode
// ---------------------------------------------------------------------------

const isMain = process.argv[1] && (
    process.argv[1].endsWith('teamwork.mjs') ||
    process.argv[1].endsWith('teamwork')
);

if (isMain) {
    const args = process.argv.slice(2);

    if (args.length === 0) {
        console.log(`Teamwork API CLI - ${API_URL}

Usage:
  ./scripts/teamwork.mjs <method> <endpoint> [json-body]
  ./scripts/teamwork.mjs get  /projects/api/v3/tasks/12345.json
  ./scripts/teamwork.mjs patch /projects/api/v3/tasks/12345.json '{"task":{"progress":100}}'
  ./scripts/teamwork.mjs post  /projects/api/v3/tasks/12345/comments.json '{"comment":{"body":"Done"}}'
`);
        process.exit(0);
    }

    const method = args[0].toUpperCase();
    const endpoint = args[1];
    const body = args[2] ? JSON.parse(args[2]) : undefined;

    try {
        const result = await request(method, endpoint, body);
        console.log(JSON.stringify(result, null, 2));
    } catch (err) {
        console.error(err.message);
        process.exit(1);
    }
}

export { tw };
