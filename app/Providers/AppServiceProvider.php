<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

use App\Repository\User\UsersRepository;
use App\Repository\User\EloquentUsersRepository;
use App\Repository\User\ElasticsearchUsersRepository;

use App\Repository\Company\CompanysRepository;
use App\Repository\Company\EloquentCompanysRepository;
use App\Repository\Company\ElasticsearchCompanysRepository;

use App\Repository\Profile\ProfileRepository;
use App\Repository\Profile\EloquentProfileRepository;
use App\Repository\Profile\ElasticsearchProfileRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
        public function register()
        {
            $this->app->singleton(UsersRepository::class, function($app) {
                if (!config('services.search.enabled')) {
                    return new EloquentUsersRepository();
                }
                return new ElasticsearchUsersRepository(
                    $app->make(Client::class)
                );
            });
            
            $this->app->singleton(CompanyRepository::class, function($app) {
                if (!config('services.search.enabled')) {
                    return new EloquentCompanyRepository();
                }
                return new ElasticsearchCompanyRepository(
                    $app->make(Client::class)
                );
            });

            $this->app->singleton(ProfileRepository::class, function($app) {
                if (!config('services.search.enabled')) {
                    return new EloquentProfileRepository();
                }
                return new ElasticsearchProfileRepository(
                    $app->make(Client::class)
                );
            });

            $this->bindSearchClient();
        }

        private function bindSearchClient()
        {
            $this->app->bind(Client::class, function ($app) {
                return ClientBuilder::create()
                    ->setHosts(config('services.search.hosts'))
                    ->build();
            });
        }
    
}
