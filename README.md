# Computer Shop Management System

A comprehensive management system for a computer retail and repair shop, built with a decoupled architecture featuring a Laravel REST API backend and a modern frontend client.

---

## Repository Structure

```text
computer-shop-management-system/
├── backend/                      # Laravel 8 REST API
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/Api/  # Dedicated API Controllers
│   │   │   ├── Requests/         # Form Request Validations
│   │   │   └── Resources/        # API Resources / JSON Transformers
│   │   └── Models/               # Eloquent Models (28 Tables)
│   ├── config/
│   │   └── cors.php              # CORS configuration for Frontend requests
│   ├── database/
│   │   ├── migrations/           # Database schema migrations
│   │   └── seeders/              # Database seeders with test data
│   ├── routes/
│   │   └── api.php               # REST API endpoints
│   ├── .env.example              # Backend environment template
│   ├── composer.json
│   └── artisan
│
├── frontend/                     # Frontend Application (React / Vite)
│   ├── public/                   # Static assets & favicons
│   ├── src/
│   │   ├── api/                  # Centralized Axios client & API services
│   │   │   ├── axios.js          # Base URL & Auth interceptors
│   │   │   ├── auth.api.js       # Auth endpoints
│   │   │   ├── product.api.js    # Product catalog endpoints
│   │   │   ├── pos.api.js        # POS checkout & receipt endpoints
│   │   │   └── repair.api.js     # Repair service endpoints
│   │   ├── assets/               # CSS styles & images
│   │   ├── components/           # Reusable UI components
│   │   ├── context/              # Global state (Auth, POS Cart)
│   │   ├── layouts/              # App & Dashboard layouts
│   │   ├── routes/               # Route definitions & guards
│   │   └── views/                # Views for the 16 Functional Modules
│   │       ├── auth/             # Login, Profile, Password
│   │       ├── dashboard/        # Metrics & Charts
│   │       ├── products/         # Catalog & Barcodes
│   │       ├── pos/              # POS Terminal & Billing
│   │       ├── repairs/          # Repair lifecycle tracking
│   │       ├── inventory/        # Stock management
│   │       ├── warranties/       # Warranty claims
│   │       ├── reports/          # Report exports
│   │       └── settings/         # System settings
│   ├── .env.example              # Frontend environment template
│   └── package.json
│
├── docs/                         # Shared project specifications & assets
│   ├── database/                 # Database ERD diagram & schema
│   ├── postman/                  # Postman API Collection
│   └── requirements/             # Functional specifications (Topic 22)
│
├── .gitignore                    # Root ignore file (protects backend & frontend)
└── README.md                     # Project documentation & setup guide
```

---

## 🚀 Getting Started

### 1. Backend Setup (Laravel API)

1. Open your terminal and navigate to `backend/`:
   ```bash
   cd backend
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Configure environment variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Make sure your database settings in `.env` match your MySQL server:*
   ```ini
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=computer_shop_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Run database migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```

5. Start the backend development server:
   ```bash
   php artisan serve
   ```
   *API will run at: `http://127.0.0.1:8000` (e.g. `http://127.0.0.1:8000/api/`)*

---

### 2. Frontend Setup (React / Vite)

1. In a new terminal, navigate to `frontend/`:
   ```bash
   cd frontend
   ```

2. Configure environment:
   ```bash
   cp .env.example .env
   ```

3. Install dependencies and start the dev server:
   ```bash
   npm install
   npm run dev
   ```
   *Frontend will run at: `http://localhost:5173`*

---

### 3. API Documentation & Specifications
- Requirements: [docs/requirements/topic_22_requirements.md](docs/requirements/topic_22_requirements.md)
- Database ERD: [docs/database/](docs/database/)
- Postman Collection: [docs/postman/](docs/postman/)
