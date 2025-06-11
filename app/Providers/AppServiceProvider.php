<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public const HOME = '/store';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap(); 
        View::composer('*', function ($view) {
        if (Auth::check()) {
            $user = Auth::user();
            $notifications = $user->unreadNotifications()->take(5)->get();
            $unreadCount = $user->unreadNotifications()->count();
            $view->with(compact('notifications', 'unreadCount'));
        }
    });
        }
    
    
    
}
    
