# PRD — Website SDN 001 Kepenuhan

## 1. Ringkasan Proyek

### 1.1 Deskripsi

Website resmi SDN 001 Kepenuhan yang berfungsi sebagai portal informasi
sekolah dan platform Penerimaan Peserta Didik Baru (PPDB) online.

### 1.2 Tech Stack

| Komponen       | Teknologi                           |
| -------------- | ----------------------------------- |
| Framework      | Laravel 13                          |
| Frontend       | Livewire 3 + Alpine.js              |
| Styling        | Tailwind CSS 4                      |
| Database       | MySQL 8.x                           |
| Authentication | Laravel Breeze (Livewire stack)     |
| PDF Generator  | barryvdh/laravel-dompdf             |
| QR Code        | simplesoftwareio/simple-qrcode      |
| Excel Export   | maatwebsite/excel (Laravel Excel 3) |
| File Storage   | Laravel Storage (local/S3)          |
| Email          | SMTP (Mailtrap dev / Mailgun prod)  |
| Server         | PHP 8.2+, Nginx, Ubuntu 22.04 LTS   |

### 1.3 Role Pengguna

| Role        | Akses                                                 |
| ----------- | ----------------------------------------------------- |
| Guest       | Halaman publik (Home, Berita, Guru, Galeri, Tentang)  |
| Calon Siswa | Registrasi, Form PPDB, Dashboard status, Cetak bukti  |
| Admin       | Full CMS, Verifikasi PPDB, Settings, Manajemen konten |

---

## 2. Arsitektur Database

### 2.1 Entity Relationship

users (1) ←→ (1) students
users (1) ←→ (N) posts
students (1) ←→ (N) student_documents
posts (N) ←→ (N) categories [melalui category_post]

### 2.2 Skema Tabel Detail

#### `users`

| Kolom       | Tipe            | Constraint                                     |
| ----------- | --------------- | ---------------------------------------------- |
| id          | bigint unsigned | PK, auto increment                             |
| name        | varchar(255)    | NOT NULL                                       |
| email       | varchar(255)    | NOT NULL, UNIQUE                               |
| password    | varchar(255)    | NOT NULL                                       |
| role        | enum            | 'admin', 'calon_siswa', default: 'calon_siswa' |
| avatar_path | varchar(255)    | NULLABLE                                       |
| timestamps  | -               | created_at, updated_at                         |

#### `settings`

Pendekatan key-value untuk fleksibilitas.

| Kolom | Tipe            | Constraint                   |
| ----- | --------------- | ---------------------------- |
| id    | bigint unsigned | PK                           |
| key   | varchar(255)    | NOT NULL, UNIQUE             |
| value | text            | NULLABLE                     |
| group | varchar(100)    | NOT NULL, default: 'general' |

Keys yang digunakan: `school_name`, `address`, `phone`, `email`,
`logo_path`, `is_ppdb_open`, `ppdb_start_date`, `ppdb_end_date`,
`principal_name`, `principal_photo`, `vision`, `mission`, `history`,
`google_maps_embed`

#### `teachers`

| Kolom        | Tipe            | Constraint             |
| ------------ | --------------- | ---------------------- |
| id           | bigint unsigned | PK                     |
| nip          | varchar(20)     | NULLABLE, UNIQUE       |
| full_name    | varchar(255)    | NOT NULL               |
| position     | varchar(100)    | NOT NULL               |
| subject      | varchar(100)    | NULLABLE               |
| phone        | varchar(20)     | NULLABLE               |
| photo_path   | varchar(255)    | NULLABLE               |
| order        | int             | default: 0             |
| is_active    | boolean         | default: true          |
| timestamps   | -               | created_at, updated_at |
| soft_deletes | -               | deleted_at             |

#### `posts`

| Kolom        | Tipe            | Constraint                        |
| ------------ | --------------- | --------------------------------- |
| id           | bigint unsigned | PK                                |
| author_id    | bigint unsigned | FK → users.id, ON DELETE SET NULL |
| title        | varchar(255)    | NOT NULL                          |
| slug         | varchar(255)    | NOT NULL, UNIQUE                  |
| excerpt      | text            | NULLABLE                          |
| content      | longtext        | NOT NULL                          |
| image_path   | varchar(255)    | NULLABLE                          |
| is_published | boolean         | default: false                    |
| published_at | timestamp       | NULLABLE                          |
| views_count  | int unsigned    | default: 0                        |
| timestamps   | -               | created_at, updated_at            |

