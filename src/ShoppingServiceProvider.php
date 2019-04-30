<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/5/2019
 * Time: 6:45 PM
 */
namespace Fordav3\Seat\Shopping;
use Fordav3\Seat\Shopping\Commands\PaymentCheck;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ShoppingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->add_routes();
        $this->add_views();
        $this->add_publishes();
        $this->add_composers();
        $this->add_commands();
        //
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function add_commands()
    {
        $this->commands([
            PaymentCheck::class
        ]);
    }
    public function add_publishes()
    {
        $this->publishes([
            __DIR__.'/database/migrations/' => database_path('migrations')
        ]);
    }
    public function add_routes()
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
    }
    public function add_views()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'shopping');
    }
    public function add_composers()
    {
        View::composer(
            'shopping::includes.detailmodal', 'Fordav3\Seat\Shopping\Http\Composers\OrderDetailComposer'
        );
    }
    public function register()
    {
        //
        $this->mergeConfigFrom(
            __DIR__ . '/Config/shopping.sidebar.php','package.sidebar');
        $this->mergeConfigFrom(__DIR__ . '/Config/shopping.permissions.php','web.permissions');
    }
}