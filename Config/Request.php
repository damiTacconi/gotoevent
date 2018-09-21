<?php

namespace Config;

class Request {
	private $controlador;
	private $metodo;
	private $parametros;

	function __construct(){
        $http = $_SERVER['REQUEST_METHOD'];
		$url = $_SERVER['REQUEST_URI'];
		$array = array_filter(explode("/", $url));

		if(empty($array)){
			$this->setControlador("Pagina");
			$this->setMetodo("inicio");
		}else{
			$this->setControlador(ucwords(array_shift($array)));
            if(!empty($array)){
                $this->setMetodo(array_shift($array));

                if($http == "GET"){
                    if(!empty($array))$this->setParametros($array);

                }else if($http == "POST"){
                    if(!empty($_POST))$this->setParametros($_POST);
                }

            }else $this->setMetodo('index');
		}
	}




    /**
     * @return mixed
     */
    public function getControlador()
    {
        return $this->controlador;
    }

    /**
     * @param mixed $controlador
     *
     * @return self
     */
    public function setControlador($controlador)
    {
        $this->controlador = $controlador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMetodo()
    {
        return $this->metodo;
    }

    /**
     * @param mixed $metodo
     *
     * @return self
     */
    public function setMetodo($metodo)
    {
        $this->metodo = $metodo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParametros()
    {
        return $this->parametros;
    }

    /**
     * @param mixed $parametros
     *
     * @return self
     */
    public function setParametros($parametros)
    {
        $this->parametros = $parametros;

        return $this;
    }
}