#### `categories`

| Kolom | Tipe            | Constraint       |
| ----- | --------------- | ---------------- |
| id    | bigint unsigned | PK               |
| name  | varchar(100)    | NOT NULL, UNIQUE |
| slug  | varchar(100)    | NOT NULL, UNIQUE |

#### `category_post` (pivot)

| Kolom       | Tipe            | Constraint         |
| ----------- | --------------- | ------------------ |
| post_id     | bigint unsigned | FK → posts.id      |
| category_id | bigint unsigned | FK → categories.id |

#### `galleries`

| Kolom       | Tipe            | Constraint             |
| ----------- | --------------- | ---------------------- |
| id          | bigint unsigned | PK                     |
| title       | varchar(255)    | NOT NULL               |
| description | text            | NULLABLE               |
| image_path  | varchar(255)    | NOT NULL               |
| album       | varchar(100)    | NULLABLE               |
| order       | int             | default: 0             |
| timestamps  | -               | created_at, updated_at |

#### `students`

| Kolom             | Tipe            | Constraint                                          |
| ----------------- | --------------- | --------------------------------------------------- |
| id                | bigint unsigned | PK                                                  |
| user_id           | bigint unsigned | FK → users.id, UNIQUE                               |
| registration_code | varchar(20)     | NOT NULL, UNIQUE                                    |
| nik               | varchar(16)     | NOT NULL                                            |
| no_kk             | varchar(16)     | NOT NULL                                            |
| nisn              | varchar(10)     | NOT NULL                                            |
| full_name         | varchar(255)    | NOT NULL                                            |
| nickname          | varchar(50)     | NULLABLE                                            |
| gender            | enum            | 'L', 'P'                                            |
| birth_place       | varchar(100)    | NOT NULL                                            |
| birth_date        | date            | NOT NULL                                            |
| religion          | varchar(50)     | NOT NULL                                            |
| address           | text            | NOT NULL                                            |
| rt                | varchar(5)      | NOT NULL                                            |
| rw                | varchar(5)      | NOT NULL                                            |
| mother_name       | varchar(255)    | NOT NULL                                            |
| father_name       | varchar(255)    | NULLABLE                                            |
| parent_occupation | varchar(100)    | NULLABLE                                            |
| parent_phone      | varchar(20)     | NOT NULL                                            |
| previous_school   | varchar(255)    | NULLABLE                                            |
| status            | enum            | 'pending','accepted','rejected', default: 'pending' |
| rejection_reason  | text            | NULLABLE                                            |
| verified_at       | timestamp       | NULLABLE                                            |
| verified_by       | bigint unsigned | FK → users.id, NULLABLE                             |
| timestamps        | -               | created_at, updated_at                              |
| soft_deletes      | -               | deleted_at                                          |

#### `student_documents`

| Kolom         | Tipe            | Constraint                            |
| ------------- | --------------- | ------------------------------------- |
| id            | bigint unsigned | PK                                    |
| student_id    | bigint unsigned | FK → students.id                      |
| type          | enum            | 'kk','akta_kelahiran','foto','ijazah' |
| file_path     | varchar(255)    | NOT NULL                              |
| file_size     | int unsigned    | NOT NULL (bytes)                      |
| original_name | varchar(255)    | NOT NULL                              |
| timestamps    | -               | created_at, updated_at                |

#### `contacts`

| Kolom      | Tipe            | Constraint             |
| ---------- | --------------- | ---------------------- |
| id         | bigint unsigned | PK                     |
| name       | varchar(255)    | NOT NULL               |
| email      | varchar(255)    | NOT NULL               |
| subject    | varchar(255)    | NOT NULL               |
| message    | text            | NOT NULL               |
| is_read    | boolean         | default: false         |
| timestamps | -               | created_at, updated_at |

#### `activity_logs`

