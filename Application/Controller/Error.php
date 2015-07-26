<?php

use Rave\Core\Controller;

class Error extends Controller
{

    public function __construct()
    {
        $this->setLayout('default');
    }

    public function internal_server_error()
    {
        Rave\Core\Error::header('500');
        $this->loadView('internalServerError');
    }

    public function not_found()
    {
        Rave\Core\Error::header('404');
        $this->loadView('notFound');
    }

    public function forbidden()
    {
        Rave\Core\Error::header('403');
        $this->loadView('forbidden');
    }

}