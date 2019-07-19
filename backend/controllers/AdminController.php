<?php

namespace App\Controllers;

use Entity\Admin;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Auth\Login;

// use App\Controllers\AuthController;
/**
 * Controller de Exemplo
 */
class AdminController
{
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


  /**
   * Método de Exemplo
   *
   * @param [type] $request
   * @param [type] $response
   * @param [type] $args
   * @return void Response
   */
  public function addAdmin($request, $response, $args)
  {

    $params = (object) $request->getParams();

    /**
     * Pega o Entity Manager do nosso Container
     */
    // var_dump($this->container->get("em"));
    $entityManager = $this->container->get("em");
    #$params->nome
    #$params->password
    
    /**
     * Instância da nossa Entidade preenchida com nossos parametros do post
     */
    $data= [];
    
    $data["password"] = $params->password;
    if (isset($params->nome))
         $data["user"] = $this->validarUserbyName("capeta");
    if ($data["user"]) {
        $entityManager = $this->container->get('em');
        $admin = new Admin($data);
        $entityManager->persist($admin);
        $entityManager->flush();
        $respota = $data["user"]->getValues();
    }else 
    {
        $respota = ["user"=>"Don't exist"];
    }
    
  
    $return = $response->withJson($respota, 201)
      ->withHeader('Content-type', 'application/json')
      ->withHeader("Access-Control-Allow-Origin","*");
    return $return;
  }
/**
   * Deleta um Livro
   * @param [type] $request
   * @param [type] $response
   * @param [type] $args
   * @return Response
   */
  public function removeUser($request, $response, $args)
  {
    
    $params = (object) $request->getParams();
    $id = (int) $params->matricula ;
        /**
         * Encontra o Livro no Banco
         */ 
        $entityManager = $this->container->get('em');
        $userRepo = $entityManager->getRepository('Entity\Users');
        $user = $userRepo->find($id);   
        /**
         * Verifica se existe um livro com a ID informada
         */
        if (!$user) {
            throw new \Exception("Users not Found", 404);
        }  
        /**
         * Atualiza e Persiste o Livro com os parâmetros recebidos no request
         */ 
    /**
     * Remove a entidade
     */
    $entityManager->remove($user);
    $entityManager->flush(); 
    $return = $response->withJson(['msg' => "Delete {$id}"], 200)
        ->withHeader('Content-type', 'application/json')
        ->withHeader("Access-Control-Allow-Origin", "*");
        return $return;    
  }


  /**
     * Exibe as informações de um livro 
     * @param [type] $request
     * @param [type] $response
     * @param [type] $args
     * @return Response
     */
  public function searchAll($request, $response, $args)
  {
    $entityManager = $this->container->get('em');
    $userRepo = $entityManager->getRepository('Entity\Users');
    $users = $userRepo->findAll(); 
    $uses_array = array();
    foreach ($users as $user) {
        $uses_array[] = array(
            'name' => $user->getNome(),
            'id' => $user->getId(),
            'orientador' => $user->getOrientador(),
            // other fields
        );
    }

    return $response->withJson($uses_array)
      ->withHeader("Access-Control-Allow-Origin", "*");
  }

  /**
   * Atualiza um Livro
   * @param [type] $request
   * @param [type] $response
   * @param [type] $args
   * @return Response
  */
  public function updateUser($request, $response, $args)
  {
    $params = (object) $request->getParams();
    $id = (int) $params->matricula ;
        /**
         * Encontra o Livro no Banco
         */ 
        $entityManager = $this->container->get('em');
        $userRepo = $entityManager->getRepository('Entity\Users');
        $user = $userRepo->find($id);   
        /**
         * Verifica se existe um livro com a ID informada
         */
        if (!$user) {
            throw new \Exception("user not Found", 404);
        }  
        /**
         * Atualiza e Persiste o Livro com os parâmetros recebidos no request
         */
        $user->settagId($params->tagId);
        /**
         * Persiste a entidade no banco de dados
         */
        $entityManager->persist($user);
        $entityManager->flush();        
        
        $return = $response->withJson($user->getValues(), 200)
            ->withHeader('Content-type', 'application/json')
            ->withHeader("Access-Control-Allow-Origin", "*");
        return $return;       


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
