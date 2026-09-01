# ✅ TASKS.md — Daftar Tugas Pengembangan Portfolio

> Ikuti urutan phase ini secara berurutan. Tandai setiap tugas dengan `[x]` setelah selesai.

---

## 🏗️ Phase 1 — Database & Model

- [x] **1.1** Buat migration `add_profile_fields_to_users_table`
  - Tambah kolom: `avatar`, `tagline`, `bio`, `github_url`, `linkedin_url`, `instagram_url`, `cv_url`
- [x] **1.2** Buat migration `create_projects_table`
- [x] **1.3** Buat migration `create_skills_table`
- [x] **1.4** Buat migration `create_experiences_table`
- [x] **1.5** Buat migration `create_messages_table`
- [x] **1.6** Buat Model `Project` dengan fillable, cast (tech_stack → array), dan relasi ke User
- [x] **1.7** Buat Model `Skill` dengan fillable dan relasi ke User
- [x] **1.8** Buat Model `Experience` dengan fillable, cast (dates), dan relasi ke User
- [x] **1.9** Buat Model `Message` dengan fillable
- [x] **1.10** Update Model `User` — tambah fillable untuk kolom profil baru
- [x] **1.11** Buat `DatabaseSeeder` — seed user admin default + data contoh
- [x] **1.12** Jalankan `php artisan migrate --seed`

---

## 🔌 Phase 2 — Backend (Controllers & Routes)

- [ ] **2.1** Buat `PublicController` — handle halaman landing publik
  - Method `index()` — ambil semua data untuk landing page
- [ ] **2.2** Buat `ContactController` — handle form kontak
  - Method `store()` — simpan pesan ke tabel `messages`
- [ ] **2.3** Buat `DashboardController` — statistik ringkasan
- [ ] **2.4** Buat `ProjectController` (resource) — CRUD proyek
  - `index`, `create`, `store`, `edit`, `update`, `destroy`
  - Handle upload thumbnail (Laravel Storage)
- [ ] **2.5** Buat `SkillController` (resource) — CRUD skill
- [ ] **2.6** Buat `ExperienceController` (resource) — CRUD pengalaman
- [ ] **2.7** Buat `MessageController` — daftar pesan & tandai dibaca
  - Method `index()`, `markRead()`, `destroy()`
- [ ] **2.8** Update `ProfileController` — tambah handling avatar & field profil baru
- [ ] **2.9** Buat Form Request classes:
  - `StoreProjectRequest`
  - `UpdateProjectRequest`
  - `StoreSkillRequest`
  - `StoreExperienceRequest`
  - `StoreContactRequest`
- [ ] **2.10** Update `routes/web.php`:
  - Route publik: `/` (landing), `/projects/{slug}` (detail proyek)
  - Route POST `/contact` (kirim pesan)
  - Route group auth: dashboard & semua CRUD
- [ ] **2.11** Buat symbolic link storage: `php artisan storage:link`

---

## 🎨 Phase 3 — Frontend: Landing Page (Publik)

- [ ] **3.1** Desain sistem (CSS variables / Tailwind config)
  - Definisikan palet warna, font, shadow, borderRadius
- [ ] **3.2** Buat komponen `Navbar.vue` — navigasi publik dengan smooth scroll
- [ ] **3.3** Buat komponen `HeroSection.vue`
  - Foto profil, nama, tagline, tombol CTA (Download CV, Kontak)
  - Animasi masuk (fade-in / slide-up)
- [ ] **3.4** Buat komponen `AboutSection.vue`
  - Foto, bio, highlight statistik (tahun pengalaman, proyek selesai, dll)
- [ ] **3.5** Buat komponen `SkillsSection.vue`
  - Kartu per kategori, progress bar per skill dengan animasi
- [ ] **3.6** Buat komponen `ProjectsSection.vue`
  - Grid kartu proyek (thumbnail, nama, deskripsi, tech badge, link)
  - Filter berdasarkan kategori (opsional)
- [ ] **3.7** Buat komponen `ExperienceSection.vue`
  - Timeline vertikal: pekerjaan, pendidikan, organisasi
- [ ] **3.8** Buat komponen `ContactSection.vue`
  - Form: nama, email, subjek, pesan + validasi
  - Icon sosial media (GitHub, LinkedIn, Instagram, Email)
- [ ] **3.9** Buat komponen `Footer.vue`
- [ ] **3.10** Rakit semua section di `Pages/Welcome.vue` (ganti konten default)
- [ ] **3.11** Implementasi SEO: `<Head>` Inertia dengan title, meta description, og:image
- [ ] **3.12** Buat halaman `Pages/Projects/Show.vue` — detail proyek

---

## 🖥️ Phase 4 — Frontend: Dashboard Admin

- [ ] **4.1** Buat layout `Layouts/DashboardLayout.vue`
  - Sidebar navigasi, header, area konten
  - Responsif (collapsible sidebar di mobile)
- [ ] **4.2** Buat `Pages/Dashboard.vue` — kartu statistik ringkasan
- [ ] **4.3** Buat halaman CRUD Proyek:
  - `Pages/Projects/Index.vue` — tabel + tombol aksi
  - `Pages/Projects/Create.vue` — form tambah
  - `Pages/Projects/Edit.vue` — form edit
- [ ] **4.4** Buat halaman CRUD Skill:
  - `Pages/Skills/Index.vue`
  - `Pages/Skills/Create.vue`
  - `Pages/Skills/Edit.vue`
- [ ] **4.5** Buat halaman CRUD Pengalaman:
  - `Pages/Experiences/Index.vue`
  - `Pages/Experiences/Create.vue`
  - `Pages/Experiences/Edit.vue`
- [ ] **4.6** Buat halaman `Pages/Messages/Index.vue` — daftar pesan masuk
- [ ] **4.7** Update `Pages/Profile/Edit.vue` — tambah field profil baru (tagline, bio, sosmed, dll)
- [ ] **4.8** Buat komponen UI reusable:
  - `Components/Table.vue`
  - `Components/Badge.vue`
  - `Components/SkillLevelBar.vue`
  - `Components/ConfirmModal.vue` (konfirmasi hapus)
  - `Components/FileUpload.vue` (drag & drop upload gambar)
  - `Components/Toast.vue` (notifikasi sukses/gagal)
- [ ] **4.9** Implementasi flash message / notifikasi dari Inertia shared data

---

## ✨ Phase 5 — Polish & Optimasi

- [ ] **5.1** Tambah animasi scroll reveal (CSS `@keyframes` atau library)
- [ ] **5.2** Implementasi dark mode (class-based atau prefers-color-scheme)
- [ ] **5.3** Optimasi gambar — pastikan thumbnail di-resize server-side
- [ ] **5.4** Tambah loading state di semua form submit
- [ ] **5.5** Validasi error tampil di-inline pada form
- [ ] **5.6** Uji responsivitas di mobile (320px), tablet (768px), desktop (1280px)
- [ ] **5.7** Audit aksesibilitas dasar (alt text, label form, focus ring)
- [ ] **5.8** Tambah `robots.txt` dan sitemap dasar
- [ ] **5.9** Jalankan `npm run build` — pastikan tidak ada error build

---

## 🚀 Phase 6 — Deployment (Opsional)

- [ ] **6.1** Setup database MySQL (production)
- [ ] **6.2** Konfigurasi `.env` production
- [ ] **6.3** Upload ke server / VPS
- [ ] **6.4** Setup domain & SSL
- [ ] **6.5** Jalankan `composer install --no-dev`, `php artisan migrate`, `npm run build`
