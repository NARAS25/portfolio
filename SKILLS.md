# 🧠 SKILLS.md — Panduan Teknis & Skill Stack

> Dokumen ini berisi referensi teknis dan praktik terbaik untuk pengembangan project Portfolio ini.
> Gunakan sebagai acuan saat menulis kode agar konsisten dengan stack yang digunakan.

---

## 1. Backend — Laravel 13

### Konvensi Umum
- Gunakan **PHP 8.3+** features: readonly properties, named arguments, enum, fibers
- Ikuti **PSR-12** coding standard (gunakan `./vendor/bin/pint` untuk format otomatis)
- Selalu gunakan **Form Request** untuk validasi, bukan validasi di controller langsung
- Gunakan **Eloquent ORM** — hindari raw SQL kecuali sangat diperlukan
- Resource route selalu di-definisikan dengan `Route::resource()`

### Struktur Controller
```php
// Gunakan pola ini — dependency injection via constructor
class ProjectController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::latest()->paginate(10),
        ]);
    }
}
```

### Eloquent & Model
```php
// Selalu definisikan $fillable secara eksplisit (bukan $guarded = [])
protected $fillable = ['title', 'slug', 'description', 'status'];

// Cast JSON ke array
protected $casts = [
    'tech_stack' => 'array',
    'start_date' => 'date',
    'is_current' => 'boolean',
];
```

### File Upload (Laravel Storage)
```php
// Simpan ke public disk
$path = $request->file('thumbnail')->store('projects', 'public');

// URL publik
$url = Storage::url($path); // menghasilkan /storage/projects/xxx.jpg
```

### Artisan Commands Berguna
```bash
php artisan make:model Project -mfcrs   # Model + Migration + Factory + Controller + Seeder
php artisan make:request StoreProjectRequest
php artisan migrate:fresh --seed        # Reset DB + seed ulang
php artisan storage:link                # Buat symlink public/storage
./vendor/bin/pint                       # Format kode otomatis
```

---

## 2. Frontend — Vue 3

### Aturan Wajib
- Selalu gunakan **Composition API** dengan `<script setup>` — jangan Options API
- Gunakan **`defineProps()`** dan **`defineEmits()`** tanpa import
- Reactive state dengan `ref()` untuk primitif, `reactive()` untuk objek kompleks
- Computed dengan `computed()`, lifecycle dengan `onMounted()`, dll

### Template Dasar
```vue
<script setup>
import { ref, computed, onMounted } from 'vue';
import { useForm, usePage, router } from '@inertiajs/vue3';

const props = defineProps({
  projects: Array,
});

const search = ref('');
const filtered = computed(() =>
  props.projects.filter(p => p.title.includes(search.value))
);
</script>

<template>
  <div>
    <input v-model="search" />
    <div v-for="project in filtered" :key="project.id">
      {{ project.title }}
    </div>
  </div>
</template>
```

### Inertia.js — Form Handling
```vue
<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
  title: '',
  description: '',
  status: 'draft',
});

const submit = () => {
  form.post(route('projects.store'), {
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <input v-model="form.title" />
    <span v-if="form.errors.title">{{ form.errors.title }}</span>
    <button type="submit" :disabled="form.processing">Simpan</button>
  </form>
</template>
```

### Inertia.js — Navigasi & Link
```vue
<script setup>
import { Link, router } from '@inertiajs/vue3';
</script>

<template>
  <!-- Link biasa -->
  <Link :href="route('dashboard')">Dashboard</Link>

  <!-- Method DELETE (untuk hapus) -->
  <button @click="router.delete(route('projects.destroy', project.id))">
    Hapus
  </button>
</template>
```

### Inertia.js — Shared Data (Flash Messages)
```php
// app/Http/Middleware/HandleInertiaRequests.php
public function share(Request $request): array
{
    return [
        ...parent::share($request),
        'flash' => [
            'success' => $request->session()->get('success'),
            'error'   => $request->session()->get('error'),
        ],
    ];
}
```

```vue
<!-- Akses di komponen Vue -->
<script setup>
import { usePage } from '@inertiajs/vue3';
const { flash } = usePage().props;
</script>
```

---

## 3. Styling — TailwindCSS 3

### Konfigurasi (`tailwind.config.js`)
```js
export default {
  darkMode: 'class', // atau 'media' untuk otomatis
  content: ['./resources/**/*.{vue,js,blade.php}'],
  theme: {
    extend: {
      colors: {
        primary: { /* HSL custom palette */ },
      },
      fontFamily: {
        sans: ['Figtree', 'Inter', 'sans-serif'],
      },
    },
  },
};
```

