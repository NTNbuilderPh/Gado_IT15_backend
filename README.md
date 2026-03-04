```markdown
# 🎓 GADO IT15 Enrollment System

**University of Mindanao – Tagum Campus**  
Academic Portal & Enrollment System  
Course: Web Systems and Technologies (IT15)

---

## ✨ Highlights

- Modern Laravel 12 + Sanctum (web + API)
- Real business rules: capacity control, duplicate prevention, race-condition safe enrollment
- Dual login (Student ID **or** Email)
- Responsive Blade UI with UM branding
- Complete student portal: enrollment, grades, attendance, finance, messaging
- RESTful JSON API ready for mobile / Postman testing
- Welcome email + file upload (digital ID)

---

## 🚀 Quick Start

```bash
# 1. Clone or extract project
git clone https://github.com/yourusername/GADO_IT15_ENROLLMENT_SYSTEM.git
cd GADO_IT15_ENROLLMENT_SYSTEM

# 2. Install dependencies
composer install

# 3. Copy & configure environment
cp .env.example .env
php artisan key:generate

# 4. Create database `gado_it15_enrollment` in phpMyAdmin / MySQL

# 5. Update .env database credentials
# DB_DATABASE=gado_it15_enrollment
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Migrate & seed demo data
php artisan migrate --seed

# 7. Create storage symlink (for ID photos)
php artisan storage:link

# 8. Start server
php artisan serve
```

Open → **http://localhost:8000**

Login with demo accounts → see [Demo Accounts](#-demo-accounts)

---

## 🎯 Features

| Area              | Key Capabilities                                                                 |
|-------------------|----------------------------------------------------------------------------------|
| **Onboarding**    | Student registration • Digital ID upload • Auto welcome email & notification     |
| **Enrollment**    | Browse courses • Real-time slots left • One-click enroll • Drop with confirmation |
| **Academic**      | Per-course grades • GPA calculation • Attendance % with progress bars            |
| **Finance**       | Tuition + scholarship ledger • Multiple payment methods • Transaction history     |
| **Communication** | Student ↔ Faculty messaging • System notifications • Read/unread status          |
| **API**           | Sanctum token auth • Full CRUD for courses, enrollment, grades, payments         |
| **Security**      | Race-condition safe enrollment • Input validation • File upload restrictions     |

**Business Rules Enforced:**

- Course capacity limit (lockForUpdate + transaction)
- No duplicate enrollment (pivot check + unique constraint)
- Only `open` courses can be enrolled

---

## 👤 Demo Accounts

| Student ID   | Email                        | Password     | Program | Year     |
|--------------|------------------------------|--------------|---------|----------|
| `22-00001`   | `gado@um.edu.ph`             | `password123`| BSIT    | 3rd Year |
| `22-00002`   | `maria.santos@um.edu.ph`     | `password123`| BSIT    | 3rd Year |
| `23-00010`   | `juan.delacruz@um.edu.ph`    | `password123`| BSCS    | 2nd Year |

> You can login with **either Student ID or Email**

---

## 🌐 API (Sanctum)

**Base URL:** `http://localhost:8000/api`

### Quick Auth Flow (Postman)

1. `POST /api/auth/login`
   ```json
   {
     "login": "22-00001",
     "password": "password123"
   }
   ```
   → Copy the `token`

2. Add header to all requests:
   ```
   Authorization: Bearer {token}
   Accept: application/json
   ```

Main endpoints:

- `GET    /api/profile`
- `GET    /api/courses`          (with `?search=IT15&semester=1st`)
- `POST   /api/enrollment`       `{ "course_id": 1 }`
- `DELETE /api/enrollment/{id}`
- `GET    /api/grades`
- `GET    /api/attendance`
- `GET    /api/finance`
- `POST   /api/payment`

See full documentation in original → [API Documentation](#-api-documentation-sanctum) section.

---

## 🗃 Database & Relationships

- **students** ↔ **courses**  → many-to-many (`course_student` pivot)
  - extra fields: grade, attendance_percentage, status
- **students** → **payments**  → one-to-many
- **students** → **messages**  → one-to-many

Important columns:

- `courses.students_count` — denormalized, incremented safely
- `course_student.status` — enrolled / dropped / completed / failed

---

## 🛠 Tech Stack

- **Backend** — Laravel 12, PHP 8.2+
- **Database** — MySQL 8
- **Auth** — Laravel Sanctum (web + API)
- **Frontend** — Blade, Tailwind / custom CSS, vanilla JS
- **Local env** — XAMPP recommended
- **API Client** — Postman

---

## 📂 Folder Structure (important parts)

```text
app/
├── Http/Controllers/
│   ├── Api/           ← REST API controllers
│   └── (Web controllers)
├── Models/
│   ├── Student.php    ← Authenticatable + API tokens
│   ├── Course.php
│   ├── Payment.php
│   └── Message.php
database/
├── migrations/
└── seeders/
    └── UMPortalSeeder.php
resources/views/
├── auth/
├── enrollment/
├── portal/
├── finance/
└── messages/
routes/
├── web.php
└── api.php
```

---

## 🔒 Security Implemented

- Bcrypt passwords
- CSRF protection
- Mass assignment protection (`$fillable`)
- Sanctum token auth
- `lockForUpdate()` + transaction for enrollment
- File upload validation (type, size)
- Custom middleware checking account status

---

## ⚡ Troubleshooting — Most Common Fixes

- **419 Page Expired** → `php artisan optimize:clear`
- **Storage images 404** → `php artisan storage:link`
- **API 401** → Check `Bearer` token & `Accept: application/json`
- **Driver not found** → Enable `pdo_mysql` in php.ini

---

## 📝 License

**Academic / Educational use only**  
Developed as a course requirement for **IT15 — Web Systems and Technologies** at **University of Mindanao – Tagum Campus**.

Not an official university system. UM branding used for demonstration purposes only.

---

## 🙌 Contributing

This is a student project — contributions not expected.  
Feel free to fork and use as inspiration/reference for your own academic work.

---

**Made with ❤️ for IT15 @ UM Tagum • 2025**

University of Mindanao  
Tagum College  
Web Systems and Technologies
```


