# ARKA HelpDesk — Detailed Implementation Plan

**Date:** 2026-08-05  
**Author:** Dea + Iwan  
**Status:** Planning

---

## 1. Overview & Goals

ARKA HelpDesk is a lightweight ticket and knowledge-base (KB) system serving all of Iwan's apps: **MineOps**, **Sarang ERP**, **ArkFleet**, **VASIA POS**, and **Pratasaba Resort**. Users submit issues via a **Telegram Bot**, an AI auto-reply engine searches the KB and attempts to resolve the ticket immediately. Unresolved tickets are escalated via **DM to Iwan**, who can then reply from a web dashboard or directly in Telegram.

### Core Principles

- **Lightweight** — no bloated CRM; just tickets + KB + Telegram bridge.
- **AI-first** — GPT-4o Mini acts as tier-1 support; Iwan only sees what the AI couldn't solve.
- **Safe** — users interact only through the bot; the dashboard is gated behind auth + roles. No arbitrary command execution or direct DB write from the bot layer.
- **Single VPS deploy** — same IDCloudHost VPS (103.55.38.96) as Iwan's other apps, Dockerized.

---

## 2. Tech Stack

| Layer | Choice | Rationale |
|---|---|---|
| **Backend** | Laravel 13 (PHP 8.3+) | Consistent with Iwan's existing stack; built-in queue, notifications, Sanctum. |
| **Frontend** | React 19 + Inertia.js 2.x | SPA-like UX without a separate API; server-driven routing. |
| **UI Kit** | Ant Design 5.x | Rich component library; table, form, modal, notification primitives. |
| **Database** | MySQL 8.4 (Docker) | Same as ArkFleet / MineOps; no new infra. |
| **Queue** | Laravel Queue (Redis driver) | Async Telegram message processing + AI calls. |
| **Telegram** | irazasyed/telegram-bot-sdk ^4.x | Long-polling or webhook; mature, well-maintained. |
| **AI** | OpenRouter → `openai/gpt-4o-mini` | Cheap ($0.15/$0.60 per 1M in/out), fast, sufficient for KB retrieval + reply generation. |
| **Search** | MySQL FULLTEXT on KB articles table + Laravel Scout (optional) | Simple first; migrate to Meilisearch if KB grows >5k articles. |
| **Deployment** | Docker Compose (single VPS) | Same pattern as MineOps, ArkFleet, Hotel ERP. |
| **Reverse Proxy** | Host Nginx → port mapping | 80→MineOps, 81→ArkFleet, 82→ARKA HelpDesk. |

---

## 3. Entity Relationship Diagram (ERD)

```
┌─────────────────┐       ┌──────────────────┐       ┌─────────────────────┐
│     users       │       │     tickets      │       │   ticket_messages   │
├─────────────────┤       ├──────────────────┤       ├─────────────────────┤
│ id (PK)         │──┐    │ id (PK)          │──┐    │ id (PK)             │
│ name            │  │    │ user_id (FK)     │◄─┘    │ ticket_id (FK)      │
│ telegram_id     │  │    │ assigned_to (FK) │──┐    │ sender_type (ENUM)  │
│ username        │  │    │ app_id (FK)      │  │    │ sender_id (polymorph)│
│ email           │  │    │ subject          │  │    │ message (text)      │
│ password        │  │    │ status (ENUM)    │  │    │ is_ai_generated     │
│ role (ENUM)     │  │    │ priority (ENUM)  │  │    │ kb_article_id (FK?) │
│ is_active       │  │    │ kb_match_id (FK?)│  │    │ created_at          │
│ telegram_username│ │    │ source (ENUM)    │  │    └─────────────────────┘
│ created_at      │  │    │ metadata (JSON)  │  │
└─────────────────┘  │    │ resolved_at      │  │
       │             │    │ created_at       │  │       ┌─────────────────────┐
       │             │    │ updated_at       │  │       │   kb_articles        │
       │  ┌──────────┘    └──────────────────┘  │       ├─────────────────────┤
       │  │                                      │       │ id (PK)             │
       │  │  ┌──────────────────┐               │       │ app_id (FK?)        │
       │  │  │      apps        │               │       │ title               │
       │  │  ├──────────────────┤               │       │ content (TEXT)      │
       │  └─►│ id (PK)          │◄──────────────┘       │ tags (JSON)         │
       │     │ name             │               │       │ source_manual       │
       │     │ description      │               │       │ is_published        │
       │     │ telegram_chat_id │               │       │ view_count          │
       │     │ is_active        │               │       │ helpful_count       │
       │     └──────────────────┘               │       │ created_at          │
       │                                        │       │ updated_at          │
       │     ┌──────────────────┐               │       └─────────────────────┘
       │     │  ai_conversations│               │               │
       │     ├──────────────────┤               │               │
       │     │ id (PK)          │               │       ┌───────┴─────────────┐
       │     │ ticket_id (FK)   │               │       │  kb_article_links   │
       │     │ prompt (JSON)    │               │       ├─────────────────────┤
       │     │ response (TEXT)  │               │       │ id (PK)             │
       │     │ tokens_used      │               │       │ article_id (FK)     │
       │     │ model            │               │       │ related_article(FK) │
       │     │ cost             │               │       │ link_type (ENUM)    │
       │     │ created_at       │               │       └─────────────────────┘
       │     └──────────────────┘
       │
       │     ┌──────────────────┐
       └────►│ telegram_sessions│
             ├──────────────────┤
             │ id (PK)          │
             │ user_id (FK)     │
             │ chat_id          │
             │ state (JSON)     │
             │ last_activity_at │
             └──────────────────┘
```

