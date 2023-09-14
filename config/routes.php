<?php

declare(strict_types=1);

use App\Controller\Utils\DocumentationController;
use App\Controller\Utils\HealthHandler;
use Hyperf\HttpServer\Router\Router;

// Utils
Router::get('/health', [HealthHandler::class, 'health']);
Router::get('/liveness', [HealthHandler::class, 'liveness']);

// Swagger Documentation
Router::addGroup('/documentation', function () {
    Router::get('', [DocumentationController::class, 'html']);
    Router::get('/v1.yaml', [DocumentationController::class, 'yaml']);
    Router::get('/v2.yaml', [DocumentationController::class, 'yamlV2']);
});