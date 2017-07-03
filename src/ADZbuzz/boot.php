<?php

define('BASE_PATH', dirname(__FILE__) . '/../../');

require(BASE_PATH . "vendor/autoload.php");

$app = new ADZbuzzDevEnv\App(BASE_PATH);
$app->start();