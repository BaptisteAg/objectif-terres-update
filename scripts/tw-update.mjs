#!/usr/bin/env node

/**
 * Update a Teamwork task: set progress, add comment, move board column, complete.
 *
 * Usage:
 *   ./scripts/tw-update.js <taskId> [options]
 *
 * Options:
 *   --progress=<0-100>       Set progress percentage
 *   --comment="<text>"       Add a comment (plain text)
 *   --complete               Mark task as completed
 *   --start="<text>"         Shortcut: move to EN COURS + comment
 *   --fixed="<text>"         Shortcut: set 90% + move to CORRIGÉ + comment
 *   --deployed="<text>"      Shortcut: set 100% + move to TERMINÉ + complete + comment
 *   --cannot-reproduce="<text>"  Shortcut: set 0% + move to DÉCISION REQUISE + comment
 *   --await-review="<text>"  Shortcut: set 50% + move to DÉCISION REQUISE + comment
 *   --resolve="<text>"       Shortcut: set 100% + move to TERMINÉ + complete + comment
 *   --move=<STAGE>           Move to any stage by key (A_TRAITER, EN_COURS, CORRIGE, DECISION_REQUISE, TERMINE)
 *
 * Examples:
 *   ./scripts/tw-update.js 35087073 --start="Investigation en cours."
 *   ./scripts/tw-update.js 35087073 --fixed="Corrigé sur dev. Commit abc123."
 *   ./scripts/tw-update.js 35087073 --deployed="Déployé en production."
 *   ./scripts/tw-update.js 35087073 --resolve="Résolu. Commit abc123."
 *   ./scripts/tw-update.js 35087073 --await-review="Investigué, non reproductible."
 *   ./scripts/tw-update.js 35087073 --move=A_TRAITER
 */

import { tw } from './teamwork.mjs';

const args = process.argv.slice(2);

if (args.length === 0) {
    console.log(`Usage: ./scripts/tw-update.js <taskId> [options]

Options:
  --progress=<0-100>       Set progress percentage
  --comment="<text>"       Add a comment
  --complete               Mark task as completed
  --start="<text>"         Shortcut: move to EN COURS + comment
  --fixed="<text>"         Shortcut: 90% + move to CORRIGÉ + comment
  --deployed="<text>"      Shortcut: 100% + move to TERMINÉ + complete + comment
  --resolve="<text>"       Shortcut: 100% + move to TERMINÉ + complete + comment
  --await-review="<text>"  Shortcut: 50% + move to DÉCISION REQUISE + comment
  --cannot-reproduce="<text>"  Shortcut: 0% + move to DÉCISION REQUISE + comment
  --move=<STAGE>           Move to stage (A_TRAITER, EN_COURS, CORRIGE, DECISION_REQUISE, TERMINE)

Examples:
  ./scripts/tw-update.js 35087073 --start="Investigation en cours."
  ./scripts/tw-update.js 35087073 --fixed="Corrigé sur dev. Commit abc123."
  ./scripts/tw-update.js 35087073 35078501 --deployed="Batch deployed"
  ./scripts/tw-update.js 35087073 --resolve="Résolu. Commit abc123."
  ./scripts/tw-update.js 35087073 --await-review="Investigué, non reproductible."
  ./scripts/tw-update.js 35087073 --move=A_TRAITER
`);
    process.exit(0);
}

// Parse options (supports both --key=value and --key value)
const taskIds = [];
let progress = null;
let comment = null;
let complete = false;
let resolve = null;
let fixed = null;
let deployed = null;
let start = null;
let awaitReview = null;
let cannotReproduce = null;
let moveStage = null;