| Kolom       | Tipe            | Constraint              |
| ----------- | --------------- | ----------------------- |
| id          | bigint unsigned | PK                      |
| user_id     | bigint unsigned | FK → users.id, NULLABLE |
| action      | varchar(100)    | NOT NULL                |
| description | text            | NOT NULL                |
| model_type  | varchar(255)    | NULLABLE                |
| model_id    | bigint unsigned | NULLABLE                |
| ip_address  | varchar(45)     | NULLABLE                |
| timestamps  | -               | created_at              |

### 2.3 Indexing Strategy

- `posts`: INDEX on (`is_published`, `published_at`), INDEX on `slug`
- `students`: INDEX on (`status`), INDEX on `registration_code`
- `teachers`: INDEX on (`is_active`, `order`)
- `activity_logs`: INDEX on (`model_type`, `model_id`)
- `settings`: INDEX on `key`

---

## 3. Fase Pengembangan

### Fase 1: Foundation & Setup (Minggu 1)

#### 1.1 Environment Setup

- [ ] Install Laravel 13: `composer create-project laravel/laravel .`
- [ ] Konfigurasi `.env` (DB, APP_URL, MAIL, FILESYSTEM)
- [ ] Install Laravel Breeze (Livewire stack): `composer require laravel/breeze --dev` → `php artisan breeze:install livewire`
- [ ] Install dependencies tambahan:
  - `barryvdh/laravel-dompdf` (PDF generation)
  - `simplesoftwareio/simple-qrcode` (QR Code)
  - `maatwebsite/excel` (Excel export)
  - `intervention/image` (Image processing & resize)

#### 1.2 Database & Migration

- [ ] Buat semua migration files sesuai skema di Bagian 2
- [ ] Buat Model + Relationship (belongsTo, hasMany, belongsToMany)
- [ ] Buat Seeder & Factory untuk: users, teachers, posts, galleries, settings
- [ ] Jalankan `php artisan migrate --seed`

#### 1.3 Auth & Middleware

- [ ] Modifikasi registrasi Breeze: otomatis assign role `calon_siswa`
- [ ] Buat middleware `AdminMiddleware` untuk proteksi route admin
- [ ] Buat middleware `PpdbOpenMiddleware` untuk cek status PPDB
- [ ] Konfigurasi redirect setelah login berdasarkan role
- [ ] Implementasi rate limiting: 5 request/menit pada endpoint registrasi

#### 1.4 Layout & Design System

- [ ] Setup layout utama `layouts/app.blade.php` (Header, Nav, Footer)
- [ ] Setup layout admin `layouts/admin.blade.php` (Sidebar, Topbar)
- [ ] Definisikan color palette di `tailwind.config.js` (warna sekolah)
- [ ] Setup Google Fonts (Inter/Poppins)
- [ ] Buat komponen Blade reusable: `x-alert`, `x-modal`, `x-card`, `x-badge`

---

### Fase 2: Area Publik / Front-End (Minggu 2)

#### 2.1 Halaman Home

- [ ] Hero Section dengan background gambar sekolah + overlay gradient
- [ ] Statistik ringkas (Jumlah Guru, Siswa, Tahun Berdiri)
- [ ] Highlight 3 berita terbaru (cards)
- [ ] CTA Banner PPDB (conditionally shown jika `is_ppdb_open`)
- [ ] Sambutan Kepala Sekolah
- [ ] Meta tags: title, description, Open Graph

#### 2.2 Halaman Tentang

- [ ] Tab/accordion: Sejarah, Visi & Misi, Struktur Organisasi
- [ ] Profil Kepala Sekolah lengkap dengan foto
- [ ] Data diambil dari tabel `settings` (bisa diedit admin)

#### 2.3 Halaman Kontak

- [ ] Form kontak (name, email, subject, message) → simpan ke tabel `contacts`
- [ ] Validasi sisi server + client (Livewire real-time validation)
- [ ] Rate limit: max 3 pesan per IP per jam
- [ ] Google Maps embed dari setting
- [ ] Informasi kontak (alamat, telepon, email)
- [ ] Toast notification setelah berhasil kirim

#### 2.4 Halaman Data Guru

- [ ] Grid kartu responsif (foto, nama, jabatan, mapel)
- [ ] Filter by jabatan/position (Livewire)
- [ ] Skeleton loading saat data dimuat
- [ ] Fallback avatar jika tidak ada foto

