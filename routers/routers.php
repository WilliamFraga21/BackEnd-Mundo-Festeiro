<?php

use MiniRest\Http\Middlewares\AuthMiddleware;
use MiniRest\Router\Router;

use MiniRest\Http\Controllers\{
    Users\UserController,AuthController
};
use MiniRest\Http\Controllers\Evento\EventoController;
use MiniRest\Http\Controllers\Evento\EventoPrestadorController;
use MiniRest\Http\Controllers\Evento\EventoPhotoController;
use MiniRest\Http\Controllers\Prestador\PrestadorController;
use MiniRest\Http\Controllers\Prestador\PrestadorProfessionController;
use MiniRest\Http\Controllers\Professions\ProfessionsController;
use MiniRest\Http\Controllers\AvatarController;


Router::post('/auth/login', [AuthController::class, 'login']);
Router::post('/api/user/create', [UserController::class, 'store']);
Router::get('/prestador/getALL/{id}', [PrestadorController::class, 'index']);
Router::get('/profissao/getALL', [ProfessionsController::class, 'index']);
Router::get('/profissao/getALL2', [ProfessionsController::class, 'index2']);
Router::get('/evento/{id}', [EventoController::class, 'all']);
Router::get('/user/getAll', [UserController::class, 'index']);


Router::prefix('/api')->group([AuthMiddleware::class], function () {

    // User
    Router::patch('/user/update', [UserController::class, 'update']);
    Router::get('/user/me', [UserController::class, 'me']);
    
    // Verify jwt token from logged user
    Router::get('/profile', [AuthController::class, 'profile']);
    Router::post('/prestador/create', [PrestadorController::class, 'store']);
    Router::post('/prestador/update', [PrestadorController::class, 'update']);
    Router::get('/prestador/me', [PrestadorController::class, 'me']);
    Router::get('/prestador/id/{id}', [PrestadorController::class, 'findById']);
    Router::post('/prestador/createProfession', [PrestadorProfessionController::class, 'store']);
    Router::post('/prestador/updateProfession', [PrestadorProfessionController::class, 'update']);
    Router::get('/prestadorprofession/me', [PrestadorProfessionController::class, 'me']);
    Router::post('/prestadorprofession/delete/{id}', [PrestadorProfessionController::class, 'delete']);

    
    
    Router::post('/evento/create', [EventoController::class, 'store']);
    Router::post('/evento/update/{id}', [EventoController::class, 'update']);
    Router::delete('/evento/deletepro/{id}', [EventoController::class, 'deletePro']);
    Router::delete('/evento/delete/{id}', [EventoController::class, 'delete']);
    Router::get('/evento/me', [EventoController::class, 'me']);
    Router::get('/evento/find/{id}', [EventoController::class, 'findById']);
    
    
    Router::post('/evento/enviarproposta', [EventoPrestadorController::class, 'store']);
    Router::get('/evento/getprestadores/{id?}', [EventoPrestadorController::class, 'getPrestadores']);
    Router::post('/evento/aceitarproposta/{id?}', [EventoPrestadorController::class, 'aceitarproposta']);
    
    
    Router::get('/user/avatar/{userId?}', [AvatarController::class, 'avatar']);
    Router::post('/user/avatar/create', [AvatarController::class, 'uploadAvatar']);
    Router::post('/evento/create/photo/{id}', [EventoPhotoController::class, 'uploadPhoto']);
    Router::get('/evento/getphoto/{userId?}', [EventoPhotoController::class, 'avatar']);
    
    
    Router::get('/prestador/propostas', [PrestadorController::class, 'getPropostas']);
    Router::get('/prestador/eventos', [PrestadorController::class, 'getEventsAp']);
    Router::post('/prestador/contratar/{id}', [PrestadorController::class, 'storeContratar']);
    Router::post('/prestador/contratar/aceitar/{id}', [PrestadorController::class, 'aceietarProposta']);

});