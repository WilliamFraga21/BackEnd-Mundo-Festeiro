<?php

use MiniRest\Http\Middlewares\AuthMiddleware;
use MiniRest\Router\Router;

use MiniRest\Http\Controllers\{
    Users\UserController,AuthController
};
use MiniRest\Http\Controllers\Evento\EventoController;
use MiniRest\Http\Controllers\Prestador\PrestadorController;
use MiniRest\Http\Controllers\Prestador\PrestadorProfessionController;
use MiniRest\Http\Controllers\Professions\ProfessionsController;


Router::post('/auth/login', [AuthController::class, 'login']);
Router::post('/api/user/create', [UserController::class, 'store']);
Router::get('/prestador/getALL', [PrestadorController::class, 'index']);
Router::get('/profissao/getALL', [ProfessionsController::class, 'index']);


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
    Router::post('/prestador/id/{id}', [PrestadorController::class, 'findById']);
    Router::post('/prestador/createProfession', [PrestadorProfessionController::class, 'store']);
    Router::post('/prestador/updateProfession', [PrestadorProfessionController::class, 'update']);
    Router::get('/prestadorprofession/me', [PrestadorProfessionController::class, 'me']);
    Router::post('/prestadorprofession/delete/{id}', [PrestadorProfessionController::class, 'delete']);
    
    
    Router::post('/evento/create', [EventoController::class, 'store']);
});