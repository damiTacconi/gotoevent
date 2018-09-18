<?php
if(empty($_SESSION)){
    session_start();
}

require_once("../Config/Config.php");
require_once("../Config/Autoload.php");

\Config\Autoload::autoload();

use Config\Router;
use Config\Request;

Router::direccionar(new Request());
