<?php 
    spl_autoload_register('myautoloader');

    function myautoloader($className) {
        $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];


        if (strpos($url,'config')) {
            $path = '../classes/';
        } else {
            $path = 'classes/';
        } 
        $ext = ".class.php";
        require_once $path.$className.$ext;
    }

    define('DB_HOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','liwed');
?>