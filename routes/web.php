<?php

use Illuminate\Support\Facades\Route;

Route::get('payment/{id}', 'PaymentController@show');
Route::post('webhook', 'WebhookController@handleWebhook');

