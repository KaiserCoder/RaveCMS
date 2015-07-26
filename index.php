<?php

session_start();

use Rave\Core\Autoloader;
use Rave\Core\Error;
use Rave\Core\Exception\RouterException;
use Rave\Core\Router;
use Rave\Library\Core\IO\In;

define('ROOT', __DIR__);
define('WEB_ROOT', dirname(filter_input(INPUT_SERVER, 'SCRIPT_NAME')) . DIRECTORY_SEPARATOR);

require_once ROOT . '/Core/Autoloader.php';

Autoloader::register();

try {
    Router::get(In::get('page'));
} catch (RouterException $routerException) {
    Error::create($routerException->getMessage(), '404');
}
