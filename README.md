<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

# 🏠 KasKos
### Sistem Informasi KasKos Berbasis Web Sebagai Media Transparansi Keuangan Patungan dan Pemetaan Denah Kamar Digital Internal Penghuni Kos

KasKos merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan keuangan kos secara transparan. Sistem ini menyediakan fitur pencatatan tagihan bersama, pembayaran sewa kamar, denah kamar digital, serta riwayat perpindahan penghuni sehingga pengelolaan kos menjadi lebih mudah, rapi, dan terdokumentasi.

---

# Fitur Utama

## Autentikasi & Hak Akses
- Login
- Register
- Logout
- Role Admin
- Role Penghuni
- Middleware Spatie Permission

---

## Manajemen Kamar
- CRUD Data Kamar
- Status kamar (Kosong / Terisi)
- Harga sewa kamar
- Assign penghuni ke kamar
- Riwayat penghuni kamar
- Relasi Many-to-Many User ↔ Kamar

---

## Denah Kamar Digital
- Tampilan denah kamar seperti denah kursi bioskop
- Klik kamar untuk melihat informasi
- Klaim kamar kosong
- Indikator warna kamar kosong dan terisi

---

## Riwayat Kamar (Rooms History)
Mencatat seluruh aktivitas perpindahan penghuni secara otomatis.

Contoh aktivitas:
- Penghuni masuk kamar
- Penghuni pindah kamar
- Penghuni keluar kamar

---

## Kategori Tagihan
- CRUD kategori
- Listrik
- Air
- WiFi
- Sampah
- Kebersihan
- Gas
- dan kategori lainnya

---

## Tagihan Patungan
Admin dapat membuat tagihan bulanan.

Fitur:
- Total tagihan
- Periode
- Jatuh tempo
- Auto Split ke seluruh penghuni aktif

---

## Pembayaran Patungan
Penghuni dapat:

- Melihat tagihan
- Upload bukti transfer
- Melihat status pembayaran

Admin dapat:

- Verifikasi pembayaran
- Menolak pembayaran
- Memberikan catatan

---

## Pembayaran Sewa Kamar
Pembayaran pribadi untuk biaya sewa kamar.

Fitur:
- Tagihan otomatis berdasarkan harga kamar
- Upload bukti transfer
- Verifikasi Admin
- Riwayat pembayaran

---

## Dashboard

### Dashboard Admin

Menampilkan:

- Total kamar
- Kamar terisi
- Kamar kosong
- Total tagihan
- Pembayaran menunggu verifikasi
- Statistik pembayaran

### Dashboard Penghuni

Menampilkan:

- Informasi kamar
- Tagihan aktif
- Status pembayaran
- Riwayat pembayaran

---

## REST API

API yang tersedia antara lain:

- API Kamar
- API Tagihan
- API Riwayat Kamar

---

# Struktur Database

Beberapa tabel utama:

- users
- roles
- permissions
- kamars
- kamar_user
- rooms_history
- kategori_tagihans
- tagihans
- pembayarans
- pembayaran_sewas

---


# 🛠️ Tech Stack

## Backend

- Laravel 13
- PHP 8.x

## Frontend

- Blade
- Tailwind CSS
- Alpine.js

## Database

- MySQL

## Authentication

- Laravel Breeze

## Authorization

- Spatie Permission

## API

- Laravel Resource API

---

# 📦 Instalasi Project

Clone repository

```bash
git clone https://github.com/username/KasKos.git
```

Masuk ke folder project

```bash
cd KasKos
```

Install dependency

```bash
composer install
```

Install Node Module

```bash
npm install
```

Copy file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Atur database pada file `.env`

```
DB_DATABASE=kaskos
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration

```bash
php artisan migrate
```

Jalankan seeder

```bash
php artisan db:seed
```

Atau

```bash
php artisan migrate:fresh --seed
```

Compile asset

```bash
npm run dev
```

Jalankan server

```bash
php artisan serve
```

Akses aplikasi

```
http://127.0.0.1:8000
```

---

# 👥 Akun Default

## Admin

Username : admin_kaskos
Password : password123

## Tenant

Username : tenant_kaskos
Password : password123

---

# 📷 Screenshot

## Halaman Welcome

[ss]

---

## Login

[ss]
---

## Dashboard Admin

[ss]
---

## Dashboard Penghuni

[ss]
---

## Manajemen Kamar

[ss]
---

## Denah Kamar

[ss]
---

## Tagihan

[ss]
---

## Pembayaran

[ss]
---

# 👨‍💻 Tim Pengembang

| Nama | NIM | Tugas |
|-------|-------|
| Ahnaf Musyaffa | 230102012 | CRUD Kamar & Relasi Kamar |
| Daffa Aqila Riyadi | 230102031 | Denah Kamar & Rooms History |
| Fauzi Maulana Akbar | 230102049 | Kategori Tagihan & Tagihan |
| Melani Anggraena | 230102073 | Pembayaran Patungan & Pembayaran Sewa |
| Tia Pebriyanti | 230102125 | Dashboard, Testing & Dokumentasi |

---

# 📄 Lisensi

Project ini dibuat untuk memenuhi tugas mata kuliah **Pemrograman Web Berbasis Framework** Program Studi Teknik Informatika Universitas Muhammadiyah Bandung.

---

**KasKos © 2026**
