<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Product\Domain\Repositories\ProductRepositoryInterface;
use Src\Product\Infrastructure\Persistence\EloquentProductRepository;
use Src\Product\Application\UseCases\RegisterProductUseCase;
use Src\Product\Application\UseCases\GetAllProductsUseCase;
use Src\Product\Application\UseCases\GetProductByIdUseCase;
use Src\Product\Application\UseCases\UpdateProductUseCase;
use Src\Product\Application\UseCases\DeleteProductUseCase;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->bind(RegisterProductUseCase::class, function ($app) {
            return new RegisterProductUseCase($app->make(ProductRepositoryInterface::class));
        });
        $this->app->bind(GetAllProductsUseCase::class, function ($app) {
            return new GetAllProductsUseCase($app->make(ProductRepositoryInterface::class));
        });
        $this->app->bind(GetProductByIdUseCase::class, function ($app) {
            return new GetProductByIdUseCase($app->make(ProductRepositoryInterface::class));
        });
        $this->app->bind(UpdateProductUseCase::class, function ($app) {
            return new UpdateProductUseCase($app->make(ProductRepositoryInterface::class));
        });
        $this->app->bind(DeleteProductUseCase::class, function ($app) {
            return new DeleteProductUseCase($app->make(ProductRepositoryInterface::class));
        });
    }

    public function boot()
    {
        //
    }
}
