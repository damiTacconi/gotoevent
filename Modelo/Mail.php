<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 4/10/2018
 * Time: 18:51
 */

namespace Modelo;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    function enviarMail( $subjet, $html , $email, $imagenes){
        include_once '../lib/mail/src/PHPMailer.php';
        include_once '../lib/mail/src/Exception.php';
        include_once '../lib/mail/src/SMTP.php';

        $mail = new PHPMailer();

        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; //465;
        $mail->SMTPSecure = 'ssl';//'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = "damian.tacconi.95@gmail.com";
        $mail->Password = "dt19951905dt";
        $mail->setFrom('gotoevent@gmail.com', 'Equipo de GoToEvent');
        if(is_array($email)){
            for($i=0;$i<count($email);$i++){
                $mail->addAddress($email[$i]);
            }
        }else $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subjet;
        $mail->Body    = $html;

        if(isset($imagenes)){
            if(is_array($imagenes)){
                foreach ($imagenes as $imagen){
                    $mail->addEmbeddedImage($imagen['path'],$imagen['cid']);
                }
            }
        }
        if (!$mail->send()) {
            try {
                throw new \Exception("ERROR");
            }catch (\Exception $e){
                throw $e;
            }
        }
    }
}