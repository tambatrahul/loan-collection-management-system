# Loan Collection Management System - Backend (Laravel)

A production-ready REST API for managing loan collections, built with Laravel 12. The system supports authentication, role-based access, customer and loan management, collection tracking, dashboard analytics, and best collection time prediction.

---

## 🚀 Tech Stack

| Layer | Technology |
|------|------|
| Backend | Laravel 12 |
| Authentication | Laravel Sanctum |
| Database | MySQL |
| API | RESTful JSON APIs |
| Testing | PHPUnit |
| Architecture | Modular Architecture + Repository Pattern |
| Queue/Jobs | Laravel Queue |
| Documentation | Postman Collection |

---

## 📌 Features Implemented

### 1. Authentication
- Login API
- Logout API
- Authenticated User Profile (`/me`)
- Role-based access:
  - Admin
  - Field Agent

### 2. Customer Management
- Create Customer
- Update Customer
- View Customer
- List Customers with pagination and filters
- Assign customer to field agent

### 3. Loan Management
- Create Loan
- View Loan
- List Loans with pagination and filters
- Track EMI amount, total amount, and status

### 4. Collection Management
- Add Collection Entry
- Payment modes:
  - Cash
  - UPI
  - Card
- Optional location capture
- Collection timestamp
- Validation to ensure amount does not exceed pending amount

### 5. Dashboard APIs
- Total Loans
- Total Collected Today
- Pending Amount
- Collection by Payment Mode
- Best Collection Time Prediction

### 6. Advanced Analytics
- Analyze historical collections
- Predict best 2-hour slot for collection
- Refresh analytics via background job

### 7. Database Seeders
- Admin and Field Agents
- Customers
- Loans
- Collections

### 8. Automated Testing
Feature tests for:
- Authentication
- Customers
- Loans
- Collections
- Dashboard

---

## 🏗 Architecture

The application follows a modular architecture:

```text
app/
└── Modules/
    ├── Auth/
    ├── Customer/
    ├── Loan/
    ├── Collection/
    └── Dashboard/
```

Each module contains:
- Controllers
- Services
- Repositories
- Interfaces
- Requests
- Resources
- Models
- Providers

---

## 🗄 Database Relationships

```text
users
  └── hasMany customers (assigned_to)

customers
  └── hasMany loans

loans
  └── hasMany collections

collections
  └── belongsTo loan
```

### Ownership Flow

```text
Customer.assigned_to      -> Agent
Loan.created_by           -> Same Agent
Collection.collected_by   -> Same Agent
```

---

## 📈 Best Collection Time Prediction

The system analyzes collection data from the last 30 days and groups collections into 2-hour slots (e.g. 08:00–10:00, 10:00–12:00). The slot with the highest collection frequency and total collected amount is returned as the recommended time to visit customers.

### Approaches Considered

#### 1. Rule-Based Analysis (Implemented)

This approach aggregates historical collection records and identifies the 2-hour slot with:

- The highest number of successful collections.
- The highest total amount collected.

**Advantages:**

- Simple and highly interpretable.
- Fast to compute using SQL aggregation.
- No external dependencies.
- Easy to maintain and explain.

**Disadvantages:**

- Does not capture advanced behavioral patterns.

---

#### 2. Python-Based Prediction (Optional Bonus)

As suggested in the assignment, all historical collection data can be exported and passed to a Python script or machine learning model. The script would process the data and return the most effective collection time slot.

**Input:**

- Historical collection records.

**Output:**

- Predicted best 2-hour collection slot.

**Advantages:**

- Can uncover more complex patterns.
- Suitable for future enhancement.

**Disadvantages:**

- Requires a Python runtime and additional dependencies.
- Increases deployment and maintenance complexity.
- More difficult to explain and validate within a short assessment timeline.

---

#### 3. Real-Time Query on Collections Table

The application could execute the aggregation query directly on the `collections` table every time the dashboard endpoint is called.

**Advantages:**

- Always uses the latest data.
- No additional storage required.

**Disadvantages:**

- Recomputes the same aggregates repeatedly.
- Becomes slower as historical data grows.
- Adds unnecessary load to the database.

---

### Why the Implemented Approach Was Chosen

The implemented solution combines the simplicity of rule-based analysis with the performance benefits of precomputed analytics.

Instead of recalculating the full aggregation on every dashboard request, a background job summarizes the collection data into the `collection_time_analytics` table. The dashboard API then reads directly from this table to retrieve the best collection slot.

This approach was chosen because:

- It is fully data-driven.
- It avoids expensive recalculation on every request.
- It scales well as the `collections` table grows.
- It is easy to understand and maintain.
- It requires no external dependencies.
- It aligns with the assignment’s focus on query optimization and analytical thinking.

### Why Recalculation Is Limited to Today and Yesterday

Historical collection data older than yesterday does not change. Therefore, the analytics refresh job only rebuilds data for:

- Today
- Yesterday

This ensures:

- Minimal processing time.
- Reduced database load.
- Near real-time accuracy.

---

### Future Enhancement Path

The current analytics table can later serve as the input dataset for a Python machine learning model if more advanced predictive capabilities are required, without changing the existing API contract.

---

## ⚙️ Installation & Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd loan-collection-management-backend-laravel
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

```bash
cp .env.example .env
```

Update `.env` with your database credentials.

### 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

### 5. Start Development Server

```bash
php artisan serve
```

API will be available at:

```text
http://127.0.0.1:8000/api/v1
```

---

## 🔑 Default Seeded Users

### Admin
| Email | Password |
|------|------|
| admin@example.com | password |

### Field Agent
| Email | Password |
|------|------|
| agent@example.com | password |

---

## 🧪 Running Tests

```bash
php artisan test --env=testing
```

---

## 🔄 Queue Job

To process queued jobs:

```bash
php artisan queue:work
```

---

## 📮 API Documentation

The Postman collection is included in:

```text
postman/Loan Collection Management.postman_collection.json
```

---

## 📌 Key API Endpoints

### Authentication
- `POST /auth/login`
- `POST /auth/logout`
- `GET /auth/me`

### Users
- `GET /users/agents`

### Customers
- `GET /customers`
- `POST /customers`
- `GET /customers/{id}`
- `PUT /customers/{id}`

### Loans
- `GET /loans`
- `POST /loans`
- `GET /loans/{id}`

### Collections
- `GET /collections`
- `POST /collections`

### Dashboard
- `GET /dashboard/summary`
- `GET /dashboard/best-collection-time`

---

## 📝 Assumptions

1. Each customer is assigned to one field agent.
2. Each loan belongs to one customer.
3. Field agents can access only their assigned customers and related loans/collections.
4. Admin users can access all records.
5. Loan status is updated based on collection progress.

---

## ⚡ Optimization & Design Decisions

- Repository and Service pattern for maintainability.
- Query optimization using aggregate functions and relationship filtering.
- Analytics table for precomputed prediction results.
- Background job recalculates only today and yesterday’s analytics.
- Feature tests ensure application stability.
