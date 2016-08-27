<?php

/*
 * Copyright (C) 2013 Virbac México
 * Waxtotem, 2014.09.04
 *
 */

include_once '../../incorporate/functions.php';
sec_session_start();

// Unset all session values
$_SESSION = array();

// get session parameters
$params = session_get_cookie_params();

// Delete the actual cookie.
setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Destroy session
session_destroy();
header("Location: ../login");
exit();
