<?php

use Rave\Core\Controller;

class Many extends Controller
{
    public function __construct()
    {
        $this->setLayout("default");
    }

    public function  index()
    {
        $this->loadView("viewMany");
    }

    public function  categories($catid = null, $display = null)
    {
        if (is_null($catid)) {
            $catid = '';
        }

        $this->loadView("viewMany", ["id" => $catid]);

    }

    public function  category($catid = null, $display = null)
    {
        if (is_null($catid)) {
            $catid = '';
        }

        $this->loadView("viewMany", ["id" => $catid]);

    }

}