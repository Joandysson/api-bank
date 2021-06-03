<?php

namespace App\Providers;


use App\Repositories\AccountRepositoryInterface;
use App\Repositories\Eloquent\AccountRepository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Eloquent\TransactionRepository;
use App\Repositories\TransactionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

/**
* Class RepositoryServiceProvider
* @package App\Providers
*/
class RepositoryServiceProvider extends ServiceProvider
{
   /**
    * Register services.
    *
    * @return void
    */
   public function register()
   {
       $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
       $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
       $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
       $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
   }
}