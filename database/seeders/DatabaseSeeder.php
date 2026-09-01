<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'          => 'Nama Anda',
            'email'         => 'admin@portfolio.test',
            'password'      => Hash::make('password'),
            'tagline'       => 'Full Stack Developer & UI/UX Enthusiast',
            'bio'           => 'Saya adalah seorang Full Stack Developer dengan passion dalam membuat aplikasi web yang indah dan fungsional. Berpengalaman dalam Laravel, Vue.js, dan teknologi modern lainnya.',
            'github_url'    => 'https://github.com',
            'linkedin_url'  => 'https://linkedin.com',
            'instagram_url' => 'https://instagram.com',
        ]);

        // Skills
        $skills = [
            ['name' => 'Laravel', 'category' => 'Backend', 'level' => 90, 'icon' => '🔴', 'order' => 1],
            ['name' => 'PHP', 'category' => 'Backend', 'level' => 85, 'icon' => '🐘', 'order' => 2],
            ['name' => 'MySQL', 'category' => 'Database', 'level' => 80, 'icon' => '🗄️', 'order' => 3],
            ['name' => 'Vue.js', 'category' => 'Frontend', 'level' => 85, 'icon' => '💚', 'order' => 4],
            ['name' => 'JavaScript', 'category' => 'Frontend', 'level' => 80, 'icon' => '🟡', 'order' => 5],
            ['name' => 'TailwindCSS', 'category' => 'Frontend', 'level' => 90, 'icon' => '🎨', 'order' => 6],
            ['name' => 'HTML/CSS', 'category' => 'Frontend', 'level' => 95, 'icon' => '🌐', 'order' => 7],
            ['name' => 'Git', 'category' => 'Tools', 'level' => 80, 'icon' => '🔧', 'order' => 8],
            ['name' => 'Docker', 'category' => 'Tools', 'level' => 65, 'icon' => '🐳', 'order' => 9],
            ['name' => 'Figma', 'category' => 'Tools', 'level' => 70, 'icon' => '🎯', 'order' => 10],
        ];
        foreach ($skills as $skill) {
            $user->skills()->create($skill);
        }

        // Projects
        $projects = [
            [
                'title'       => 'E-Commerce Platform',
                'slug'        => 'ecommerce-platform',
                'description' => 'Platform e-commerce lengkap dengan manajemen produk, keranjang belanja, dan payment gateway.',
                'tech_stack'  => ['Laravel', 'Vue.js', 'MySQL', 'TailwindCSS'],
                'github_url'  => 'https://github.com',
                'demo_url'    => 'https://demo.example.com',
                'status'      => 'published',
                'order'       => 1,
            ],
            [
                'title'       => 'Task Management App',
                'slug'        => 'task-management-app',
                'description' => 'Aplikasi manajemen tugas dengan fitur kolaborasi tim, drag-and-drop, dan notifikasi real-time.',
                'tech_stack'  => ['Laravel', 'Inertia.js', 'Vue.js', 'Pusher'],
                'github_url'  => 'https://github.com',
                'status'      => 'published',
                'order'       => 2,
            ],
            [
                'title'       => 'Portfolio Website',
                'slug'        => 'portfolio-website',
                'description' => 'Website portfolio personal dengan CMS admin untuk mengelola proyek, skill, dan pengalaman.',
                'tech_stack'  => ['Laravel', 'Inertia.js', 'Vue.js', 'TailwindCSS'],
                'github_url'  => 'https://github.com',
                'status'      => 'published',
                'order'       => 3,
            ],
        ];
        foreach ($projects as $project) {
            $user->projects()->create($project);
        }

        // Experiences
        $experiences = [
            [
                'type'         => 'work',
                'title'        => 'Full Stack Developer',
                'organization' => 'PT. Teknologi Indonesia',
                'location'     => 'Jakarta, Indonesia',
                'description'  => 'Mengembangkan aplikasi web enterprise menggunakan Laravel dan Vue.js. Memimpin tim frontend dan berkolaborasi dengan tim backend.',
                'start_date'   => '2023-01-01',
                'is_current'   => true,
                'order'        => 1,
            ],
            [
                'type'         => 'work',
                'title'        => 'Junior Web Developer',
                'organization' => 'CV. Digital Kreatif',
                'location'     => 'Bandung, Indonesia',
                'description'  => 'Membangun website klien dengan PHP, MySQL, dan JavaScript. Bekerja dengan tim agile dalam pengembangan fitur.',
                'start_date'   => '2021-06-01',
                'end_date'     => '2022-12-31',
                'is_current'   => false,
                'order'        => 2,
            ],
            [
                'type'         => 'education',
                'title'        => 'S1 Teknik Informatika',
                'organization' => 'Universitas Indonesia',
                'location'     => 'Depok, Indonesia',
                'description'  => 'Fokus pada pemrograman web, algoritma, dan rekayasa perangkat lunak. IPK 3.75.',
                'start_date'   => '2017-08-01',
                'end_date'     => '2021-05-31',
                'is_current'   => false,
                'order'        => 3,
            ],
        ];
        foreach ($experiences as $exp) {
            $user->experiences()->create($exp);
        }
    }
}
