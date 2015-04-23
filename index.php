<?php

session_start();

use Rave\Library\Core\IO\In;

use Rave\Core\Router;
use Rave\Core\Autoloader;

define('ROOT', __DIR__);

require_once ROOT . '/Core/Autoloader.php';

Autoloader::register();

try {
    Router::get(In::get('page'));
} catch (RouterException $routerException) {
    Error::create($routerException->getMessage(), '404');
}
