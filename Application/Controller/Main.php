<?php

use Rave\Core\Controller;
use Rave\Application\Model\UserModel;

class Main extends Controller
{

    public function __construct()
    {
        $this->setLayout('default');
    }

    public function index()
    {
        $this->loadView('viewMain');
    }

}
