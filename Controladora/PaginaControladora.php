<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 17/9/2018
 * Time: 10:36
 */

namespace Controladora;


class PaginaControladora
{

    public  function index(){
        header('location: /');
    }

    public function inicio(){
        if(!empty($_GET)){
            header('location: /');
        }
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin' ){
            $this->page('inicioAdmin', 'Administrar', 2);
        }else{
            $this->page();
        }
    }
    private function showPage($page , $title , $param ,$array){
        if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
            $ruta   = URL_VISTA . 'admin/';
            $header = $ruta . 'header-admin.php';
            $footer = $ruta . 'footer-admin.php';
        }else{
            $ruta   = URL_VISTA;
            $header = $ruta . $array[0] . '.php';
            $footer = $ruta . $array[1] . '.php';
        }
        require($header);
        require($ruta . $page . '.php');
        require($footer);
    }

    protected function page($page="inicio" , $title="GoToEvent" ,
                            $permission=0 , $params = [],
                            $array = [0 => 'header' , 1 => 'footer']){
        $redirect = FALSE;
        switch ($permission){
            case 1:
                if(!empty($_SESSION)){
                    $this->showPage($page,$title,$params,$array);
                }else $redirect = TRUE;
                break;
            case 2:
                if(!empty($_SESSION) && $_SESSION['rol'] === 'admin'){
                    $this->showPage($page,$title,$params,$array);
                }else $redirect = TRUE;
                break;
            default:
                $this->showPage($page,$title,$params,$array);
                break;
        }

        if($redirect){
            header('location: /');
        }

    }
}