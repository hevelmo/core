<?php
include '../../incorporate/db_connect.php';
include '../../incorporate/functions.php';
sec_session_start();
if(isset($_POST['email'], $_POST['crypt_id'], $_POST['name'])) {
    $email = $_POST['email'];
    $cryptId = $_POST['crypt_id'];
    $name = $_POST['name'];
    if(isset($_POST['p'])) {
        $password = $_POST['p'];
        if(restoreUserPass($email, $password, $cryptId)) {
            //The hashed password.
            if(login($email, $password) == true) {
                //Login success
                header('Location: ../welcome/');
            } else {
                //Login failed
                header('Location: index.php?error=IncorrectLogin');
            }
        } else {
            //Login failed
            header('Location: index.php?error=IncorrectPassword');
        }
    } else {
        header("Location: index.php?iur=$cryptId&m=$email&nc=$name");
    }
} else {
    header('Location: ../login/');
}