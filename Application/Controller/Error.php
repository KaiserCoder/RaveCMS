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
        $this->errorHeader('500');
        $this->loadView('internalServerError');
    }

    private function errorHeader($errorCode)
    {
        switch ($errorCode) {
            case '403':
                header('HTTP/1.0 403 Forbidden');
                break;
            case '404':
                header('HTTP/1.0 404 Not Found');
                break;
            case '500':
                header('HTTP/1.0 500 Internal Server Error');
                break;
        }
    }

    public function not_found()
    {
        $this->errorHeader('404');
        $this->loadView('notFound');
    }

    public function forbidden()
    {
        $this->errorHeader('403');
        $this->loadView('forbidden');
    }

}