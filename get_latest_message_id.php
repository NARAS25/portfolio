<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$m = App\Models\Message::latest()->first();
if ($m) echo $m->id . PHP_EOL; else echo '' . PHP_EOL;
