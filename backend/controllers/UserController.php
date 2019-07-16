<?php

namespace App\Controllers;

use Entity\Users;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



use Doctrine\ORM\Query\AST\NewObjectExpression;

/**
 * Controller de Exemplo
 */
class UserController
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
  public function addUser($request, $response, $args)
  {

    $params = (object) $request->getParams();

    /**
     * Pega o Entity Manager do nosso Container
     */
    // var_dump($this->container->get("em"));
    $entityManager = $this->container->get("em");

    /**
     * Instância da nossa Entidade preenchida com nossos parametros do post
     */
    $user = (new Users())->setNome($params->nome)
      ->setId($params->matricula)
      ->setTagId($params->tagId);

    /**
     * Persiste a entidade no banco de dados
     */
    $entityManager->persist($user);
    $entityManager->flush();
    $return = $response->withJson($user->getValues(), 201)
      ->withHeader('Content-type', 'application/json');
    return $return;
  }
  public function removeUser($request, $response, $args)
  {
    # code...
  }

  public function searchAll($request, $response, $args)
  {

    $a->name = "Christian";
    $a->id = 17204298;
    $a->data = "Passou em POO";

    $b->name = "Cristian";
    $b->id = 14011234;
    $b->data = "Nunca mais faz a REC";


    // $dataArray = array(['id' => '12', 'name' => 'somethingElse', 'data' => '00']);
    $dataArray = [];

    array_push($dataArray, $a);
    array_push($dataArray, $b);

    // return $response->write(json_encode($dataArray))
    return $response->withJson($dataArray)
      ->withHeader("Access-Control-Allow-Origin", "*");
  }
  public function updateUser($request, $response, $args)
  {
    # code...
  }
}
