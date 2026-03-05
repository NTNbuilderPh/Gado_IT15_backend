

```markdown
# 🎓 GADO_IT15_ENROLLMENT_SYSTEM

### University of Mindanao — Tagum Campus
### Academic Portal & Enrollment System

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/12.x/releases)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Sanctum](https://img.shields.io/badge/Sanctum-API_Auth-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com/docs/12.x/sanctum)
[![License](https://img.shields.io/badge/License-Academic-green?style=for-the-badge)](#license)

---

<p align="center">
  <strong>A high-fidelity enrollment and academic management portal built for IT15 (Web Systems and Technologies) at the University of Mindanao.</strong>
</p>

---

## 📋 Table of Contents

- [Overview](#-overview)
- [The Academic Arsenal — Features](#-the-academic-arsenal--features)
- [System Architecture & Business Logic](#-system-architecture--business-logic)
- [Database Schema](#-database-schema)
- [Technology Stack](#-technology-stack)
- [Prerequisites](#-prerequisites)
- [Installation & Setup](#-installation--setup)
- [Running the Application](#-running-the-application)
- [Demo Accounts](#-demo-accounts)
- [Web Routes Reference](#-web-routes-reference)
- [API Documentation (Sanctum)](#-api-documentation-sanctum)
- [Project Structure](#-project-structure)
- [Screenshots](#-screenshots)
- [Business Rules Implementation](#-business-rules-implementation)
- [Security Features](#-security-features)
- [Troubleshooting](#-troubleshooting)
- [References & Tools](#-references--tools)
- [Author](#-author)
- [License](#-license)

---

## 🏫 Overview

**GADO_IT15_ENROLLMENT_SYSTEM** is a full-stack web application that simulates a real-world university enrollment and academic management system. The project is designed as a dual-focus platform that balances **smooth student onboarding** (enrollment) with **long-term academic success tracking** (portal management).

The system is built on the **Laravel 12.x** framework with **Laravel Sanctum** for API token authentication. It features a responsive web interface styled with **UM Maroon branding** and a complete **RESTful API** that can be tested with **Postman**.

### 🎯 Project Objectives

| Objective | Description |
|-----------|-------------|
| **Frictionless Enrollment** | Students can register, upload digital IDs, and enroll in courses within minutes |
| **Academic Tracking** | Real-time grade reports and attendance percentage monitoring |
| **Financial Management** | Secure tuition payment gateway with scholarship balance ledger |
| **Unified Communication** | Automated welcome emails and direct faculty messaging system |
| **SIS Integration** | Students can authenticate using either their Student ID or Email |
| **Capacity Control** | Automated enforcement of course enrollment limits |

---

## 🚀 The "Academic Arsenal" — Features

### Feature Matrix

| Feature Set | Goal | Implementation Details |
|-------------|------|------------------------|
| 🎫 **Enrollment Design** | Frictionless Onboarding | Digital ID upload, SIS integration via `student_number` verification, one-click course enrollment |
| 📊 **Academic Portal** | Daily Task Management | Real-time tracking for grades (GPA computation) and attendance percentages per course |
| 💬 **Communication** | Unified Messaging | Automated "Welcome" email sequences on registration and direct student-to-faculty messaging |
| 💰 **Financials** | Secure Ledger | Tuition payment gateway (GCash, Bank Transfer, Cash, Scholarship) with transaction history |
| 🔐 **Authentication** | Dual-Mode Login | Laravel Sanctum — session-based for web, token-based for API |
| 📱 **API** | RESTful Interface | Complete CRUD API with Bearer token authentication for mobile/external integration |

### Detailed Feature Breakdown

#### 1. Student Registration & Onboarding
- Student number validation (format: `XX-XXXXX`)
- Digital ID photo upload (JPG/PNG, max 2MB)
- Program and year level selection
- Automatic welcome email dispatch
- System-generated welcome notification message
- Initial tuition balance assignment (₱15,000.00)

#### 2. Course Enrollment System
- Browse available courses filtered by semester and academic year
- Real-time capacity indicators (slots remaining / total capacity)
- One-click enrollment with instant confirmation
- Course dropping with confirmation dialog
- Visual status badges (Enrolled, Full, Available)
- Total units counter for load tracking

#### 3. Grade Tracking Portal
- Per-course grade display with pass/fail indicators
- General Weighted Average (GPA) computation
- Grade status categorization (Passed / Failed / In Progress)
- Historical grade records across semesters

#### 4. Attendance Monitoring
- Per-course attendance percentage tracking
- Average attendance computation across all enrolled courses
- Visual progress bars with color-coded status
- "Good Standing" vs "At Risk" indicators (threshold: 80%)

#### 5. Financial Ledger
- Tuition balance overview
- Scholarship balance tracking
- Multiple payment methods (GCash, Bank Transfer, Cash, Scholarship)
- Unique reference number generation per transaction
- Paginated payment history with status tracking
- Scholarship balance auto-deduction

#### 6. Messaging System
- Student-to-faculty direct messaging
- System notification messages
- Automated welcome messages on registration
- Read/unread status tracking
- Chronological message inbox

---

## 🏗 System Architecture & Business Logic

### Architecture Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     CLIENT LAYER                            │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │  Web Browser  │  │   Postman    │  │  Mobile Client   │  │
│  │ (Blade Views) │  │  (API Test)  │  │ (Future/External)│  │
│  └──────┬───────┘  └──────┬───────┘  └────────┬─────────┘  │
└─────────┼─────────────────┼────────────────────┼────────────┘
          │                 │                    │
          ▼                 ▼                    ▼
┌─────────────────────────────────────────────────────────────┐
│                   LARAVEL APPLICATION                       │
│  ┌─────────────────────────────────────────────────────┐    │
│  │                 ROUTING LAYER                        │    │
│  │   routes/web.php (Session Auth)                     │    │
│  │   routes/api.php (Sanctum Token Auth)               │    │
│  └─────────────────────┬───────────────────────────────┘    │
│                        ▼                                    │
│  ┌─────────────────────────────────────────────────────┐    │
│  │              MIDDLEWARE LAYER                        │    │
│  │   EnsureStudentAuthenticated (Web)                  │    │
│  │   auth:sanctum (API)                                │    │
│  └─────────────────────┬───────────────────────────────┘    │
│                        ▼                                    │
│  ┌─────────────────────────────────────────────────────┐    │
│  │             CONTROLLER LAYER                        │    │
│  │                                                     │    │
│  │   Web Controllers:          API Controllers:        │    │
│  │   ├── AuthController        ├── Api\AuthController  │    │
│  │   ├── DashboardController   ├── Api\CourseController│    │
│  │   ├── EnrollmentController  ├── Api\EnrollmentCtrl  │    │
│  │   ├── PortalController      └── Api\StudentCtrl     │    │
│  │   ├── FinanceController                             │    │
│  │   └── MessageController                             │    │
│  └─────────────────────┬───────────────────────────────┘    │
│                        ▼                                    │
│  ┌─────────────────────────────────────────────────────┐    │
│  │               MODEL LAYER (Eloquent ORM)            │    │
│  │   ├── Student   (Authenticatable + HasApiTokens)    │    │
│  │   ├── Course    (Many-to-Many with Student)         │    │
│  │   ├── Payment   (Belongs to Student)                │    │
│  │   └── Message   (Belongs to Student)                │    │
│  └─────────────────────┬───────────────────────────────┘    │
└─────────────────────────┼───────────────────────────────────┘
                          ▼
┌─────────────────────────────────────────────────────────────┐
│                    DATABASE LAYER (MySQL)                    │
│   ┌──────────┐  ┌──────────┐  ┌──────────────────────┐     │
│   │ students │  │ courses  │  │   course_student     │     │
│   │          │◄─┤          │◄─┤   (pivot table)      │     │
│   └──────────┘  └──────────┘  └──────────────────────┘     │
│   ┌──────────┐  ┌──────────┐  ┌──────────────────────┐     │
│   │ payments │  │ messages │  │ personal_access_tkns │     │
│   └──────────┘  └──────────┘  └──────────────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

### Enrollment Business Rules

The enrollment system enforces three critical rules at both the **web controller** and **API controller** layers:

| Rule | Logic | Implementation |
|------|-------|----------------|
| **1. Capacity Control** | `students_count >= capacity` → **BLOCK** | `Course::lockForUpdate()` with DB transaction prevents race conditions |
| **2. Duplicate Prevention** | Check `course_student` pivot for existing active enrollment → **BLOCK** | `Student::isEnrolledIn($courseId)` helper method |
| **3. Course Status** | `course.status !== 'open'` → **BLOCK** | Only courses with `status = 'open'` are enrollable |

```
Student clicks "Enroll"
        │
        ▼
