# User Soft Delete Impact Specification

This document details the application-wide impact when a User is soft-deleted (`deleted_at` is set) across all layers: public frontend, front office (moderators/supervisors), and admin (Nova).

## Overview

| Layer | Login | Profile | Ads | Dashboard | Data |
|-------|-------|---------|-----|-----------|------|
| **Public (PP)** | ❌ Blocked* | 404 | Hidden | - | Preserved |
| **Moderator (1)** | ❌ Blocked | - | View deleted | ❌ Blocked | Preserved |
| **Primo Accueillant (2)** | ❌ Blocked | - | View deleted | ❌ Blocked | Preserved |
| **Resp. Territorial (3)** | ❌ Blocked | - | View deleted | ❌ Blocked | Preserved |
| **Admin Nova (4)** | - | Via filter | Via filter | ✅ Can restore | Full access |

> *Exception: Salesforce SSO login **automatically restores** soft-deleted users

---

## 1. Public Frontend (Porteur de Projet - Role 0)

### Authentication
| Aspect | Behavior |
|--------|----------|
| Standard Login | **BLOCKED** - Auth queries exclude soft-deleted users |
| Salesforce SSO | **AUTO-RESTORE** - `SalesforceService::syncLocalUser()` sets `deleted_at = null` |
| Session | Existing sessions invalidated |

**Code Reference** - `app/Services/SalesforceService.php`:
```php
$localUser->deleted_at = null;  // Restores deleted user on SSO login
$localUser->save();
```

### Profile Visibility
| Aspect | Behavior |
|--------|----------|
| Direct URL access | **404 Not Found** - Implicit model binding excludes trashed |
| Search results | **Hidden** - User excluded from queries |
| Ad author display | **Hidden** or shows "Utilisateur supprimé" |

### User's Ads
| Aspect | Behavior |
|--------|----------|
| Public listing | **HIDDEN** - Ads excluded from public searches |
| Direct ad URL | **Accessible** if ad not deleted, but author info hidden |
| Ad status | Remains unchanged (published stays published) |

### User Data
| Data Type | Status |
|-----------|--------|
| Favorite ads | Preserved in DB, inaccessible to user |
| Saved searches | Preserved in DB, inaccessible to user |
| Messages sent | Visible in threads, sender shown as deleted |
| Documents | Preserved in DB |

---

## 2. Front Office (Moderators, Advisors, Supervisors)

### Access Control
All soft-deleted staff members are **immediately blocked** from their dashboards:

| Role | Middleware | Result |
|------|------------|--------|
| Moderator (1) | `ModeratorMiddleware` | 403 Forbidden |
| Primo Accueillant (2) | `AdvisorMiddleware` | 403 Forbidden |
| Resp. Territorial (3) | `SupervisorMiddleware` | 403 Forbidden |

### Critical: Observer-Triggered Unassignment

When a moderator/advisor/supervisor is soft-deleted, `UserObserver::deleted()` **automatically clears all their ad assignments**:

**Code Reference** - `app/Observers/UserObserver.php`:
```php
public function deleted(User $user)
{
    // Clears advisor assignments
    if($user->adsAdvisor()->exists()) {
        $user->adsAdvisor()->each(function($attributionAd) {
            $attributionAd->userAdvisor()->dissociate();
            $attributionAd->save();
        });
    }
    // Same for moderator and supervisor assignments
}
```

| Assignment Type | Column Affected | Result |
|-----------------|-----------------|--------|
| Moderator | `user_moderator_id` | Set to NULL |
| Supervisor | `user_supervisor_id` | Set to NULL |
| Advisor | `user_advisor_id` | Set to NULL |
| Advisor 2-4 | `user_advisor_2/3/4_id` | Set to NULL |

**Impact**: All ads assigned to the deleted user become **unassigned** and need reassignment.

### Viewing Deleted Users in Dashboards

Active moderators/advisors can still **see data from deleted users**:

