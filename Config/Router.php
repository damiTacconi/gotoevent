<?php 

namespace Config;

class Router{

	public static function direccionar(Request $request){
		$controlador = $request->getControlador();
		$metodo = $request->getMetodo();
		$parametros = $request->getParametros();

		self::ejecutar(self::instanciar($controlador) , $metodo , $parametros);

	}

	static function instanciar($controlador){
	    $ruta = "Controladora\\" . $controlador . "Controladora";
	    return new $ruta;
	}

	static function ejecutar($controlador, $metodo, $parametros){
		if(!isset($parametros)){
			call_user_func(array($controlador, $metodo));
		}else{
			call_user_func_array(array($controlador,$metodo), $parametros);
		}
	}
}

?>