<?php

require 'vendor/autoload.php';

$app = new Slim\App();

/**
 * Rotas da API
 */
require 'routes.php';

$app->get('/', function ($request, $response) {

    $a->name = "Christian";
    $a->id = 17204298;
    $a->data = "Passou em POO";

    $b->name = "Cristian";
    $b->id = 14011234;
    $b->data = "Nunca mais faz a REC";


    // $dataArray = array(['id' => '12', 'name' => 'somethingElse', 'data' => '00']);
    $dataArray = [];

    array_push ( $dataArray  ,$a);
    array_push ( $dataArray  ,$b);

    // return $response->write(json_encode($dataArray))
    return $response->withJson($dataArray)
    ->withHeader("Access-Control-Allow-Origin","*");
});


$app->run();