<?php

namespace App\Controllers;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Doctrine\DBAL\Types\DateTimeType;
use Entity\Logs;

class EspController {

  
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

  public function validarUser($tag)
    {
        $entityManager = $this->container->get('em');
        $userRepo = $entityManager->getRepository('Entity\Users');
        $user = $userRepo->findOneBy([
            "tagId" => $tag,
            ]); 

        return $user ;
    }

    /**
   * Método de Exemplo
   *
   * @param [type] $request
   * @param [type] $response
   * @param [type] $args
   * @return void Response
   */
    public function autenticUser($request, $response, $args)
    {
        $acess = false;
        $code  = 404;

        $params = (object) $request->getParams();
        $TagId = (string) $params->tagId;

          $user = $this->validarUser($TagId);
        if ($user) {
  
            $log = new Logs();
            $entityManager = $this->container->get('em');
            $log->setMatricula($user);
            $log->setIndate(new \DateTime(date("Y-m-d H:i:s")));
        
            $entityManager->persist($log);
            $entityManager->flush();

            $acess = true;
            $code = 200 ;

        }
        
        $return = $response->withJson(['acess' => $acess], $code)
        ->withHeader('Content-type', 'application/json')
        ->withHeader("Access-Control-Allow-Origin", "*");
        return $return; 

    }

    public function registerLogTable($tag, $name, $matricula)
    {
        # code...
    }

    

}