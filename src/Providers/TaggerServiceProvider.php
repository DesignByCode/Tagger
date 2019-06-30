<?php

namespace DesignByCode\Tagger\Providers;

use DesignByCode\Tagger\Models\Tag;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class TaggerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../migrations');

        Tag::creating(function($query) {
            $query->name = Str::title($query->name);
            $query->slug = Str::slug($query->name);
        });

        Tag::updating(function($query) {
            $query->name = Str::title($query->name);
            $query->slug = Str::slug($query->name);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
