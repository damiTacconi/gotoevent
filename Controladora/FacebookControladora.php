<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 2/9/2018
 * Time: 17:33
 */

namespace Controladora;
use Dao\ClienteBdDao as ClienteDao;
#use Dao\ClienteListaDao as ClienteDao;
use Facebook;


class FacebookControladora
{
    private $clienteDao;

    function __construct()
    {
        $this->clienteDao = ClienteDao::getInstance();
    }

    function index(){
        header('location: /');
    }
    function login(){
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            try {
                $fb = new Facebook\Facebook([
                    'app_id' => '215614699309419',
                    'app_secret' => '2b264b393f18f999b73e5b8df32909de',
                    'default_graph_version' => 'v3.1',
                ]);
            }catch (\Facebook\Exceptions\FacebookSDKException $e){
                die("ERROR_FACEBOOK_SDK: {$e->getMessage()}");
            }

            $helper = $fb->getJavaScriptHelper();
            //$helper = $fb->getRedirectLoginHelper();

            try {
                $accessToken = $helper->getAccessToken();
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo "Graph returned an error[{$e->getCode()}]: " . $e->getMessage();
                if($e->getCode() === 100){
                    header("location: /");
                }else
                    exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            if (! isset($accessToken)) {
                echo 'No cookie set or no OAuth data could be obtained from cookie.';
                exit;
            }

            // Logged in
            // echo '<h3>Access Token</h3>';
            // var_dump($accessToken->getValue());

            $_SESSION['fb_access_token'] = (string) $accessToken;

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,email,first_name,picture{url},last_name', $_SESSION['fb_access_token']);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            /*
             * Capturo los datos del usuario
             */
            $userData = $response->getDecodedBody();

            /*
             * Ingreso los datos en la sesion
             */
            $_SESSION['id']             = $userData['id'];
            $_SESSION['name']           = $userData['name'];
            $_SESSION['email']          = $userData['email'];
            $_SESSION['first_name']     = $userData['first_name'];
            $_SESSION['last_name']      = $userData['last_name'];
            $_SESSION['picture_url']    = $userData['picture']['data']['url'];

            //Verifico si la cuenta existe en la base de datos

            $cliente = $this->clienteDao->traerPorEmail($_SESSION['email']);

            if(!$cliente){
                session_destroy();
                echo "noRegister";
                exit;
            }

            // fin verificar

            // Si el Email corresponde a un admin, le otorgo rol admin.
            // ADMIN_EMAIL = CONSTANTE EN CONFIG.PHP DONDE ESTABLECE LOS EMAILS DE ADMINS.
            if(in_array($_SESSION['email'], unserialize(ADMIN_EMAIL))) {
                $_SESSION['rol'] = 'admin';
            }else $_SESSION['rol'] = 'cliente';
            echo 'success';
        }else{
            //Redirecciono al inicio
            header('location: /');
        }
    }
    function logout(){
        if(!empty($_SESSION)) {
            /*$url = 'https://www.facebook.com/logout.php?next=' . 'https://damiweb.com/' .
                '&access_token=' . $_SESSION['fb_access_token'];*/

            if(isset($_SESSION['fb_access_token'])) {
                unset($_SESSION['rol']);
                unset($_SESSION['email']);
                unset($_SESSION['name']);
                unset($_SESSION['first_name']);
                unset($_SESSION['last_name']);
                unset($_SESSION['picture_url']);
                unset($_SESSION['fb_access_token']);
                unset($_SESSION['id']);
            }
        }
        header('location: /');
    }
}