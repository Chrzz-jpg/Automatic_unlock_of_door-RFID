<?php

require 'vendor/autoload.php';

date_default_timezone_set('America/Sao_paulo');

$isDevMode = true;

$conn = array(
    'driver' => 'pdo_mysql',
    'host'=>'dev.local',
    'user'=>'root',
    'password'=>'123',
    'dbname'=>'slim_artigo_blog'
);

$doctrine = new WebDevBr\Doctrine\Doctrine($conn, $isDevMode);
$doctrine->setEntitiesDir(__DIR__.'/src/App/Entities/');
$entityManager = $doctrine->getEntityManager();
