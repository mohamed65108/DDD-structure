<?php 

namespace Majal\DDD;

use Majal\DDD\Make;
use Majal\DDD\Build;
use Majal\DDD\Directory;
use Illuminate\Support\ServiceProvider;

class DomainDriverDesignServiceProvider extends ServiceProvider{
    

    protected $commands = [
        Directory::class,
        Make::class,
    ];

    public function boot(){
        $this->setConfigs();
        $this->setCommands();
    }
    
    public function register(){

    }

    private function setConfigs(){
        $this->publishes([
            __DIR__.'/../config/ddd.php'   =>  config_path('ddd.php'),
        ]);

        $this->mergeConfigFrom(__DIR__.'/../config/ddd.php', 'ddd');
    }

    private function setCommands(){
        if($this->app->runningInConsole()){
            $this->commands($this->commands);
        }
    }
}