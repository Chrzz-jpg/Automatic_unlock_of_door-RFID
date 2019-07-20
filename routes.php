<?php
 use \Slim\Interfaces\CallableResolverInterface;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
       $response = $this->view->render($response, 'index.html');
    return $response;
})->setName('home');

$app->get('/login', function ($request, $response, $args) {
    if ($_SESSION['isLoggedIn'] === 'yes') {
        return $response->withRedirect("/logs");
    }
    $response = $this->view->render($response, 'login.html');
    return $response;
});

$app->post('/login',"\App\controllers\AuthController:check");

$app->get('/logout', function ($request, $response, $args) {
    unset($_SESSION['isLoggedIn']);
    session_regenerate_id();
    return $response->withRedirect($this->router->pathFor('home'));
});

$app->get('/lista', function (Request $request, Response $response) {
   
    $response = $this->view->render($response, 'lista.html');
    return $response;
})->add('Auth');

$app->get('/users', function (Request $request, Response $response) {
   
    $response = $this->view->render($response, 'users.html');
    return $response;
})->add('Auth');;
$app->get('/logs',function (Request $request, Response $response) {
   
    $response = $this->view->render($response, 'logs.html');
    return $response;
})->add('Auth');

$app->get('/admin',"\App\controllers\AdminController:addAdmin");

/**
 * Grupo dos enpoints iniciados por v1
 */
$app->group('/api',function() {
 
    /**
     *  o recurso /users
     */
    $this->group('/users',function() {

        $this->get('',"\App\controllers\UserController:searchAll");
        $this->post('', '\App\controllers\UserController:addUser');
        $this->put('', '\App\controllers\UserController:updateUser');
        $this->delete('', '\App\controllers\UserController:removeUser');
        
    });

    $this->group('/logs',function() {

        $this->get('',"\App\controllers\LogController:searchAll");
   
    });
    $this->group('/esp',function() {

        $this->post('',"\App\controllers\EspController:autenticUser");
   
    });
  
})->add('Auth');
;