<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 17:44
 */

namespace Controladora;


use Dao\CalendarioBdDao;

class CalendarioControladora extends PaginaControladora
{
    private $calendarioDao;
    function __construct()
    {
        $this->calendarioDao = CalendarioBdDao::getInstance();
    }


}