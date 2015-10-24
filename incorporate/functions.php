<?php
/*
 * Copyright (C) 2013 Virbac México
 * Waxtotem, 2014.09.04
 * 
 */


include_once 'pro_con_ini.php';

function getConnection() {
    $dbhost = HOST;
    $dbname = DATABASE;
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", USER, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

function sec_session_start() {
    $session_name = 'VEXCRM';   // Set a custom session name 
    $secure = SECURE;

    // This stops JavaScript being able to access the session id.
    $httponly = true;

    // Forces sessions to only use cookies.
    if(ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    // Sets the session name to the one set above.
    session_name($session_name);

    session_start();            // Start the PHP session 
    session_regenerate_id();    // regenerated the session, delete the old one. 
   
}

function login($email, $password) {

        $prep_stmt = "SELECT USR_Id, USR_Name, USR_Username, USR_Type, USR_VEN_Id, USR_Password, USR_Salt 
                      FROM vexUsers 
                      WHERE USR_Username = :mail AND USR_Usercontrol = 1
                      LIMIT 1";
        try {
            $db = getConnection();
            $stmt = $db->prepare($prep_stmt); 
            $stmt->bindParam("mail", $email); 
            $stmt->execute();
            $resultado_usuario = $stmt->rowCount();
            $package = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            if($resultado_usuario == 1) {
                $response_login = $package[0];  
                $user_id = $response_login[USR_Id];
                $user_name = $response_login[USR_Name];
                $user_username = $response_login[USR_Username];
                $user_type = $response_login[USR_Type];
                $user_password = $response_login[USR_Password];
                $user_vendor_id = $response_login[USR_VEN_Id];
                $user_salt = $response_login[USR_Salt];

                $password_sha = hash('sha512', $password);

                $password_final = hash('sha512', $password_sha . $user_salt);               

                if($user_password == $password_final) {
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];    
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;

                    // XSS protection as we might print this value
                    $name =  $user_name;
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $user_username);
                    $_SESSION['name'] = $name;
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $user_password . $user_browser);
                    $_SESSION['type'] = $user_type;
                    $_SESSION['vendor_id'] = $user_vendor_id;
                    return true;  
                } else {          
                    // CHECK Attemps
                    /*if(!$mysqli->query("INSERT INTO cmoss_login_attempts(user_id, time) 
                                    VALUES ('$user_id', '$now')")) {
                        header("Location: ../error.php?err=Database error: login_attempts");
                        exit();
                    }*/
                    return false;
                }
            } else {
                return false;
            }           
              
        }catch(PDOException $e) {
            header("Location: ../error.php?err=Database error: cannot prepare statement"); 
            exit();
        }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();

    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);

    if($stmt = $mysqli->prepare("SELECT time 
                                  FROM cmoss_login_attempts 
                                  WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 5 failed logins 
        if($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    } else {
        // Could not create a prepared statement
        header("Location: ../error.php?err=Database error: cannot prepare statement");
        exit();
    }
}

function login_check() {

     $prep_stmt = "SELECT USR_Password FROM vexUsers WHERE USR_Id = :user LIMIT 1";
        if(isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
            $user_id = $_SESSION['user_id'];
            $login_string = $_SESSION['login_string'];
            $username = $_SESSION['username'];
                try {
                    $db = getConnection();
                    $stmt = $db->prepare($prep_stmt); 
                    $stmt->bindParam("user", $user_id); 
                    $stmt->execute();
                    $resultado_usuario = $stmt->rowCount();
                    $package = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $db = null;
                        if($resultado_usuario == 1) {
                            // If the user exists get variables from result.
                            $user_browser = $_SERVER['HTTP_USER_AGENT'];
                            $response_login = $package[0]; 
                            $password = $response_login['USR_Password'];
                            $login_check = hash('sha512', $password . $user_browser);
                            if($login_check == $login_string) {
                                // Logged In!!!! 
                                return true;
                            } else {
                                // Not logged in 
                                return false;
                            }                            
                        } else {
                            // Not logged in 
                            return false;
                        }
                } catch(PDOException $e) {                
                    header("Location: ../error.php?err=Database error: warning"); 
                    exit();
                }
        } else {
            // Not logged in 
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
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}