for (let i = 0; i < args.length; i++) {
    const arg = args[i];
    if (arg.startsWith('--progress=')) {
        progress = parseInt(arg.split('=')[1], 10);
    } else if (arg === '--progress') {
        progress = parseInt(args[++i], 10);
    } else if (arg.startsWith('--comment=')) {
        comment = arg.slice('--comment='.length);
    } else if (arg === '--comment') {
        comment = args[++i];
    } else if (arg === '--complete') {
        complete = true;
    } else if (arg.startsWith('--resolve=')) {
        resolve = arg.slice('--resolve='.length);
    } else if (arg === '--resolve') {
        resolve = args[++i];
    } else if (arg.startsWith('--fixed=')) {
        fixed = arg.slice('--fixed='.length);
    } else if (arg === '--fixed') {
        fixed = args[++i];
    } else if (arg.startsWith('--deployed=')) {
        deployed = arg.slice('--deployed='.length);
    } else if (arg === '--deployed') {
        deployed = args[++i];
    } else if (arg.startsWith('--start=')) {
        start = arg.slice('--start='.length);
    } else if (arg === '--start') {
        start = args[++i];
    } else if (arg.startsWith('--await-review=')) {
        awaitReview = arg.slice('--await-review='.length);
    } else if (arg === '--await-review') {
        awaitReview = args[++i];
    } else if (arg.startsWith('--cannot-reproduce=')) {
        cannotReproduce = arg.slice('--cannot-reproduce='.length);
    } else if (arg === '--cannot-reproduce') {
        cannotReproduce = args[++i];
    } else if (arg.startsWith('--move=')) {
        moveStage = arg.slice('--move='.length);
    } else if (arg === '--move') {
        moveStage = args[++i];
    } else if (/^\d+$/.test(arg)) {
        taskIds.push(arg);
    } else {
        console.error(`Unknown argument: ${arg}`);
        process.exit(1);
    }
}

if (taskIds.length === 0) {
    console.error('Error: at least one task ID is required');
    process.exit(1);
}

// Resolve --move=STAGE_KEY to a stage ID
let moveStageId = null;
if (moveStage) {
    moveStageId = tw.STAGES[moveStage];
    if (!moveStageId) {
        console.error(`Unknown stage: ${moveStage}. Valid: ${Object.keys(tw.STAGES).join(', ')}`);
        process.exit(1);
    }
}

// Start shortcut = move to EN COURS + comment
if (start) {
    comment = start;
    moveStageId = tw.STAGES.EN_COURS;
}

// Fixed shortcut = progress 90 + move to CORRIGÉ + comment
if (fixed) {
    progress = 90;
    comment = fixed;
    moveStageId = tw.STAGES.CORRIGE;
}

// Deployed shortcut = progress 100 + move to TERMINÉ + comment + complete
if (deployed) {
    progress = 100;
    comment = deployed;
    complete = true;
    moveStageId = tw.STAGES.TERMINE;
}

// Resolve shortcut = progress 100 + move to TERMINÉ + comment + complete
if (resolve) {
    progress = 100;
    comment = resolve;
    complete = true;
    moveStageId = tw.STAGES.TERMINE;
}

// Await-review shortcut = progress 50 + move to DÉCISION REQUISE + comment
if (awaitReview) {
    progress = progress ?? 50;
    comment = awaitReview;
    moveStageId = tw.STAGES.DECISION_REQUISE;
}

// Cannot-reproduce shortcut = progress 0 + move to DÉCISION REQUISE + comment
if (cannotReproduce) {
    progress = 0;
    comment = cannotReproduce;
    moveStageId = tw.STAGES.DECISION_REQUISE;
}

async function updateOne(taskId) {
    const results = [];

    if (progress !== null) {
        await tw.setProgress(taskId, progress);
        results.push(`progress=${progress}%`);
    }

    if (comment) {
        await tw.commentOnTask(taskId, comment);
        results.push('commented');
    }

    if (moveStageId) {
        await tw.moveToStage(taskId, moveStageId);
        const stageName = tw.STAGE_NAMES[moveStageId] || moveStageId;
        results.push(`→ ${stageName}`);
    }

    if (complete) {
        try {
            await tw.completeTask(taskId);
            results.push('completed');
        } catch (e) {
            if (e.message.includes('404')) {
                results.push('already completed');
            } else {
                throw e;
            }
        }
    }

    console.log(`  #${taskId}: ${results.join(', ')}`);
}

console.log(`Updating ${taskIds.length} task(s)...`);

for (const id of taskIds) {
    try {
        await updateOne(id);
    } catch (err) {
        console.error(`  #${id}: ERROR - ${err.message}`);
    }
}

console.log('Done.');
