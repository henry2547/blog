# Blog Application

This project is a Laravel-based blog application with user authentication, post management, comments, likes, follows, and a dashboard. It uses Laravel, Livewire, Flux, Vite, and WorkOS authentication.

## Features

- User authentication and dashboard
- Create, edit, publish, and manage blog posts
- Draft posts and view post statistics
- Comments and likes on posts
- Follow users and view profiles
- Modern UI powered by Tailwind and Vite

## Requirements

Before installing, make sure you have the following installed:

- PHP 8.3 or newer
- Composer
- Node.js and npm
- A database such as SQLite, MySQL, or PostgreSQL

## Download and Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/henry2547/blog.git
   cd blog
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Create your environment file:

   ```bash
   cp .env.example .env
   ```

4. Generate the application key:

   ```bash
   php artisan key:generate
   ```

5. Set up the database:

   - If you are using SQLite, create the database file:

     ```bash
     touch database/database.sqlite
     ```

   - Then run migrations:

     ```bash
     php artisan migrate
     ```

6. Install frontend dependencies:

   ```bash
   npm install
   ```

7. Build the frontend assets:

   ```bash
   npm run build
   ```

8. Start the application:

   ```bash
   php artisan serve
   ```

9. Open your browser and visit:

   ```text
   http://localhost:8000
   ```

## Optional Development Mode

For live frontend development with Vite:

```bash
npm run dev
```

Run this in a separate terminal while the Laravel server is running.

## Authentication Setup

This project uses WorkOS for authentication. If you want the sign-in flow to work locally, add your WorkOS credentials to the `.env` file:

```env
WORKOS_CLIENT_ID=your-client-id
WORKOS_API_KEY=your-api-key
WORKOS_REDIRECT_URL="http://localhost:8000/authenticate"
```

## Testing

To run the application tests:

```bash
php artisan test
```

## Contact

For questions or support, contact:

Email: henrynjue255@gmail.com