### Key Enums

**ticket.status:** `open`, `ai_replied`, `escalated`, `in_progress`, `resolved`, `closed`  
**ticket.priority:** `low`, `medium`, `high`, `critical`  
**ticket.source:** `telegram`, `web`  
**ticket_messages.sender_type:** `user`, `ai`, `admin`  
**users.role:** `super_admin`, `admin` (Iwan), `user` (end users)  
**kb_article_links.link_type:** `related`, `prerequisite`, `see_also`

### Database Name: `arka_helpdesk`

---

## 4. Ticket Lifecycle

```
  ┌─────────┐
  │  OPEN   │ ◄── User sends /ticket or taps "Report Issue" in Telegram
  └────┬────┘
       │  AI scans KB for matching articles
       ▼
  ┌─────────────┐
  │ AI_REPLIED  │ ◄── AI found a match → sends answer directly
  └──────┬──────┘       (user can reply "not helpful" to escalate)
         │
         │ if no match OR user says "not helpful"
         ▼
  ┌──────────────┐
  │  ESCALATED   │ ◄── DM sent to Iwan via Telegram
  └──────┬───────┘       Dashboard badge increments
         │
         │ Iwan picks it up (web or Telegram reply)
         ▼
  ┌──────────────┐
  │ IN_PROGRESS  │ ◄── Iwan investigating; can chat with user through bot
  └──────┬───────┘
         │
         │ Iwan resolves
         ▼
  ┌──────────────┐
  │  RESOLVED    │ ◄── User notified; can re-open within 48h
  └──────┬───────┘
         │
         │ 48h elapsed or Iwan marks done
         ▼
  ┌──────────────┐
  │   CLOSED     │ ◄── Archived; KB article optionally auto-generated
  └──────────────┘
```

### State Transitions Enforced

| From | Allowed To |
|---|---|
| `open` | `ai_replied`, `escalated`, `closed` |
| `ai_replied` | `escalated`, `closed` |
| `escalated` | `in_progress`, `closed` |
| `in_progress` | `resolved`, `closed` |
| `resolved` | `open` (re-open), `closed` |

---

## 5. Knowledge Base Integration

### Data Model

KB articles live in the `kb_articles` table. Each article belongs to an **app** (MineOps, Sarang ERP, etc.) via `app_id`. Articles have a **FULLTEXT index** on `title` + `content` for fast keyword search.

### Initial KB Seeding

Iwan's existing manuals are currently scattered (PDFs, docs, existing app READMEs). The plan:

1. **Phase 1 — Manual seed:** Iwan (or Dea) creates 10–20 core articles per app covering the most common issues.
2. **Phase 2 — PDF ingest:** A Laravel command (`php artisan kb:ingest --app=mineops mineops-manual.pdf`) uses `smalot/pdfparser` to extract text and split into articles.
3. **Phase 3 — Ticket → Article:** When a ticket is resolved and Iwan marks it as "worth saving," an "Auto-generate KB" button creates a draft article from the conversation. Iwan reviews + publishes.

### Search Flow

