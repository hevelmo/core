<?php
/*
 * Copyright (C) 2015 Medigraf
 * Waxtotem, 2015.10.02
 * 
 */

include_once "cam_con_ini.php";
include_once "queryintojson.php";

function getConnection() {
    $dbhost = HOST;
    $dbname = DATABASE;
    $dbh    = new PDO("mysql:host=$dbhost;dbname=$dbname", USER, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function sec_session_start() {
    //Set a custom session name
    $sessionName = "CAMCRM";
    $secure      = SECURE;
    
    //This stops JavaScript being able to access the session id.
    $httponly = true;
    
    //Forces sessions to only use cookies.
    if (ini_set("session.use_only_cookies", 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    
    //Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    
    //Sets the session name to the one set above.
    session_name($sessionName);
    
    //Start the PHP session
    session_start();
    //regenerated the session, delete the old one.
    session_regenerate_id();
    
}

function login($mail, $password) {
    $mail = trim($mail);
    
    $sql = "SELECT usr.USR_Id,
                   usr.USR_NumeroEmpleado,
                   usr.USR_Username,
                   CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto,
                   usr.USR_Mail,
                   usr.USR_AGN_Id,
                   COALESCE(agn.AGN_Nombre, 'Administrador') AGN_Nombre,
                   COALESCE(agn.AGN_Logo1, 'admin.png') AGN_Logo1,
                   COALESCE(agn.AGN_Logo2, 'admin.png') AGN_Logo2,
                   usr.USR_Tipo,
                   usr.USR_Password,
                   usr.USR_Salt,
                   COALESCE(agn.AGN_Header, '') AGN_Header,
                   USR_AdminAccess
            FROM camUsuarios usr
            LEFT JOIN camAgencias agn
            ON usr.USR_AGN_Id = agn.AGN_Id
            WHERE USR_Control = :control
            AND USR_Mail = :mail
            LIMIT 1";
    
    $structure = array(
        "usr_id" => "USR_Id",
        "usr_no_empleado" => "USR_NumeroEmpleado",
        "usr_username" => "USR_Username",
        "usr_nombre_completo" => "USR_NombreCompleto",
        "usr_mail" => "USR_Mail",
        "usr_agn_id" => "USR_AGN_Id",
        "usr_agn_name" => "AGN_Nombre",
        "usr_agn_logo1" => "AGN_Logo1",
        "usr_agn_logo2" => "AGN_Logo2",
        "usr_type" => "USR_Tipo",
        "usr_password" => "USR_Password",
        "usr_salt" => "USR_Salt",
        "usr_agn_header" => "AGN_Header",
        "usr_adm_access" => "USR_AdminAccess"
    );
    
    $params = array(
        "control" => 1,
        "mail" => $mail
    );
    
    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    
    if (count($result)) {
        if (rightResult($result)) {
            $userId         = $result[0]["usr_id"];
            $noEmpleado     = $result[0]["usr_no_empleado"];
            $username       = $result[0]["usr_username"];
            $nombreCompleto = $result[0]["usr_nombre_completo"];
            $email          = $result[0]["usr_mail"];
            $agnId          = $result[0]["usr_agn_id"];
            $agency         = $result[0]["usr_agn_name"];
            $agnLogo1       = $result[0]["usr_agn_logo1"];
            $agnLogo2       = $result[0]["usr_agn_logo2"];
            $type           = $result[0]["usr_type"];
            $dbPassword     = $result[0]["usr_password"];
            $userSalt       = $result[0]["usr_salt"];
            $agnHeader      = $result[0]["usr_agn_header"];
            $adminAccess    = $result[0]["usr_adm_access"];
            
            //If the user exists we check if the account is locked
            //from too many login attempts
            
            if (checkbrute($userId) == true) {
                //Account is locked
                //Send an email to user saying their account is locked
                return false;
            } else {
                //hash the password with the unique salt.
                $passwordSha   = $password;
                $passwordFinal = hash("sha512", $passwordSha . $userSalt);
                
                //Check if the password in the database matches
                //the password the user submitted.
                if ($dbPassword == $passwordFinal) {
                    //Password is correct!
                    login_last($userId);
                    
                    //Get the user-agent string of the user.
                    $userBrowser = $_SERVER["HTTP_USER_AGENT"];
                    
                    //---------- INTEGERS ----------
                    
                    //XSS protection as we might print this value
                    $userId              = preg_replace("/[^0-9]+/", "", $userId);
                    $_SESSION["user_id"] = $userId;
                    
                    //XSS protection as we might print this value
                    $agnId                  = preg_replace("/[^0-9]+/", "", $agnId);
                    $_SESSION["usr_agn_id"] = $agnId;
                    
                    //XSS protection as we might print this value
                    $type                 = preg_replace("/[^0-9]+/", "", $type);
                    $_SESSION["usr_type"] = $type;
                    
                    //XSS protection as we might print this value
                    $adminAccess                = preg_replace("/[^0-9]+/", "", $adminAccess);
                    $_SESSION["usr_adm_access"] = $adminAccess;
                    
                    //---------- UTF8 STRINGS ----------
                    
                    $agency                     = utf8_encode($agency);
                    $_SESSION["usr_agn_nombre"] = $agency;
                    
                    //---------- EMAIL ----------
                    
                    $_SESSION["email"] = $email;
                    
                    //------------- STRINGS -------------
                    
                    $_SESSION["usr_no_empleado"]     = $noEmpleado;
                    $_SESSION["usr_agn_logo1"]       = $agnLogo1;
                    $_SESSION["usr_agn_logo2"]       = $agnLogo2;
                    $_SESSION["usr_agn_header"]      = $agnHeader;
                    $_SESSION["usr_nombre_completo"] = $nombreCompleto;
                    
                    //---------- LOGIN STRINGS ----------
                    
                    $_SESSION["login_string"] = hash("sha512", $passwordFinal . $userBrowser);
                    
                    //Login successful.
                    return true;
                } else {
                    //Password is not correct
                    //We record this attempt in the database
                    $now         = time();
                    $sql_i       = "INSERT INTO camAttempts(
                            ATT_USR_Id,
                            ATT_Time
                         ) VALUES (
                            :usr_id,
                            :time
                         )";
                    $structure_i = array();
                    $params_i    = array(
                        "usr_id" => $userId,
                        "time" => $now
                    );
                    $result      = restructureQuery($structure_i, getConnection(), $sql_i, $params_i, 1, PDO::FETCH_ASSOC);
                    return false;
                }
            }
            
        } else {
            return false;
        }
    } else {
        //No user exists.
        return false;
    }
    
}

function login_last($userId) {
    $sql     = "UPDATE camUsuarios
            SET USR_UltimoIngreso = :today,
                USR_IngresosTotales = USR_IngresosTotales + 1
            WHERE USR_Id = :usrId";
    $params  = array(
        "today" => date("o-m-d H:i:s"),
        "usrId" => $userId
    );
    $updated = false;
    $result  = generalQuery(getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
    if (count($result)) {
        $updated = rightResult($result);
    }
    return $updated;
}

function login_check() {
    if (isset(
            $_SESSION["user_id"], 
            $_SESSION["usr_no_empleado"], 
            //$_SESSION["username"],
            $_SESSION["usr_nombre_completo"], 
            $_SESSION["email"], 
            $_SESSION["usr_agn_id"], 
            $_SESSION["usr_agn_nombre"], 
            //$_SESSION["usr_agn_logo1"],
            //$_SESSION["usr_agn_logo2"],
            $_SESSION["usr_type"], 
            $_SESSION["login_string"], 
            $_SESSION["usr_adm_access"]
        )
    ) {
        $loginString    = $_SESSION["login_string"];
        $userId         = $_SESSION["user_id"];
        $noEmpleado     = $_SESSION["usr_no_empleado"];
        //$username = $_SESSION["username"];
        $nombreCompleto = $_SESSION["usr_nombre_completo"];
        $email          = $_SESSION["email"];
        $agnId          = $_SESSION["usr_agn_id"];
        $type           = $_SESSION["usr_type"];
        $agency         = $_SESSION["usr_agn_nombre"];
        $agnLogo1       = $_SESSION["usr_agn_logo1"];
        $agnLogo2       = $_SESSION["usr_agn_logo2"];
        $agnHeader      = $_SESSION["usr_agn_header"];
        $adminAccess    = $_SESSION["usr_adm_access"];
        
        //Get the user-agent string of the user.
        $userBrowser = $_SERVER["HTTP_USER_AGENT"];
        
        $sql = "SELECT USR_Password
                FROM camUsuarios
                WHERE USR_Id = :usr_id
                LIMIT 1";
        
        $structure = array(
            "password" => "USR_Password"
        );
        
        $params = array(
            "usr_id" => $userId
        );
        
        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        
        if (count($result)) {
            if (rightResult($result)) {
                //If the user exists get variables from result.
                $password   = $result[0]["password"];
                $loginCheck = hash("sha512", $password . $userBrowser);
                if ($loginCheck == $loginString) {
                    //Logged In!!!!
                    return true;
                } else {
                    //Not logged in
                    return false;
                }
            } else {
                //Not logged in
                return false;
            }
        } else {
            //Not logged in
            return false;
        }
        
    } else {
        if (isset($_SESSION["user_control"])) {
            return true;
        } else {
            return false;
        }
        //Not logged in
    }
}

function checkbrute($userId) {
    //Get timestamp of current time
    $now           = time();
    //All login attempts are counted from the past 2 hours.
    $validAttempts = $now - (2 * 60 * 60);
    $sql           = "SELECT ATT_Time
            FROM camAttempts
            WHERE ATT_USR_Id = :usr_id
            AND ATT_Time > :valid_attempts";
    $structure     = array(
        "password" => "DIS_Password"
    );
    $params        = array(
        "usr_id" => $userId,
        "valid_attempts" => $validAttempts
    );
    $result        = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    if (count($result)) {
        if (rightResult($result)) {
            //If there have been more than 5 failed logins
            if (count($result) > 5) {
                return true;
            } else {
                return false;
            }
        } else {
            //Could not create a prepared statement
            header("Location: ../error.php?err=Database error: cannot prepare statement");
            exit();
        }
    }
    return false;
}

function admin_access_check() {
    $adminAccess = isset($_SESSION["usr_adm_access"]) ? $_SESSION["usr_adm_access"] : 0;
    $adminAccess = intval($adminAccess);
    return ($adminAccess > 0);
}

function esc_url($url) {
    
    if ("" == $url) {
        return $url;
    }
    
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', "", $url);
    
    $strip = array("%0d", "%0a", "%0D", "%0A"
    );
    $url   = (string) $url;
    
    $count = 1;
    while ($count) {
        $url = str_replace($strip, "", $url, $count);
    }
    
    $url = str_replace(";//", "://", $url);
    
    $url = htmlentities($url);
    
    $url = str_replace("&amp;", "&#038;", $url);
    $url = str_replace("'", "&#039;", $url);
    
    if ($url[0] !== "/") {
        //We're only interested in relative links from $_SERVER["PHP_SELF"]
        return "";
    } else {
        return $url;
    }
}

/*
 *Gottten from http://php.net/manual/es/function.checkdate.php
 */
function validateDate($date, $format = "Y-m-d H:i:s") {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function registerCode($email) {
    $validate = false;
    $email    = trim($email);
    if ($email !== "") {
        $sql_s       = "SELECT * 
                  FROM camUsuarios
                  WHERE USR_Control <> :control
                  AND USR_Mail = :email";
        $structure_s = array(
            "id" => "USR_Id",
            "no_empleado" => "USR_NumeroEmpleado",
            "correo" => "USR_Mail",
            "usercontrol" => "USR_Control"
        );
        $params_s    = array(
            "control" => 0,
            "email" => $email
        );
        $result_s    = restructureQuery($structure_s, getConnection(), $sql_s, $params_s, 0, PDO::FETCH_ASSOC);
        if (rightResult($result_s)) {
            if (count($result_s)) {
                $control  = (int) ($result_s[0]["usercontrol"]);
                //if($control !== 1) {
                $validate = true;
                //}
            }
        }
    }
    return $validate;
}

function validatePassUrl($iur, $email) {
    $sql    = "SELECT USR_Id, USR_NumeroEmpleado, USR_Mail, USR_Password USR_Iur
            FROM camUsuarios
            WHERE USR_Control = :control
            AND USR_Mail = :email
            AND USR_Password = :password
            AND USR_Salt = :salt
            LIMIT 1";
    $params = array(
        "control" => 3,
        "email" => $email,
        "password" => $iur,
        "salt" => $iur
    );
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    $valid  = false;
    if (rightResult($result)) {
        if (count($result)) {
            $valid = true;
        }
    }
    return $valid;
}

function restoreUserPass($mail, $password, $iur) {
    //$passwordSha = hash("sha512", $password);
    $passwordSha = $password;
    $randomSalt  = hash("sha512", uniqid(mt_rand(), TRUE));
    $passFinal   = hash("sha512", $passwordSha . $randomSalt);
    $sql         = "UPDATE camUsuarios
            SET USR_Password = :new_password,
                USR_Salt = :new_salt,
                USR_Control = :new_control
            WHERE USR_Control = :old_control
            AND USR_Mail = :mail
            AND USR_Password = :old_password
            AND USR_Salt = :old_salt
            LIMIT 1";
    $structure   = array();
    $params      = array(
        "new_password" => $passFinal,
        "new_salt" => $randomSalt,
        "new_control" => 1,
        "old_control" => 3,
        "mail" => $mail,
        "old_password" => $iur,
        "old_salt" => $iur
    );
    $result      = generalQuery(getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
    $success     = false;
    if (count($result)) {
        if (!array_key_exists("error", $result)) {
            if (count($result) == 1) {
                $success = true;
            }
        }
    }
    return $success;
}
