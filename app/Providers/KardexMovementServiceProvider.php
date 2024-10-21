<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\KardexMovement\Domain\Repositories\KardexMovementRepositoryInterface;
use Src\KardexMovement\Infrastructure\Persistence\EloquentKardexMovementRepository;
use Src\KardexMovement\Application\UseCases\RegisterKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\GetAllKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\GetKardexMovementByIdUseCase;
use Src\KardexMovement\Application\UseCases\UpdateKardexMovementUseCase;
use Src\KardexMovement\Application\UseCases\DeleteKardexMovementUseCase;

class KardexMovementServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(KardexMovementRepositoryInterface::class, EloquentKardexMovementRepository::class);
        $this->app->bind(RegisterKardexMovementUseCase::class, function ($app) {
            return new RegisterKardexMovementUseCase($app->make(KardexMovementRepositoryInterface::class));
        });
        $this->app->bind(GetAllKardexMovementUseCase::class, function ($app) {
            return new GetAllKardexMovementUseCase($app->make(KardexMovementRepositoryInterface::class));
        });
        $this->app->bind(GetKardexMovementByIdUseCase::class, function ($app) {
            return new GetKardexMovementByIdUseCase($app->make(KardexMovementRepositoryInterface::class));
        });
        $this->app->bind(UpdateKardexMovementUseCase::class, function ($app) {
            return new UpdateKardexMovementUseCase($app->make(KardexMovementRepositoryInterface::class));
        });
        $this->app->bind(DeleteKardexMovementUseCase::class, function ($app) {
            return new DeleteKardexMovementUseCase($app->make(KardexMovementRepositoryInterface::class));
        });
    }

    public function boot()
    {
        //
    }
}
