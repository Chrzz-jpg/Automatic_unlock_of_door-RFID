<?php
namespace App\Controllers;

class LogController {

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
  public function searchAll($request, $response, $args)
  {
    $entityManager = $this->container->get('em');
    $logRepo = $entityManager->getRepository('Entity\Logs');

    $logs = $logRepo->findAll(); 
    $uses_array = array();
    foreach ($logs as $log) {
        $uses_array[] = array(
            'name' => $log->getMatricula()->getNome(),
            'id' => $log->getMatricula()->getId(),
            'data' => $log->GetIndate()->format("Y-m-d H:i:s"),
            // other fields
        );
    }

    return $response->withJson($uses_array)
      ->withHeader("Access-Control-Allow-Origin", "*");
  }

}