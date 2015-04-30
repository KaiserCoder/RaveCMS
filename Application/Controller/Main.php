<?php

use Rave\Core\Controller;

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
