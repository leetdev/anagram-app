<?php

namespace App\Providers;

use App\Services\AnagramSolvers\AnagramSolverInterface;
use App\Services\AnagramSolvers\SortedAnagramSolver;
use Illuminate\Support\ServiceProvider;

class AnagramSolverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind a factory for creating AnagramSolverInterface
        $this->app->bind(AnagramSolverInterface::class, function () {
            return new SortedAnagramSolver;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
