<?php

use Rave\Core\Controller;

class Single extends Controller
{
    public function __construct()
    {
        $this->setLayout('default');
    }

    public function post()
    {
        $this->loadView('viewSingle');
    }

    public function page()
    {

    }
}