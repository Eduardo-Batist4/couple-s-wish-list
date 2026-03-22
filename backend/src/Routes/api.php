<?php

declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;

$auth = new AuthMiddleware();
$userController = new UserController();
$authController = new AuthController();

// Public routes
$router->post('/auth/register', fn () => $userController->store());
$router->post('/auth/login', fn () => $authController->login());

// Authenticate routes
$router->get('/me', function () use ($auth, $authController) {
    $auth->handle();
    $authController->me();
});
$router->get('/users/{id}', function ($id) use ($auth, $userController) {
    $auth->handle();
    $userController->show((int) $id);
});
$router->put('/users/update', function () use ($auth, $userController) {
    $auth->handle();
    $userController->update();
});



// Just Admin Role
/* 
    $router->get('/users', function () use ($auth, $userController) {
        $auth->handle();
        $userController->index();
    });

    $router->delete('/users/{id}', function ($id) use ($auth, $userController) {
        $auth->handle();
        $userController->delete((int) $id);
    });
*/