```
User: "How do I reset my MineOps password?"
       │
       ▼
MySQL FULLTEXT: MATCH(title, content) AGAINST('reset MineOps password' IN BOOLEAN MODE)
       │
       ▼
  Score ≥ threshold? ──YES──► Return top 3 matches → GPT-4o Mini formats a friendly reply
       │
       NO
       │
       ▼
  Escalate to Iwan
```

### Search Query (Laravel)

```php
$results = KBArticle::where('app_id', $ticket->app_id)
    ->where('is_published', true)
    ->whereRaw(
        "MATCH(title, content) AGAINST(? IN BOOLEAN MODE)",
        [$searchQuery]
    )
    ->orderByRaw('MATCH(title, content) AGAINST(?) DESC', [$searchQuery])
    ->limit(3)
    ->get();
```

### AI Reply Prompt Template

```
You are ARKA HelpDesk, the support bot for {app_name}.
Use the knowledge base articles below to answer the user's question.
If the articles don't cover the question, say so honestly.

KB Articles:
{article_1_title}: {article_1_content}
{article_2_title}: {article_2_content}

User question: {user_message}

Reply in a friendly, helpful tone. Keep it under 300 words. 
Start with "Hi {user_name}! 👋" and end with "If this doesn't solve it, reply 'not helpful' and I'll escalate to the team."
```

---

## 6. Telegram Bot Flow

### Bot Setup

