<?php

use Rave\Core\Controller;

class Admin extends Controller
{

    public function __construct()
    {
        $this->setLayout('admin');
    }

    public function index()
    {

        $this->loadView('adminLogin');
    }

}