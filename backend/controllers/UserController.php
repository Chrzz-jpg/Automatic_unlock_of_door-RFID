<?php

namespace App\Controllers;

/**
 * Controller de Exemplo
 */
class UserController {
     /**
     * Container Class
     * @var [object]
     */
    private $container;

   


   protected $tag;
   protected $matricula;
   protected $name;

  /**
     * Undocumented function
     * @param [object] $container
     */
    public function __construct($container) {
        $this->container = $container;
    }
    

     /**
     * Método de Exemplo
     *
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return void Response
     */
    public function addUser($tag, $name, $matricula) {
        // journalctl -xe
    }
    public function removeUser($matricula)
    {
        # code...
    }

    public function searchAll()
    {
        # code...
    }
    public function updateUser($tag, $name = null, $matricula = null)
    {
        # code...
    }   

}