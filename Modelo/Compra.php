<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 19:03
 */

namespace Modelo;


class Compra
{
   private $total;
   private $lineas = [];


   function __construct($total){
     $this->total = $total;
   }


}
