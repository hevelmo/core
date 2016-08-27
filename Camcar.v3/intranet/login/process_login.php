<?php
include '../../incorporate/db_connect.php';
include '../../incorporate/functions.php';
//Our custom secure way of starting a PHP session.
sec_session_start();
if(isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    //The hashed password.
    $password = $_POST['p'];
    $user_browser = $_SERVER['HTTP_USER_AGENT'];
    if(login($email, $password) == true) {
        //Login success
        header('Location: ../welcome/');
    } else {
        //Login failed
        header('Location: index.php?error=IncorrectLogin');
    }
} else {
    //The correct POST variables were not sent to this page.
    //echo 'Invalid Request';
}