#### 2.5 Halaman Galeri

- [ ] Grid foto dengan filter album (Livewire)
- [ ] Lightbox view gambar (Alpine.js)
- [ ] Pagination: `WithPagination` Livewire (12 per halaman)
- [ ] Lazy loading gambar (`loading="lazy"`)
- [ ] Image placeholder / blur-up effect

#### 2.6 Halaman Berita

- [ ] Daftar berita dengan gambar thumbnail
- [ ] Real-time search: `wire:model.live.debounce.300ms="search"`
- [ ] Filter by kategori
- [ ] Pagination: 10 per halaman
- [ ] Halaman detail berita: judul, gambar, konten, author, tanggal, views
- [ ] Social share buttons
- [ ] Breadcrumb navigation
- [ ] Related posts (3 berita terkait berdasarkan kategori)

#### 2.7 SEO & Performance

- [ ] Dynamic meta tags per halaman (`<title>`, `<meta description>`, OG tags)
- [ ] Sitemap generator otomatis (`spatie/laravel-sitemap` atau manual)
- [ ] `robots.txt` configuration
- [ ] Canonical URLs
- [ ] Structured data (JSON-LD) untuk organisasi sekolah
- [ ] Image optimization saat upload (resize max 1920px, compress 80%)

---

### Fase 3: Fitur PPDB (Minggu 3)

#### 3.1 Gatekeeper System

- [ ] Middleware `PpdbOpenMiddleware`: cek `is_ppdb_open` + `ppdb_start_date`/`ppdb_end_date`
- [ ] Halaman informasi PPDB (jadwal, syarat, alur)
- [ ] Countdown timer jika PPDB belum dibuka
- [ ] Redirect dengan pesan jika PPDB sudah ditutup

#### 3.2 Registrasi & Multi-Step Form

Alur: **Registrasi Akun → Login → Isi Form PPDB**

**Step 1: Data Diri Siswa**

- NIK (16 digit), No KK (16 digit), NISN (10 digit)
- Nama lengkap, nama panggilan, jenis kelamin
- Tempat & tanggal lahir, agama
- Alamat, RT, RW, asal sekolah
- Validasi: semua required, NIK & No KK = 16 digit numerik, NISN = 10 digit numerik

**Step 2: Data Orang Tua**

- Nama ibu (required), nama ayah (opsional), pekerjaan, nomor HP
- Validasi: phone format Indonesia (08xx / +628xx)

**Step 3: Upload Dokumen**

- KK, Akta Kelahiran, Foto (3x4), Ijazah (opsional)
- Validasi: max 2MB, format jpg/png/pdf
- Preview file sebelum submit
- Progress bar upload (Livewire)

**Step 4: Review & Submit**

- Tampilkan ringkasan semua data
- Checkbox pernyataan kebenaran data
- Tombol submit final
- Auto-generate `registration_code` (format: PPDB-2026-XXXX)

#### 3.3 Dashboard Calon Siswa

- [ ] Status pendaftaran (badge: pending/accepted/rejected)
- [ ] Timeline progress pendaftaran
- [ ] Detail data yang sudah diinput (read-only)
- [ ] Alasan penolakan (jika ditolak)
- [ ] Cetak Bukti Registrasi (PDF) — memuat:
  - Data diri ringkas
  - Foto siswa
  - QR Code (berisi registration_code untuk validasi)
  - Tanggal pendaftaran
  - Catatan: "Bawa bukti ini saat verifikasi berkas fisik"
- [ ] Re-upload dokumen jika ditolak (optional feature)

---

### Fase 4: Panel Admin / CMS (Minggu 4)

#### 4.1 Dashboard Admin

- [ ] Statistik cards: Total Pendaftar, Pending, Accepted, Rejected
- [ ] Grafik pendaftaran per hari/minggu (Chart.js / Alpine)
- [ ] Shortcut: pesan kontak belum dibaca, berita draft
- [ ] Activity log terbaru

#### 4.2 Manajemen Konten

