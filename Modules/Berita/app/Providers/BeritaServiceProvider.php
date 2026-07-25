<?php
namespace Modules\Berita\Providers;
use Illuminate\Support\ServiceProvider;
class BeritaServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'berita');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
