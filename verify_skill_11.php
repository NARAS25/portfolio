<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$s = App\Models\Skill::find(11);
if ($s) echo 'FOUND:' . $s->id . ':' . $s->name . PHP_EOL; else echo 'NOT-FOUND' . PHP_EOL;