1. Create bot via [@BotFather](https://t.me/BotFather) → get `TELEGRAM_BOT_TOKEN`
2. Set commands in BotFather:

```
start - Welcome message and app selection
ticket - Submit a new issue
status - Check ticket status
apps - List available apps
help - Show help menu
```

3. Webhook URL: `https://<vps-ip>:82/api/telegram/webhook` (or via Tailscale Funnel for dev)

### Conversation Flow (Text Diagram)

```
User: /start
Bot:  "Welcome to ARKA HelpDesk! 👋
       Which app do you need help with?"
       [ MineOps ] [ Sarang ERP ] [ ArkFleet ] [ VASIA POS ] [ Pratasaba Resort ]

User: taps "MineOps"
Bot:  "Got it! What's the issue you're facing with MineOps?"

User: "I can't log in. It says invalid credentials."
Bot:  "⏳ Let me check our knowledge base..."

       ┌─── AI lookup ───┐
       │ KB match found! │
       └─────────────────┘

Bot:  "Hi John! 👋
       This usually happens when your password has expired. Here's how to reset it:
       1. Go to the MineOps login page
       2. Click 'Forgot Password'
       3. Enter your email and follow the reset link
       
       If this doesn't solve it, reply 'not helpful' and I'll escalate to the team."

       ─── OR, if no match ───

Bot:  "I couldn't find an answer in our knowledge base. I've escalated this to the team.
       Iwan will get back to you soon! Your ticket number is #TK-0042."
       [ Check Status ]

       ═══ Backend: DM to Iwan ═══
       Iwan's Telegram:
       "🔔 New ticket #TK-0042 from John (MineOps):
       'I can't log in. It says invalid credentials.'
       Reply to this message to respond, or open dashboard."
       
Iwan: replies "Hi John, can you send a screenshot of the error?"
       → forwarded to user's chat

User: replies with screenshot
       → forwarded to Iwan's DM

Iwan: /resolve #TK-0042 "Password reset sent to your email."
       → ticket resolved, user notified
```

### Session State Machine

A `telegram_sessions` row tracks each user's current state:

```
States:  idle → selecting_app → describing_issue → waiting_ai → 
         ai_responded → escalated → in_conversation → resolved
```

### Bot Middleware / Security

- **Rate limiting:** 5 tickets per user per hour.
- **Input sanitization:** All user text is stripped of HTML/JS before storage.
- **No command injection:** The bot uses only predefined commands (`/start`, `/ticket`, `/status`, `/apps`, `/help`). No `eval()`, no `shell_exec()`, no raw SQL from bot input. All queries go through Eloquent.
- **Telegram webhook secret:** Validate `X-Telegram-Bot-Api-Secret-Token` header on webhook endpoint.
- **App selection is validated:** User can only select from `apps` table; app_id is validated server-side.

---

## 7. OpenRouter / AI Auto-Reply Configuration

### Model

- **Model:** `openai/gpt-4o-mini` (via OpenRouter)
- **Pricing:** $0.15/1M input tokens, $0.60/1M output tokens
- **Context window:** 128K tokens (far more than needed)
- **Estimated monthly cost:** ~$2–5 for expected ticket volume (50–200 tickets/month)

### OpenRouter Setup

```env
# .env
OPENROUTER_API_KEY=sk-or-v1-xxxxx
OPENROUTER_MODEL=openai/gpt-4o-mini
OPENROUTER_MAX_TOKENS=1024
OPENROUTER_TEMPERATURE=0.7
AI_ENABLED=true
AI_CONFIDENCE_THRESHOLD=0.6   # minimum FULLTEXT score to attempt AI reply
```

### Laravel Integration

Create a service class `App\Services\OpenRouterService`:

```php
class OpenRouterService
{
    public function askKB(Ticket $ticket, array $kbArticles): string
    {
        $response = Http::withToken(config('services.openrouter.key'))
            ->post('https://openrouter.ai/api/v1/chat/completions', [
                'model' => 'openai/gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $this->buildSystemPrompt($ticket->app)],
                    ['role' => 'user', 'content' => $this->buildUserPrompt($ticket, $kbArticles)],
                ],
                'max_tokens' => 1024,
                'temperature' => 0.7,
            ]);

        $cost = $response['usage']['total_tokens'] * 0.00000015; // approx
        // Save to ai_conversations with cost

        return $response['choices'][0]['message']['content'];
    }
}
```

### Queue Job

`App\Jobs\ProcessTicketWithAI` — dispatched when a ticket is created:

1. Runs FULLTEXT search against `kb_articles`.
2. If confidence ≥ threshold, calls OpenRouter with top 3 articles.
3. Saves AI reply as `ticket_message` (sender_type=ai).
4. Sends reply via Telegram Bot API.
5. Sets ticket status to `ai_replied`.
6. If confidence < threshold, sets status to `escalated`, fires `TicketEscalated` event.

### Fallback Behavior

- If OpenRouter API is down (5xx), job is retried 3x with exponential backoff (Laravel queue `tries=3`, `backoff=[30, 60, 120]`).
- If all retries fail, ticket auto-escalates to Iwan with a note: "AI unavailable, manual review needed."

---

## 8. Deployment to IDCloudHost

### VPS Details (from existing setup)

| Host | User | IP | OS |
|---|---|---|---|
| IDCloudHost VPS | `hermesadmin` | `103.55.38.96` | Ubuntu 24.04 |

### Existing Port Allocation

| App | Host Port | Container |
|---|---|---|
| MineOps | 80 (or 3005) | mineops-app |
| ArkFleet | 81 (or 3002) | arkfleet-app |
| Hotel ERP | 3004 | hotel-app |
| **ARKA HelpDesk** | **82** (or **3006**) | **arka-helpdesk-app** |

Nginx host proxy routes: 80→3005, 81→3002, **82→3006**.

### Directory Structure on VPS

```
/home/hermesadmin/arka-helpdesk/
├── Dockerfile
├── docker-compose.yml
├── docker/
│   ├── nginx.conf
│   ├── supervisord.conf
│   └── php.ini
├── .env
└── (application code — cloned from Git repo)
```

### Docker Compose

```yaml
services:
  arka-helpdesk-app:
    build: .
    restart: unless-stopped
    ports:
      - "3006:80"
    depends_on:
      arka-helpdesk-mysql:
        condition: service_healthy
    networks:
      - arka-network
    volumes:
      - arka_storage:/var/www/storage
    environment:
      - APP_ENV=production
      - DB_CONNECTION=mysql
      - DB_HOST=arka-helpdesk-mysql
      - DB_DATABASE=arka_helpdesk
      - DB_USERNAME=arka_user
      - DB_PASSWORD=${DB_PASSWORD}
      - REDIS_HOST=arka-redis

  arka-helpdesk-mysql:
    image: mysql:8.4
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASSWORD}
      MYSQL_DATABASE: arka_helpdesk
      MYSQL_USER: arka_user
      MYSQL_PASSWORD: ${DB_PASSWORD}
    volumes:
      - arka_mysql_data:/var/lib/mysql
    ports:
      - "3309:3306"  # remote access if needed
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      interval: 10s
      timeout: 5s
      retries: 5
    networks:
      - arka-network

  arka-redis:
    image: redis:7-alpine
    restart: unless-stopped
    networks:
      - arka-network

volumes:
  arka_storage:
  arka_mysql_data:
networks:
  arka-network:
    driver: bridge
```

### Deploy Steps (following existing pattern)

```bash
# 1. Push code to Git repo
cd ~/arka-helpdesk && git add -A && git commit -m "feat: initial ARKA HelpDesk" && git push

# 2. Build locally (fast machine) — optional if VPS is slow
docker compose build --no-cache
docker save arka-helpdesk-app:latest | gzip > /tmp/arka-image.tar.gz

# 3. Transfer to VPS
scp /tmp/arka-image.tar.gz hermesadmin@103.55.38.96:/tmp/

# 4. Load image + start on VPS
ssh hermesadmin@103.55.38.96 '
  zcat /tmp/arka-image.tar.gz | docker load
  cd /home/hermesadmin/arka-helpdesk
  docker compose up -d
'

# 5. Generate APP_KEY + migrate
ssh hermesadmin@103.55.38.96 '
  docker exec arka-helpdesk-app php artisan key:generate
  docker exec arka-helpdesk-app php artisan migrate --force
  docker exec arka-helpdesk-app php artisan config:clear
'

# 6. Create admin user (Iwan)
ssh hermesadmin@103.55.38.96 '
  docker exec arka-helpdesk-app php artisan helpdesk:create-admin \\
    --name="Iwan" --email="iwan@example.com" --password="<secure-password>"
'

# 7. Add Nginx host proxy for port 82 → 3006
ssh hermesadmin@103.55.38.96 '
  # add server block for port 82 → proxy_pass http://127.0.0.1:3006
  sudo nginx -t && sudo systemctl reload nginx
'

# 8. Set Telegram webhook
curl -X POST "https://api.telegram.org/bot<TELEGRAM_BOT_TOKEN>/setWebhook" \
  -d "url=https://<vps-domain-or-ip>:82/api/telegram/webhook" \
  -d "secret_token=<WEBHOOK_SECRET>"
```

---

## 9. User Roles & Security

### Roles

| Role | Permissions |
|---|---|
| **super_admin** | Full access: manage users, all tickets, KB CRUD, system settings, AI config. *Reserved for Dea / system.* |
| **admin** (Iwan) | View/manage all tickets, reply, resolve, KB CRUD, view dashboard, receive escalations. Cannot delete users or change system config. |
| **user** | Create tickets via Telegram or web, view own tickets, reply to own tickets. No dashboard access. |

### Authentication

- **Web Dashboard:** Laravel Sanctum (SPA auth via Inertia) or session-based auth. Admin only.
- **Telegram:** Stateless — user identity is tied to their Telegram ID (`users.telegram_id`). Users are auto-registered on first `/start`.
- **Bot ↔ Webhook:** Webhook secret token validated on every request.

### Hard Security Rules

1. **No arbitrary command execution.** The bot cannot execute shell commands, eval PHP, or run raw SQL. All DB access goes through Eloquent models with strict validation.
2. **No direct DB write from bot.** The bot layer calls service classes that enforce business logic (ticket state machine, rate limiting, input sanitization).
3. **CSRF protection** on all web routes (Laravel default).
4. **Rate limiting** on all API/webhook endpoints (`throttle:60,1` for webhooks, `throttle:5,60` for ticket creation).
5. **Content Security Policy** headers on the web dashboard.
6. **Input validation:** All user input (Telegram text, web forms) is validated through Laravel FormRequest classes.
7. **Telegram secret token** validated on every webhook call as a middleware.
8. **Environment isolation:** `.env` values are never exposed. API keys are stored in `.env` only, never committed to Git.
9. **No file uploads through Telegram bot** (Phase 1) — avoids file-based attack vectors. Can add with strict MIME validation in Phase 2.

### Middleware Stack (web.php)

```php
Route::middleware(['auth', 'role:admin,super_admin'])->group(function () {
    Route::get('/dashboard', DashboardController::class);
    Route::resource('tickets', TicketController::class);
    Route::resource('kb', KBArticleController::class);
    // etc.
});

Route::post('/api/telegram/webhook', [TelegramWebhookController::class, 'handle'])
    ->middleware(['telegram.secret', 'throttle:telegram']);
```

---

## 10. Dashboard & Views

### Pages

| Route | Component | Description |
|---|---|---|
| `/login` | `Auth/Login` | Admin login (no public registration) |
| `/dashboard` | `Dashboard/Index` | Stats: open, escalated, resolved today, avg response time, AI solve rate |
| `/tickets` | `Tickets/Index` | AntD Table: filterable by app, status, priority, date |
| `/tickets/:id` | `Tickets/Show` | Ticket thread (chat-like), reply form, status actions |
| `/kb` | `KB/Index` | Searchable article list, filter by app |
| `/kb/create` | `KB/Create` | Rich text editor for new articles |
| `/kb/:id/edit` | `KB/Edit` | Edit existing article |
| `/settings` | `Settings/Index` | AI config, Telegram bot status, OpenRouter usage/cost |

### Dashboard Stats (API)

```php
// DashboardController
return [
    'tickets_open'       => Ticket::where('status', 'open')->count(),
    'tickets_escalated'  => Ticket::where('status', 'escalated')->count(),
    'resolved_today'     => Ticket::whereDate('resolved_at', today())->count(),
    'avg_response_min'   => round(Ticket::whereNotNull('first_reply_at')
                                ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, first_reply_at)'))),
    'ai_solve_rate'      => round(Ticket::where('status', 'closed')
                                ->whereHas('messages', fn($q) => $q->where('is_ai_generated', true)
                                    ->whereDoesntHave(...)) // complex; simplified
                                ->count() / max(Ticket::count(), 1) * 100),
    'ai_cost_this_month' => AIConversation::whereMonth('created_at', now()->month)->sum('cost'),
];
```

---

## 11. Implementation Phases & Effort Estimate

### Phase 1: Core MVP (3–4 days)

| Task | Est. Hours | Description |
|---|---|---|
| Laravel project scaffold | 3 | `laravel new`, Inertia+React+AntD setup, DB migration base |
| User + Auth system | 4 | Sanctum SPA auth, roles, admin seed, login page |
| Tickets CRUD | 6 | Migration, model, controller, state machine, API routes, AntD table + detail view |
| KB CRUD | 4 | Migration, FULLTEXT index, CRUD, search endpoint |
| Dashboard | 3 | Stats API, AntD dashboard cards + charts |
| **Phase 1 subtotal** | **20h** | |

### Phase 2: Telegram Integration (2–3 days)

| Task | Est. Hours | Description |
|---|---|---|
| Bot setup + webhook | 4 | BotFather, webhook endpoint, secret validation, command routing |
| Ticket creation flow | 5 | Conversation state management, app selection, issue capture, DB write |
| Ticket reply flow | 4 | Admin reply via Telegram → user chat forwarding |
| Telegram notifications | 2 | Status changes → user notification, escalation → DM to Iwan |
| Rate limiting + security | 2 | Middleware, input validation, anti-abuse |
| **Phase 2 subtotal** | **17h** | |

### Phase 3: AI Auto-Reply (1–2 days)

| Task | Est. Hours | Description |
|---|---|---|
| OpenRouter integration | 3 | Service class, API client, config |
| AI queue job | 4 | ProcessTicketWithAI job, KB search → prompt → reply → save |
| AI escalation logic | 2 | Confidence threshold, fallback, retry |
| Cost tracking | 1 | Token usage, cost per conversation, monthly aggregate |
| **Phase 3 subtotal** | **10h** | |

### Phase 4: Deployment & Polish (1–2 days)

| Task | Est. Hours | Description |
|---|---|---|
| Docker setup | 3 | Dockerfile (multi-stage: Node build + PHP-FPM + Nginx), compose |
| VPS deploy | 2 | Transfer image, start containers, Nginx proxy, webhook |
| PDF ingest command | 3 | `kb:ingest` artisan command for existing manuals |
| Testing + bug fixes | 4 | End-to-end flow testing, edge cases |
| Documentation | 2 | README, inline docs |
| **Phase 4 subtotal** | **14h** | |

### Grand Total: ~61 hours (~8 working days for one developer)

### Optional Phase 5 (post-MVP, ~2–3 days)

- **Meilisearch** migration for advanced KB search
- **File uploads** through Telegram (screenshots)
- **Auto-generate KB from resolved tickets**
- **Multi-language KB** (Bahasa Indonesia + English)
- **Analytics:** ticket volume trends, peak hours, common issues heatmap
- **SLA tracking:** configurable response-time targets per app/priority

---

## 12. Git Repository

```
Repository: github.com/<org>/arka-helpdesk
Branch strategy: main (production) + feature/* branches
CI: GitHub Actions — lint, test (Pest), build Docker image
```

### Initial Directory Structure

```
arka-helpdesk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TicketController.php
│   │   │   ├── KBArticleController.php
│   │   │   ├── Auth/
│   │   │   └── Api/
│   │   │       └── TelegramWebhookController.php
│   │   └── Middleware/
│   │       ├── RoleMiddleware.php
│   │       └── TelegramSecretMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Ticket.php
│   │   ├── TicketMessage.php
│   │   ├── App.php           # "apps" table (MineOps, Sarang ERP, etc.)
│   │   ├── KBArticle.php
│   │   ├── AIConversation.php
│   │   └── TelegramSession.php
│   ├── Services/
│   │   ├── OpenRouterService.php
│   │   ├── TelegramBotService.php
│   │   └── TicketService.php
│   ├── Jobs/
│   │   └── ProcessTicketWithAI.php
│   └── Enums/
│       ├── TicketStatus.php
│       ├── TicketPriority.php
│       └── UserRole.php
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_apps_table.php
│       ├── create_tickets_table.php
│       ├── create_ticket_messages_table.php
│       ├── create_kb_articles_table.php
│       ├── create_ai_conversations_table.php
│       ├── create_telegram_sessions_table.php
│       └── create_kb_article_links_table.php
├── resources/js/
│   ├── Pages/
│   │   ├── Auth/Login.jsx
│   │   ├── Dashboard/Index.jsx
│   │   ├── Tickets/Index.jsx
│   │   ├── Tickets/Show.jsx
│   │   ├── KB/Index.jsx
│   │   ├── KB/Create.jsx
│   │   ├── KB/Edit.jsx
│   │   └── Settings/Index.jsx
│   └── Layouts/
│       └── AuthenticatedLayout.jsx
├── docker/
│   ├── nginx.conf
│   ├── supervisord.conf
│   └── php.ini
├── Dockerfile
├── docker-compose.yml
└── .env.example
```

---

## 13. Key Configuration Checklist

- [ ] Telegram Bot Token from @BotFather
- [ ] OpenRouter API Key (https://openrouter.ai/keys)
- [ ] VPS port 82 opened (or Tailscale for dev)
- [ ] Webhook secret token generated (`php artisan helpdesk:generate-webhook-secret`)
- [ ] Admin user created
- [ ] Apps seeded (MineOps, Sarang ERP, ArkFleet, VASIA POS, Pratasaba Resort)
- [ ] Initial KB articles created (10–20 per app)
- [ ] Nginx host proxy configured (82→3006)
- [ ] Queue worker running (`php artisan queue:work --queue=telegram,ai,default`)
- [ ] Laravel scheduler for nightly cost reports (`php artisan schedule:run`)

---

## 14. Quick Reference: Telegram Commands for Users

| Command | Description |
|---|---|
| `/start` | Welcome + app selection |
| `/ticket` | Submit a new issue |
| `/status` | Check status of your open tickets |
| `/apps` | List available apps |
| `/help` | Show usage guide |

## Quick Reference: Telegram Commands for Admin (Iwan)

| Command | Description |
|---|---|
| `/resolve #TK-0042` | Resolve a ticket with optional message |
| `/reopen #TK-0042` | Re-open a closed ticket |
| `/assign #TK-0042` | Assign ticket to yourself |

---

## Appendix: Environment Variables (.env.example)

```env
APP_NAME=ARKA_HelpDesk
APP_ENV=production
APP_DEBUG=false
APP_URL=https://arka-helpdesk.example.com

DB_CONNECTION=mysql
DB_HOST=arka-helpdesk-mysql
DB_PORT=3306
DB_DATABASE=arka_helpdesk
DB_USERNAME=arka_user
DB_PASSWORD=

REDIS_HOST=arka-redis
REDIS_PASSWORD=null
REDIS_PORT=6379

TELEGRAM_BOT_TOKEN=
TELEGRAM_WEBHOOK_SECRET=

OPENROUTER_API_KEY=
OPENROUTER_MODEL=openai/gpt-4o-mini
OPENROUTER_MAX_TOKENS=1024
OPENROUTER_TEMPERATURE=0.7

AI_ENABLED=true
AI_CONFIDENCE_THRESHOLD=0.6
```
