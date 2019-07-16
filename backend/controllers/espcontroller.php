<?php

namespace App\v1\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class EspController {

    /**
     * Container - Ele recebe uma instancia de um 
     * container da rota no construtor
     * @var object s
     */

   
   protected $tag;
   protected $matricula;
   protected $name;

   public function __construct($tag, $name, $matricula) {
       $this->$tag = $tag;
       $this->$name = $name;
       $this->$matricula = $matricula;
       }

    public function autenticUser($tag)
    {
        # code...
    }

    public function registerLogTable($tag, $name, $matricula)
    {
        # code...
    }

}