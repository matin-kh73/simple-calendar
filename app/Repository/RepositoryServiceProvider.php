<?php


namespace App\Repository;


use App\Repository\Event\EventRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(BaseRepositoryInterface::class, EventRepository::class);
    }

    public function boot()
    {

    }
}