┌─── DB::transaction() ────────────────────────┐
│                                              │
│   1. Lock course row (SELECT ... FOR UPDATE) │
│                                              │
│   2. Check: Already enrolled?                │
│      YES → Return error (409 Conflict)       │
│                                              │
│   3. Check: Course full?                     │
│      YES → Return error (422 Unprocessable)  │
│                                              │
│   4. Check: Course open?                     │
│      NO  → Return error (422 Unprocessable)  │
│                                              │
│   5. Attach student to course (pivot)        │
│   6. Increment students_count                │
│   7. Return success (201 Created)            │
│                                              │
└──────────────────────────────────────────────┘
```

### SIS (Student Information System) Integration

The login system uses **unified authentication logic** where students can use either their **Student ID** or **Email** to access the portal:

```
User enters credential
        │
        ▼
  filter_var(FILTER_VALIDATE_EMAIL)
        │
   ┌────┴────┐
   │         │
  YES        NO
   │         │
   ▼         ▼
 email    student_number
 field       field
   │         │
   └────┬────┘
        │
        ▼
  Auth::attempt([$field => $value, 'password' => $pwd])
        │
        ▼
  Session (Web) or Token (API) created
```

---

## 🗃 Database Schema

### Entity Relationship Diagram

```
┌─────────────────────┐       ┌──────────────────────┐
│      students       │       │       courses         │
├─────────────────────┤       ├──────────────────────┤
│ id (PK)             │       │ id (PK)              │
│ student_number (UQ) │       │ course_code (UQ)     │
│ first_name          │       │ course_name          │
│ last_name           │       │ description          │
│ email (UQ)          │       │ units                │
│ password            │       │ schedule             │
│ phone               │       │ instructor           │
│ address             │       │ room                 │
│ date_of_birth       │       │ capacity             │
│ gender              │       │ students_count       │
│ program             │       │ semester             │
│ year_level          │       │ academic_year        │
│ semester            │       │ status               │
│ academic_year       │       │ created_at           │
│ id_photo            │       │ updated_at           │
│ scholarship_balance │       └───────────┬──────────┘
│ tuition_balance     │                   │
│ status              │                   │
│ created_at          │                   │
│ updated_at          │     ┌─────────────┴──────────┐
└───────────┬─────────┘     │                        │
            │               │    course_student      │
            │               │    (PIVOT TABLE)       │
            │               ├────────────────────────┤
            └──────────────►│ id (PK)                │
                            │ course_id (FK)         │◄── courses.id
                            │ student_id (FK)        │◄── students.id
                            │ enrolled_at            │
                            │ grade                  │
                            │ attendance_percentage  │
                            │ status                 │
                            │ created_at             │
                            │ updated_at             │
                            │                        │
                            │ UNIQUE(course_id,      │
                            │        student_id)     │
                            └────────────────────────┘

