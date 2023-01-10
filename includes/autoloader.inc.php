<?php 
    spl_autoload_register('myautoloader');

    function myautoloader($className) {
        $url = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        echo $url;

        if (strpos($url,'includes')) {
            $path = '../controller/';
        } else {
            $path = 'controller/';
        }


        require_once $path.$className.$ext;

    }
?>