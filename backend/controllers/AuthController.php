<?php

namespace App\Controllers;

class AuthController
{

    private $user;
    private $data;

 /**
   * Container Class
   * @var [object]
   */
  private $container;

  /**
   * Undocumented function
   * @param [object] $container
   */
  public function __construct($container)
  {
    $this->container = $container;
  }


    public function check($user)
    {
        if (!isset($user['password']) or !isset($this->data['password']))
            return false;

        if (password_verify($user['password'], $this->data['password']))
            return true;

        return false;
    }

    public function access()
    {
        $_SESSION['user'] = $this->data;
    }

    public function validarUserbyName($name)
    {
        $entityManager = $this->container->get('em');
        $userRepo = $entityManager->getRepository('Entity\Users');
        $user = $userRepo->findOneBy([
            "nome" => $name,
            ]); 

        return $user ;
    }

}