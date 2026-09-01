<script setup>
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";

const props = defineProps({
  owner: Object,
  projects: Array,
  skills: Array,
  experiences: Array,
});

const { flash } = usePage().props;
const showToast = ref(false);
const toastMessage = ref("");

const contactForm = useForm({
  name: "",
  email: "",
  subject: "",
  body: "",
});

const submitContact = () => {
  contactForm.post(route("contact.store"), {
    onSuccess: () => {
      contactForm.reset();
      toastMessage.value = "Pesan berhasil dikirim!";
      showToast.value = true;
      setTimeout(() => (showToast.value = false), 4000);
    },
  });
};

const skillCategories = computed(() => {
  if (!props.skills) return {};
  return props.skills.reduce((acc, skill) => {
    if (!acc[skill.category]) acc[skill.category] = [];
    acc[skill.category].push(skill);
    return acc;
  }, {});
});

const workExp = computed(() => props.experiences?.filter((e) => e.type === "work") ?? []);
const eduExp = computed(() => props.experiences?.filter((e) => e.type === "education") ?? []);
const orgExp = computed(() => props.experiences?.filter((e) => e.type === "organization") ?? []);

const formatDate = (date) => {
  if (!date) return "Sekarang";
  return new Date(date).toLocaleDateString("id-ID", { year: "numeric", month: "short" });
};

const scrollTo = (id) => {
  document.getElementById(id)?.scrollIntoView({ behavior: "smooth" });
};

onMounted(() => {
  // Intersection observer for animations
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    },
    { threshold: 0.1 }
  );
  document.querySelectorAll(".animate-on-scroll").forEach((el) => observer.observe(el));
});
</script>

