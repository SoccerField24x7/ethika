<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Cache;
use App\Models\Order;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* pre-load redis with last 100 orders (totally arbitrary) */
        $orders = Order::with('order_items')->orderBy('id', 'DESC')->limit(100)->get();
        foreach ($orders as $order) {
            Cache::store('redis')->tags(['orders'])->put($order->id, json_encode($order), 600);
        }
    }
}