- [ ] **CRUD Berita**: Editor rich text (Trix/CKEditor), upload gambar, preview, publish/draft toggle, kategori
- [ ] **CRUD Galeri**: Upload multiple gambar, drag-drop reorder, album grouping
- [ ] **CRUD Guru**: Form lengkap, upload foto, sortable order, toggle aktif/non-aktif
- [ ] **CRUD Kategori**: Nama + slug auto-generate

#### 4.3 Verifikasi PPDB

- [ ] Tabel pendaftar: search, filter by status, sort by tanggal
- [ ] Detail pendaftar: data lengkap + preview dokumen inline (modal)
- [ ] Aksi accept/reject dengan konfirmasi (modal)
- [ ] Input alasan penolakan (required jika reject)
- [ ] Bulk action: accept/reject multiple pendaftar
- [ ] **Export Data Pendaftar ke Excel** (`maatwebsite/excel`):
  - Format kolom rapi: No, Kode Pendaftaran, NIK, No KK, NISN, Nama Lengkap, Jenis Kelamin, Tempat/Tanggal Lahir, Agama, Alamat, RT/RW, Nama Ibu, Nama Ayah, Pekerjaan Orang Tua, No HP, Asal Sekolah, Status, Tanggal Daftar
  - Header styling: bold, background warna, border
  - Auto-fit column width
  - Filter export by status: Semua / Pending / Accepted / Rejected
  - Nama file: `Data_Pendaftar_PPDB_{tahun}_{status}.xlsx`
  - Sheet title: "Data Pendaftar PPDB {tahun}"
- [ ] Notifikasi email ke calon siswa saat status berubah

#### 4.4 Pengaturan Website

- [ ] Form settings: nama sekolah, alamat, telepon, email, logo, Google Maps embed
- [ ] PPDB settings: buka/tutup, tanggal mulai & akhir
- [ ] Konten "Tentang": visi, misi, sejarah, profil kepala sekolah
- [ ] Upload logo dengan preview

#### 4.5 Manajemen Pesan Kontak

- [ ] List pesan masuk (unread badge)
- [ ] Detail pesan + tandai sudah dibaca
- [ ] Hapus pesan

#### 4.6 Activity Log

- [ ] Log semua perubahan: siapa, kapan, apa yang diubah
- [ ] Filter by user, action, tanggal

---

### Fase 5: Testing, Optimasi & Deployment (Minggu 5)

#### 5.1 Testing

- [ ] **Feature Tests**: Auth flow, PPDB registration, Admin CRUD
- [ ] **Browser Testing**: Form validation, file upload, multi-step form
- [ ] **Responsive Testing**: Mobile (375px), Tablet (768px), Desktop (1024px+)
- [ ] **Cross-browser**: Chrome, Firefox, Edge, Safari
- [ ] **Security Tests**: XSS, CSRF, SQL Injection, unauthorized access

#### 5.2 Performance Optimization

- [ ] Query optimization: Eager Loading (`with()`) di semua query relasi
- [ ] Cache: halaman publik (5 menit), settings (1 jam)
- [ ] Image: lazy loading, WebP conversion (opsional), resize saat upload
- [ ] Assets: `npm run build` (Vite minification)
- [ ] Database: tambahkan index sesuai Bagian 2.3

#### 5.3 Error Handling

- [ ] Custom error pages: 404, 403, 500, 503 (maintenance)
- [ ] Global exception handler: log ke file + notifikasi admin (critical errors)
- [ ] Form error messages yang user-friendly (Bahasa Indonesia)

#### 5.4 Deployment

- [ ] **Server**: VPS (Ubuntu 22.04) + Nginx + PHP 8.2-FPM + MySQL 8
- [ ] **Checklist**:
  - `php artisan storage:link`
  - `php artisan config:cache`
  - `php artisan route:cache`
  - `php artisan view:cache`
  - `php artisan migrate --force`
  - `npm run build`
  - Set `APP_ENV=production`, `APP_DEBUG=false`
- [ ] **SSL**: Certbot (Let's Encrypt) untuk HTTPS
- [ ] **Domain**: Konfigurasi DNS A Record
- [ ] **Backup**: Cron job backup database harian (`mysqldump` atau `spatie/laravel-backup`)
- [ ] **Monitoring**: Setup log rotation, uptime check
- [ ] **CI/CD** (opsional): GitHub Actions → auto deploy on push to `main`
