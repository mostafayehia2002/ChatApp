# 💬 RealTimeChat Application

A modern chat app built with **Laravel 12**. Features real-time messaging, read receipts (✓✓), media attachments, infinite scroll, and clean architecture.

**[Features](#-features) • [Install](#-installation--setup) • [Usage](#-usage-instructions) • [Tech Stack](#-technologies-used)**

---

## 🚀 Features

**Authentication:** Registration • Login • Logout
**Messaging:** Text messages • Media attachments (images, videos, files) • Mixed messages
**Read Status:** ✓ sent • ✓✓ read (WhatsApp-style) • Timestamps
**Activity:** Last seen indicator • Online status tracking
**UI:** Infinite scroll (20 msgs/batch) • Search conversations • Responsive design

---

## 🏗️ Architecture

**Service Layer Pattern**: Request → Controller → Service → Model → DB

**Core Services**: ConversationService | ChatService | AuthService | ProfileService

**Message Types**: TEXT (1) | MEDIA (2) | TEXT_MEDIA (3)

**Read Tracking**: Dual-table approach for O(1) unread count
- `message_reads` → Detailed audit trail
- `conversation_participants.last_read_message_id` → Fast reference

**Database**: User ↔ Conversation (Many-to-Many) → Messages → Media (Polymorphic)

---

## 📸 Screenshots

### **Authentication Flow**
| Login | Registration | Profile |
|-------|--------------|---------|
| ![Login Screen](screenshots/login.png) | ![Register Screen](screenshots/register.png) | ![Profile Management](screenshots/profile.png) |

### **Desktop Application**
| Home Dashboard | Chat Interface |
|---|---|
| ![Home Page](screenshots/home.png) | ![Desktop Chat View](screenshots/desktop-chat.png) |

### **Mobile & Responsive Views**
| Conversation List | Chat View | Media Messages |
|---|---|---|
| ![Conversations](screenshots/conversations.png) | ![Chat Interface](screenshots/chat.png) | ![Media Upload](screenshots/upload-media.png) |
---

## 🛠️ Technologies Used

- **Backend**: PHP 8.2+ • Laravel 12 • MySQL • Laravel Reverb
- **Frontend**: Blade • Bootstrap 5 • jQuery • AJAX • Vite
- **Testing**: Pest • Faker • Mockery • Laravel Pint
- **Libraries**: php-flasher • Laravel Tinker • Laravel Pail

---

## 📦 Installation & Setup

**Quick Setup:**
```bash
git clone https://github.com/mostafayehia2002/ChatApp.git
cd ChatApp
composer setup
```

**Manual Setup:**
```bash
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
```

**Database Config** (`.env`):
```env
DB_DATABASE=realtimechat
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🚀 Usage Instructions

**Development:**
```bash
composer dev  # Runs server + queue + vite (port 8000)
```

**Production:**
```bash
npm run build
php artisan migrate --force
php artisan serve --host=0.0.0.0 --port=8000
```

**Testing:**
```bash
composer test
```

**Features:**
1. **Register** → `/register` (email, name, password)
2. **Start Chat** → `/home` → New Conversation → Enter email
3. **Send Message** → Type & send (✓ = sent, ✓✓ = read)
4. **Send Media** → Click attachment → Select files → Optional text → Send
5. **View Profile** → Avatar → Update info/photo
6. **Last Seen** → Shows when user was last active

---

## 🔒 Security

- ✅ Authorization: `whereHas('participants')` validates access
- ✅ Input Validation: FormRequest classes
- ✅ CSRF Protection: Laravel default
- ✅ File Upload: MIME validation + storage in non-web directory
- ✅ Transactions: DB consistency + file cleanup on failure
- ✅ Middleware: Auth + activity tracking on protected routes

---

## 🔄 Development Workflows

**Adding a Feature:**
1. Define validation in `app/Http/Requests/`
2. Implement logic in `app/Services/`
3. Inject service in Controller
4. Add route in `routes/web.php`
5. Create Blade template

**Modifying Message Types:**
1. Update `MessageType` enum
2. Edit `ConversationService::formatSingleMessage()`
3. Update DB logic AND formatting

**Debugging Unread Counts:**
```php
Message::where('id', '>', $participant->last_read_message_id)
    ->where('sender_id', '!=', auth()->id())->count();
```

---

## 📄 License

This project is open source and available under the **MIT License**. See the `LICENSE` file for details.

---

## 📝 Future Enhancements

- 🚀 Typing indicators • Message reactions • Message editing & deletion
- 🚀 Group conversations • Voice/video calls • End-to-end encryption
- 🚀 User blocking • Mobile app (React Native)
- ✅ Performance: Redis caching • Message indexing • Elasticsearch
- ✅ DevOps: Laravel Forge • CI/CD (GitHub Actions) • Sentry monitoring

---

## 📞 Contact & Support

For questions, feedback, or support:
- **GitHub Issues**: [Create an issue](https://github.com/mostafayehia2002/ChatApp/issues)
- **Email**: [moustafa.yehia.dev@gmail.com]
- **Documentation**: See `/docs` folder for detailed guides

---

**Made with ❤️ using Laravel 12**