### Class Utility yang Sering Digunakan
```html
<!-- Layout -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

<!-- Glassmorphism -->
<div class="backdrop-blur-md bg-white/10 border border-white/20 rounded-2xl">

<!-- Gradient Text -->
<h1 class="bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">

<!-- Transition & Hover -->
<button class="transition-all duration-300 hover:scale-105 hover:shadow-xl">

<!-- Dark Mode -->
<div class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white">
```

---

## 4. Routing — Ziggy

Ziggy memungkinkan penggunaan `route()` helper Laravel di Vue:

```vue
<script setup>
// route() sudah tersedia global via app.js
</script>

<template>
  <Link :href="route('projects.show', { project: project.slug })">
    Lihat Detail
  </Link>
</template>
```

```js
// Di app.js sudah di-setup:
import { ZiggyVue } from 'ziggy-js';
app.use(ZiggyVue);
```

---

## 5. Pola Kode — Do's & Don'ts

### ✅ Do's
- Gunakan `<script setup>` untuk semua komponen Vue baru
- Definisikan props dengan tipe yang jelas: `defineProps({ title: String })`
- Selalu handle loading & error state di form
- Gunakan Inertia `useForm` untuk semua form submit
- Pisahkan logika kompleks ke composable (`/resources/js/composables/`)
- Gunakan `route()` dari Ziggy, bukan hardcode URL
- Semua string UI dalam Bahasa Indonesia (kecuali kode)

### ❌ Don'ts
- Jangan gunakan `axios` langsung — gunakan `useForm` atau `router` dari Inertia
- Jangan hardcode URL di Vue (`/dashboard`) — gunakan `route('dashboard')`
- Jangan taruh logika bisnis di komponen Vue — taruh di Controller atau Service
- Jangan gunakan `$guarded = []` di Model — selalu eksplisit dengan `$fillable`
- Jangan lupa `php artisan optimize:clear` setelah perubahan config/route

---

## 6. Struktur Folder Konvensi

```
resources/js/
├── app.js                    # Entry point
├── bootstrap.js              # Setup axios
├── Components/               # Komponen UI reusable (Atom/Molecule level)
│   ├── ui/                   # Primitif: Button, Input, Badge, Modal
│   └── shared/               # Shared: Navbar, Footer, Toast
├── Layouts/
│   ├── AuthenticatedLayout.vue
│   ├── GuestLayout.vue
│   └── DashboardLayout.vue   # [NEW] Layout dashboard admin
├── Pages/
│   ├── Welcome.vue           # Landing page publik
│   ├── Dashboard.vue         # Dashboard admin
│   ├── Projects/
│   │   ├── Index.vue
│   │   ├── Create.vue
│   │   ├── Edit.vue
│   │   └── Show.vue
│   ├── Skills/
│   ├── Experiences/
│   ├── Messages/
│   ├── Profile/
│   └── Auth/
└── composables/              # [NEW] Logic yang bisa dipakai ulang
    ├── useFlash.js
    └── useConfirm.js

app/
├── Http/
│   ├── Controllers/
│   │   ├── PublicController.php
│   │   ├── ContactController.php
│   │   ├── DashboardController.php
│   │   ├── ProjectController.php
│   │   ├── SkillController.php
│   │   ├── ExperienceController.php
│   │   ├── MessageController.php
│   │   └── ProfileController.php
│   ├── Requests/
│   │   ├── StoreProjectRequest.php
│   │   ├── StoreSkillRequest.php
│   │   ├── StoreExperienceRequest.php
│   │   └── StoreContactRequest.php
│   └── Middleware/
├── Models/
│   ├── User.php
│   ├── Project.php
│   ├── Skill.php
│   ├── Experience.php
│   └── Message.php
└── Providers/
```

---

## 7. Environment & Setup

### Variabel `.env` Penting
```env
APP_NAME="Portfolio"
APP_URL=http://localhost

DB_CONNECTION=sqlite
# DB_CONNECTION=mysql  (production)
# DB_HOST=127.0.0.1
# DB_DATABASE=portfolio

FILESYSTEM_DISK=public
```

### Jalankan Development
```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite dev server
npm run dev

# ATAU pakai composer script (semua sekaligus):
composer run dev
```

### Format & Lint
```bash
./vendor/bin/pint          # Format PHP
```

---

## 8. Git Workflow

```
main           → Production-ready code
develop        → Integration branch
feature/xxx    → Fitur baru (branching dari develop)
fix/xxx        → Bug fix
```

### Commit Message Convention
```
feat: tambah halaman detail proyek
fix: perbaiki validasi form kontak
style: update warna hero section
refactor: pisahkan ProjectController jadi resource controller
docs: update TASKS.md progress phase 2
```
