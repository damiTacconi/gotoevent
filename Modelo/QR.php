<?php
/**
 * Created by PhpStorm.
 * User: dami_
 * Date: 3/10/2018
 * Time: 16:44
 */

namespace Modelo;



class QR
{
    function generateQR($qr , $domain){
        require_once('../lib/phpqrcode/qrlib.php');
        require_once('../lib/config.php');

        // how to save PNG codes to server

        $tempDir = EXAMPLE_TMP_SERVERPATH;

        $codeContents = $qr;

        // we need to generate filename somehow,
        // with md5 or with database ID used to obtains $codeContents...
        $fileName = $domain . '.png';

        $pngAbsoluteFilePath = $tempDir.$fileName;
        $urlRelativeFilePath = EXAMPLE_TMP_URLRELPATH.$fileName;

        // generating
        if (!file_exists($pngAbsoluteFilePath)) {
            \QRcode::png($codeContents, $pngAbsoluteFilePath);
            //echo 'File generated!';
            //echo '<hr />';
        } else {
            //echo 'File already generated! We can use this cached file to speed up site on common codes!';
            //echo '<hr />';
        }

        /*
        echo 'Server PNG File: '.$pngAbsoluteFilePath;
        echo '<hr />';

        // displaying
        echo '<img src="'.$urlRelativeFilePath.'" />';*/
    }


}