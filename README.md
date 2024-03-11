<p align="center"><img src="public/images/lara-surveys.png" width="100" alt="LaraSurveys Logo"></p>


# Lara Surveys

Lara Surveys is a SaaS application developed as a practice project to learn Laravel along with the TALL stack.

 The aim of this application is to offer a platform where companies can create, distribute, and analyze surveys efficiently.

This app allows for multi-tenancy, where each company account acts as a separate tenant.

## About the TALL Stack

The TALL stack is a modern stack of technologies that includes:

- **[Tailwind CSS](https://tailwindcss.com/)**: A utility-first CSS framework for rapidly building custom designs.
- **[Alpine.js](https://alpinejs.dev/)**: A rugged, minimal framework for composing JavaScript behavior in your markup.
- **[Laravel](https://laravel.com/)**: A web application framework with expressive, elegant syntax.
- **[Livewire](https://laravel-livewire.com/)**: A full-stack framework for Laravel that makes building dynamic interfaces simple, without leaving the comfort of Laravel.

## Features

- **Multi-Tenant SaaS App**: Each company account is isolated and acts as a separate tenant.
- **Admin and User Roles**:
  - **Admins** can:
    - Invite or create new users for their company.
    - Create and manage surveys.
    - View and analyze survey reports and response rates.
  - **Users** can:
    - Answer surveys assigned to them.
- **Security**: Default user password is set to "password". In production, it should trigger an email inviting the user to reset their password.

## Requirements

- Docker

## Installation

1. **Env vars**
Replace the `.env.example` with a `.env`

2. **Build the Docker image**:
```bash
docker compose build
```

3. **Start the application** using Docker Compose:
```bash
docker compose up
```

Alternatively, use the provided `./dev` script:
```bash
./dev
```

4. **Set up the database** by running migrations:
```bash
docker exec -it laravel_app php artisan migrate
```

5. **Generate app key**:
```bash
docker exec -it laravel_app php artisan key:generate
```

6. **Enjoy the app**

## Usage

- **Running Tests**: To ensure everything is set up correctly and functioning as expected, run the included tests using the `./test` script:

```bash
./test
```
