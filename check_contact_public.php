<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$m = App\Models\Message::where('email','public@local')->orderBy('id','desc')->first();
if ($m) echo 'FOUND:' . $m->id . ':' . $m->email . PHP_EOL; else echo 'NOT-FOUND' . PHP_EOL;