┌─────────────────────┐     ┌────────────────────────┐
│      payments       │     │       messages         │
├─────────────────────┤     ├────────────────────────┤
│ id (PK)             │     │ id (PK)                │
│ student_id (FK)     │     │ sender_id (FK)         │
│ reference_number(UQ)│     │ receiver_email         │
│ amount              │     │ subject                │
│ type                │     │ body                   │
│ method              │     │ type                   │
│ description         │     │ is_read                │
│ status              │     │ read_at                │
│ paid_at             │     │ created_at             │
│ created_at          │     │ updated_at             │
│ updated_at          │     └────────────────────────┘
└─────────────────────┘
```

### Relationships Summary

| Relationship | Type | Description |
|-------------|------|-------------|
| `Student ↔ Course` | **Many-to-Many** | Through `course_student` pivot table with extra fields (grade, attendance, status) |
| `Student → Payment` | **One-to-Many** | A student can have multiple payment records |
| `Student → Message` | **One-to-Many** | A student can send multiple messages |

### Table Details

#### `students` Table
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK, AUTO_INCREMENT | Primary key |
| `student_number` | VARCHAR | UNIQUE | Format: `XX-XXXXX` (e.g., `22-00001`) |
| `first_name` | VARCHAR | NOT NULL | Student's first name |
| `last_name` | VARCHAR | NOT NULL | Student's last name |
| `email` | VARCHAR | UNIQUE | Student email address |
| `password` | VARCHAR | NOT NULL | Hashed password (bcrypt) |
| `phone` | VARCHAR | NULLABLE | Contact number |
| `address` | TEXT | NULLABLE | Home address |
| `date_of_birth` | DATE | NULLABLE | Birth date |
| `gender` | ENUM | Male/Female/Other | Gender identity |
| `program` | VARCHAR | DEFAULT 'BSIT' | Academic program |
| `year_level` | ENUM | 1st–4th Year | Current year level |
| `semester` | ENUM | 1st/2nd/Summer | Current semester |
| `academic_year` | VARCHAR | DEFAULT '2024-2025' | Current academic year |
| `id_photo` | VARCHAR | NULLABLE | Path to uploaded ID photo |
| `scholarship_balance` | DECIMAL(10,2) | DEFAULT 0.00 | Available scholarship funds |
| `tuition_balance` | DECIMAL(10,2) | DEFAULT 0.00 | Remaining tuition to pay |
| `status` | ENUM | active/inactive/graduated/suspended | Account status |

#### `courses` Table
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK, AUTO_INCREMENT | Primary key |
| `course_code` | VARCHAR | UNIQUE | Subject code (e.g., `IT15`) |
| `course_name` | VARCHAR | NOT NULL | Full subject name |
| `description` | TEXT | NULLABLE | Course description |
| `units` | INT | DEFAULT 3 | Credit units |
| `schedule` | VARCHAR | NULLABLE | Class schedule |
| `instructor` | VARCHAR | NULLABLE | Professor name |
| `room` | VARCHAR | NULLABLE | Room assignment |
| `capacity` | INT | DEFAULT 40 | Maximum enrollment |
| `students_count` | INT | DEFAULT 0 | Current enrollment (denormalised) |
| `semester` | ENUM | 1st/2nd/Summer | Semester offered |
| `academic_year` | VARCHAR | DEFAULT '2024-2025' | Academic year |
| `status` | ENUM | open/closed/cancelled | Enrollment status |

#### `course_student` Pivot Table
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | BIGINT | PK | Primary key |
| `course_id` | BIGINT | FK → courses.id | Course reference |
| `student_id` | BIGINT | FK → students.id | Student reference |
| `enrolled_at` | TIMESTAMP | DEFAULT NOW | Enrollment timestamp |
| `grade` | DECIMAL(3,2) | NULLABLE | Course grade (1.00–5.00 scale) |
| `attendance_percentage` | DECIMAL(5,2) | DEFAULT 100.00 | Attendance rate |
| `status` | ENUM | enrolled/dropped/completed/failed | Enrollment status |
| — | — | UNIQUE(course_id, student_id) | Prevents duplicate enrollment |

---

## 🛠 Technology Stack

| Layer | Technology | Version | Purpose |
|-------|-----------|---------|---------|
| **Backend Framework** | [Laravel](https://laravel.com/docs/12.x/releases) | 12.x | MVC web application framework |
| **Language** | PHP | 8.2+ | Server-side scripting |
| **Database** | MySQL | 8.0 | Relational data storage |
| **API Authentication** | [Laravel Sanctum](https://laravel.com/docs/12.x/sanctum) | 4.x | Token-based API auth |
| **Web Server** | [XAMPP (Apache)](https://www.apachefriends.org/) | Latest | Local development server |
| **Package Manager** | [Composer](https://getcomposer.org/) | 2.x | PHP dependency management |
| **Frontend** | Blade Templates + CSS + JS | — | Server-side rendering with vanilla JS |
| **API Testing** | [Postman](https://www.postman.com/) | Latest | REST API testing tool |
| **Design Reference** | [Figma](https://www.figma.com/) | — | UI/UX design mockups |
| **Build Tool** | Vite | 6.x | Asset bundling (optional) |

---

## 📋 Prerequisites

Before setting up the project, ensure you have the following installed:

| Requirement | Minimum Version | Download Link |
|-------------|----------------|---------------|
| **PHP** | 8.2 | Bundled with XAMPP |
| **Composer** | 2.0 | https://getcomposer.org/ |
| **XAMPP** | Any recent | https://www.apachefriends.org/ |
| **MySQL** | 5.7 / 8.0 | Bundled with XAMPP |
| **Node.js** (optional) | 18.x | https://nodejs.org/ |
| **Postman** (for API testing) | Any | https://www.postman.com/ |

### Required PHP Extensions
```
php-mbstring
php-xml
php-curl
php-mysql (pdo_mysql)
php-zip
php-gd
php-fileinfo
```

> **Note:** All required PHP extensions are pre-installed with XAMPP.

---

## ⚙ Installation & Setup

### Step 1: Clone or Extract the Project

```bash
# If cloning from a repository
git clone <repository-url> GADO_IT15_ENROLLMENT_SYSTEM
cd GADO_IT15_ENROLLMENT_SYSTEM

