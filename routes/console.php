<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('api:register {name} {email} {password}', function ($name, $email, $password) {
    $response = Http::post(config('app.url') . '/api/register', [
        'name' => $name,
        'email' => $email,
        'password' => $password,
    ]);
    $this->info($response->body());
});

Artisan::command('api:login {email} {password}', function ($email, $password) {
    $response = Http::post(config('app.url') . '/api/login', [
        'email' => $email,
        'password' => $password,
    ]);
    $this->info($response->body());
});

Artisan::command('api:orders {token} {--composition=} {--per_page=10}', function ($token) {
    $params = [];
    if ($this->option('composition')) {
        $params['composition'] = $this->option('composition');
    }
    if ($this->option('per_page')) {
        $params['per_page'] = $this->option('per_page');
    }
    $response = Http::withToken($token)->get(config('app.url') . '/api/orders', $params);
    $this->info($response->body());
});

Artisan::command('api:change-status {token} {order_id} {status_id}', function ($token, $order_id, $status_id) {
    $response = Http::withToken($token)->post(config('app.url') . "/api/orders/{$order_id}/change-status", [
        'status_id' => $status_id,
    ]);
    $this->info($response->body());
});
