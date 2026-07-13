<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$app->instance('request', $request);
$kernel->bootstrap();
$user = App\Models\User::first();
auth()->login($user);
try {
    $request = Illuminate\Http\Request::create('/admin/term-and-conditions/create', 'GET');
    $response = $kernel->handle($request);
    echo "Status: " . $response->getStatusCode() . "\n";
    if ($response->getStatusCode() === 500) {
        if (property_exists($response, 'exception') && $response->exception) {
            echo $response->exception->getMessage();
        } else {
            echo file_get_contents('storage/logs/laravel.log');
        }
    }
} catch (\Throwable $e) {
    echo $e->getMessage() . "\n" . $e->getTraceAsString();
}
