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

        $this->get('',"\App\Controllers\UserController:searchAll");
        $this->post('', '\App\Controllers\UserController:addUser');
        $this->put('', '\App\Controllers\UserController:updateUser');
        $this->delete('', '\App\Controllers\UserController:removeUser');
        
    });
  
});