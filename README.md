# Jangu International — Questionnaire Application

A Laravel application for managing program applications with a public submission form and an admin dashboard. Built with Livewire, Flux UI, and Laravel Fortify.

## Features

- **Public Application Form** — Dynamic form rendered from database fields (text, email, phone, textarea, date, select, radio, checkbox, consent). Fields are grouped into sections (Personal Info, Emergency Contact, Motivation).
- **Admin Dashboard** (`/responses`) — Tabbed interface with:
  - **Responses tab**: Stats cards (total, pending, weekly, gender), distribution charts (education, gender, how they heard), searchable/sortable/paginated table, status management, inline editing of submission data, export to Excel and PDF.
  - **Form Fields tab**: Full CRUD for form fields — reorder, toggle active, edit labels/types/options.
- **Email Notification** — Sends a notification to `info@janguinternational.org` on each new submission (requires SMTP configuration).
- **Dark Mode** — Full dark mode support via Flux UI.

## Requirements

- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL (or any database supported by Laravel)

## Installation

```bash
git clone https://github.com/omaadonyo/jangu-international-questionnaire.git
cd jangu-international-questionnaire

# Install PHP dependencies
composer install

# Install and build frontend assets
npm install
npm run build

# Copy environment file and configure database
cp .env.example .env
# Edit .env with your database credentials and APP_URL

# Generate app key
php artisan key:generate

# Run migrations and seeders
php artisan migrate
php artisan db:seed

# Start the dev server
php artisan serve
```

## Default Login

- **Email:** `test@example.com`
- **Password:** (set by Laravel's default user factory — check `database/factories/UserFactory.php`)

## Mail Configuration

To enable email notifications on new submissions, set your SMTP credentials in `.env`:

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## Tech Stack

- **Laravel 13** — PHP framework
- **Livewire 4 + Blaze** — Dynamic UI components
- **Flux UI 2** — Component library (open-source tier)
- **Laravel Fortify** — Authentication scaffolding
- **Laravel Excel** — Excel export
- **Laravel DOMPDF** — PDF export
- **MySQL** — Database
- **Tailwind CSS v4** — Styling

## License

MIT
