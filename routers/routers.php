<?php

use MiniRest\Http\Middlewares\AuthMiddleware;
use MiniRest\Router\Router;

use MiniRest\Http\Controllers\{
    Users\UserController,AuthController
};
use MiniRest\Http\Controllers\Prestador\PrestadorController;

Router::post('/auth/login', [AuthController::class, 'login']);
Router::post('/api/user/create', [UserController::class, 'store']);

Router::prefix('/api')->group([AuthMiddleware::class], function () {

    // User
    Router::get('/user/getAll', [UserController::class, 'index']);
    Router::patch('/user/update', [UserController::class, 'update']);
    Router::get('/user/me', [UserController::class, 'me']);
    
    // Verify jwt token from logged user
    Router::get('/profile', [AuthController::class, 'profile']);
    Router::post('/prestador/create', [PrestadorController::class, 'store']);
    Router::post('/prestador/update', [PrestadorController::class, 'update']);
    Router::get('/prestador/me', [PrestadorController::class, 'me']);




});