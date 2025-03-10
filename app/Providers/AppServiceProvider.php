<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
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
        View::composer('masterrhu.partials.notifications', function ($view) {
            $healthFacility = session('facility_id');
            
            $unreadNotifications = Notification::where('receiver', $healthFacility)
                ->where('status', 'unread')
                ->get();
    
            $readNotifications = Notification::where('receiver', $healthFacility)
                ->where('status', 'read')
                ->get();
               
            $view->with(compact('unreadNotifications', 'readNotifications'));
        });
    }
}
