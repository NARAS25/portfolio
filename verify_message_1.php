<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$m = App\Models\Message::find(1);
if ($m) echo 'FOUND:' . $m->id . ':is_read=' . ($m->is_read ? '1' : '0') . PHP_EOL; else echo 'NOT-FOUND' . PHP_EOL;
