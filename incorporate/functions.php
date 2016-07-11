<?php
/*
 * Copyright (C) 2013 Virbac México
 * Waxtotem, 2014.09.04
 * 
 */


include_once 'pro_con_ini.php';
include_once 'queryintojson.php';

function getConnection() {
    $dbhost = HOST;
    $dbname = DATABASE;
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", USER, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function sec_session_start_gen() {
    $session_name = 'MAXT';   // Set a custom session name
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if(ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=SoloGalletas");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();// Start the PHP session 
    session_regenerate_id();// regenerated the session, delete the old one.
}

function sec_session_start() {
    sec_session_start_gen();
    $_SESSION['user_control'] = 0;
}

function sec_session_start_api() {
    sec_session_start_gen();
    if(!isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        $_SESSION['client_id'] = 0;
        $_SESSION['client_status'] = 0;
    }
}

function login($mail, $password) {
    $mail = trim($mail);

    $sql = "SELECT * 
            FROM m1ton_usuarios
            WHERE correo_principal = :mail
            LIMIT 1";

    $structure = array(
        'user_id' => 'usuario_id',
        'username' => 'correo_principal',
        'password' => 'password',
        'salt' => 'salt',
        'status' => 'status',
        'tipo_usuario' => 'tipo_usuario',
    );

    $params = array(
        //'control' => 1,
        'mail' => $mail
    );

    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

    if(count($result)) {
        if(rightResult($result)) {
            $userId = $result[0]['user_id'];
            $clientId = $userId;
            $status = $result[0]['status'];
            $userType = $result[0]['tipo_usuario'];
            $username = $result[0]['username'];
            $userSalt = $result[0]['salt'];
            $dbPassword = $result[0]['password'];

            //If the user exists we check if the account is locked
            //from too many login attempts

            if(checkbrute($userId) == true) {
                //Account is locked
                //Send an email to user saying their account is locked
                return false;
            } else {
                //hash the password with the unique salt.
                $passwordSha = $password;
                $passwordFinal = hash('sha512', $passwordSha . $userSalt);

                //Check if the password in the database matches
                //the password the user submitted.
                if($dbPassword == $passwordFinal) {
                    //Password is correct!

                    //Get the user-agent string of the user.
                    $userBrowser = $_SERVER['HTTP_USER_AGENT'];

                    //---------- INTEGERS ----------

                    //XSS protection as we might print this value
                    $userId = preg_replace("/[^0-9]+/", "", $userId);
                    $_SESSION['user_id'] = $userId;

                    //XSS protection as we might print this value
                    $clientId = preg_replace("/[^0-9]+/", "", $clientId);
                    $_SESSION['client_id'] = $clientId;

                    //XSS protection as we might print this value
                    $status = preg_replace("/[^0-9]+/", "", $status);
                    $_SESSION['client_status'] = $status;

                    //XSS protection as we might print this value
                    $userType = preg_replace("/[^0-9]+/", "", $userType);
                    $_SESSION['user_type'] = $userType;

                    //---------- UTF8 STRINGS ----------

                    //---------- EMAIL ----------
                    
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;

                    //------------- STRINGS -------------

                    //---------- LOGIN STRINGS ----------
                    
                    $_SESSION['login_string'] = hash('sha512', $passwordFinal . $userBrowser);

                    //Login successful.
                    return true;
                } else {
                    //Password is not correct
                    //We record this attempt in the database
                    $now = time();
                    $sql_i = 
                        "INSERT INTO m1ton_login_attempts(
                            user_id,
                            user_type,
                            time
                         ) VALUES (
                            :user_id,
                            :user_type,
                            :time
                         )";
                    $structure_i = array();
                    $params_i = array(
                        'user_id' => $userId,
                        'user_type' => 0,
                        'time' => $now
                    );
                    $result = restructureQuery($structure_i, getConnection(), $sql_i, $params_i, 1, PDO::FETCH_ASSOC);
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

function login_check() {
    if(isset(
        $_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['user_type'],
        $_SESSION['login_string']
        )
    ) {
        $loginString = $_SESSION['login_string'];
        $userId = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $userType = $_SESSION['user_type'];

        //Get the user-agent string of the user.
        $userBrowser = $_SERVER['HTTP_USER_AGENT'];

        $sql = "SELECT password
                FROM m1ton_usuarios
                WHERE usuario_id = :user_id
                LIMIT 1";

        $structure = array(
            'password' => 'password'
        );

        $params = array(
            'user_id' => $userId
        );

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

        if(count($result)) {
            if(rightResult($result)) {
                //If the user exists get variables from result.
                $password = $result[0]['password'];
                $loginCheck = hash('sha512', $password . $userBrowser);
                if($loginCheck == $loginString) {
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
        if(isset($_SESSION['user_control'])) {
            return true;
        } else {
          return false;
        }
        //Not logged in
    }
}

function user_check() {
    $nameSession = session_name();
    $loginString = $_SESSION['login_string'];
    $userBrowser = $_SERVER['HTTP_USER_AGENT'];
    $loginCheck = hash('sha512', $nameSession . $userBrowser);
    if($loginCheck == $loginString) {
       return true;
    } else {
       return false;
    }
}

function checkbrute($userId) {
    //Get timestamp of current time
    $now = time();
    //All login attempts are counted from the past 2 hours.
    $validAttempts = $now - (2 * 60 * 60);
    $sql = "SELECT time
            FROM m1ton_login_attempts
            WHERE user_id = :user_id
            AND user_type = :user_type
            AND time > :valid_attempts";
    $params = array(
        'user_id' => $userId,
        'user_type' => 0,
        'valid_attempts' => $validAttempts
    );
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    if(count($result)) {
        if(rightResult($result)) {
            //If there have been more than 5 failed logins
            if(count($result) > 5) {
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

function new_user($mail, $password) {
    $sql = "SELECT *
            FROM m1ton_usuarios
            WHERE status = :status
            AND correo_principal = :mail
            AND password = :password
            AND salt = :salt
            LIMIT 1";

    $structure = array(
        'user_id' => 'usuario_id',
        'username' => 'correo_principal',
        'password' => 'password',
        'salt' => 'salt',
        'status' => 'status'
    );

    $params = array(
        'status' => 2,
        'mail' => $mail,
        'password' => $password,
        'salt' => $password
    );

    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

    if(count($result)) {
        if(rightResult($result)) {
            if(count($result) == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }

}

function restore_user_pass($mail, $password) {
    //$passwordSha = hash('sha512', $password);
    $passwordSha = $password;
    $randomSalt = hash('sha512', uniqid(mt_rand(), TRUE));
    $passFinal = hash('sha512', $passwordSha . $randomSalt);

    $sql = "UPDATE m1ton_usuarios
            SET password = :password,
                salt = :salt,
                status = :new_status
            WHERE status = :old_status
            AND correo_principal = :mail
            LIMIT 1";

    $structure = array();

    $params = array(
        'password' => $passFinal,
        'salt' => $randomSalt,
        'new_status' => 1,
        'old_status' => 2,
        'mail' => $mail
    );

    $result = generalQuery(getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);

    if(count($result)) {
        if(!array_key_exists('error', $result)) {
            if(count($result) == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }

}

function esc_url($url) {

    if('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if($url[0] !== '/') {
        //We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

function own_array_column($array, $column) {
    $myFunction = function($interlnalArray, $internalColumn) {
        $internalValues = array();
        foreach($interlnalArray as $current) {
            $internalValues[] = $current[$internalColumn];
        }
        $internalValues = array_values($internalValues);
        return $internalValues;
    };
    $version = phpversion();
    $elements = explode('.', $version);
    $first = (integer)($elements[0]);
    if($first === 5) {
        $count = count($elements);
        switch($count) {
            case 1:
                $proyectos_values = $myFunction($array, $column);
                break;
            case 2:
                $second = (integer)($elements[1]);
                if($second === 5) {
                    $proyectos_values = $myFunction($array, $column);
                } else if($second > 5) {
                    $proyectos_values = array_column($array, $column);
                } else {
                    $proyectos_values = $myFunction($array, $column); 
                }
                break;
            case 3:
            default:
                $second = (integer)($elements[1]);
                $third = (integer)($elements[2]);
                if($second === 5) {
                    if($third >= 0) {
                        $proyectos_values = array_column($array, $column);
                    } else {
                        $proyectos_values = $myFunction($array, $column); 
                    }
                } else if($second > 5) {
                    $proyectos_values = array_column($array, $column);
                } else {
                    $proyectos_values = $myFunction($array, $column); 
                }

        }
    } else if($first > 5) {
        $proyectos_values = array_column($array, $column);
    } else {
        $proyectos_values = $myFunction($array, $column);
    }
    $proyectos_values = array_values($proyectos_values);
    return $proyectos_values;
}

/*
 * Function taken from:
 * http://php.net/manual/es/function.array-filter.php
 * Adapted and customized by Javier Corona, Medigraf, 2015-10-27
 */

function filterByValue($array, $index, $value, $equal) {
    $newArray = array();
    if(is_array($array) && count($array) > 0) {
        foreach(array_keys($array) as $key) {
            $temp[$key] = $array[$key][$index];
            if($equal) {
                if($temp[$key] == $value) {
                    $newArray[$key] = $array[$key];
                }
            } else {
                if($temp[$key] != $value) {
                    $newArray[$key] = $array[$key];
                }
            }
        }
    }
    return $newArray;
}

/*
 *Gottten from http://php.net/manual/es/function.checkdate.php
 */
function validateDate($date, $format = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
