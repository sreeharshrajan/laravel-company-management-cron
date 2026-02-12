# Laravel Company Management System

A robust Laravel application for managing companies and users, featuring secure authentication, role-based access control, full CRUD operations, and an automated background process for purging inactive users. The application follows modern PHP standards with emphasis on security, performance, and maintainable architecture.

---

## Table of Contents

- [Laravel Company Management System](#laravel-company-management-system)
  - [Table of Contents](#table-of-contents)
  - [✨ Features](#-features)
  - [🚀 Tech Stack](#-tech-stack)
  - [🛠 System Architecture](#-system-architecture)
    - [1. MVC Architecture with Granular Access](#1-mvc-architecture-with-granular-access)
    - [2. Role-Based Access Control (RBAC)](#2-role-based-access-control-rbac)
    - [3. Automated Database Maintenance (Cron)](#3-automated-database-maintenance-cron)
    - [4. Background Queue Processing](#4-background-queue-processing)
  - [📁 Project Structure](#-project-structure)
  - [🐳 Installation \& Deployment](#-installation--deployment)
    - [Prerequisites](#prerequisites)
    - [Quick Start](#quick-start)
  - [🔒 Security Implementation](#-security-implementation)
  - [⚡ Performance Optimization](#-performance-optimization)
  - [🧩 Key Implementations](#-key-implementations)
    - [1. User Purging Logic](#1-user-purging-logic)
    - [2. Search & Filtering](#2-search--filtering)
  - [📚 API Documentation](#-api-documentation)
    - [Authentication](#authentication)
    - [Users](#users)
  - [🧪 Testing](#-testing)
  - [📝 Code Standards](#-code-standards)
  - [📞 Contact](#-contact)

## ✨ Features

- **Authenticated Access**: Secure login system using Laravel Breeze.
- **Company Management**: Create, Read, Update, and Delete companies.
- **User Management**: Admin-only user administration.
- **Automated Maintenance**: Scheduled task to purge inactive users after 30 days.
- **Search & Filtering**: Filter users by name/email and status.
- **Role-Based Access Control**: Granular permissions (Admin vs User).
- **Audit Logging**: Logs user purge activities for accountability.

## 🚀 Tech Stack

- **Framework**: Laravel 12.x
- **Backend**: PHP 8.2+
- **Frontend**: Blade, Tailwind CSS, Alpine.js
- **Database**: MySQL 8.0 / SQLite
- **Authentication**: Laravel Breeze & Sanctum (API)
- **Queues**: Database/Redis
- **Testing**: PHPUnit

## 🛠 System Architecture

This project follows strict MVC principles enhanced with standard Laravel patterns for maintainability.

### 1. MVC Architecture with Granular Access

- **Controllers**: Handle HTTP requests and delegate logic.
- **Models**: Eloquent ORM for data interaction.
- **Requests**: Form Request classes (e.g., `StoreCompanyRequest`) handle validation.

### 2. Role-Based Access Control (RBAC)

- **Implementation**: Native Laravel Gates and Policies.
- **Enforcement**:
  - `CompanyPolicy` restricts Write operations to Admins.
  - Middleware protects Admin routes.

### 3. Automated Database Maintenance (Cron)

- **Command**: `users:purge-inactive` runs daily.
- **Logic**: Identifies users inactive for >30 days and removes them.
- **Logging**: Records deletion count and IDs in `purge_logs` table.

### 4. Background Queue Processing

- **Job**: `PurgeInactiveUsersJob` functionality is queueable for performance.
- **Benefit**: Decouples heavy processing from the scheduler or request cycle.

## 📁 Project Structure

```bash
app/
├── Http/
│   ├── Controllers/
│   │   ├── CompanyController.php    # Company CRUD
│   │   ├── UserController.php       # User Management
│   │   └── Api/
│   │       └── UserController.php   # API Endpoints
│   ├── Requests/
│   │   ├── StoreCompanyRequest.php
│   │   └── StoreUserRequest.php
│   └── Middleware/                  # Admin access control
├── Models/
│   ├── Company.php
│   ├── User.php
│   └── PurgeLog.php                 # Logs for cron job
├── Console/
│   └── Commands/
│       └── PurgeInactiveUsers.php   # Cron command
├── Jobs/
│   └── PurgeInactiveUsersJob.php    # Queued job
└── Policies/
    └── CompanyPolicy.php            # Authorization logic
```

## 🐳 Installation & Deployment

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

### Quick Start

1. **Clone the repository**

   ```bash
   git clone <repository_url>
   cd laravel-company-management-cron
   ```

2. **Install Dependencies**

   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   Configure your database credentials in `.env`, then run:

   ```bash
   php artisan migrate --seed
   ```

5. **Serve Application**

   ```bash
   php artisan serve
   ```
   Access at `http://localhost:8000`

6. **Setup Scheduler (Cron)**
   Add the following cron entry to your server:
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

## 🔒 Security Implementation

- **CSRF Protection**: Standard Laravel protection on all forms.
- **Authorization**: Policies ensure only Admins can modify Company data.
- **Validation**: Strict server-side validation on all inputs.
- **Sanctum**: Token-based authentication for API endpoints.

## ⚡ Performance Optimization

- **Queued Jobs**: Heavy database cleanup tasks are queued.
- **Pagination**: All list views use server-side pagination.
- **Eager Loading**: Optimized queries to prevent N+1 issues.

## 🧩 Key Implementations

### 1. User Purging Logic
- **Console Command**: `users:purge-inactive`
- **Schedule**: Daily
- **Threshold**: Inactive > 30 Days (based on `last_active_at`)

### 2. Search & Filtering
- **Scope**: `User::filter()` scope implementation.
- **Features**: Search by keyword (name/email) + Status filter (active/inactive).

## 📚 API Documentation

### Authentication
All protected endpoints require `Authorization: Bearer <token>`.

### Users

| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `GET` | `/api/users` | List all users |
| `POST` | `/api/users` | Create user |
| `GET` | `/api/users/{id}` | Get single user |
| `PUT` | `/api/users/{id}` | Update user |
| `DELETE` | `/api/users/{id}` | Delete user |

## 🧪 Testing

### Run Tests

```bash
php artisan test
```

### ✅ Test Suites

- **Feature Tests**: Covers Company CRUD, Purge Logic, User Search, and API.
- **Unit Tests**: Model methods and isolation tests.

## 📝 Code Standards

- Follows **PSR-12** coding standards.
- Uses Laravel standard practices (Facade Pattern, DI).

## 📞 Contact

- **Developer**: Sreeharsh K
- **Position**: PHP Developer
- **Email**: sreeharshkrajan@gmail.com
- **Date**: 2026-02-12
