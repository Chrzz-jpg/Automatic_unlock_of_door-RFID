<?php
require  __DIR__ . '/../bootstrap.php';
session_start();
/**
 * Rotas
 */
require __DIR__ . '/../routes.php';

$app->run();