<template>
  <Head>
    <title>{{ owner?.name ?? "Portfolio" }} — {{ owner?.tagline ?? "Developer" }}</title>
    <meta name="description" :content="owner?.bio ?? 'Personal portfolio website'" />
  </Head>

  <!-- Toast Notification -->
  <Transition name="toast">
    <div v-if="showToast" class="fixed top-6 right-6 z-50 bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
      <span>✅</span><span>{{ toastMessage }}</span>
    </div>
  </Transition>

  <div class="min-h-screen bg-[#0a0a0f] text-white overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-40 backdrop-blur-xl bg-black/30 border-b border-white/5">
      <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="font-bold text-xl bg-gradient-to-r from-violet-400 to-cyan-400 bg-clip-text text-transparent">
          {{ owner?.name?.split(" ")[0] ?? "Portfolio" }}.dev
        </div>
        <div class="hidden md:flex items-center gap-8 text-sm text-white/60">
          <button @click="scrollTo('about')" class="hover:text-white transition-colors">About</button>
          <button @click="scrollTo('skills')" class="hover:text-white transition-colors">Skills</button>
          <button @click="scrollTo('projects')" class="hover:text-white transition-colors">Proyek</button>
          <button @click="scrollTo('experience')" class="hover:text-white transition-colors">Pengalaman</button>
          <button @click="scrollTo('contact')" class="hover:text-white transition-colors">Kontak</button>
        </div>
        <Link :href="route('login')" class="px-4 py-2 rounded-xl text-sm bg-violet-600 hover:bg-violet-500 transition-colors font-medium">
          Admin
        </Link>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center relative pt-20 overflow-hidden">
      <!-- Background decoration -->
      <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-violet-600/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-cyan-600/15 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-purple-900/10 rounded-full blur-3xl"></div>
      </div>

      <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
        <!-- Avatar -->
        <div class="mb-8 inline-block">
          <div class="w-28 h-28 rounded-full ring-4 ring-violet-500/50 ring-offset-4 ring-offset-[#0a0a0f] overflow-hidden mx-auto bg-gradient-to-br from-violet-500 to-cyan-500 flex items-center justify-center text-4xl font-bold">
            <img v-if="owner?.avatar" :src="`/storage/${owner.avatar}`" :alt="owner.name" class="w-full h-full object-cover" />
            <span v-else>{{ owner?.name?.[0] ?? "P" }}</span>
          </div>
        </div>

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-violet-500/10 border border-violet-500/30 text-violet-300 text-sm mb-6">
          <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
          Tersedia untuk proyek
        </div>

        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
          Halo, Saya<br />
          <span class="bg-gradient-to-r from-violet-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent">
            {{ owner?.name ?? "Nama Anda" }}
          </span>
        </h1>

        <p class="text-xl md:text-2xl text-white/60 mb-4 font-light">
          {{ owner?.tagline ?? "Full Stack Developer" }}
        </p>

        <p class="text-white/40 max-w-2xl mx-auto mb-12 leading-relaxed">
          {{ owner?.bio ?? "Seorang developer yang passionate dalam membuat pengalaman digital yang indah dan fungsional." }}
        </p>

        <div class="flex flex-wrap gap-4 justify-center">
          <button @click="scrollTo('contact')" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-500 hover:to-purple-500 font-semibold transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-violet-500/25">
            Hubungi Saya ✉️
          </button>
          <a v-if="owner?.cv_url" :href="owner.cv_url" target="_blank" class="px-8 py-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 font-semibold transition-all duration-300 hover:scale-105">
            Download CV 📄
          </a>
          <button v-else @click="scrollTo('projects')" class="px-8 py-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 font-semibold transition-all duration-300 hover:scale-105">
            Lihat Proyek 🚀
          </button>
        </div>

        <!-- Social Links -->
        <div class="flex gap-4 justify-center mt-10">
          <a v-if="owner?.github_url" :href="owner.github_url" target="_blank" class="p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all hover:scale-110 hover:border-violet-500/50 text-white/70 hover:text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
          </a>
          <a v-if="owner?.linkedin_url" :href="owner.linkedin_url" target="_blank" class="p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all hover:scale-110 hover:border-blue-500/50 text-white/70 hover:text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a v-if="owner?.instagram_url" :href="owner.instagram_url" target="_blank" class="p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-all hover:scale-110 hover:border-pink-500/50 text-white/70 hover:text-white">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
          </a>
        </div>

        <!-- Scroll indicator -->
        <button @click="scrollTo('about')" class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/30 hover:text-white/60 transition-colors animate-bounce">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 relative">
      <div class="max-w-6xl mx-auto px-6">
        <div class="animate-on-scroll opacity-0 translate-y-8 transition-all duration-700">
          <div class="text-center mb-16">
            <span class="text-violet-400 font-medium text-sm uppercase tracking-widest">Tentang Saya</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3">Siapa Saya?</h2>
          </div>

          <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
              <p class="text-white/70 text-lg leading-relaxed mb-6">
                {{ owner?.bio ?? "Bio belum diisi. Pergi ke dashboard dan edit profil Anda." }}
              </p>
              <div class="grid grid-cols-3 gap-4 mt-8">
                <div class="text-center p-4 rounded-2xl bg-white/5 border border-white/10">
                  <div class="text-3xl font-bold bg-gradient-to-r from-violet-400 to-cyan-400 bg-clip-text text-transparent">{{ projects?.length ?? 0 }}+</div>
                  <div class="text-sm text-white/50 mt-1">Proyek</div>
                </div>
                <div class="text-center p-4 rounded-2xl bg-white/5 border border-white/10">
                  <div class="text-3xl font-bold bg-gradient-to-r from-violet-400 to-cyan-400 bg-clip-text text-transparent">{{ skills?.length ?? 0 }}+</div>
                  <div class="text-sm text-white/50 mt-1">Skill</div>
                </div>
                <div class="text-center p-4 rounded-2xl bg-white/5 border border-white/10">
                  <div class="text-3xl font-bold bg-gradient-to-r from-violet-400 to-cyan-400 bg-clip-text text-transparent">{{ experiences?.length ?? 0 }}+</div>
                  <div class="text-sm text-white/50 mt-1">Pengalaman</div>
                </div>
              </div>
            </div>
            <div class="flex justify-center">
              <div class="relative">
                <div class="w-72 h-72 rounded-3xl overflow-hidden bg-gradient-to-br from-violet-600/30 to-cyan-600/30 border border-white/10 flex items-center justify-center">
                  <img v-if="owner?.avatar" :src="`/storage/${owner.avatar}`" :alt="owner.name" class="w-full h-full object-cover" />
                  <div v-else class="text-8xl opacity-30">👤</div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-br from-violet-500 to-cyan-500 rounded-2xl opacity-20 blur-xl"></div>
                <div class="absolute -top-4 -left-4 w-16 h-16 bg-gradient-to-br from-pink-500 to-violet-500 rounded-xl opacity-20 blur-xl"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="py-24 relative bg-white/[0.02]">
      <div class="max-w-6xl mx-auto px-6">
        <div class="animate-on-scroll opacity-0 translate-y-8 transition-all duration-700">
          <div class="text-center mb-16">
            <span class="text-violet-400 font-medium text-sm uppercase tracking-widest">Keahlian</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3">Tech Stack</h2>
          </div>

          <div v-if="Object.keys(skillCategories).length" class="space-y-10">
            <div v-for="(categorySkills, category) in skillCategories" :key="category">
              <h3 class="text-sm font-medium text-white/40 uppercase tracking-widest mb-4">{{ category }}</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div v-for="skill in categorySkills" :key="skill.id" class="flex items-center gap-4 p-4 rounded-2xl bg-white/5 border border-white/10 hover:border-violet-500/30 transition-all group">
                  <span class="text-2xl">{{ skill.icon || "🔧" }}</span>
                  <div class="flex-1">
                    <div class="flex justify-between mb-2">
                      <span class="font-medium text-sm">{{ skill.name }}</span>
                      <span class="text-xs text-white/40">{{ skill.level }}%</span>
                    </div>
                    <div class="h-1.5 bg-white/10 rounded-full overflow-hidden">
                      <div
                        class="h-full rounded-full bg-gradient-to-r from-violet-500 to-cyan-500 transition-all duration-1000"
                        :style="`width: ${skill.level}%`"
                      ></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center text-white/30 py-12">Skill belum ditambahkan.</div>
        </div>
      </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-24">
      <div class="max-w-6xl mx-auto px-6">
        <div class="animate-on-scroll opacity-0 translate-y-8 transition-all duration-700">
          <div class="text-center mb-16">
            <span class="text-violet-400 font-medium text-sm uppercase tracking-widest">Portofolio</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3">Proyek Saya</h2>
          </div>

          <div v-if="projects?.length" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div v-for="project in projects" :key="project.id" class="group rounded-3xl bg-white/5 border border-white/10 overflow-hidden hover:border-violet-500/30 hover:bg-white/[0.08] transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-violet-500/10">
              <!-- Thumbnail -->
              <div class="h-48 bg-gradient-to-br from-violet-900/50 to-cyan-900/50 relative overflow-hidden flex items-center justify-center">
                <img v-if="project.thumbnail" :src="`/storage/${project.thumbnail}`" :alt="project.title" class="w-full h-full object-cover" />
                <div v-else class="text-6xl opacity-20">🚀</div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0a0f] via-transparent to-transparent"></div>
              </div>

              <div class="p-6">
                <h3 class="text-lg font-bold mb-2 group-hover:text-violet-300 transition-colors">{{ project.title }}</h3>
                <p class="text-white/50 text-sm leading-relaxed mb-4">{{ project.description }}</p>

                <!-- Tech Stack -->
                <div v-if="project.tech_stack?.length" class="flex flex-wrap gap-2 mb-5">
                  <span v-for="tech in project.tech_stack" :key="tech" class="px-2 py-1 text-xs rounded-lg bg-violet-500/10 text-violet-300 border border-violet-500/20">
                    {{ tech }}
                  </span>
                </div>

                <!-- Links -->
                <div class="flex gap-3">
                  <a v-if="project.github_url" :href="project.github_url" target="_blank" class="flex-1 text-center py-2 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 text-sm transition-all hover:border-violet-500/30">
                    GitHub
                  </a>
                  <a v-if="project.demo_url" :href="project.demo_url" target="_blank" class="flex-1 text-center py-2 rounded-xl bg-violet-600/20 border border-violet-500/30 hover:bg-violet-600/30 text-violet-300 text-sm transition-all">
                    Live Demo →
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center text-white/30 py-12">Proyek belum ditambahkan.</div>
        </div>
      </div>
    </section>

    <!-- Experience Section -->
    <section id="experience" class="py-24 bg-white/[0.02]">
      <div class="max-w-6xl mx-auto px-6">
        <div class="animate-on-scroll opacity-0 translate-y-8 transition-all duration-700">
          <div class="text-center mb-16">
            <span class="text-violet-400 font-medium text-sm uppercase tracking-widest">Perjalanan</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3">Pengalaman</h2>
          </div>

          <div v-if="experiences?.length" class="grid md:grid-cols-2 gap-8">
            <!-- Work & Education -->
            <div v-if="workExp.length">
              <h3 class="flex items-center gap-2 text-sm font-medium text-white/40 uppercase tracking-widest mb-6">
                <span class="w-5 h-5 flex items-center justify-center text-base">💼</span> Pekerjaan
              </h3>
              <div class="relative">
                <div class="absolute left-4 top-0 bottom-0 w-px bg-gradient-to-b from-violet-500/50 to-transparent"></div>
                <div v-for="exp in workExp" :key="exp.id" class="relative pl-10 pb-8">
                  <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-violet-500/20 border border-violet-500/50 flex items-center justify-center text-sm">💼</div>
                  <div class="p-4 rounded-2xl bg-white/5 border border-white/10 hover:border-violet-500/20 transition-colors">
                    <div class="flex justify-between items-start flex-wrap gap-2 mb-1">
                      <h4 class="font-semibold">{{ exp.title }}</h4>
                      <span class="text-xs text-white/40">{{ formatDate(exp.start_date) }} – {{ exp.is_current ? "Sekarang" : formatDate(exp.end_date) }}</span>
                    </div>
                    <p class="text-violet-300 text-sm mb-2">{{ exp.organization }} • {{ exp.location }}</p>
                    <p class="text-white/50 text-sm">{{ exp.description }}</p>
                  </div>
                </div>
              </div>
            </div>

            <div>
              <div v-if="eduExp.length" class="mb-8">
                <h3 class="flex items-center gap-2 text-sm font-medium text-white/40 uppercase tracking-widest mb-6">
                  <span class="w-5 h-5 flex items-center justify-center text-base">🎓</span> Pendidikan
                </h3>
                <div class="relative">
                  <div class="absolute left-4 top-0 bottom-0 w-px bg-gradient-to-b from-cyan-500/50 to-transparent"></div>
                  <div v-for="exp in eduExp" :key="exp.id" class="relative pl-10 pb-8">
                    <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-cyan-500/20 border border-cyan-500/50 flex items-center justify-center text-sm">🎓</div>
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 hover:border-cyan-500/20 transition-colors">
                      <div class="flex justify-between items-start flex-wrap gap-2 mb-1">
                        <h4 class="font-semibold">{{ exp.title }}</h4>
                        <span class="text-xs text-white/40">{{ formatDate(exp.start_date) }} – {{ exp.is_current ? "Sekarang" : formatDate(exp.end_date) }}</span>
                      </div>
                      <p class="text-cyan-300 text-sm mb-2">{{ exp.organization }} • {{ exp.location }}</p>
                      <p class="text-white/50 text-sm">{{ exp.description }}</p>
                    </div>
                  </div>
                </div>
              </div>

              <div v-if="orgExp.length">
                <h3 class="flex items-center gap-2 text-sm font-medium text-white/40 uppercase tracking-widest mb-6">
                  <span>🏢</span> Organisasi
                </h3>
                <div v-for="exp in orgExp" :key="exp.id" class="mb-4 p-4 rounded-2xl bg-white/5 border border-white/10">
                  <div class="flex justify-between items-start flex-wrap gap-2 mb-1">
                    <h4 class="font-semibold">{{ exp.title }}</h4>
                    <span class="text-xs text-white/40">{{ formatDate(exp.start_date) }} – {{ exp.is_current ? "Sekarang" : formatDate(exp.end_date) }}</span>
                  </div>
                  <p class="text-purple-300 text-sm">{{ exp.organization }}</p>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center text-white/30 py-12">Pengalaman belum ditambahkan.</div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24">
      <div class="max-w-6xl mx-auto px-6">
        <div class="animate-on-scroll opacity-0 translate-y-8 transition-all duration-700">
          <div class="text-center mb-16">
            <span class="text-violet-400 font-medium text-sm uppercase tracking-widest">Kontak</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3">Mari Berkolaborasi</h2>
            <p class="text-white/40 mt-4 max-w-xl mx-auto">Punya proyek atau ide menarik? Saya siap mendengarkan dan membantu mewujudkannya.</p>
          </div>

          <div class="grid md:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-6">
              <div class="p-6 rounded-2xl bg-white/5 border border-white/10">
                <h3 class="font-semibold mb-4 text-white/80">Temukan Saya Di</h3>
                <div class="space-y-3">
                  <a v-if="owner?.github_url" :href="owner.github_url" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 group-hover:border-violet-500/30 flex items-center justify-center text-lg transition-all">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0 1 12 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                    </div>
                    <span>GitHub</span>
                  </a>
                  <a v-if="owner?.linkedin_url" :href="owner.linkedin_url" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 group-hover:border-blue-500/30 flex items-center justify-center transition-all">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </div>
                    <span>LinkedIn</span>
                  </a>
                  <a v-if="owner?.instagram_url" :href="owner.instagram_url" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors group">
                    <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 group-hover:border-pink-500/30 flex items-center justify-center transition-all">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                    </div>
                    <span>Instagram</span>
                  </a>
                </div>
              </div>
            </div>

            <!-- Contact Form -->
            <form @submit.prevent="submitContact" class="space-y-4">
              <div class="grid grid-cols-2 gap-4">
                <div>
                  <input v-model="contactForm.name" type="text" placeholder="Nama Anda *" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-violet-500/50 focus:outline-none focus:bg-white/[0.08] text-white placeholder-white/30 transition-all" />
                  <p v-if="contactForm.errors.name" class="text-red-400 text-xs mt-1">{{ contactForm.errors.name }}</p>
                </div>
                <div>
                  <input v-model="contactForm.email" type="email" placeholder="Email Anda *" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-violet-500/50 focus:outline-none focus:bg-white/[0.08] text-white placeholder-white/30 transition-all" />
                  <p v-if="contactForm.errors.email" class="text-red-400 text-xs mt-1">{{ contactForm.errors.email }}</p>
                </div>
              </div>
              <div>
                <input v-model="contactForm.subject" type="text" placeholder="Subjek (opsional)" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-violet-500/50 focus:outline-none focus:bg-white/[0.08] text-white placeholder-white/30 transition-all" />
              </div>
              <div>
                <textarea v-model="contactForm.body" rows="5" placeholder="Tulis pesan Anda di sini... *" class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 focus:border-violet-500/50 focus:outline-none focus:bg-white/[0.08] text-white placeholder-white/30 transition-all resize-none"></textarea>
                <p v-if="contactForm.errors.body" class="text-red-400 text-xs mt-1">{{ contactForm.errors.body }}</p>
              </div>
              <button type="submit" :disabled="contactForm.processing" class="w-full py-4 rounded-2xl bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-500 hover:to-purple-500 font-semibold transition-all duration-300 hover:shadow-2xl hover:shadow-violet-500/25 disabled:opacity-50 disabled:cursor-not-allowed">
                {{ contactForm.processing ? "Mengirim..." : "Kirim Pesan ✉️" }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 border-t border-white/5 text-center text-white/30 text-sm">
      <p>© {{ new Date().getFullYear() }} {{ owner?.name ?? "Portfolio" }}. Dibuat dengan ❤️ menggunakan Laravel & Vue.js</p>
    </footer>
  </div>
</template>

<style>
.animate-on-scroll {
  transition: opacity 0.7s ease, transform 0.7s ease;
}
.animate-on-scroll.visible {
  opacity: 1 !important;
  transform: translateY(0) !important;
}
.toast-enter-active, .toast-leave-active { transition: all 0.3s ease; }
.toast-enter-from, .toast-leave-to { opacity: 0; transform: translateY(-20px) scale(0.95); }
</style>