
## Project Overview
**RealTimeChat** is a real-time chat application built with **Laravel 12**, featuring conversations, media attachments, read status tracking, and last activity monitoring. The architecture uses clean service-layer patterns with Blade templating and JavaScript for frontend interactivity.

**Tech Stack:** Laravel 12, Blade, Bootstrap 5, jQuery/JS, Laravel Reverb (WebSocket-ready), MySQL

---

## Architecture & Core Patterns

### Service-Based Architecture
Business logic is delegated to service classes that handle complex operations:
- **ConversationService** - Manages conversation creation, retrieval, participant tracking, and message formatting
- **ChatService** - Handles message sending with media attachment support and transaction safety
- **LoginService, RegisterService, ProfileService, LogoutService** - User lifecycle management

**Pattern:** Controllers inject services via constructor; services return `['success' => bool, 'message' => string, 'data' => mixed]` arrays consistently.

### Data Flow - Critical Concept

#### 1. **Conversation Creation Flow**
- User sends email → ConversationService finds receiver → Creates conversation if not exists → Adds two ConversationParticipant records → Creates initial message
- **Key:** `findOrCreateConversation()` uses double `whereHas()` to ensure exactly 2 participants exist

#### 2. **Message Reading & Unread Tracking** (Complex)
- **message_reads** table stores individual read events for each message per user
- **conversation_participants.last_read_message_id** stores fastest unread count reference
- When viewing conversation: all unread messages from other sender marked as read, `ConversationParticipant.last_read_message_id` updated
- Unread count calculated as: `messages where id > last_read_message_id AND sender_id != current_user`
- **Why two tables?** Last_read_message_id enables O(1) unread count; message_reads provides detailed audit trail

#### 3. **Message Types & Media Handling**
- MessageType Enum (TEXT=1, MEDIA=2, TEXT_MEDIA=3) determines message rendering
- Media uploaded to `storage/public/uploads/messages/` via `store('uploads/messages', 'public')`
- **Polymorphic:** Media uses MorphMany - can attach to Messages or User profiles
- ConversationService.formatSingleMessage() adds computed `media_category` (image/video/application) from MIME type

---

## Key Code Patterns & Conventions

### Service Method Returns
```php
return [
    'success' => true,
    'message' => 'User-facing message',
    'data' => $model->load(['relations']),  // Load relations for efficiency
    'conversation_id' => $id,  // Context-specific data
];
```
All service methods follow this pattern for consistent error handling in controllers.

### Authorization Pattern
- ConversationService.getAuthorizedConversation() validates user is conversation participant
- Uses `whereHas('participants', fn ($q) => $q->where('user_id', $currentUserId))`
- Prevents SQL injection and unauthorized access simultaneously

### Message Formatting
- ConversationService.formatSingleMessage() is the single source for message DTO generation
- Adds computed fields: `is_me`, `is_read`, `read_at`, `media` array
- Used by both initial load and infinite scroll pagination

### Transactions for Consistency
- ChatService.store() and ConversationService.store() wrap database changes in DB::beginTransaction()
- On failure: rollback + delete uploaded files + log error
- **Why:** Prevents orphaned media files and database inconsistency

### Helpers Pattern
- Global `notifyMessage($message, $type, $position, $rtl)` uses php-flasher for toast notifications
- Registered in `composer.json` autoload-dev for availability across views

---

## Critical Workflows

### Development Server (from composer.json)
```bash
# Full dev environment with concurrent processes
composer dev

# Runs: Laravel server + queue listener + Vite dev server
# Named: "server", "queue", "vite" in output
```

### Testing
```bash
composer test
# Clears config cache then runs Pest
```

### Setup New Machine
```bash
composer setup
# Handles: composer install → copy .env → key:generate → migrate → npm install → build
```

### Production Build
```bash
npm run build  # Vite production bundle
php artisan migrate --force
```

---

## Database Design (Essential for Queries)

### Key Relations
- **User** ↔ **Conversation** (BelongsToMany via conversation_participants)
- **Conversation** → **Message** (HasMany, ordered by id DESC)
- **Message** → **Media** (MorphMany)
- **Message** → **MessageRead** (HasMany - audit trail)
- **ConversationParticipant** stores `last_read_message_id` for unread count optimization

### Query Optimization Notes
- ConversationService.showConversation() loads: `with(['participants.user.media', 'messages.reads.media'])`
- Always use `orderByDesc('id')` for messages, then reverse in collection for chronological view
- Limit 20 messages per infinite scroll batch

---

## Frontend Integration Points

### Blade Templates
- Controllers pass view data to `view('index', ['conversation' => [...]])`
- Partials rendered dynamically: `view('partials.message', ['message' => $message])->render()`
- Bootstrap 5 grid system for responsive layout

### AJAX for Infinite Scroll
- **Endpoint:** GET `/conversations/{conversationId}/messages?last_message_id={id}`
- Returns JSON: `{ 'html': '...rendered partials...', 'count': int }`
- Frontend renders returned HTML instead of full JSON reloading

### Laravel Reverb Integration (Prepared)
- MessageSent event broadcasts to `PrivateChannel('conversation.' . $conversationId)`
- Event name: `message.sent`
- Config in `config/reverb.php` and `config/broadcasting.php`
- Not currently wired to frontend but infrastructure ready for real-time updates

---

## Important File References

| Path | Purpose |
|------|---------|
| `app/Services/` | Business logic - **start here for features** |
| `app/Models/` | Eloquent relations and casts - check for query patterns |
| `app/Http/Requests/` | Form validation rules |
| `app/Enums/MessageType.php` | Message type constants + label generation |
| `routes/web.php` | Middleware stack: `['auth', 'last_activity']` tracks online status |
| `composer.json` scripts | Custom commands (dev, test, setup) |

---

## Common Tasks for AI Agents

### Adding a New Feature
1. Define validation in `app/Http/Requests/StoreFeatureRequest.php`
2. Implement business logic in appropriate Service class
3. Create/update controller to inject service
4. Add route to `routes/web.php` with proper middleware
5. Blade template uses service result data

### Modifying Message Flow
- Update MessageType enum if adding new type
- Edit ConversationService.formatSingleMessage() for DTO changes
- Remember: must update both database insertion AND formatting logic

### Debugging Unread Counts
- Check `conversation_participants.last_read_message_id` alignment
- Verify message_reads table has entries for user
- Compare: actual unread count vs `WHERE id > last_read_message_id`

### Adding Middleware/Authorization
- Register in routes group: `middleware(['auth', 'last_activity'])`
- UpdateLastActivity middleware updates `users.last_activity_at` on every request
- Use `whereHas('participants')` for conversation-level authorization

---

## Dependencies Worth Knowing

- **laravel/reverb** - WebSocket server (configured, not fully integrated)
- **php-flasher/flasher-laravel** - Toast notifications via helper
- **pestphp** - Testing framework (replaces PHPUnit)
- **vite** - Frontend build tool (Laravel Vite plugin configured)

---

## Notes for AI Consistency

- Always load relations eagerly to prevent N+1 queries
- Use `->values()` after manipulating collections to reset indices
- Services return consistent error structure - don't break this pattern
- Media file storage is atomic within transactions - don't bypass
- ConversationParticipant is many-to-many junction, not a pivot - use relations, not table()

