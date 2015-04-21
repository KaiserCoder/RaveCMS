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
    	$this->log('test');
        $this->loadView('viewMain', ['users' => UserModel::selectAll()]);
    }

}
