<?php
namespace Modules\BimbinganKonseling\Providers;
use Illuminate\Support\ServiceProvider;
class BkServiceProvider extends ServiceProvider
{
    public function register(): void {}
    public function boot(): void {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'bk');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}
