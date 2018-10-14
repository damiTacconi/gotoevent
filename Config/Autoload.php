<?php 

namespace Config;

class Autoload{

	public static function autoload(){
 	    require __DIR__ . '/fb-sdk/src/Facebook/autoload.php';
	}

}
