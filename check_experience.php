<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$e = App\Models\Experience::where('title', 'LIKE', 'CLI Experience %')->orderBy('id','desc')->first();
if ($e) echo 'FOUND:' . $e->id . ':' . $e->title . PHP_EOL; else echo 'NOT-FOUND' . PHP_EOL;
#CHECKTITLE:CLI Experience 1917529357