| View | Behavior |
|------|----------|
| Ad details | Deleted user PP info visible via `withTrashed()` |
| Thread history | Deleted participants visible |
| Attribution history | Shows deleted moderator/advisor names |

**Code Reference** - `app/Repositories/AdRepository.php`:
```php
public static function getDashboardsEagerLoading() {
    return [
        'userPp' => function ($query) {
            $query->withTrashed();  // Includes deleted users
        },
        // ...
    ];
}
```

---

## 3. Admin (Nova - Role 4)

### Default Behavior
| Aspect | Behavior |
|--------|----------|
| User index | Soft-deleted users **hidden by default** |
| Trashed filter | Toggle "With Trashed" to see deleted users |
| Individual view | Accessible via direct URL or filter |

### Available Actions
| Action | Available | Notes |
|--------|-----------|-------|
| View deleted user | ✅ Yes | Via trashed filter |
| Restore user | ✅ Yes | Standard Nova restore |
| Force delete | ✅ Yes | Permanent deletion with cascades |
| Edit deleted user | ✅ Yes | Must access via trashed filter |

### Nova Resource Configuration

The User Nova resource uses Laravel's default soft delete handling:
- `SoftDeletes` trait detected automatically
- Trashed toggle available in index view
- Restore action available on trashed records

---

## 4. Data Relationships Summary

### Preserved Data (No Cascade)
| Table | Relationship | Status After Soft Delete |
|-------|--------------|--------------------------|
| `ads` | User's created ads | Preserved, hidden publicly |
| `favorite_ads` | User's favorites | Preserved, orphaned |
| `researches` | Saved searches | Preserved, orphaned |
| `documents` | Uploaded files | Preserved |
| `thread_users` | Thread membership | Preserved |
| `messages` | Sent messages | Preserved, sender shows as deleted |
| `locationable_users` | Location assignments | Preserved |
| `referent_locationables` | Territory assignments | Preserved |
| `user_permissions` | Permissions | Preserved |

### Cleared Data (Observer Action)
| Table | Columns | Action |
|-------|---------|--------|
| `attribution_ads` | `user_moderator_id` | Set to NULL |
| `attribution_ads` | `user_supervisor_id` | Set to NULL |
| `attribution_ads` | `user_advisor_id` | Set to NULL |
| `attribution_ads` | `user_advisor_2_id` | Set to NULL |
| `attribution_ads` | `user_advisor_3_id` | Set to NULL |
| `attribution_ads` | `user_advisor_4_id` | Set to NULL |

---

## 5. Edge Cases & Warnings

### Email Address Blocking
- Soft-deleted user's email **remains reserved**
- New registration with same email will fail
- Must hard delete or restore to reuse email

### Salesforce SSO Auto-Restore
- Users deleted locally but active in Salesforce will be **automatically restored** on next SSO login
- To permanently block: must also deactivate in Salesforce or hard delete

### Pending Moderation
- All ads pending moderation by deleted user become **unassigned**
- Requires manual reassignment or automatic redistribution

### Thread Visibility
- Threads explicitly load deleted users with `withTrashed()`
- Conversation history preserved
- Deleted user appears in participant list

---

## 6. Restoration Process

When a soft-deleted user is restored (via Nova or code):

| Aspect | Behavior |
|--------|----------|
| Login | Immediately possible |
| Profile | Visible again |
| Ads | Visible publicly again |
| Favorites/Searches | Accessible again |
| **Ad assignments** | **NOT restored** - must be manually reassigned |

**Important**: The observer only clears assignments on deletion. Restoration does **not** restore previous assignments.

---

## Code References

| File | Relevance |
|------|-----------|
| `app/Models/User.php` | SoftDeletes trait, relationships |
| `app/Observers/UserObserver.php` | Assignment clearing on delete |
| `app/Services/SalesforceService.php` | SSO auto-restore logic |
| `app/Repositories/AdRepository.php` | withTrashed() eager loading |
| `app/Http/Middleware/ModeratorMiddleware.php` | Role-based access control |
| `app/Nova/User.php` | Nova admin configuration |
