<?php

namespace Config;

class Router{ 

	public static function direccionar(Request $request){
		$controlador = $request->getControladora();
		$metodo = $request->getMetodo();
		$parametros = $request->getParametros();

		self::ejecutar(self::instanciar($controlador) , $metodo , $parametros);

	}

	static function instanciar($controlador){
	    $ruta = "Controladora\\" . $controlador . "Controladora";
	    return new $ruta;
	}

	static function ejecutar($controlador, $metodo, $parametros){
		try{
			if(!isset($parametros)){
				if(is_callable(array($controlador, $metodo)))	
	        		call_user_func(array($controlador, $metodo));
	        	else
	        		header("location: /");
			}else{
				if(is_callable(array($controlador,$metodo)))
					call_user_func_array(array($controlador,$metodo), $parametros);
				else
					header("location: /");
			}
		}catch(\ArgumentCountError $e){
			header("location: /");

		}catch(\Exception $e){
			header("loaction: /");
		}
	}
}

?>
