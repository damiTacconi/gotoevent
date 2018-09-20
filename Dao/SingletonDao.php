<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 20/9/2018
 * Time: 16:08
 */

namespace Dao;

class SingletonDao
{
    private static $instance = array();

    static function getInstance(){
        $class =get_called_class();
        if(!isset(self::$instance[$class]))
        {
            self::$instance[$class]=new $class;
        }
        return self::$instance[$class];
    }
}