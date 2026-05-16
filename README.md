# 💬 EchoChat

> A modern, real-time chat application built with Laravel 12 featuring instant messaging, read receipts, media attachments, and service-layer architecture.

---

## 🔗 Quick Links

| Section | Purpose |
|---------|---------|
| [Features](#features) | Core functionality overview |
| [Tech Stack](#tech-stack) | Technologies & dependencies |
| [Installation](#installation) | Get started in minutes |
| [Quick Start](#quick-start-guide) | First-time user workflow |
| [Architecture](#architecture) | System design & patterns |
| [API Endpoints](#api-endpoints) | Available routes & endpoints |
| [Testing](#testing) | Running tests |

---

## ✨ Features

### 💬 **Messaging**
- Text messages with instant delivery
- Media attachments (images, videos, documents)
- Mixed content (text + media in single message)
- Infinite scroll pagination (20 messages/batch)
- Search conversations by participant

### ✅ **Read Status & Activity**
- WhatsApp-style read receipts (✓ sent • ✓✓ read)
- Message timestamps for all messages
- Last seen indicator & online status
- Automatic unread tracking per conversation
- Activity monitoring with optimized O(1) queries

### 👤 **User Management**
- Email-based registration & login
- Profile management with avatar upload
- Session-based authentication
- Last activity tracking across sessions

### 🎨 **User Interface**
- Responsive design (Desktop, Tablet, Mobile)
- Bootstrap 5 styling
- Real-time toast notifications
- Conversation list with last message preview
- Modern clean message bubbles

---

## 🛠️ Tech Stack

| Category | Technology |
|----------|-----------|
| **Backend** | Laravel 12, PHP 8.2+, MySQL 5.7+ |
| **Frontend** | Blade, Bootstrap 5, jQuery/Vanilla JS |
| **Build Tools** | Vite, npm |
| **Real-Time** | Laravel Reverb (WebSocket-ready) |
| **Utilities** | php-flasher, Eloquent ORM |
| **Testing** | Pest, MockeryPHP |

---

## 📦 Installation

### Prerequisites
```
✓ PHP ≥ 8.2
✓ Composer (dependency manager)
✓ Node.js & npm
✓ MySQL 5.7+
```

### One-Command Setup
```bash
git clone https://github.com/mostafayehia2002/EchoChat.git
cd EchoChat
composer setup
```

### Manual Setup (Step-by-Step)

**1. Clone & Install Dependencies**
```bash
git clone https://github.com/mostafayehia2002/EchoChat.git
cd EchoChat
composer install
npm install
```

**2. Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

**3. Database Setup** (edit `.env`)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=echochat
DB_USERNAME=root
DB_PASSWORD=
```

**4. Initialize Database & Assets**
```bash
php artisan migrate
php artisan storage:link
npm run build
```

**5. Start Server**
```bash
php artisan serve
# Visit http://localhost:8000
```

---

## 🚀 Quick Start Guide

### 1️⃣ **Register Account**
- Navigate to `/register`
- Enter email, name, and password
- Account activated immediately

### 2️⃣ **Start Conversation**
- Go to `/home`
- Click "New Conversation"
- Enter recipient's email
- Send initial message

### 3️⃣ **Send Messages**
- Type in message input field
- Click Send (✓ = sent)
- Recipient sees notification
- Turns ✓✓ when recipient reads

### 4️⃣ **Attach Media**
- Click attachment/paperclip icon
- Select file (image/video/document)
- Add optional text caption
- Click Send (displays inline)

### 5️⃣ **View Activity**
- See "Last seen X minutes ago" on contacts
- Online status updates in real-time
- Timestamps on each message

---

## 🏗️ Architecture

### Request Flow
```
Request → Route → Middleware [auth] → Controller
  ↓
Service (Business Logic) → Model (Eloquent)
  ↓
Database (MySQL) → Response
```

### Core Components

| Component | Location | Responsibility |
|-----------|----------|-----------------|
| **Services** | `app/Services/` | Business logic, transactions |
| **Controllers** | `app/Http/Controllers/` | Route handling, service injection |
| **Models** | `app/Models/` | Eloquent relations, queries |
| **Requests** | `app/Http/Requests/` | Form validation rules |
| **Enums** | `app/Enums/MessageType.php` | Message type constants |

### Database Schema
```
User ←→ Conversation (Many-to-Many)
     ↓
ConversationParticipant (Junction + last_read tracking)
     ↓
Message → Media (Polymorphic)
     ↓
MessageRead (Audit trail)
```

**Smart Unread Tracking:**
- **`message_reads`** - Detailed audit trail
- **`conversation_participants.last_read_message_id`** - O(1) count reference
- **Formula**: `COUNT(msg WHERE id > last_read_id AND sender != user)`

---

## 🔌 API Endpoints

### Authentication
| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/register` | Register new user |
| POST | `/login` | Login user |
| POST | `/logout` | Logout user |
| GET | `/profile` | View/edit profile |
| POST | `/profile/update` | Update profile |

### Conversations
| Method | Endpoint | Purpose |
|--------|----------|---------|
| GET | `/home` | List all conversations |
| POST | `/conversations` | Create new conversation |
| GET | `/conversations/{id}` | Get conversation details |
| GET | `/conversations/{id}/messages` | Get messages (infinite scroll) |

### Messaging
| Method | Endpoint | Purpose |
|--------|----------|---------|
| POST | `/conversations/{id}/messages` | Send message |
| POST | `/conversations/{id}/messages/{id}/read` | Mark message as read |

---

## 🧪 Testing

```bash
# Run all tests
composer test

# Run with cache clear
composer test

# Expected Output
# ✓ All Feature tests pass
# ✓ All Unit tests pass
```

---

## 📂 Project Structure

```
EchoChat/
├── app/
│   ├── Services/              # Business logic layer
│   │   ├── ConversationService.php
│   │   ├── ChatService.php
│   │   └── AuthService.php
│   ├── Models/                # Eloquent models
│   ├── Http/
│   │   ├── Controllers/       # Route handlers
│   │   ├── Requests/          # Form validation
│   │   └── Middleware/        # Request middleware
│   └── Enums/                 # Type constants
├── database/
│   └── migrations/            # Schema definitions
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # Stylesheets
│   └── js/                    # Frontend scripts
├── routes/
│   └── web.php               # Route definitions
├── composer.json              # PHP dependencies
├── package.json               # JS dependencies
└── vite.config.js            # Build config
```

---

## 🔐 Authentication & Security

- **Email-based auth** with session management
- **CSRF protection** on all forms
- **Transaction safety** - Database + file operations atomic
- **Input validation** via Form Requests
- **Authorization** - Users can only access their conversations
- **Media security** - Files stored outside web root

---

## ⚡ Development Commands

### Full Dev Environment
```bash
composer dev
# Runs: Server (port 8000) + Queue + Vite live reload
```

### Production Build
```bash
npm run build
php artisan migrate --force
```

### Performance Monitoring
- **Eager loading** prevents N+1 queries
- **Indexed queries** on message IDs
- **O(1) unread counts** via last_read_message_id
- **Asset optimization** via Vite bundling

---

## 📧 Support & License

**MIT License** - Open source and free to use

**Questions or Issues?**
- 📝 [GitHub Issues](https://github.com/mostafayehia2002/EchoChat/issues)
- 📧 [Email Support](mailto:moustafa.yehia.dev@gmail.com)
- 📖 [Developer Docs](AGENTS.md) - AI development guidelines

---

## 👨‍💻 Project Info

- **Author**: Mostafa Yehia
- **Status**: Actively Maintained
- **Last Updated**: May 2026
- **Repository**: [GitHub - EchoChat](https://github.com/mostafayehia2002/EchoChat)

---

<div align="center">

**Made with ❤️ using Laravel 12**

[⭐ Star on GitHub](https://github.com/mostafayehia2002/EchoChat) • [📖 Full Docs](AGENTS.md)

</div>
