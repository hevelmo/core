<?php
include '../../incorporate/db_connect.php';
include '../../incorporate/functions.php';
//Our custom secure way of starting a PHP session.
//sec_session_start();
if(isset($_POST['email'])) {
    $email = $_POST['email'];
    $email = trim($email);
    if(registerCode($email)) {
        $devserverlist = array('127.0.0.1','::1','192.168.0.102','localhost');
        $server = (!in_array($_SERVER['SERVER_NAME'], $devserverlist))
            ? "camcar.mx/intranet"
            : "localhost/camcar/intranet";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://$server/api/v20/intranet/recovery/$email");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $package_geo = curl_exec($ch);
        curl_close($ch);
        header('Location: ../login/');
    } else {
        header('Location: ../recovery/');
    }
} else {
    header('Location: ../recovery/');
}