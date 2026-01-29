# Thread Moderator Reassignment Fix Report

**Date**: 2026-01-23
**Issue**: Clothilde Caron cannot use messaging on ads reassigned from Claire Cormary
**Example ad**: https://www.objectif-terres.org/annonces/9371

---

## Executive Summary

When Claire Cormary (user ID 15775) was replaced by Clothilde Caron (user ID 20415), ads were reassigned but Clothilde could not access existing message threads. This was caused by a missing feature in the reassignment process that was only added on Dec 4, 2025.

**Fix applied to staging**: 76 threads updated
**Production**: Pending

---

## Root Cause Analysis

### How Messaging Works

Threads are conversations between:
- The **ad owner** (user_pp_id)
- Whoever **initiates contact** (the person who sends the first message)

The assigned moderator (`attribution_ads.user_moderator_id`) is **NOT automatically added** to threads. Moderators only become participants when they send a message.

### The Bug

The `ReallocateModeratorAds` Nova action was missing thread participant updates until commit `c5ffea46` (Dec 4, 2025). When Claire's ads were reassigned to Clothilde **before** this fix:

1. `attribution_ads.user_moderator_id` was updated to Clothilde ✓
2. Thread participants (`thread_users`) were NOT updated ✗
3. Claire remained in threads, Clothilde was never added

### Current Code (Fixed)

`app/Nova/Actions/ReallocateModeratorAds.php` (lines 87-96):
```php
// Update thread participants: add new moderator, remove old moderators
$threads = Thread::whereIn('ad_id', $adIds)->get();
foreach ($threads as $thread) {
    if (!$thread->users()->where('users.id', $new_moderator_id)->exists()) {
        $thread->users()->attach($new_moderator_id);
    }
    $thread->users()->detach($old_moderator_ids);
}
```

---

## Investigation Data

| Metric | Count |
|--------|-------|
| Total threads with ads | 53,766 |
| Threads missing current moderator | 38,054 |
| ↳ This is BY DESIGN (moderators not auto-added) | - |
| Clothilde's threads where she's missing | 188 |
| ↳ Claire present, Clothilde absent | **76** ← BUG |
| ↳ Neither present (no moderator initiated) | 112 |
| Claire in threads for ads now Clothilde's | 91 |

---

## Fix Applied

### SQL Queries

**Step 1: Add Clothilde to threads where Claire was present**
```sql
INSERT INTO thread_users (thread_id, user_id, created_at, updated_at)
SELECT t.id, 20415, NOW(), NOW()
FROM threads t
JOIN attribution_ads aa ON t.ad_id = aa.ad_id
WHERE aa.user_moderator_id = 20415
AND EXISTS (SELECT 1 FROM thread_users tu WHERE tu.thread_id = t.id AND tu.user_id = 15775)
AND NOT EXISTS (SELECT 1 FROM thread_users tu WHERE tu.thread_id = t.id AND tu.user_id = 20415);
```

**Step 2: Remove Claire from threads she no longer moderates**
```sql
DELETE tu FROM thread_users tu
JOIN threads t ON tu.thread_id = t.id
JOIN attribution_ads aa ON t.ad_id = aa.ad_id
WHERE tu.user_id = 15775
AND aa.user_moderator_id = 20415;
```

### Results on Staging

| Before | After |
|--------|-------|
| Clothilde in 19 threads | Clothilde in 95 threads |
| Claire in 91 Clothilde's threads | Claire in 0 Clothilde's threads |

---

## What About the Other 112 Threads?

These are threads where **neither Claire nor Clothilde ever participated**. The conversations were between ad owners and other users (not the assigned moderator). This is normal behavior - Clothilde can start new conversations on those ads if needed.

---

## Production Deployment

Run the same SQL queries on production:

```bash
ssh runcloud@54.37.149.176 "cd /home/runcloud/webapps/ObjectifTerreProd && php artisan tinker"
```

Then execute the SQL queries above, or run directly via MySQL.

---

## Prevention

The fix in commit `c5ffea46` (Dec 4, 2025) ensures future moderator reassignments will correctly update thread participants. No additional code changes needed.

---

## Files Involved

- `app/Nova/Actions/ReallocateModeratorAds.php` - Bulk moderator reassignment
- `app/Nova/Actions/ReallocateAd.php` - Single ad reassignment
- `app/Models/Thread.php` - Thread model with `scopeForUser()` access control
- `app/Repositories/Threads/ThreadsRepository.php` - Thread queries using `forUser()` scope
