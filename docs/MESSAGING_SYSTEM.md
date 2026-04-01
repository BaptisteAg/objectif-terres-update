# Messaging System Documentation

This document provides a complete overview of the messaging system in Objectif Terres, including architecture, permissions, and business logic.

## Overview

The messaging system enables communication between:
- **Porteurs de projet** (PP) and ad responders
- **PP** and Terre de Liens staff (advisors, moderators, supervisors)
- **Staff members** among themselves

## Database Schema

### Tables

```
threads
├── id (PK)
├── title (nullable)
├── is_private (default: 1)
├── ad_id (FK → ads, nullable, CASCADE)
├── created_at
└── updated_at

messages
├── id (PK)
├── content (nullable - documents only allowed)
├── thread_id (FK → threads, CASCADE)
├── sender_user_id (FK → users, SET NULL)
├── created_at
└── updated_at

thread_users (pivot)
├── id (PK)
├── thread_id (FK → threads, CASCADE)
├── user_id (FK → users, CASCADE)
├── created_at
└── updated_at

read_messages (pivot)
├── id (PK)
├── message_id (FK → messages, CASCADE)
├── user_id (FK → users, CASCADE)
├── is_read (default: 0)
├── created_at
└── updated_at
```

### Entity Relationships

```
User ──┬── M:N ──► Thread (via thread_users)
       └── 1:N ──► Message (as sender)

Thread ──┬── 1:N ──► Message
         └── N:1 ──► Ad (optional)

Message ──┬── N:1 ──► Thread
          ├── N:1 ──► User (sender)
          └── 1:N ──► ReadMessage

ReadMessage ──┬── N:1 ──► Message
              └── N:1 ──► User
```

---

## Permission Matrix

### Actions by Role (Messaging Page)

| Action | PP (0) | Mod (1) | Advisor (2) | Supervisor (3) | Admin (4) |
|--------|--------|---------|-------------|----------------|-----------|
| Access messaging page | ✅ | ✅ | ✅ | ✅ | ✅ |
| View own threads | ✅ | ✅ | ✅ | ✅ | ✅ |
| Send message in own thread | ✅ | ✅ | ✅ | ✅ | ✅ |
| Delete own message | ✅ | ✅ | ✅ | ✅ | ✅ |
| Respond to ad | ✅ | ✅ | ✅ | ✅ | ✅ |
| View staff user list | ❌ | ✅ | ✅ | ✅ | ✅ |
| Message staff members | ❌ | ✅ | ✅ | ✅ | ✅ |
| Use response templates | ❌ | ✅ | ✅ | ✅ | ✅ |
| Multi-recipient threads | ❌ | ✅ | ✅ | ✅ | ✅ |
| Trigger support stage update | ❌ | ❌ | ✅ | ✅ | ✅ |
| Send auto-messages | ❌ | ❌ | ❌ | ✅ | ✅ |
| Manage response templates | ❌ | ❌ | ❌ | ✅ | ✅ |

### Thread Visibility (Messaging Page)

| Thread Type | PP (0) | Mod (1) | Advisor (2) | Supervisor (3) | Admin (4) |
|-------------|--------|---------|-------------|----------------|-----------|
| Own ad responses | ✅ | ✅ | ✅ | ✅ | ✅ |
| Threads as participant | ✅ | ✅ | ✅ | ✅ | ✅ |
| Staff-only threads | ❌ | ✅* | ✅* | ✅* | ✅* |
| All threads | ❌ | ❌ | ❌ | ❌ | ❌** |

*Only if participant
**Admin excluded from `forUser()` scope by default

### Message Actions

| Action | Condition |
|--------|-----------|
| View message | User is thread participant |
| Send message | User is thread participant AND thread not blocked |
| Delete message | User is message sender |
| Upload documents | User is thread participant |

---

## Ad Show Page - Discussion Permissions

The ad detail page (`/annonces/{type}/{id}`) has a separate discussion section with different visibility rules.

### Who Can SEE Discussions on Ad Show

| Role | Same Territory | Different Territory | Conditions |
|------|----------------|---------------------|------------|
| **PP (0) - Ad Owner** | ✅ | ✅ | Always sees all threads on their ad |
| **PP (0) - Other** | ✅* | ✅* | Only sees threads they participate in |
| **Moderator (1)** | ✅** | ❌ | Only if assigned as moderator for this ad |
| **Advisor (2)** | ✅* | ❌ | Only sees threads they participate in |
| **Supervisor (3)** | ✅* | ❌ | Only sees threads they participate in |
| **Admin (4)** | ✅ | ✅ | Sees ALL threads (bypasses filters) |

*Must be in `thread_users` table for that thread
**Must be the moderator in charge (`moderatorInChargeOfModeration`)

