<?php

/*
    WaxConfigSet

    Type: configuration
    Object: Configuration variables
    Update: 21 Jun 2016
    Author: A Guerrero
*/

$devServerList = array("127.0.0.1","::1","192.168.0.102","localhost");
$folderDev = "onebike";

if(!in_array($_SERVER['SERVER_NAME'], $devServerList)){
    $urlHost  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $urlHost .= $_SERVER['SERVER_NAME'] . '/';
    define("_HOST", $urlHost);
    define("_SITIO", "http://camcar.mx/sitio/");
    define("_INTRANET", "http://camcar.mx/intranet/");
    define("_ADMIN", "http://camcar.mx/intranet/admin/");
} else {
    $urlHost  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $urlHost .= $_SERVER['SERVER_NAME'] . '/' . $folderDev.'/';
    define("_HOST", $urlHost);
    define("_SITIO", "http://localhost/camcar/sitio/");
    define("_INTRANET", "http://localhost/camcar/intranet/");
    define("_ADMIN", "http://localhost/camcar/intranet/admin/");
}

?>
