<?php
namespace Modules\Core\Providers;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    protected string $name = 'Core';
    protected string $nameLower = 'core';

    public function register(): void {}

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', $this->nameLower);
    }
}
