# ARKA HelpDesk

Lightweight ticket & knowledge-base system with Telegram Bot + AI auto-reply for all ARKA apps.

**Apps served:** MineOps · Sarang ERP · ArkFleet · VASIA POS · Pratasaba Resort

## How It Works

```
User → Telegram Bot → Submits Issue
                         ↓
              AI (GPT-4o Mini) scans KB
                         ↓
            ┌─ Match found? ──YES──→ AI replies instantly
            │
            NO
            │
            ↓
       Escalated → DM to Iwan → Iwan resolves via Dashboard or Telegram
```

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13 (PHP 8.3+) |
| Frontend | React 19 + Inertia.js 2.x + Ant Design 5.x |
| Database | MySQL 8.4 |
| Queue | Laravel Queue (Redis driver) |
| Telegram SDK | irazasyed/telegram-bot-sdk ^3.0 |
| AI | OpenRouter → `openai/gpt-4o-mini` |
| Search | MySQL FULLTEXT on `kb_articles` |
| Deployment | Docker Compose |

## Project Structure

```
ark-help-desk/
├── app/
│   ├── Console/Commands/     # Artisan commands (kb:ingest)
│   ├── Enums/                # TicketStatus, TicketPriority, UserRole
│   ├── Events/               # TicketCreated, TicketEscalated, TicketResolved
│   ├── Http/
│   │   ├── Controllers/      # Auth, Dashboard, Ticket, KB, Telegram
│   │   └── Middleware/       # Role, TelegramSecret
│   ├── Jobs/                 # ProcessTicketWithAI (queue job)
│   ├── Listeners/            # Telegram notification listeners
│   ├── Models/               # User, Ticket, TicketMessage, KBArticle, etc.
│   └── Services/             # OpenRouterService, TelegramBotService
├── config/                   # Laravel config
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Schema migrations
│   └── seeders/              # Database seeders
├── docker/
│   ├── nginx.conf            # Nginx config (Inertia SPA routing)
│   ├── php.ini               # PHP production settings
│   └── supervisord.conf      # Supervisor (php-fpm + nginx)
├── public/                   # Web root
├── resources/
│   └── js/                   # React + Inertia frontend
├── routes/
│   ├── api.php               # Telegram webhook endpoint
│   └── web.php               # Web dashboard routes
├── tests/                    # PHPUnit tests
├── Dockerfile                # Multi-stage Docker build
├── docker-compose.yml        # Docker Compose stack
└── .env.production           # Production env template
```

## Ticket Lifecycle

```
OPEN → AI_REPLIED → ESCALATED → IN_PROGRESS → RESOLVED → CLOSED
  │         │            │            │            │           │
  │     AI found      No match     Iwan is       Iwan      48h auto-
  │     KB match      or user      working     resolved     close or
  │                   rejects       on it                    manual
```

## Knowledge Base

- KB articles stored in `kb_articles` table with MySQL FULLTEXT index
- AI searches KB to auto-reply to tickets
- Articles can be imported via PDF ingest command
- Articles linked via `kb_article_links` for related content

---

## Setup Instructions

### Prerequisites

