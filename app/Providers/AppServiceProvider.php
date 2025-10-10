<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Register custom Blade directives for helper functions
        Blade::directive('formatBytes', function ($bytes) {
            return "<?php
                if (function_exists('formatBytes')) {
                    echo formatBytes($bytes);
                } else {
                    \$size = $bytes;
                    \$units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                    \$i = 0;
                    while (\$size >= 1024 && \$i < count(\$units) - 1) {
                        \$size /= 1024;
                        \$i++;
                    }
                    echo round(\$size, 2) . ' ' . \$units[\$i];
                }
            ?>";
        });
    }
}
