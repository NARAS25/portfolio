<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$e = App\Models\Experience::find(4);
if ($e) echo 'FOUND:' . $e->id . ':' . $e->title . PHP_EOL; else echo 'NOT-FOUND' . PHP_EOL;
