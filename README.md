# SPK Skripsi Backend (Laravel API)

Backend REST API untuk **Sistem Pendukung Keputusan (SPK) Penentuan Topik Skripsi Mahasiswa Jurusan TIK Prodi TI PNJ** menggunakan metode **WASPAS (Weighted Aggregated Sum Product Assessment)**.

## Tech Stack

- Laravel 12+
- MySQL
- Laravel Sanctum Authentication
- Spatie Permission (Role & Permission)
- REST API
- WASPAS Method

---

## Features

### Mahasiswa / User

- Register + Data Mahasiswa
- Login
- Logout
- Profile Mahasiswa
- Isi Kuesioner Penilaian Topik Skripsi
- Hasil Rekomendasi Topik Skripsi
- Detail Perhitungan WASPAS
- Riwayat Hasil Rekomendasi

### Admin

- Dashboard Monitoring
- CRUD Kriteria
- CRUD Alternatif (Topik Skripsi)
- CRUD Nilai Alternatif Kriteria
- CRUD Mahasiswa
- Monitoring Riwayat Pengguna
- Monitoring Hasil Rekomendasi
- Role-based Access Control

---

## Installation

Clone repository:

```bash
git clone https://github.com/Dbagustri/spk-skripsi-be.git
cd spk-skripsi-be
```

Install dependency:

```bash
composer install
```

Copy environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Setup database pada file `.env`

Run migration + seeder:

```bash
php artisan migrate --seed
```

Run server:

```bash
php artisan serve
```

---

## Default Account

### Admin

```text
Email    : admin@gmail.com
Password : admin12345
```

### Mahasiswa

```text
Email    : user@gmail.com
Password : user12345
```

---

# API Documentation

Base URL:

```text
http://127.0.0.1:8000/api
```

---

# Authentication

## Register

Mendaftarkan akun mahasiswa sekaligus membuat data `student_profile`.

### Endpoint

```http
POST /auth/register
```

### Request Body

```json
{
    "name": "Diandra Bagustri",
    "email": "diandra@mail.com",
    "password": "password123",
    "password_confirmation": "password123",
    "nim": "2207411001",
    "semester": 8,
    "ipk": 3.75,
    "minat": "Software Engineer"
}
```

### Response

```json
{
    "success": true,
    "message": "Register berhasil",
    "data": {
        "token": "TOKEN",
        "user": {
            "id": 1,
            "name": "Diandra Bagustri",
            "email": "diandra@mail.com",
            "role": ["user"]
        }
    }
}
```

---

## Login

### Endpoint

```http
POST /auth/login
```

### Request Body

```json
{
    "email": "user@gmail.com",
    "password": "user12345"
}
```

---

## Profile

### Endpoint

```http
GET /auth/profile
```

### Header

```text
Authorization:
Bearer TOKEN
```

### Response

```json
{
    "success": true,
    "data": {
        "id": 2,
        "name": "Mahasiswa",
        "email": "user@gmail.com",
        "role": ["user"],
        "student_profile": {
            "nim": "2207411001",
            "semester": 8,
            "ipk": 3.75,
            "minat": "Software Engineer"
        }
    }
}
```

---

## Logout

### Endpoint

```http
POST /auth/logout
```

---

# User API

Semua endpoint berikut membutuhkan token:

```text
Authorization:
Bearer TOKEN
```

---

## Get Me

### Endpoint

```http
GET /me
```

---

## Get Criteria

### Endpoint

```http
GET /criteria
```

---

## Get Alternatives

### Endpoint

```http
GET /alternatives
```

---

# Questionnaire

## Get Questionnaire

### Endpoint

```http
GET /questionnaire
```

---

## Submit Questionnaire

### Endpoint

```http
POST /questionnaire
```

### Request Body

```json
{
    "answers": [
        {
            "alternative_id": 1,
            "criteria_id": 1,
            "nilai": 4
        },
        {
            "alternative_id": 1,
            "criteria_id": 2,
            "nilai": 5
        }
    ]
}
```

---

# Recommendation (WASPAS)

## Calculate Recommendation

Menghitung rekomendasi topik skripsi menggunakan metode WASPAS.

### Endpoint

```http
POST /recommendation
```

---

## Latest Recommendation

### Endpoint

```http
GET /recommendation/latest
```

---

## Detail Recommendation

Menampilkan detail perhitungan metode WASPAS.

### Endpoint

```http
GET /recommendation/detail
```

---

## Recommendation History

### Endpoint

```http
GET /recommendation/history
```

---

## Recommendation History Detail

### Endpoint

```http
GET /recommendation/history/{id}
```

---

# Admin API

Admin only:

```text
Middleware:
auth:sanctum
role:admin
```

---

## Dashboard Data

### Get Users

```http
GET /admin/users
```

### Get Results

```http
GET /admin/results
```

### Get History

```http
GET /admin/history
```

---

## Criteria CRUD

```http
GET    /admin/criteria
POST   /admin/criteria
PUT    /admin/criteria/{id}
DELETE /admin/criteria/{id}
```

---

## Alternatives CRUD

```http
GET    /admin/alternatives
POST   /admin/alternatives
PUT    /admin/alternatives/{id}
DELETE /admin/alternatives/{id}
```

---

## Alternative Criteria CRUD

Digunakan untuk mengelola nilai sistem terhadap alternatif berdasarkan kriteria admin.

### Endpoint

```http
GET    /admin/alternative-criteria
POST   /admin/alternative-criteria
PUT    /admin/alternative-criteria/{id}
DELETE /admin/alternative-criteria/{id}
```

---

## Student Management

### Get Students

```http
GET /admin/students
```

### Create Student

```http
POST /admin/students
```

### Update Student

```http
PUT /admin/students/{id}
```

### Delete Student

```http
DELETE /admin/students/{id}
```

---

# WASPAS Formula

Sistem menggunakan metode **WASPAS (Weighted Aggregated Sum Product Assessment)**.

Perhitungan akhir:

Qᵢ = 0.5(Q1) + 0.5(Q2)

Keterangan:

- **Q1** = Weighted Sum Model (WSM)
- **Q2** = Weighted Product Model (WPM)

### Benefit Criteria

Normalisasi:

```text
xij / max(xij)
```

### Cost Criteria

Normalisasi:

```text
min(xij) / xij
```

---

## Project Structure

```text
app/
├── Http/Controllers/Api
│   ├── Admin
│   ├── AuthController.php
│   ├── QuestionnaireController.php
│   ├── RecommendationController.php
│   └── StudentProfileController.php
│
├── Models
│   ├── Alternative.php
│   ├── Criteria.php
│   ├── StudentProfile.php
│   ├── QuestionnaireAnswer.php
│   ├── RecommendationResult.php
│   └── AlternativeCriteria.php
```

---

## Author

**Diandra Bagustri**

Sistem Pendukung Keputusan Topik Skripsi Mahasiswa menggunakan metode WASPAS.