# If extracting from a ZIP file
# Extract to your desired location, then navigate into the folder
cd GADO_IT15_ENROLLMENT_SYSTEM
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

> If `vendor/` is excluded from submission, this step is **required**.

### Step 3: Environment Configuration

```bash
# Copy the example environment file
cp .env.example .env

# Generate the application encryption key
php artisan key:generate
```

### Step 4: Configure the Database

1. **Start XAMPP** — Launch Apache and MySQL services
2. **Open phpMyAdmin** — Navigate to `http://localhost/phpmyadmin`
3. **Create a new database:**
   - Database name: `gado_it15_enrollment`
   - Collation: `utf8mb4_unicode_ci`

4. **Update `.env` file** with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gado_it15_enrollment
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

This creates the following tables:
- `students`
- `courses`
- `course_student`
- `payments`
- `messages`
- `personal_access_tokens`
- `password_reset_tokens`
- `sessions`

### Step 6: Seed the Database

```bash
php artisan db:seed --class=UMPortalSeeder
```

This populates the database with:
- ✅ 8 courses (BSIT curriculum)
- ✅ 3 demo students
- ✅ Demo enrollments with grades and attendance
- ✅ Demo payment records
- ✅ Welcome notification messages

### Step 7: Create Storage Symlink

```bash
php artisan storage:link
```