**Code logic** (`BaseController::getShowVars()`):
```php
if (auth()->user()->role === 4 ||
    $ad->user_pp_id === auth()->user()->id ||
    $moderatorInChargeOfModeration) {
    $threads = $ad->threads;
}
```

### Who Can SEND Messages on Ad Show

| Role | Same Territory | Different Territory | Conditions |
|------|----------------|---------------------|------------|
| **PP (0) - Ad Owner** | ✅ | ✅ | Can reply to any thread on their ad |
| **PP (0) - Other** | ✅ | ✅ | Can initiate thread OR reply if participant |
| **Moderator (1)** | ✅ | ❌ | Only if assigned as moderator + participant |
| **Advisor (2)** | ✅ | ❌ | Only if participant in thread |
| **Supervisor (3)** | ✅ | ❌ | Only if participant in thread |
| **Admin (4)** | ✅ | ✅ | If participant in thread |

### Response Templates on Ad Show

| Role | Can Use Templates | Can Create Templates |
|------|-------------------|----------------------|
| PP (0) | ❌ | ❌ |
| Moderator (1) | ✅ | ❌ |
| Advisor (2) | ✅ | ❌ |
| Supervisor (3) | ✅ | ✅ |
| Admin (4) | ✅ | ✅ |

### Thread Participant Assignment

When a thread is created on an ad, participants are automatically set:

| Scenario | Participants Added |
|----------|-------------------|
| PP responds to ad | Ad owner + Responder |
| Advisor contacts PP | Ad owner + Advisor |
| Supervisor auto-message | Ad owner + Supervisor |
| Support request created | Ad owner only (advisor added later) |

### Territory Impact Summary

| Context | Territory Restriction |
|---------|----------------------|
| Ad visibility in dashboard | ✅ Staff see only their territory |
| Thread initiation | ✅ Can only message ads visible to them |
| Thread visibility (once participant) | ❌ No restriction |
| Thread reply (once participant) | ❌ No restriction |
| Staff user list in messaging | ❌ All staff visible regardless of territory |

---

## Thread Types

### 1. Ad Response Thread
- **Trigger**: User responds to another user's ad
- **Participants**: Ad owner + responder
- **Linked to**: Ad (`ad_id`)
- **Created by**: Any authenticated user

### 2. Support Request Thread
- **Trigger**: User creates support request for their ad
- **Participants**: Initially ad owner only, advisor added later
- **Linked to**: Ad with project
- **Created by**: PP (role 0)

### 3. Direct Message Thread
- **Trigger**: User messages another specific user
- **Participants**: Sender + recipient
- **Linked to**: Nothing
- **Created by**: Any authenticated user

### 4. Team Thread
- **Trigger**: Staff member messages multiple staff
- **Participants**: Sender + all selected recipients
- **Linked to**: Nothing
- **Created by**: Staff (role ≥ 1)

### 5. Auto-Message Thread
- **Trigger**: Supervisor sends automatic follow-up (10 days after ad)
- **Participants**: Ad owner + supervisor
- **Linked to**: Ad
- **Created by**: System/Supervisor

---

## API Endpoints

| Method | Route | Controller | Purpose |
|--------|-------|------------|---------|
| GET | `/mon-espace/messagerie` | ThreadsController@index | List threads |
| GET | `/mon-espace/messagerie/actualisation` | ThreadsController@refreshUnreadMessages | AJAX unread count |
| POST | `/mon-espace/messagerie/creer` | ThreadsController@create | Create thread |
| GET | `/mon-espace/messagerie/{id}` | MessagesController@show | Get thread messages |
| POST | `/mon-espace/messagerie/envoi` | MessagesController@create | Send message |
| POST | `/mon-espace/messagerie/upload` | MessagesController@uploadDocuments | Upload files |
| GET | `/mon-espace/messagerie/delete/{id}` | MessagesController@delete | Delete message |

All routes require `auth` middleware.

---

## Business Logic

### Thread Creation Flow

```
1. User submits ThreadRequest
   ├── content (required)
   ├── ad_id (optional - for ad context)
   ├── user_pp_id (optional - direct message)
   ├── receivers_user_message[] (optional - multi-recipient)
   └── title (optional)

2. ThreadService determines participants:
   ├── Ad response: [ad_owner, sender]
   ├── Direct message: [target_user, sender]
   ├── Team message: [sender, ...recipients]
   └── Support request: [ad_owner]

3. Create Thread record
4. Attach participants via thread_users
5. Create initial Message
6. Create ReadMessage (is_read=0) for each recipient
7. Send NewMessageNotification email to recipients
```

### Message Creation Flow

