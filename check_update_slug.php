<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$p = App\Models\Project::where('slug', 'cli-test-project-1251297712-Rh0Aj')->first();
if ($p) echo 'TITLE:' . $p->title . PHP_EOL; else echo 'MISSING' . PHP_EOL;