> This creates a symbolic link from `public/storage` → `storage/app/public` for ID photo uploads.

### Step 8 (Optional): Install Node.js Dependencies

```bash
npm install
npm run build
```

> Only needed if you want to use Vite for asset compilation. The project works without this step using the pre-built CSS/JS files in `public/`.

---

## 🖥 Running the Application

### Start the Development Server

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

### Quick Access URLs

| Page | URL | Auth Required |
|------|-----|---------------|
| Welcome/Landing | http://localhost:8000 | No |
| Student Login | http://localhost:8000/login | No |
| Registration | http://localhost:8000/register | No |
| Dashboard | http://localhost:8000/dashboard | Yes |
| Enrollment | http://localhost:8000/enrollment | Yes |
| Grades | http://localhost:8000/portal/grades | Yes |
| Attendance | http://localhost:8000/portal/attendance | Yes |
| Finance | http://localhost:8000/finance | Yes |
| Messages | http://localhost:8000/messages | Yes |

---

## 👤 Demo Accounts

After running the seeder, use any of these accounts to log in:

| Student ID | Email | Password | Program | Year |
|-----------|-------|----------|---------|------|
| `22-00001` | `gado@um.edu.ph` | `password123` | BSIT | 3rd Year |
| `22-00002` | `maria.santos@um.edu.ph` | `password123` | BSIT | 3rd Year |
| `23-00010` | `juan.delacruz@um.edu.ph` | `password123` | BSCS | 2nd Year |

> **SIS Integration:** You can use either the **Student ID** or **Email** as the login credential.

### Demo Student Details

**Gado Developer (22-00001)**
- Enrolled in: IT15, IT14, IT16
- Has grade in IT15 (1.50)
- Tuition balance: ₱15,000.00
- Scholarship balance: ₱5,000.00
- Has 2 payment records

**Maria Santos (22-00002)**
- Enrolled in: IT15, GE05, MATH02
- No grades yet
- Tuition balance: ₱12,000.00
- Scholarship balance: ₱3,000.00

**Juan Dela Cruz (23-00010)**
- Enrolled in: IT13, IT14
- No grades yet
- Tuition balance: ₱18,000.00
- No scholarship balance

---

## 🌐 Web Routes Reference

### Public Routes (No Authentication)

| Method | URI | Controller | Action |
|--------|-----|-----------|--------|
| `GET` | `/` | Closure | Landing page |
| `GET` | `/login` | `AuthController@showLogin` | Login form |
| `POST` | `/login` | `AuthController@login` | Process login |
| `GET` | `/register` | `AuthController@showRegister` | Registration form |
| `POST` | `/register` | `AuthController@register` | Process registration |

### Protected Routes (Student Authentication Required)

| Method | URI | Controller | Action |
|--------|-----|-----------|--------|
| `POST` | `/logout` | `AuthController@logout` | Log out |
| `GET` | `/dashboard` | `DashboardController@index` | Student dashboard |
| `GET` | `/enrollment` | `EnrollmentController@index` | Browse courses |
| `POST` | `/enrollment` | `EnrollmentController@store` | Enroll in course |
| `DELETE` | `/enrollment/{course}` | `EnrollmentController@destroy` | Drop course |
| `GET` | `/portal/grades` | `PortalController@grades` | Grade report |
| `GET` | `/portal/attendance` | `PortalController@attendance` | Attendance record |
| `GET` | `/finance` | `FinanceController@index` | Financial ledger |
| `POST` | `/finance/payment` | `FinanceController@processPayment` | Make payment |
| `GET` | `/messages` | `MessageController@index` | Message inbox |
| `POST` | `/messages` | `MessageController@store` | Send message |

---

## 📬 API Documentation (Sanctum)

