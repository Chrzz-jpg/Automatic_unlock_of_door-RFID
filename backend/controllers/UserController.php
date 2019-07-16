<?php

namespace App\Controllers;

/**
 * Controller de Exemplo
 */
class UserController {
    /**
     * Container - Ele recebe uma instancia de um 
     * container da rota no construtor
     * @var object s
     */

   
   protected $tag;
   protected $matricula;
   protected $name;

//    /**
//     * Método Construtor 
//     * @param ContainerInterface $container
//     */
//    public function __construct($tag, $name, $matricula) {
//        $this->$tag = $tag;
//        $this->$name = $name;
//        $this->$matricula = $matricula;
//        }
   

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