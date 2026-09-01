<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$e = App\Models\Experience::where('title', 'LIKE', 'CLI Experience %')->orderBy('id','desc')->first();
if ($e) echo $e->id . PHP_EOL; else echo '' . PHP_EOL;
