<?php

require 'vendor/autoload.php';

$container = new \Slim\Container();

date_default_timezone_set('America/Sao_paulo');

// $conn = array(
//     'driver' => 'pdo_mysql',
//     'host'=>'dev.local',
//     'user'=>'root',
//     'password'=>'123',
//     'dbname'=>'slim_artigo_blog'
// );


// Doctrine DBAL

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

$dbalconfig = new Doctrine\DBAL\Configuration();
$conn = Doctrine\DBAL\DriverManager::getConnection($conn , $dbalconfig);

// Doctrine ORM
$ormconfig = new Doctrine\ORM\Configuration();
$cache = new Doctrine\Common\Cache\ArrayCache();
$ormconfig->setQueryCacheImpl($cache);
$ormconfig->setProxyDir(__DIR__ . '/backend/models/EntityProxy');
$ormconfig->setProxyNamespace('EntityProxy');
$ormconfig->setAutoGenerateProxyClasses(true);

// ORM mapping by Annotation
Doctrine\Common\Annotations\AnnotationRegistry::registerFile(__DIR__ . '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
$driver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
    new Doctrine\Common\Annotations\AnnotationReader(),
    array(__DIR__ . '/backend/models/Entity')
);
$ormconfig->setMetadataDriverImpl($driver);
$ormconfig->setMetadataCacheImpl($cache);

// EntityManager
$em = Doctrine\ORM\EntityManager::create($conn ,$ormconfig);

// The Doctrine Classloader
require __DIR__ . '/vendor/doctrine/common/lib/Doctrine/Common/ClassLoader.php';
$classLoader = new Doctrine\Common\ClassLoader('Entity', __DIR__ . '/backend/models');
$classLoader->register();


//  Add View
$container['view'] = new \Slim\Views\PhpRenderer(  __DIR__ . '/templates');

/**
 * Coloca o Entity manager dentro do container com o nome de em (Entity Manager)
 */
$container['em'] = $em ;
$app = new \Slim\App($container);


