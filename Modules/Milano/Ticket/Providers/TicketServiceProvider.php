<?php
namespace Milano\Ticket\Providers;

use Milano\Ticket\Models\Reply;
use Milano\Ticket\Models\Ticket;
use Milano\Ticket\Policies\ReplyPolicy;
use Milano\Ticket\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider {
    public $namespace = "Milano\Ticket\Http\Controllers";
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . "/../Resources/Views", "Ticket");
        $this->loadMigrationsFrom(__DIR__ . "/../Database/Migrations");
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../Routes/web.php');
        $this->loadJsonTranslationsFrom(__DIR__ . "/../Resources/Lang");
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(Reply::class, ReplyPolicy::class);
    }

    public function boot()
    {
        config()->set('sidebar.items.tickets', [
            "icon" => "i-tickets",
            "title" => "تیکت های پشتیبانی",
            "url" => route('tickets.index'),
        ]);
    }
}
