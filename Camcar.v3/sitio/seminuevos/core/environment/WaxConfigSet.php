<?php

/*
    WaxConfigSet

    Type: configuration
    Object: Configuration variables
    Update: 21 Jun 2016
    Author: A Guerrero
*/

$devServerList = array('127.0.0.1','::1','192.168.0.102','localhost');
$folderDev = 'camcar';

if(!in_array($_SERVER['SERVER_NAME'], $devServerList)){
    $urlHost  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $urlHost .= $_SERVER['SERVER_NAME'] . '/';
    define("_HOST", $urlHost);
} else {
    $urlHost  = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $urlHost .= $_SERVER['SERVER_NAME'] . '/' . $folderDev.'/';
    define("_HOST", $urlHost);
}

define("_INTRANET", "{$urlHost}intranet/");
define("_ADMIN", "{$urlHost}intranet/admin/");
define("_SITIO", "{$urlHost}sitio/");
define("_SEMINUEVOS", "{$urlHost}sitio/seminuevos/");
define("_INVENTARIOS", "{$urlHost}sitio/seminuevos/inventarios/");
define("_DETALLES", "{$urlHost}sitio/seminuevos/detalles/");

?>
