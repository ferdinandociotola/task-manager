# Task Manager Laravel

Applicazione CRUD completa per gestione task con autenticazione utente.

## Features
- Autenticazione utente (login/registrazione)
- CRUD task completo
- Dashboard con statistiche
- Filtri per categoria e stato
- Design responsive Tailwind CSS

## Tech Stack
- PHP 8.3
- Laravel 11
- MySQL 8.0
- Tailwind CSS
- Blade Templates

## Demo
http://159.69.125.94:8080/tasks

## Setup Locale
```bash
git clone [repo-url]
cd task-manager
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
