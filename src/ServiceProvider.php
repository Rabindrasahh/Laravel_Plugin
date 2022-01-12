<?php

namespace Acelle\Plugin\AddNewLeadToCrm;

use Illuminate\Support\ServiceProvider as Base;
use Acelle\Plugin\AddNewLeadToCrm\Main;

class ServiceProvider extends Base
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Get the Plugin Main object
        $plugin = new Main();

        // Only register hook if plugin is active
        // However, it is better that the host application controls this
        $plugin->registerHooks();

        // routes
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        // view
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'add_new_lead_to_crm');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Hello
    }
}
