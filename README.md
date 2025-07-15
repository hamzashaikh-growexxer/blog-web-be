<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License: MIT">
  </a>
</p>

---

# Laravel Blog API

A RESTful **Laravel 8.83.29** backend for a blog system, following clean architecture using the **Repository Pattern**, **Resource Controllers**, and **Form Requests**. The API supports full **CRUD operations** including blog creation with multiple image uploads, update, delete, and image management.

---

## 🚀 Features

-   Laravel 8 RESTful API
-   CRUD operations for blog posts
-   Repository pattern for clean and scalable architecture
-   Form request validation
-   Resource controllers and routes
-   Upload multiple images per blog post
-   Delete individual images from blog post
-   Uses Laravel Storage for file handling
-   MySQL database integration
-   CORS-ready for frontend integration

---

## 🧰 Tech Stack

| Component          | Description                                    |
| ------------------ | ---------------------------------------------- |
| Laravel 8.83.29    | PHP framework used for building the API        |
| MySQL              | Relational database for storing blog data      |
| Laravel Storage    | File system abstraction to store blog images   |
| Repository Pattern | Business logic separated from controller logic |
| Form Requests      | For validating incoming API data               |

---

## 📁 Project Structure Highlights

```bash
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── BlogController.php
│   ├── Requests/
│   │   └── BlogRequest.php
├── Models/
│   └── Blog.php
├── Repositories/
│   ├── BlogRepositoryInterface.php
│   └── BlogRepository.php
routes/
└── api.php
```

---

## 📦 Installation & Setup

### Prerequisites

-   PHP >= 7.4
-   Composer
-   MySQL
-   Laravel 8
-   Laravel Storage link: `php artisan storage:link`

### Clone the repository

```bash
git clone https://github.com/hamzashaikh-growexxer/blog-web-be
cd blog-web-be
```

### Install dependencies

```bash
composer install
```

### Environment configuration

```bash
cp .env.example .env
```

### Run migrations

```bash
php artisan migrate
```

### Start the development server

```bash
php artisan serve
```

### Laravel app will run at:

```bash
http://localhost:8000
```