The API uses **Laravel Sanctum** for token-based authentication. Test all endpoints with [Postman](https://www.postman.com/).

**Base URL:** `http://localhost:8000/api`

### Authentication Endpoints

#### POST `/api/auth/login`
Login and receive a Bearer token.

**Request Body:**
```json
{
    "login": "22-00001",
    "password": "password123"
}
```

**Successful Response (200):**
```json
{
    "success": true,
    "message": "Login successful.",
    "data": {
        "student": {
            "id": 1,
            "student_number": "22-00001",
            "first_name": "Gado",
            "last_name": "Developer",
            "email": "gado@um.edu.ph",
            "program": "BSIT",
            "year_level": "3rd Year"
        },
        "token": "1|abc123def456..."
    }
}
```

> **Note:** The `login` field accepts either a Student ID (e.g., `22-00001`) or an email (e.g., `gado@um.edu.ph`).

#### POST `/api/auth/register`
Register a new student account.

**Request Body:**
```json
{
    "student_number": "24-00001",
    "first_name": "New",
    "last_name": "Student",
    "email": "new.student@um.edu.ph",
    "password": "password123",
    "password_confirmation": "password123",
    "program": "BSIT",
    "year_level": "1st Year"
}
```

#### POST `/api/auth/logout` 🔒
Revoke the current access token.

**Header:** `Authorization: Bearer {token}`

### Protected Endpoints 🔒

> All endpoints below require the header: `Authorization: Bearer {token}`

#### GET `/api/profile`
Get the authenticated student's profile.

**Response:**
```json
{
    "success": true,
    "data": {
        "student": { ... },
        "total_units": 9,
        "gpa": 1.50
    }
}
```

#### PUT `/api/profile`
Update profile information.

**Request Body:**
```json
{
    "phone": "09171234567",
    "address": "Tagum City, Davao del Norte",
    "gender": "Male"
}
```

#### GET `/api/courses`
List all open courses. Supports query parameters:

| Parameter | Type | Description |
|-----------|------|-------------|
| `semester` | string | Filter by semester |
| `search` | string | Search by code, name, or instructor |

**Example:** `GET /api/courses?search=IT15&semester=1st Semester`

#### GET `/api/courses/{id}`
Get a specific course with enrolled students.

#### POST `/api/enrollment`
Enroll in a course.

**Request Body:**
```json
{
    "course_id": 1
}
```

**Error Responses:**

| Status | Scenario |
|--------|----------|
| `409` | Already enrolled (Duplicate Prevention) |
| `422` | Course is full (Capacity Control) |
| `422` | Course is not open |

#### DELETE `/api/enrollment/{courseId}`
Drop a course.

#### GET `/api/grades`
Get grade report with GPA.

**Response:**
```json
{
    "success": true,
    "data": {
        "gpa": 1.50,
        "courses": [
            {
                "course_code": "IT15",
                "course_name": "Web Systems and Technologies",
                "units": 3,
                "grade": 1.50,
                "status": "enrolled",
                "instructor": "Prof. Maria Santos"
            }
        ]
    }
}
```

#### GET `/api/attendance`
Get attendance record for active courses.

#### GET `/api/finance`
Get financial overview with payment history.

#### POST `/api/payment`
Process a tuition payment.

**Request Body:**
```json
{
    "amount": 5000,
    "method": "gcash"
}
```

**Available Methods:** `cash`, `gcash`, `bank_transfer`, `scholarship`

### Postman Setup Guide

1. Open [Postman](https://www.postman.com/)
2. Create a new Collection: **"GADO_IT15_ENROLLMENT_SYSTEM"**
3. Set the base URL variable: `{{base_url}}` = `http://localhost:8000/api`
4. First, call `POST /api/auth/login` to get a token
5. Copy the token from the response
6. For all subsequent requests, add the header:
   ```
   Authorization: Bearer {your_token_here}
   ```
7. Also add:
   ```
   Accept: application/json
   Content-Type: application/json
   ```

---

## 📂 Project Structure

```
GADO_IT15_ENROLLMENT_SYSTEM/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── AuthController.php        # API login/register/logout
│   │   │   │   ├── CourseController.php       # API course listing
│   │   │   │   ├── EnrollmentController.php   # API enroll/drop/grades/attendance
│   │   │   │   └── StudentController.php      # API profile/finance/payment
│   │   │   │
│   │   │   ├── AuthController.php             # Web login/register/logout
│   │   │   ├── Controller.php                 # Base controller
│   │   │   ├── DashboardController.php        # Student dashboard
│   │   │   ├── EnrollmentController.php       # Web enrollment management
│   │   │   ├── FinanceController.php          # Financial ledger & payments
│   │   │   ├── MessageController.php          # Messaging system
│   │   │   └── PortalController.php           # Grades & attendance views
│   │   │
│   │   └── Middleware/
│   │       └── EnsureStudentAuthenticated.php  # Custom auth middleware
│   │
│   ├── Mail/
│   │   └── WelcomeStudent.php                 # Welcome email mailable
│   │
│   ├── Models/
│   │   ├── Course.php                         # Course model (scopes, accessors)
│   │   ├── Message.php                        # Message model
│   │   ├── Payment.php                        # Payment model (ref generator)
│   │   └── Student.php                        # Student model (auth, relationships)
│   │
│   └── Providers/
│       └── AppServiceProvider.php             # App service provider
│
├── bootstrap/
│   └── app.php                                # Application bootstrap config
│
├── config/
│   └── auth.php                               # Auth guards & providers
│
├── database/
│   ├── migrations/
│   │   ├── 2025_01_01_000001_create_students_table.php
│   │   ├── 2025_01_01_000002_create_courses_table.php
│   │   ├── 2025_01_01_000003_create_course_student_table.php
│   │   ├── 2025_01_01_000004_create_payments_table.php
│   │   ├── 2025_01_01_000005_create_messages_table.php
│   │   └── 2025_01_01_000006_create_personal_access_tokens_table.php
│   │
│   └── seeders/
│       ├── DatabaseSeeder.php                 # Master seeder
│       └── UMPortalSeeder.php                 # UM-specific demo data
│
├── public/
│   ├── css/
│   │   └── app.css                            # UM Maroon branded stylesheet
│   ├── js/
│   │   └── app.js                             # Capacity validation & UI logic
│   └── images/
│       └── um-logo.png                        # UM logo (place here)
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php                  # Master layout (navbar, alerts)
│       ├── auth/
│       │   ├── login.blade.php                # Login page
│       │   └── register.blade.php             # Registration page
│       ├── enrollment/
│       │   └── index.blade.php                # Course enrollment page
│       ├── portal/
│       │   ├── grades.blade.php               # Grade report page
│       │   └── attendance.blade.php           # Attendance record page
│       ├── finance/
│       │   └── index.blade.php                # Financial ledger page
│       ├── messages/
│       │   └── index.blade.php                # Messaging page
│       ├── emails/
│       │   └── welcome.blade.php              # Welcome email template
│       ├── dashboard.blade.php                # Student dashboard
│       └── welcome.blade.php                  # Landing page
│
├── routes/
│   ├── web.php                                # Web routes (session auth)
│   └── api.php                                # API routes (Sanctum token auth)
│
├── storage/                                   # File storage & logs
├── tests/                                     # PHPUnit tests
│
├── .env                                       # Environment config (local)
├── .env.example                               # Environment template
├── .gitignore                                 # Git ignore rules
├── artisan                                    # Laravel CLI
├── composer.json                              # PHP dependencies
├── composer.lock                              # Locked dependency versions
├── package.json                               # Node.js dependencies (optional)
├── phpunit.xml                                # Test configuration
├── README.md                                  # This documentation
└── vite.config.js                             # Vite asset bundler config
```

---

## 📸 Screenshots

### Landing Page
> The welcome page features UM Maroon branding with login and registration buttons.

### Student Dashboard
> Displays enrolled courses, GPA, attendance averages, tuition balance, and recent payments in a card-based layout.

### Course Enrollment
> Shows available courses with real-time capacity indicators, enrolled course list with drop functionality.

### Grade Report
> Displays all courses with grades, pass/fail indicators, and computed GPA.

### Attendance Tracker
> Shows per-course attendance percentages with color-coded progress bars.

### Financial Ledger
> Payment form with method selection and paginated transaction history.

> **Note:** Place actual screenshots in a `/screenshots` folder and update the image paths above for your submission.

---

## ✅ Business Rules Implementation

### 1. Capacity Control

**Location:** `EnrollmentController@store` (both Web and API)

```php
// Lock the course row to prevent race conditions
$course = Course::lockForUpdate()->findOrFail($courseId);

// Check capacity
if ($course->students_count >= $course->capacity) {
    // BLOCK enrollment — return error
}

// If passed, enroll and increment counter
$student->courses()->attach($courseId, [...]);
$course->increment('students_count');
```

- Uses `DB::transaction()` with `lockForUpdate()` to prevent race conditions
- Denormalised `students_count` column for fast reads
- Frontend also validates by disabling buttons for full courses

### 2. Duplicate Prevention

**Location:** `Student::isEnrolledIn()` helper method

```php
public function isEnrolledIn(int $courseId): bool
{
    return $this->courses()
        ->where('courses.id', $courseId)
        ->wherePivot('status', 'enrolled')
        ->exists();
}
```

- Checks the `course_student` pivot table for existing active enrollments
- Database-level `UNIQUE(course_id, student_id)` constraint as a safety net
- UI shows "Enrolled ✓" badge for already-enrolled courses

### 3. SIS Integration (Dual-Mode Login)

**Location:** `AuthController@login` (both Web and API)

```php
$loginValue = trim($request->login);
$field = filter_var($loginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_number';

// Auth::attempt uses the dynamically determined field
Auth::attempt([$field => $loginValue, 'password' => $request->password]);
```

---

## 🔐 Security Features

| Feature | Implementation |
|---------|---------------|
| **Password Hashing** | Bcrypt via Laravel's `Hash` facade (automatic in `casts`) |
| **CSRF Protection** | All web forms include `@csrf` token |
| **SQL Injection Prevention** | Eloquent ORM with parameterised queries |
| **XSS Prevention** | Blade's `{{ }}` auto-escaping |
| **Mass Assignment Protection** | `$fillable` whitelists on all models |
| **Authentication Middleware** | Custom `EnsureStudentAuthenticated` checks both auth and account status |
| **API Token Auth** | Laravel Sanctum with per-request token validation |
| **Race Condition Prevention** | `DB::transaction()` with `lockForUpdate()` for enrollment |
| **Input Validation** | Server-side validation on all controller methods |
| **File Upload Security** | MIME type validation, size limits, and secure storage |
| **Session Security** | Session regeneration on login, invalidation on logout |

---

## 🔧 Troubleshooting

### Common Issues & Solutions

#### 1. "Could not find driver" Error
```bash
# Enable the PDO MySQL extension in php.ini
# Uncomment this line:
extension=pdo_mysql

# Restart Apache in XAMPP
```

#### 2. Migration Fails — Table Already Exists
```bash
# Drop all tables and re-migrate
php artisan migrate:fresh

# Then re-seed
php artisan db:seed --class=UMPortalSeeder
```

#### 3. 419 Page Expired (CSRF Token Mismatch)
```bash
# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Make sure all forms include @csrf
```

#### 4. Storage Link Error (ID Photos Not Loading)
```bash
# Create the symbolic link
php artisan storage:link

# On Windows, run Command Prompt as Administrator
```

#### 5. API Returns 401 Unauthenticated
- Ensure you include the `Authorization: Bearer {token}` header
- Ensure `Accept: application/json` header is set
- Check that the token hasn't been revoked

#### 6. "Class not found" Error
```bash
# Regenerate the autoloader
composer dump-autoload

# Clear all caches
php artisan optimize:clear
```

#### 7. Welcome Email Not Sending
- Configure SMTP settings in `.env` (use [Mailtrap](https://mailtrap.io/) for testing)
- The system gracefully handles email failures — registration will still succeed
- Check `storage/logs/laravel.log` for email error details

### Useful Artisan Commands

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Fresh migration + seed
php artisan migrate:fresh --seed

# Seed specific seeder
php artisan db:seed --class=UMPortalSeeder

# Clear all caches
php artisan optimize:clear

# Generate application key
php artisan key:generate

# List all registered routes
php artisan route:list

# Enter Tinker (interactive REPL)
php artisan tinker
```

---

## 📚 References & Tools

| Resource | URL | Usage |
|----------|-----|-------|
| **Laravel 12.x Documentation** | https://laravel.com/docs/12.x/releases | Backend framework reference |
| **Laravel Sanctum** | [Quipper Lesson — Sanctum](https://learn.quipper.com/en/assignments/69a7a8de73b7f20027d5ba72/topics/69a7a6ea91bbd60604e921a3/lessons/1/chapters/1) | API token authentication |
| **Laravel Backend** | [Quipper Lesson — Backend](https://learn.quipper.com/en/assignments/698aa97e686f6400278aadc7/topics/698aa89ac86b8905bb12308e/lessons/1/chapters/1) | Backend development concepts |
| **Postman** | https://www.postman.com/ | API endpoint testing |
| **XAMPP** | https://www.apachefriends.org/ | Local PHP/MySQL development environment |
| **Composer** | https://getcomposer.org/ | PHP dependency management |
| **Figma** | https://www.figma.com/ | UI/UX design reference |

---

## 👨‍💻 Author

| Field | Detail |
|-------|--------|
| **Developer** | Gado |
| **Course** | IT15 — Web Systems and Technologies |
| **Institution** | University of Mindanao — Tagum Campus |
| **Academic Year** | 2024–2025 |
| **Semester** | 1st Semester |

---

## 📝 License

This project is developed for **academic purposes** as a course requirement for **IT15 — Web Systems and Technologies** at the **University of Mindanao (Tagum Campus)**.

This is **not** an official University of Mindanao product. All university branding is used solely for educational demonstration within the context of the course project.

---

## 📌 Submission Checklist

| Item | Status | Description |
|------|--------|-------------|
| `/app` (Models & Controllers) | ✅ | Student, Course, Payment, Message models + all controllers |
| `/database` (Migrations & Seeders) | ✅ | 6 migration files + UMPortalSeeder |
| `/resources/views` (Blade Templates) | ✅ | Dashboard, Enroll, Login, Register, Portal, Finance, Messages |
| `/public` (CSS, JS, Logos) | ✅ | UM Maroon branded CSS + capacity validation JS |
| `/routes` (web.php, api.php) | ✅ | Full web + RESTful API routes |
| `README.md` | ✅ | This documentation |
| `vendor/` excluded | ✅ | Run `composer install` to restore |
| `node_modules/` excluded | ✅ | Run `npm install` to restore (optional) |

---

<p align="center">
  <strong>🎓 University of Mindanao — Tagum Campus</strong><br>
  <em>IT15 — Web Systems and Technologies</em><br>
  <em>GADO_IT15_ENROLLMENT_SYSTEM © 2025</em>
</p>
```