- PHP 8.3+
- Node.js 22+
- MySQL 8.4
- Redis 7
- Composer 2
- Telegram Bot Token (from [@BotFather](https://t.me/BotFather))
- OpenRouter API key (from [openrouter.ai](https://openrouter.ai))

### Local Development

```bash
# Clone the repo
git clone <repo-url> ark-help-desk
cd ark-help-desk

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env
# Edit .env with your DB, Telegram, and OpenRouter credentials

# Generate app key
php artisan key:generate

# Run migrations and seed
php artisan migrate --seed

# Start dev server (server + queue + vite)
composer run dev

# Or start individually:
php artisan serve              # → http://localhost:8000
php artisan queue:work          # → process AI jobs
npm run dev                     # → Vite HMR
```

### Run Tests

```bash
php artisan test
```

### Database Setup (Local MySQL)

The default `.env.example` uses SQLite. To switch to MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=arka_helpdesk
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Create the database:

```bash
mysql -u root -p -e "CREATE DATABASE arka_helpdesk CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

## Docker Deployment

### Quick Start

```bash
# Set secrets (use strong passwords!)
export DB_PASSWORD=your_db_password
export DB_ROOT_PASSWORD=your_root_password

# Build and start
docker compose up -d --build

# Run migrations
docker exec arka-helpdesk-app php artisan migrate --force

# Generate app key (first deploy only)
docker exec arka-helpdesk-app php artisan key:generate

# Clear config cache
docker exec arka-helpdesk-app php artisan config:clear
```

### Service Ports

| Service | Container Port | Host Port |
|---|---|---|
| ARKA HelpDesk (Nginx) | 80 | 3006 |
| MySQL | 3306 | 3309 |
| Redis | 6379 | (internal only) |

### Environment Variables

All variables are set via `.env` or `docker-compose.yml` environment section.

| Variable | Description | Required |
|---|---|---|
| `APP_NAME` | Application name | Yes |
| `APP_ENV` | Environment (`local`/`production`) | Yes |
| `APP_KEY` | Laravel encryption key (generated by `key:generate`) | Yes |
| `APP_URL` | Public URL of the application | Yes |
| `DB_CONNECTION` | Database driver (`mysql`) | Yes |
| `DB_HOST` | Database hostname | Yes |
| `DB_PORT` | Database port | Yes |
| `DB_DATABASE` | Database name | Yes |
| `DB_USERNAME` | Database user | Yes |
| `DB_PASSWORD` | Database password | Yes |
| `REDIS_HOST` | Redis hostname | Yes |
| `QUEUE_CONNECTION` | Queue driver (`redis` for production) | Yes |
| `TELEGRAM_BOT_TOKEN` | Telegram Bot API token from BotFather | Yes |
| `TELEGRAM_WEBHOOK_SECRET` | Secret token for webhook validation | Yes |
| `TELEGRAM_ADMIN_ID` | Telegram user ID of admin (Iwan) for DMs | Yes |
| `OPENROUTER_API_KEY` | OpenRouter API key | Yes |
| `OPENROUTER_MODEL` | Model name (default: `openai/gpt-4o-mini`) | No |
| `AI_ENABLED` | Enable AI auto-reply (`true`/`false`) | No |
| `AI_CONFIDENCE_THRESHOLD` | Minimum KB match score for AI reply (0-1) | No |

### Docker Volumes

| Volume | Purpose |
|---|---|
| `arka_storage` | Laravel storage (logs, uploads, cache) |
| `arka_mysql_data` | MySQL persistent data |

### Multi-Stage Docker Build

The `Dockerfile` uses three stages:

1. **node-build** (node:22-alpine) — Installs npm dependencies and runs `vite build`
2. **php-deps** (php:8.4-fpm-alpine) — Installs PHP extensions, Composer deps, copies app code + frontend build
3. **final** (php:8.4-fpm-alpine) — Minimal runtime image with nginx + supervisor

This keeps the final image small and cache-friendly.

---

## VPS Deployment (IDCloudHost)

### Host Details

| Property | Value |
|---|---|
| IP | 103.55.38.96 |
| User | hermesadmin |
| Port | 82 → 3006 (container) |

### Deployment Steps

```bash
# 1. Push code to Git
cd ~/ark-help-desk
git add -A && git commit -m "feat: deploy" && git push

# 2. Build image locally (optional, if VPS is slow)
docker compose build --no-cache
docker save arka-helpdesk-app:latest | gzip > /tmp/arka-image.tar.gz

# 3. Transfer to VPS
scp /tmp/arka-image.tar.gz hermesadmin@103.55.38.96:/tmp/
scp docker-compose.yml hermesadmin@103.55.38.96:/home/hermesadmin/arka-helpdesk/

# 4. Load + start on VPS
ssh hermesadmin@103.55.38.96 '
  zcat /tmp/arka-image.tar.gz | docker load
  cd /home/hermesadmin/arka-helpdesk
  docker compose up -d
'

# 5. Initialize app
ssh hermesadmin@103.55.38.96 '
  docker exec arka-helpdesk-app php artisan key:generate
  docker exec arka-helpdesk-app php artisan migrate --force
  docker exec arka-helpdesk-app php artisan config:clear
'

# 6. Create admin user
ssh hermesadmin@103.55.38.96 '
  docker exec arka-helpdesk-app php artisan helpdesk:create-admin \
    --name="Iwan" --email="iwan@example.com" --password="<secure-password>"
'

# 7. Set webhook
ssh hermesadmin@103.55.38.96 '
  curl -X POST "https://api.telegram.org/bot<TOKEN>/setWebhook" \
    -d "url=https://100.77.117.2:3006/api/telegram/webhook" \
    -d "secret_token=<WEBHOOK_SECRET>"
'
```

### Host Nginx Proxy

Add to host nginx config to route port 82 → Docker container:

```nginx
server {
    listen 82;
    server_name _;

    location / {
        proxy_pass http://127.0.0.1:3006;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### Port Allocation (All ARKA Apps)

| App | Host Port | Container |
|---|---|---|
| MineOps | 80 → 3005 | mineops-app |
| ArkFleet | 81 → 3002 | arkfleet-app |
| Hotel ERP | 3004 | hotel-app |
| **ARKA HelpDesk** | **82 → 3006** | **arka-helpdesk-app** |

---

## Telegram Bot Setup

### 1. Create Bot

Message [@BotFather](https://t.me/BotFather) on Telegram:

```
/newbot
ARKA HelpDesk
@arka_helpdesk_bot
```

Save the token you receive.

### 2. Set Commands

Send to BotFather:

```
/setcommands

start - Welcome message and app selection
ticket - Submit a new issue
status - Check ticket status
apps - List available apps
help - Show help menu
```

### 3. Configure Webhook

Set `.env` values:

```env
TELEGRAM_BOT_TOKEN=your_bot_token
TELEGRAM_WEBHOOK_SECRET=your_secret_token
TELEGRAM_ADMIN_ID=your_telegram_user_id
```

Set the webhook URL (replace placeholders):

```bash
curl -X POST "https://api.telegram.org/bot<TOKEN>/setWebhook" \
  -d "url=https://your-domain.com/api/telegram/webhook" \
  -d "secret_token=<WEBHOOK_SECRET>"
```

### 4. Verify

Send `/start` to your bot on Telegram. You should receive a welcome message with app selection.

### Conversation Flow

```
/start      → Welcome + app selection buttons
/start MineOps → "What's the issue with MineOps?"
Describe issue → AI searches KB and replies
"not helpful"  → Ticket escalated to admin (DM)
Admin replies  → Forwarded to user
/resolve       → Ticket resolved, user notified
```

---

## Artisan Commands

### `kb:ingest` — PDF Knowledge Base Import

Import a PDF document, splitting it into KB articles by detected headings.

```bash
# Import PDF for a specific app
php artisan kb:ingest docs/mineops-manual.pdf --app=MineOps

# Import without app association
php artisan kb:ingest docs/general-guide.pdf

# Import by app ID
php artisan kb:ingest docs/manual.pdf --app=1
```

**How it works:**

1. Parses PDF using `smalot/pdfparser`
2. Detects headings: ALL CAPS lines, Markdown `##` headers, colon-ending titles, numbered sections
3. Groups content under each heading as separate KB articles
4. Creates `kb_articles` rows with `source_manual = true`, `is_published = true`
5. If no headings detected, splits by paragraph chunks (~10 articles)

### `helpdesk:create-admin`

Create an admin user for dashboard access.

```bash
php artisan helpdesk:create-admin --name="Iwan" --email="iwan@example.com" --password="secure123"
```

---

## Queue & AI Pipeline

### Queue Worker

In production, the queue worker runs inside the Docker container via supervisor. For local dev:

```bash
php artisan queue:work --tries=3 --backoff=30
```

### AI Auto-Reply Flow

1. User submits ticket via Telegram bot
2. `TicketCreated` event fires
3. `ProcessTicketWithAI` job is dispatched
4. Job runs MySQL FULLTEXT search on `kb_articles`
5. If confidence ≥ threshold → calls OpenRouter GPT-4o Mini
6. AI reply saved as `ticket_message` (sender_type=ai)
7. Reply sent via Telegram Bot API
8. Ticket status → `ai_replied`
9. If no KB match → status → `escalated` → DM to admin

### Job Retry

- Max 3 retries with exponential backoff (30s, 60s, 120s)
- On total failure → ticket auto-escalates with note "AI unavailable"

---

## Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=TicketCreationTest

# Run with coverage (requires Xdebug)
php artisan test --coverage
```

Current test suite covers: auth, ticket CRUD, KB article CRUD, dashboard, AI service.

---

## Useful Docker Commands

```bash
# View logs
docker compose logs -f arka-helpdesk-app

# Shell into container
docker exec -it arka-helpdesk-app sh

# Restart services
docker compose restart

# Rebuild after code changes
docker compose up -d --build

# Stop everything
docker compose down

# Stop + remove volumes (reset DB)
docker compose down -v
```

---

## Troubleshooting

### "Vite manifest not found"
Run `npm run build` to regenerate the frontend build manifest.

### "SQLSTATE[HY000] Connection refused"
Ensure MySQL container is healthy: `docker compose ps`. Check `DB_HOST` matches service name.

### Telegram webhook not receiving
- Verify webhook URL is publicly accessible
- Check `TELEGRAM_WEBHOOK_SECRET` matches header validation
- Check Laravel logs: `docker exec arka-helpdesk-app cat storage/logs/laravel.log`

### Queue jobs not processing
- Ensure `QUEUE_CONNECTION=redis` in production
- Check supervisor is running: `docker exec arka-helpdesk-app supervisorctl status`
- Check failed jobs: `docker exec arka-helpdesk-app php artisan queue:failed`

---

## License

MIT
