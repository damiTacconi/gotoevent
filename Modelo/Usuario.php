<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 4/9/2018
 * Time: 23:24
 */

namespace Modelo;


class Usuario
{
    private $id;
    protected $email;
    protected $password;

    function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    function setId($id){
        $this->id=$id;
    }

    function getId(){return $this->id;}
    function getEmail(){return $this->email;}
    function getPassword(){return $this->password;}

}