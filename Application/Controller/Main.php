<?php

use Rave\Core\Controller;

class Main extends Controller
{

    public function __construct()
    {
        $this->setLayout('main');
    }

    public function index()
    {
        $this->loadView('carousel');
    }

}
