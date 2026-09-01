# 📋 Product Requirements Document (PRD)

## Portfolio Website — Personal Developer Portfolio

**Versi:** 1.0.0
**Tanggal:** 2026-08-21
**Status:** Draft
**Stack:** Laravel 13 · Inertia.js 2 · Vue 3 · TailwindCSS 3 · SQLite

---

## 1. Ringkasan Produk

Website portfolio personal yang menampilkan identitas, keahlian, proyek, dan pengalaman seorang developer. Pengunjung dapat melihat profil secara publik, sementara pemilik (admin) dapat mengelola semua konten melalui dashboard yang terautentikasi.

---

## 2. Tujuan Produk

| Tujuan | Keterangan |
|---|---|
| **Branding Diri** | Menampilkan identitas profesional secara online |
| **Showcase Proyek** | Memamerkan hasil karya dan proyek yang pernah dikerjakan |
| **Kontak** | Memudahkan klien / recruiter menghubungi pemilik |
| **CMS Mandiri** | Pemilik dapat mengelola konten tanpa menyentuh kode |

---

## 3. Pengguna (User Personas)

### 3.1 Pengunjung (Publik)
- Recruiter, klien potensial, atau sesama developer
- Ingin mengetahui keahlian, pengalaman, dan portofolio
- Tidak perlu login

### 3.2 Admin (Pemilik)
- Developer pemilik portfolio
- Dapat login dan mengelola semua konten (profil, proyek, skill, pengalaman)
- Akses penuh ke dashboard

---

## 4. Halaman & Fitur

### 4.1 Halaman Publik

#### `/` — Halaman Utama (Landing Page)
- **Hero Section** — Nama, tagline, foto profil, tombol CTA (Download CV, Kontak)
- **About Section** — Bio singkat, foto, deskripsi diri
- **Skills Section** — Daftar keahlian dengan ikon & level (progress bar)
- **Projects Section** — Grid kartu proyek (thumbnail, nama, deskripsi singkat, link)
- **Experience Section** — Timeline pengalaman kerja / pendidikan
- **Contact Section** — Form kontak (nama, email, pesan) + link sosial media
- **Footer** — Copyright, link cepat

#### `/projects/{slug}` — Detail Proyek
- Thumbnail / screenshot proyek
- Deskripsi lengkap
- Tech stack yang digunakan
- Link ke GitHub & Live Demo

### 4.2 Halaman Admin (Terautentikasi)

#### `/login` — Login
- Form email & password

#### `/dashboard` — Dashboard Utama
- Statistik ringkasan (jumlah proyek, skill, pesan masuk)

#### `/dashboard/projects` — Manajemen Proyek (CRUD)
#### `/dashboard/skills` — Manajemen Skill (CRUD)
#### `/dashboard/experiences` — Manajemen Pengalaman (CRUD)
#### `/dashboard/messages` — Pesan Masuk
#### `/profile` — Pengaturan Profil Admin

---

## 5. Data Model (Database)

### Tabel `users` (extended)
| Kolom | Tipe | Keterangan |
|---|---|---|
| avatar | varchar | Path foto profil |
| tagline | varchar | Tagline / subtitle |
| bio | text | Bio singkat |
| github_url | varchar | Link GitHub |
| linkedin_url | varchar | Link LinkedIn |
| instagram_url | varchar | Link Instagram |
| cv_url | varchar | Link / path file CV |

### Tabel `projects`
| Kolom | Tipe | Keterangan |
|---|---|---|
| title | varchar | Nama proyek |
| slug | varchar | URL-friendly name |
| description | text | Deskripsi singkat |
| content | longtext | Deskripsi lengkap |
| thumbnail | varchar | Path gambar thumbnail |
| tech_stack | json | Array teknologi |
| github_url | varchar | Link GitHub |
| demo_url | varchar | Link live demo |
| status | enum | published / draft |
| order | int | Urutan tampil |

### Tabel `skills`
| Kolom | Tipe | Keterangan |
|---|---|---|
| name | varchar | Nama skill |
| category | varchar | Frontend / Backend / Tools / dll |
| level | int | 1–100 (persentase) |
| icon | varchar | Nama ikon / URL |
| order | int | Urutan tampil |

### Tabel `experiences`
| Kolom | Tipe | Keterangan |
|---|---|---|
| type | enum | work / education / organization |
| title | varchar | Posisi / Gelar |
| organization | varchar | Nama perusahaan / institusi |
| location | varchar | Lokasi |
| description | text | Deskripsi singkat |
| start_date | date | Tanggal mulai |
| end_date | date | Tanggal selesai (null = sekarang) |
| is_current | boolean | Masih aktif atau tidak |

### Tabel `messages`
| Kolom | Tipe | Keterangan |
|---|---|---|
| name | varchar | Nama pengirim |
| email | varchar | Email pengirim |
| subject | varchar | Subjek pesan |
| body | text | Isi pesan |
| is_read | boolean | Status baca |

---

## 6. Persyaratan Non-Fungsional

| Aspek | Persyaratan |
|---|---|
| **Responsif** | Tampil sempurna di mobile, tablet, dan desktop |
| **Dark Mode** | Mendukung dark mode otomatis berdasarkan preferensi sistem |
| **Performa** | First Contentful Paint < 2 detik |
| **SEO** | Meta title, description, og:image untuk setiap halaman publik |
| **Keamanan** | Autentikasi berbasis session, CSRF protection, validasi input |

---

## 7. Tech Stack

| Layer | Teknologi |
|---|---|
| **Backend** | PHP 8.3 + Laravel 13 |
| **Frontend** | Vue 3 (Composition API + `<script setup>`) |
| **Bridge** | Inertia.js 2 |
| **Styling** | TailwindCSS 3 |
| **Database** | SQLite (development) / MySQL (production) |
| **Build Tool** | Vite 8 |
| **Auth** | Laravel Breeze (session-based) |

---

## 8. Prioritas Fitur (MVP)

### Phase 1 — MVP (Wajib)
- [x] Setup project (Laravel + Inertia + Vue + Tailwind)
- [x] Landing page publik (Hero, About, Skills, Projects, Experience, Contact)
- [x] Form kontak → simpan ke database
- [x] Autentikasi admin (login/logout)
- [x] Dashboard ringkasan
- [x] CRUD Proyek
- [x] CRUD Skill
- [x] CRUD Pengalaman
- [x] Manajemen pesan masuk
- [x] Edit profil admin

### Phase 2 — Enhancement
- [ ] Halaman detail proyek
- [ ] Upload & resize gambar otomatis
- [ ] Dark mode toggle manual
- [ ] Email notifikasi pesan masuk
- [ ] Animasi scroll

### Phase 3 — Advanced
- [ ] Blog / artikel
- [ ] Multi-bahasa (ID / EN)
- [ ] Analytics pengunjung
- [ ] Sitemap XML

---

## 9. Desain & UI/UX

- **Tema warna:** Gelap elegan dengan aksen biru/ungu/cyan
- **Tipografi:** Font `Inter` atau `Figtree`
- **Gaya:** Glassmorphism, gradient halus, micro-animation
- **Layout:** Single-page landing + multi-page dashboard
