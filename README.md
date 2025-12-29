# Task Manager Laravel

Applicazione CRUD completa per gestione task con autenticazione utente, dashboard statistiche e filtri avanzati.

## Stack Tecnologico

- Laravel 11
- PHP 8.3
- MySQL 8.0
- Tailwind CSS 3
- Blade Templates
- Nginx

## Features

✅ Autenticazione utente (Laravel Breeze)
✅ CRUD completo task
✅ Dashboard con statistiche real-time
✅ Filtri per stato (completed/pending/all)
✅ Filtri per categoria
✅ Sistema categorie personalizzate
✅ Design responsive Tailwind CSS
✅ Validazione form lato server

## Demo Live

🔗 **http://159.69.125.94:8080/tasks**

Registrati per testare l'applicazione completa.

## Screenshot

### Dashboard
![Dashboard con statistiche task completati, pending e totali]

### Lista Task
![Vista lista task con filtri per stato e categoria]

## Installazione

### 1. Clone repository
```bash
git clone https://github.com/ferdinandociotola/task-manager.git
cd task-manager
```

### 2. Installa dipendenze
```bash
composer install
npm install
```

### 3. Configura environment
```bash
cp .env.example .env
php artisan key:generate
```

Modifica `.env`:
```env
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=tua_password
```

### 4. Database setup
```bash
php artisan migrate
```

### 5. Compila assets
```bash
npm run build
```

### 6. Avvia server
```bash
php artisan serve
```

Applicazione disponibile su: `http://127.0.0.1:8000`

---

## Utilizzo

### 1. Registrazione / Login

Accedi alla homepage e registra un nuovo account o effettua login.

### 2. Crea Task

Clicca "New Task" e compila:
- **Title**: Nome task
- **Description**: Descrizione dettagliata (opzionale)
- **Category**: Seleziona categoria
- **Status**: Pending / Completed

### 3. Gestisci Task

- **Edit**: Modifica titolo, descrizione, categoria, status
- **Delete**: Elimina task
- **Toggle Status**: Marca completed/pending con checkbox

### 4. Filtri

Dashboard include filtri:
- **All**: Tutti i task
- **Completed**: Solo completati
- **Pending**: Solo da fare
- **By Category**: Filtra per categoria specifica

### 5. Statistiche

Dashboard mostra:
- Task totali
- Task completati
- Task pending
- Percentuale completamento

---

## Database Schema

### users
- id
- name
- email
- password
- created_at
- updated_at

### tasks
- id
- user_id (FK → users)
- title
- description
- status (pending/completed)
- category_id (FK → categories)
- created_at
- updated_at

### categories
- id
- name
- user_id (FK → users)
- created_at
- updated_at

---

## Tech Stack Dettaglio

**Backend:**
- Laravel 11 (PHP 8.3)
- MySQL 8.0
- Laravel Breeze (authentication)
- Eloquent ORM

**Frontend:**
- Blade Templates
- Tailwind CSS 3
- Alpine.js (interattività)

**DevOps:**
- Nginx
- Ubuntu 24.04
- Git/GitHub

---

## Caratteristiche Tecniche

**Sicurezza:**
- CSRF protection
- Password hashing (bcrypt)
- SQL injection protection (Eloquent)
- XSS protection (Blade escaping)

**Performance:**
- Eager loading relazioni
- Query optimization
- Asset compilation (Vite)

**UX:**
- Design responsive mobile-first
- Feedback real-time
- Form validation
- Messages flash

---

## Autore

Ferdinando Ciotola - [GitHub](https://github.com/ferdinandociotola) | [LinkedIn](https://linkedin.com/in/ferdinando-ciotola)

---

## License

MIT
