<?php

session_start();

use Rave\Core\Autoloader;
use Rave\Core\Exception\RouterException;
use Rave\Core\Router;
use Rave\Library\Core\IO\In;

define('ROOT', __DIR__);
define('WEB_ROOT', dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME')));

require_once ROOT . '/Core/Autoloader.php';

Autoloader::register();

try {
    Router::get(In::get('page'));
} catch (RouterException $routerException) {
    Rave\Core\Error::create($routerException->getMessage(), '404');
}
