# Employee Management & Analytics

[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-v4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![Alpine.js](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)](https://alpinejs.dev)
[![D3.js](https://img.shields.io/badge/D3.js-v7-F9A03C?style=for-the-badge&logo=d3dotjs&logoColor=white)](https://d3js.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.x-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)

**Employee Management & Analytics** is a modern enterprise workforce management and statistical intelligence platform built with **Laravel 12**, **Blade**, **Tailwind CSS**, **Alpine.js**, and **D3.js**. The application features role-based authorization, complete CRUD workflows with robust validation, interactive delete confirmations, real-time MySQL-synchronized workforce analytics, and a professional fixed-sidebar layout.

---

## Developer Identity

| Attribute | Details |
| :--- | :--- |
| **Developer** | **Dea Kusuma Ningrum** |
| **Student ID** | **23082010048** |
| **Project** | Employee Management & Analytics |
| **Academic Year** | 2026 |

---

## Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Authentication & Authorization](#authentication--authorization)
- [Employee Management](#employee-management)
- [Dashboard & Analytics](#dashboard--analytics)
- [Validation](#validation)
- [Screenshots](#screenshots)
- [Installation](#installation)
- [Testing / QA](#testing--qa)
- [Deployment](#deployment)

---

## Project Overview

The Employee Management & Analytics system provides organizations with an intuitive, secure, and responsive platform to register staff members, track career demographics, and visualize workforce metrics. The platform adopts a **modern navy-teal visual design language** with soft neumorphic card surfaces, responsive data tables, and high-readability 2D data visualizations driven directly by underlying database records.

---

## Features

- **Role-Based Access Control (RBAC)**: Distinct permissions for `Admin` (full CRUD + analytics) and standard `User` (read-only directory + analytics).
- **Comprehensive CRUD Operations**: Create, Read, Update, and Delete employee records with route model binding.
- **Robust Multi-Rule Validation**: Server-side and client-side validation ensuring data integrity across age limits, phone formatting, tenure, and email uniqueness.
- **Safe Delete Modal**: Two-step deletion confirmation with Alpine.js to prevent accidental data loss.
- **Interactive D3.js Statistical Visualizations**: Pure 2D statistical charts (Doughnut, Bar, Histograms) rendering live database metrics without distortion.
- **Responsive Fixed Sidebar**: Persistent left sidebar on desktop with independent main content scrolling, collapsible mode with `localStorage` persistence, and an off-canvas drawer on mobile.
- **Live Demo Credentials**: One-click autofill for quick evaluation on the login portal.

---

## Technology Stack

- **Backend Framework**: [Laravel 12](https://laravel.com)
- **Language**: [PHP 8.2+](https://php.net)
- **Database**: [MySQL 8.x / MariaDB](https://mysql.com)
- **Frontend Views**: Laravel Blade Templates
- **Styling**: [Tailwind CSS v4](https://tailwindcss.com) with `@tailwindcss/vite`
- **Interactivity**: [Alpine.js 3.x](https://alpinejs.dev)
- **Data Visualization**: [D3.js v7](https://d3js.org) (Pure 2D SVG, responsive `viewBox`)
- **Asset Bundler**: [Vite 7](https://vitejs.dev)

---

## Authentication & Authorization

The system enforces authorization at both the routing and controller layers:

| Role | Permissions |
| :--- | :--- |
| **Administrator** | • View Analytics Dashboard<br>• View Employee Directory & Details<br>• Register New Employees (`create` / `store`)<br>• Edit Existing Records (`edit` / `update`)<br>• Delete Employee Records (`destroy`) |
| **Standard User** | • View Analytics Dashboard<br>• Browse & Search Employee Directory (`index`)<br>• View Detailed Employee Profile (`show`)<br>• *Restricted from all write/delete operations (receives HTTP 403 Forbidden)* |

### Default Demo Accounts

| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@example.com` | `password` |
| **Standard User** | `user@example.com` | `password` |

---

## Employee Management

The Employee module tracks complete career and demographic details:
- **Full Name**: Staff member's official legal name.
- **Gender**: `Laki-laki` or `Perempuan`.
- **Educational Attainment**: `SMA/SMK`, `D3`, `S1`, `S2`, `S3`.
- **Age**: Integer constrained between 18 and 100 years.
- **Work Duration (Tenure)**: Years of experience (non-negative integer).
- **Phone Number**: Valid telecommunication number (10 to 20 characters).
- **Email Address**: Unique valid email address.

---

## Dashboard & Analytics

All KPI cards and statistical distribution charts reflect live MySQL database calculations:

1. **KPI Metric Cards**:
   - **Total Employees**: Count of all active staff records.
   - **Male Employees**: Count and percentage breakdown.
   - **Female Employees**: Count and percentage breakdown.
   - **Average Workforce Age**: Mean age with single-decimal precision.
   - **Average Tenure**: Average years of service across staff.

2. **D3.js Data Visualizations**:
   - **Gender Distribution**: 2D D3.js Doughnut Chart with interactive hover states and tooltips.
   - **Education Distribution**: 2D D3.js Bar Chart with dynamic category scaling (`SMA/SMK`, `D3`, `S1`, `S2`, `S3`).
   - **Age Demographics**: 2D D3.js Histogram displaying age brackets (`18–25`, `26–35`, `36–45`, `46–55`, `56+`).
   - **Work Duration (Tenure)**: 2D D3.js Bar Chart showing experience segmentation (`< 2 yrs`, `2–5 yrs`, `6–10 yrs`, `11–15 yrs`, `15+ yrs`).
   - **Empty State**: Elegant empty vault visual state if 0 employee records exist.

---

## Validation

Validation rules are strictly defined in `app/Http/Controllers/EmployeeController.php` and verified via automated test suites:

```php
[
    'name'          => ['required', 'string', 'max:255'],
    'gender'        => ['required', 'in:Laki-laki,Perempuan'],
    'education'     => ['required', 'in:SMA/SMK,D3,S1,S2,S3'],
    'age'           => ['required', 'integer', 'min:18', 'max:100'],
    'work_duration' => ['required', 'integer', 'min:0', 'max:100'],
    'phone'         => ['required', 'string', 'min:10', 'max:20', 'regex:/^[0-9+\-\s()]+$/'],
    'email'         => ['required', 'email', 'max:255', 'unique:employees,email,...'],
]
```

- **Inline Error Feedback**: Displayed directly underneath the relevant form input field.
- **Input Preservation**: `old('field')` preserves data during validation redirects.

---

## Screenshots

> Visual layout and interface architecture:

- **Sign In Portal**: Modern two-panel login with developer attribution, feature highlights, and responsive controls.
- **Workforce Analytics Dashboard**: 4 KPI cards and 4 responsive D3.js charts with real MySQL synchronization.
- **Employee Directory**: Filterable and searchable data table with gender badges, pagination, and quick action buttons.
- **Delete Confirmation Modal**: Alpine.js backdrop modal requiring explicit confirmation prior to removal.

---

## Installation

Follow these steps to set up and run the application locally:

### 1. Clone Repository

```bash
git clone https://github.com/deakusuma05/Website-Sistem-Informasi-Pegawai.git
cd Website-Sistem-Informasi-Pegawai
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM packages
npm install
```

### 3. Environment Configuration

```bash
# Copy example environment file
cp .env.example .env

# Generate application encryption key
php artisan key:generate
```

Configure your `.env` database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pegawai_app
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Migration & Seeding

```bash
# Run migrations and seed default administrative/standard accounts & demo employees
php artisan migrate:fresh --seed
```

### 5. Compile Assets & Launch Development Server

```bash
# Compile frontend assets
npm run build

# Start local server
php artisan serve
```

Visit the application at: `http://127.0.0.1:8000`

---

## Testing / QA

The project includes an automated test suite spanning 64 feature and unit tests with 261 assertions:

```bash
php artisan test
```

### Test Coverage Highlights

- **AuthenticationTest**: Login, logout, registration, remember-me persistence, and credential validation.
- **RoleAuthorizationTest**: Strict verification of admin privileges and 403 Forbidden responses for unauthorized standard users.
- **EmployeeCrudTest**: Complete lifecycle testing for Store, Show, Edit, Update, and Destroy operations.
- **EmployeeValidationTest**: Edge-case validation testing for all required fields, age bounds, phone formatting, and invalid inputs.
- **DeleteConfirmationTest**: Modal rendering verification, cancel scenario safety, and confirmed deletion dispatching.
- **DashboardTest**: Real-time KPI synchronization and D3.js dataset structure matching database state.
- **LoginPageFinalContentTest**: Brand identity, non-clipping layout, and developer attribution verification.
- **NavigationTest**: Fixed sidebar positioning, mobile drawer triggers, and local storage state persistence.

---

## Deployment

For production environments (e.g. Railway, Render, VPS):

1. Set environment variables:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY=<your-app-key>`
   - `APP_URL=https://your-domain.com`
   - Database connection credentials (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
2. Run database migration:
   ```bash
   php artisan migrate --force
   ```
3. Optimize configuration and route caching:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Build production assets:
   ```bash
   npm run build
   ```

---

## License

This project is open-source and developed for academic coursework demonstration.
