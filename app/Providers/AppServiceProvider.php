<?php

namespace App\Providers;

use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(ConversationService $conversationService): void
    {
        // Navbar needs only user
        View::composer(['layouts.navbar','auth.profile'], function ($view) {
            $view->with('user', Auth::user());
        });

        // Sidebar needs conversations (expensive)
        View::composer('layouts.sidebar', function ($view) use ($conversationService) {
            $user = Auth::user();
            $conversations = [];

            if ($user) {
                $conversations = $conversationService->getUserConversations(
                    $user->id,
                    request('search')
                );
            }

            $view->with('conversations', $conversations);
        });
    }
}
