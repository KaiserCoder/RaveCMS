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
        $this->loadView('internalServerError');
    }
    
    public function not_found()
    {
        $this->loadView('notFound');
    }
    
    public function forbidden()
    {
        $this->loadView('forbidden');
    }

}