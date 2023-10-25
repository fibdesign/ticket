<?php

namespace Fibdesign\Ticket\Providers;
use Illuminate\Support\ServiceProvider;

class TicketProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfig();
    }

    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishEmails();
        $this->publishControllers();
    }

    private function mergeConfig():void
    {
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'ticket');
    }
    private function getConfigPath(): string
    {
        return __DIR__ . '/../config/ticket.php';
    }
    private function publishConfig():void
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('ticket.php')], 'ticket-config');
    }

    private function getMigrationsPath(): string
    {
        return __DIR__ . '/../database/migrations/';
    }
    private function publishMigrations():void
    {
        $path = $this->getMigrationsPath();
        $this->publishes([$path => database_path('migrations')], 'ticket-migrations');
    }

    private function getEmailPath():string{
        return __DIR__ .'/../resources/views';
    }
    private function publishEmails():void{
        $path = $this->getEmailPath();
        $this->loadViewsFrom($path,'ticket');
    }

    public function publishControllers()
    {
        $this->publishes([
            __DIR__.'/../Controllers/admin/TicketController.php' => app_path('Http/Controllers/TicketController.php'),
            __DIR__.'/../Controllers/admin/TicketMessageController.php' => app_path('Http/Controllers/TicketMessageController.php'),
            __DIR__.'/../Controllers/client/TicketController.php' => app_path('Http/Controllers/TicketController.php'),
            __DIR__.'/../Controllers/client/TicketMessageController.php' => app_path('Http/Controllers/TicketMessageController.php'),
        ], 'ticket-controllers');
    }
}
