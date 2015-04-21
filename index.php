<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
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
