<?php

use Rave\Core\Controller;

use Rave\Library\Core\In;
use Rave\Library\Core\Out;

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