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
        View::composer('*', function ($view) use ($conversationService) {

            $user = Auth::user();
            $view->with('user', $user);
            $conversations = [];
            if ($user) {
                $conversations = Cache::remember('user_'.$user->id.'_conversations', 3600, function () use ($conversationService, $user) {
                    return $conversationService->getUserConversations($user->id,request()->input('search'));
                });
            }
            $view->with('conversations', $conversations);
        });
    }
}
