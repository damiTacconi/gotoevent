<?php
if(empty($_SESSION)){
    session_start();
}

require_once("../Config/Config.php");
require_once("../Config/Autoload.php");

use \Config\Autoload as Autoload;
use Config\Router;
use Config\Request;

Autoload::autoload();
Router::direccionar(new Request());
