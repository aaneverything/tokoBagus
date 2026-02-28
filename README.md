# 🛒 SPP — E-Commerce Backend

Backend API dan Admin Panel untuk aplikasi e-commerce, dibangun dengan **Laravel 12**, **Filament v5**, dan **Laravel Sanctum**.

---

## 📋 Tech Stack

| Teknologi    | Versi | Kegunaan                         |
| ------------ | ----- | -------------------------------- |
| **Laravel**  | 12    | Framework backend                |
| **Filament** | 5     | Admin panel                      |
| **Sanctum**  | 4     | API authentication (token-based) |
| **Fortify**  | 1.x   | Auth scaffolding + 2FA           |
| **SQLite**   | -     | Database default                 |

---

## ⚡ Quick Start

### Installation

```bash
# Clone repo
git clone <repository-url>
cd spp

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Jalankan migrasi database
php artisan migrate

# Build frontend assets
npm run build
```

### Running

```bash
# Development mode (server + queue + vite + logs)
composer dev

# Atau jalankan server saja
php artisan serve
```

## 🔌 API Endpoints

Base URL: `http://localhost:8000`

Header untuk authenticated routes:

```
Authorization: Bearer <token>
```

---

### `POST /api/register`

Registrasi user baru.

**Request Body:**

```json
{
    "name": "John Doe",
    "username": "johndoe",
    "email": "john@example.com",
    "phone": "081234567890",
    "password": "password123"
}
```

| Field      | Type   | Required | Rule            |
| ---------- | ------ | -------- | --------------- |
| `name`     | string | ✅       | max:255         |
| `username` | string | ✅       | max:255, unique |
| `email`    | string | ✅       | email, unique   |
| `phone`    | string | ❌       | max:255         |
| `password` | string | ✅       | min:8           |

**Response (200):**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Registrasi berhasil"
    },
    "data": {
        "access_token": "1|abc123...",
        "token_type": "Bearer",
        "user": {
            "id": 1,
            "name": "John Doe",
            "username": "johndoe",
            "email": "john@example.com",
            "phone": "081234567890",
            "roles": "user"
        }
    }
}
```

---

### `POST /api/login`

Login dan dapatkan token.

**Request Body:**

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**

```json
{
    "meta": { "code": 200, "status": "success", "message": "Authenticated" },
    "data": {
        "access_token": "2|xyz789...",
        "token_type": "Bearer",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "...": "..."
        }
    }
}
```

**Response (401):**

```json
{
    "meta": {
        "code": 401,
        "status": "error",
        "message": "Login gagal, email atau password salah"
    },
    "data": { "message": "Unauthorized" }
}
```

---

### `GET /api/product`

Daftar semua produk dengan filter.

**Query Parameters:**

| Param         | Type    | Deskripsi                        |
| ------------- | ------- | -------------------------------- |
| `id`          | int     | Ambil 1 produk by ID             |
| `limit`       | int     | Jumlah per halaman (default: 10) |
| `name`        | string  | Filter by nama (LIKE)            |
| `description` | string  | Filter by deskripsi (LIKE)       |
| `tags`        | string  | Filter by tags (LIKE)            |
| `categories`  | int     | Filter by category ID            |
| `price_from`  | numeric | Harga minimum                    |
| `price_to`    | numeric | Harga maksimum                   |

**Response (200) — by ID:**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Data produk berhasil diambil"
    },
    "data": {
        "id": 1,
        "name": "Produk A",
        "price": 150000,
        "description": "Deskripsi produk",
        "tags": "elektronik",
        "categories_id": 1,
        "category": { "id": 1, "name": "Elektronik" },
        "galleries": [{ "id": 1, "url": "path/to/image.jpg", "products_id": 1 }]
    }
}
```

