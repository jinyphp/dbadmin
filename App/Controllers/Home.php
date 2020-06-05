<?php
namespace App\Controllers;
use \Jiny\Core\Controller;

class Home extends Controller
{
    public function __construction()
    {
        // echo __CLASS__;
    }

    public function main()
    {
        $body = \jiny\template("../Resource/view/home.html");

        return $body;        
    }

}