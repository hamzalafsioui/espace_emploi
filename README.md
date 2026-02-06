# 🚀 Espace Emploi - Recruitment Platform

Espace Emploi is a modern, premium recruitment platform designed to seamlessly connect recruiters with top talent. Built with the TALL stack (Tailwind, Alpine, Laravel, Livewire), it offers a fast, interactive, and secure experience for all users.

---

## ✨ Key Features

### 👤 User Management & Profiles

- **Multi-role Support**: Separate workflows for **Recruiters** and **Job Seekers**.
- **Professional Profiles**: Job seekers can showcase their education, work experience, and technical skills.
- **CV Management**: Easy upload and management of professional resumes.

### 💼 Job Marketplace

- **Recruiter Dashboard**: Create, edit, and track job offers with ease.
- **Smart Search**: Powerful search engine to find the right jobs or candidates.
- **Easy Applications**: Fast-track application process for job seekers.

### 🤝 Social Connectivity

- **Friendship System**: Connect with other professionals in the industry.
- **Notifications**: Stay updated on application statuses and connection requests.

### 🔒 Enterprise-Grade Security

- **RBAC (Role-Based Access Control)**: Powered by `spatie/laravel-permission` for strict access management.
- **Secure Authentication**: Built on Laravel's robust authentication system.

---

## 🛠️ Technology Stack

- **Framework**: [Laravel 12.x](https://laravel.com)
- **Frontend**: [Livewire 3.x](https://livewire.laravel.com) & [Tailwind CSS](https://tailwindcss.com)
- **Database**: MySQL / PostgreSQL
- **Permissions**: [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)

---

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js & NPM

### Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd espace_emploi
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Environment Setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database Migration & Seeding**

    ```bash
    # Run migrations
    php artisan migrate

    # Important: Seed roles and permissions
    php artisan db:seed --class=RolePermissionSeeder
    ```

5. **Build Assets**

    ```bash
    npm run dev
    ```

6. **Start the Server**
    ```bash
    php artisan serve
    ```

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).
