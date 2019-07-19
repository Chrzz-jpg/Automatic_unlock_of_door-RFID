<?php
 use \Slim\Interfaces\CallableResolverInterface;


 use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/', function (Request $request, Response $response) {
       $response = $this->view->render($response, 'index.html');
    return $response;
})->setName('home');

// $app->get('/login', "\App\controllers\AuthController:check");

$app->get('/login', function ($request, $response, $args) {
    // Check if the user's credentials are valid, then log them in however you keep track of users.
    // Obviously this method isn't secure, and is just used to illustrate the flow.
    if ($request->getParsedBodyParam('name') === 'user') {
        $_SESSION['isLoggedIn'] = 'no';
        session_regenerate_id();
        // Login success, redirect to the dashboard.
        return $response->withRedirect("/logs");
    }
    // Login failed, redirect home.
    $uri = $this->router->pathFor('home');
    // return $response->withRedirect($uri);
    // $return = $response->withJson(["url"=>$_SESSION['isLoggedIn']], 201)
    //   ->withHeader('Content-type', 'application/json')
    //   ->withHeader("Access-Control-Allow-Origin","*");
    // return $return;
    $response = $this->view->render($response, 'login.html');
    return $response;
});

$app->post('/login',"\App\controllers\AuthController:check");



$app->get('/lista', function (Request $request, Response $response) {
   
    $response = $this->view->render($response, 'lista.html');
    return $response;
})->add('Auth');;

$app->get('/users', function (Request $request, Response $response) {
   
    $response = $this->view->render($response, 'users.html');
    return $response;
})->add('Auth');;
$app->get('/logs',function (Request $request, Response $response) {
   
    $response = $this->view->render($response, 'logs.html');
    return $response;
})->setName('home');

$app->get('/capeta',"\App\controllers\AdminController:addAdmin");

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