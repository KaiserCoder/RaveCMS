<?php

session_start();

use Rave\Library\Core\In;

use Rave\Core\Router;
use Rave\Core\Autoloader;

define('ROOT', __DIR__);

require_once ROOT . '/Core/Autoloader.php';

Autoloader::register();

try {
    Router::get(In::get('page'));
} catch (RouterException $exception) {
    Error::create($exception->getMessage(), '404');
}