```
1. User submits MessageRequest
   ├── thread_id (required)
   └── content (nullable if documents)

2. ThreadService creates message:
   ├── Sanitize HTML content
   ├── Convert URLs to links
   ├── Create Message record
   ├── Attach documents if any
   └── Update thread.updated_at

3. For each participant (except sender):
   ├── Create ReadMessage (is_read=0)
   └── Send NewMessageNotification

4. Special: If advisor first message on support request
   └── Update support_stage to FIRST_RECEPTION
```

### Read Status Tracking

```
Message Created
    ↓
ReadMessage created for each recipient (is_read=0)
    ↓
Recipient opens thread
    ↓
MessagesController@show() marks all as read (is_read=1)
    ↓
AJAX polling updates unread count every 25 seconds
```

---

## Content Handling

### HTML Sanitization

**Allowed tags**:
```html
<strong> <u> <i> <a> <ul> <li> <br> <img> <p>
```

**Removed**:
- `<script>` tags completely stripped
- All other HTML tags removed

### URL Auto-Linking

Plain URLs converted to clickable links:
```
https://example.com → <a href="https://example.com" target="_blank">https://example.com</a>
```

### Document Attachments

- Messages can have documents attached via `Documentable` trait
- Upload via separate endpoint, then attach IDs to message
- Images displayed inline, other files as download buttons

---

## Notifications

### NewMessageNotification

**Channel**: Email (queued)

**Trigger**: Every new message

**Recipients**: All thread participants except sender

**Content**:
- Sender name
- Message preview
- Link to messaging page
- Ad context (if applicable)

**Skipped for**: Soft-deleted users

---

## Frontend Architecture

### Vue Components

```
vue-threads (main)
├── ListThreads (sidebar)
│   ├── Thread list with unread indicators
│   ├── Thread type tags (annonce/accompagnement/TdL)
│   └── New message button (role ≥ 1)
├── HeaderMessage
│   ├── Thread title / participant names
│   └── Ad link (if applicable)
├── DisplayMessageContent
│   ├── Messages (sent right, received left)
│   ├── Timestamps
│   ├── Document previews
│   └── Delete button (own messages)
└── FormMessageReply
    ├── Rich text editor
    ├── Document upload
    ├── Response templates (role ≥ 1)
    └── Send button
```

### Polling

- Unread count refreshed every 25 seconds
- No WebSocket/real-time updates
- Endpoint: `GET /mon-espace/messagerie/actualisation`

---

## Edge Cases

### Deleted Users
- Threads load users with `withTrashed()`
- Deleted users shown as "Utilisateur supprimé"
- Messages from deleted users preserved
- `sender_user_id` set to NULL on hard delete

### Deleted Ads
- Threads load ads with `withTrashed()`
- Thread remains accessible
- Message form disabled (`isThreadBlocked`)
- Shows "Annonce supprimée"

### Thread Blocking
Form disabled when:
- User not in thread
- Associated ad is deleted
- Upload in progress

### Admin Role (4)
- Excluded from `forUser()` scope
- Can access threads via direct URL
- Not included in default thread queries

---

## Key Files

| Category | File |
|----------|------|
| **Models** | |
| Thread | `app/Models/Thread.php` |
| Message | `app/Models/Message.php` |
| ReadMessage | `app/Models/ReadMessage.php` |
| ThreadUser | `app/Models/ThreadUser.php` |
| **Controllers** | |
| Threads | `app/Http/Controllers/Threads/ThreadsController.php` |
| Messages | `app/Http/Controllers/Threads/MessagesController.php` |
| **Services** | |
| ThreadService | `app/Services/Threads/ThreadService.php` |
| **Repositories** | |
| ThreadsRepository | `app/Repositories/Threads/ThreadsRepository.php` |
| MessagesRepository | `app/Repositories/Threads/MessagesRepository.php` |
| **Requests** | |
| ThreadRequest | `app/Http/Requests/ThreadRequest.php` |
| MessageRequest | `app/Http/Requests/MessageRequest.php` |
| **Notifications** | |
| NewMessage | `app/Notifications/NewMessageNotification.php` |
| **Views** | |
| Index | `resources/views/pages/messages/index.blade.php` |
| **Vue Components** | |
| Main | `resources/js/pages/threads/threads.js` |
| ListThreads | `resources/js/pages/threads/components/ListThreads.vue` |
| DisplayMessageContent | `resources/js/pages/threads/components/DisplayMessageContent.vue` |
| FormMessageReply | `resources/js/pages/threads/components/FormMessageReply.vue` |
| HeaderMessage | `resources/js/pages/threads/components/HeaderMessage.vue` |
| **Migrations** | |
| threads | `database/migrations/2020_01_06_000047_create_threads_table.php` |
| messages | `database/migrations/2020_01_06_000048_create_messages_table.php` |
| thread_users | `database/migrations/2020_02_12_151028_create_thread_users_table.php` |
| read_messages | `database/migrations/2020_02_12_151029_create_read_messages_table.php` |
