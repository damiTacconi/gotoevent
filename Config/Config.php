<?php

namespace Config;

#configs constantes
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "1234");
define("DB_NAME", "gotoevent");

#config constante admins
define("ADMIN_EMAIL" , serialize(array(
    1 => 'dami_tano_95@hotmail.com',
    2 => 'admin@admin.com'
)));

#configs directorios
define("ROOT" , dirname(__DIR__) . '/');
define("URL_VISTA", ROOT . 'Vista/');
define("URL_JSON", ROOT . 'Dao/json/');
define("HEADER", URL_VISTA . 'header.php');
define("FOOTER", URL_VISTA . 'footer.php');