**Response (200) — list (paginated):**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Data produk berhasil diambil"
    },
    "data": {
        "current_page": 1,
        "data": [{ "...": "..." }],
        "last_page": 5,
        "per_page": 10,
        "total": 50
    }
}
```

---

### `GET /api/categories`

Daftar semua kategori.

**Query Parameters:**

| Param          | Type   | Deskripsi                                   |
| -------------- | ------ | ------------------------------------------- |
| `id`           | int    | Ambil 1 kategori by ID (include products)   |
| `limit`        | int    | Jumlah per halaman (default: 10)            |
| `name`         | string | Filter by nama (LIKE)                       |
| `show_product` | any    | Jika ada, tampilkan produk di tiap kategori |

**Response (200):**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Data kategori berhasil diambil"
    },
    "data": {
        "current_page": 1,
        "data": [{ "id": 1, "name": "Elektronik", "products": ["..."] }]
    }
}
```

---

### 🔒 `GET /transactions`

Daftar transaksi user yang login.

**Query Parameters:**

| Param    | Type   | Deskripsi                                         |
| -------- | ------ | ------------------------------------------------- |
| `id`     | int    | Ambil 1 transaksi by ID (include items & product) |
| `limit`  | int    | Jumlah per halaman                                |
| `status` | string | Filter by status                                  |

**Response (200):**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Data transaksi berhasil diambil"
    },
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "users_id": 1,
                "address": "Jl. Contoh No. 123",
                "payment": "manual",
                "total_price": 300000,
                "shipping_price": 15000,
                "status": "pending",
                "items": [
                    {
                        "id": 1,
                        "products_id": 1,
                        "quantity": 2,
                        "product": {
                            "id": 1,
                            "name": "Produk A",
                            "price": 150000
                        }
                    }
                ]
            }
        ]
    }
}
```

---

### 🔒 `POST /checkout`

Buat transaksi baru.

**Request Body:**

```json
{
    "address": "Jl. Contoh No. 123",
    "items": [
        { "id": 1, "quantity": 2 },
        { "id": 3, "quantity": 1 }
    ],
    "total_price": 450000,
    "shipping_price": 15000,
    "status": "pending"
}
```

| Field              | Type    | Required | Rule                                                              |
| ------------------ | ------- | -------- | ----------------------------------------------------------------- |
| `items`            | array   | ✅       | Array of objects                                                  |
| `items.*.id`       | int     | ✅       | Harus ada di tabel products                                       |
| `items.*.quantity` | int     | ✅       | Jumlah item                                                       |
| `total_price`      | numeric | ✅       |                                                                   |
| `shipping_price`   | numeric | ✅       |                                                                   |
| `status`           | string  | ✅       | `pending`, `shipping`, `success`, `canceled`, `failed`, `shipped` |

**Response (200):**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Checkout berhasil"
    },
    "data": {
        "id": 1,
        "users_id": 1,
        "address": "Jl. Contoh No. 123",
        "total_price": 450000,
        "shipping_price": 15000,
        "status": "pending",
        "items": [
            {
                "id": 1,
                "products_id": 1,
                "quantity": 2,
                "product": { "...": "..." }
            },
            {
                "id": 2,
                "products_id": 3,
                "quantity": 1,
                "product": { "...": "..." }
            }
        ]
    }
}
```

---

### 🔒 `POST /updateUser`

Update profil user yang login.

**Request Body:**

```json
{
    "name": "John Updated",
    "username": "johnupdated",
    "email": "john.new@example.com",
    "phone": "089876543210"
}
```

| Field      | Type   | Required | Rule                           |
| ---------- | ------ | -------- | ------------------------------ |
| `name`     | string | ✅       | max:255                        |
| `username` | string | ✅       | max:255, unique (exclude self) |
| `email`    | string | ✅       | email, unique (exclude self)   |
| `phone`    | string | ❌       | max:255                        |

**Response (200):**

```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Profile berhasil diupdate"
    },
    "data": {
        "id": 1,
        "name": "John Updated",
        "username": "johnupdated",
        "email": "john.new@example.com",
        "phone": "089876543210",
        "roles": "user"
    }
}
```

---

### 🔒 `POST /logout`

Logout dan revoke token.

**Request Body:** Tidak perlu body.

**Response (200):**

```json
{
    "meta": { "code": 200, "status": "success", "message": "Logout berhasil" },
    "data": null
}
```

---

## 📝 License

MIT
