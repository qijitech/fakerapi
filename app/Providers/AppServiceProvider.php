<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\AuthInterface;
use App\Repositories\Interfaces\CategoryInterface;
use App\Repositories\Interfaces\PostInterface;
use App\Repositories\PostRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(PostInterface::class, PostRepository::class);
    $this->app->bind(CategoryInterface::class, CategoryRepository::class);
    $this->app->bind(AuthInterface::class, AuthRepository::class);
  }
}
