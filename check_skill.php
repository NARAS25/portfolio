<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$s = App\Models\Skill::where('name', 'CLI Skill 1252527954')->first();
if ($s) echo 'FOUND:' . $s->id . PHP_EOL; else echo 'NOT' . PHP_EOL;
