<?php

namespace App\Providers;

use App\Models\ExamTaker;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
    public function boot(): void
    {
        Gate::define('start-attempt', function(User $user, ExamTaker $examTaker){
            return $user->student->id === $examTaker->student_id;
        });
    }
}
