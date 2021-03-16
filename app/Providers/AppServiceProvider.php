<?php

namespace App\Providers;

use App\Repositories\Functionalities\FieldsExists;
use App\Repositories\Functionalities\FieldsExistsInterface;
use App\Repositories\NumberConversionsRepository;
use App\Repositories\NumberConversionsRepositoryInterface;
use App\Repositories\ParamObj\NrConversionsRepoIndex;
use App\Repositories\ParamObj\NrConversionsRepoIndexInterface;
use App\Services\NumericConverter\NumericConverter;
use App\Services\NumericConverter\NumericConverterInterface;
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
        // Repositories
        app()->bind(NumberConversionsRepositoryInterface::class, NumberConversionsRepository::class);

        //Services
        app()->bind(NumericConverterInterface::class, NumericConverter::class);
        app()->bind(FieldsExistsInterface::class, FieldsExists::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
