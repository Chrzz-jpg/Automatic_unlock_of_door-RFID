<?php
 use \Slim\Interfaces\CallableResolverInterface;
/**
 * Grupo dos enpoints iniciados por v1
 */
$app->group('/api', function() {
 
    /**
     *  o recurso /users
     */
    $this->group('/users', function() {

        $this->get('',"\App\controllers\UserController:searchAll");
        $this->post('', '\App\controllers\UserController:addUser');
        $this->put('', '\App\controllers\UserController:updateUser');
        $this->delete('', '\App\controllers\UserController:removeUser');
        
    });

    $this->group('/logs', function() {

        $this->get('',"\App\controllers\LogController:searchAll");
   
    });
    $this->group('/esp', function() {

        $this->post('',"\App\controllers\EspController:autenticUser");
   
    });
  
});