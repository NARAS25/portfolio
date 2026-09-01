<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$p = App\Models\Project::where('title', 'LIKE', 'CLI Test Project%')->orderBy('id','desc')->first();
if ($p) echo 'FOUND:' . $p->id . PHP_EOL . 'TITLE:' . $p->title . PHP_EOL; else echo 'NOT-FOUND' . PHP_EOL;
