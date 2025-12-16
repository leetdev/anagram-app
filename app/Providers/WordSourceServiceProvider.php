<?php

namespace App\Providers;

use App\Services\WordSources\HttpWordSource;
use App\Services\WordSources\WordSourceInterface;
use Illuminate\Support\ServiceProvider;

class WordSourceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind a factory for creating WordSourceInterface
        $this->app->bind(WordSourceInterface::class, function ($app) {
            // Expect "url" to be passed at resolution time
            $url = $app->make('word_source_url');

            return new HttpWordSource($url);
        });
    }

    public function boot(): void
    {
        //
    }
}
