 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../incorporate/db_connect.php';
include '../../../incorporate/functions.php';
include '../../../incorporate/queryintojson.php';
include '../../../incorporate/json-file-decode.class.php';
include '../Mandrill.php';

date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');

/**
 *
 * [Initial V 1.0]
 *
**/
require '../Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'mode' => 'development',
    'cookies.httponly' => true
));
// Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});
// Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});
/**
 * [Routes Deep V 1.0]
**/
// POST route
    //$app->post('/post/table', /*'mw1',*/ 'addTable');
// INSERT
    //$app->post('/new/table', /*'mw1',*/ 'addTable');
// UPDATE
    //$app->post('/set/table/:idTable', /*'mw1',*/ 'setTable');
// GET route
// SELECT
    //$app->post('/get/table/:idTable', /*'mw1',*/ 'setTable');
// DELETE
    //$app->get('/del/table/:idTable', /*'mw1',*/ 'delTable');
//TEST
    $app->get('/get/test', /*'mw1',*/ 'getTest');
    $app->post('/post/test', /*'mw1',*/ 'postTest');
$app->run();

//Functions
//TEST
    function getTest() {
        $today = date('o-m-d H:i:s');
        $array = array('date' => $today);
        echo changeArrayIntoJSON('propa', $array);
    }
    function postTest() {
        $array = array('process' => 'ok');
        //echo changeArrayIntoJSON('propa', $array);
        echo "string";
    }
/*
  ----------------------------------------------------------------------------
  General Helper Methods
  ----------------------------------------------------------------------------
*/
    function requestBody() {
        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        return json_decode($request->getBody());
    }
    function mw1() {
        $app = \Slim\Slim::getInstance();
        $db = getConnection();
        if (login_check($db) == true) {
            return true;
        } else {
            $app->halt(401, 'Token Requerido');
        }
    }
/*
  ----------------------------------------------------------------------------
  General Post Methods
  ----------------------------------------------------------------------------
*/
    // INSERT
    function addTable() {
        $property = requestBody();
        $sql = "INSERT INTO camTable(TAB_Field)
                VALUES(:field)";
        $structure = array();
        $params = array(
            'field' => trim($property->field),
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);
    }
    // UPDATE
    function setTable($idTable) {
        $property = requestBody();
        $sql = "UPDATE camTable
                SET TAB_Field = :field
                WHERE TAB_Id = :tabId";
        $structure = array();
        $params = array(
            'tabId' => $idTable,
            'field' => trim($property->field)
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
    }
/*
  ----------------------------------------------------------------------------
  General Get Methods
  ----------------------------------------------------------------------------
*/
// SELECT
    function getTable() {
        $sql = "SELECT * FROM proTable tab";
        $structure = array(
            'alias' => 'TAB_Field'
        );
        $params = array();
        echo changeQueryIntoJSON('propa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
// DELETE
    function delTable($idTable) {
        $sql = "DELETE FROM camTable WHERE TAB_Id = :tabId";
        $structure = array();
        $params = array(
            'tabId' => $idTable
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 3, PDO::FETCH_ASSOC);
    }
/*
  ----------------------------------------------------------------------------
  General Get Mandril
  ----------------------------------------------------------------------------
*/
    /*
    // SEND MAIL CONTACT
    function sem_premium_contacto($sem_con_sp_name, $sem_con_sp_email, $sem_con_sp_message, $sem_con_sp_concesionarie, $sem_con_sp_logo) {
        try {
            $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
            $message = array(
                'html' => '
                    <html>
                        <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
                        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
                        <style>
                            html{width: 100%;}
                            * {
                                margin: 0 auto;
                                padding: 0;
                            }
                            body{
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1) !important;
                                -moz-osx-font-smoothing: grayscale;
                                -webkit-font-smoothing: antialiased;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            .ExternalClass {
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1) !important;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            *:before, *:after {
                                -webkit-box-sizing: border-box;
                                -moz-box-sizing: border-box;
                                box-sizing: border-box;
                            }
                        </style>
                        </head>

                        <body>

                            <div style="background-color: rgba(225, 222, 223, 1); padding: 20px;border-bottom: 0px" width="600">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: rgba(255,255,255, 1); border-radius: 5px;">
                                    <tbody>
                                        <tr>
                                            <td width="11"></td>
                                            <td style="background-color: rgba(255, 255, 255, 1); border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                                <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="15" width="100">
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    <img src="http://camcar.mx/resources/public/img/'.$sem_con_sp_logo.'" alt="Modelo" width="150">
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width="11"></td>
                                        </tr>
                                        <tr>
                                            <td height="11" valign="top" width="11"></td>
                                            <td rowspan="2" style="border:1px solid #fff;border-top:0" bgcolor="#ffffff">
                                                <table style="padding:15px 60px 15px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Nombre(s):
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_name.'
                                                                </span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Correo Electrónico:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_email.'
                                                                </span><br>
                                                            </td>
                                                            <br>
                                                            <br>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" width="600" valign="top">
                                                                <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'
                                                                    .$sem_con_sp_message.
                                                                '</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p style="color: #000000; font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 11px; text-align: right; padding: 0">
                                                                    &nbsp;© 2015 / '.$sem_con_sp_concesionarie.'
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td height="11" valign="top" width="11"></td>
                                        </tr>
                                        <tr>
                                            <td width="11"></td>
                                            <td width="11"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
                ',
                'subject' => $sem_con_sp_concesionarie,
                'from_email' => $sem_con_sp_email,
                'from_name' => $sem_con_sp_name,
                'to' => array(
                    array(
                        'email' => 'marina.reyes@camcar.mx',
                        //'email' => 'hevelmo060683@gmail.com',
                        'name' => $sem_con_sp_concesionarie,
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'marina.reyes@camcar.mx'),
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'bcc_address' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,

                'tags' => array('orden-new-notificacion'),
                'google_analytics_domains' => array('http://camcar.mx/'),
                'google_analytics_campaign' => 'marina.reyes@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/'),

            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '';
            $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
            //print_r($result);

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }
    // SEND MAIL CONTACT BY MODEL
    function sem_premium_bymodel_contacto($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_sen_email, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture) {
        try {
            $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
            $message = array(
                'html' => '
                    <html>
                        <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
                        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
                        <style>
                            html{width: 100%;}
                            * {
                                margin: 0 auto;
                                padding: 0;
                            }
                            body{
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1)!important;
                                -moz-osx-font-smoothing: grayscale;
                                -webkit-font-smoothing: antialiased;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            .ExternalClass {
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1) !important;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            *:before, *:after {
                                -webkit-box-sizing: border-box;
                                -moz-box-sizing: border-box;
                                box-sizing: border-box;
                            }
                        </style>
                        </head>

                        <body>

                            <div style="background-color: rgba(225, 222, 223, 1); padding: 20px;border-bottom: 0px" width="600">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: rgba(255,255,255, 1); border-radius: 5px;">
                                    <tbody>
                                        <tr>
                                            <td width="11"></td>
                                            <td style="background-color: rgba(255, 255, 255, 1); border-radius: 5px 5px 0 0; border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                                <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="15" width="100">
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    <img src="http://camcar.mx/resources/public/img/'.$sem_con_sp_bm_logo_seminuevos.'" alt="Modelo" width="150">
                                                                </p>
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-right: 0px; float: right;">
                                                                    <img src="http://camcar.mx/resources/public/img/logos_agencias/'.$sem_con_sp_bm_logo_agencia.'" alt="Modelo" width="120">
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width="11"></td>
                                        </tr>
                                        <tr>
                                            <td height="11" valign="top" width="11"></td>
                                            <td rowspan="2" style="border:1px solid #fff;border-top:0" bgcolor="#ffffff">
                                                <table style="padding:15px 60px 15px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" valign="top" width="250">
                                                                <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Marca:
                                                                </strong>
                                                                <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_bm_marc.
                                                                '</span><br>
                                                                <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Modelo:
                                                                </strong>
                                                                <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_bm_model.
                                                                '</span><br>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <img src="http://camcar.mx/intranet/admin/cdn/img/seminuevos/'.$sem_con_sp_bm_picture.'" alt="Modelo" width="250">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Nombre(s):
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_bm_name.'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Correo Electrónico:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_bm_email.'</span><br>
                                                            </td>
                                                            <br>
                                                            <br>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Telefono:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_bm_phone.'</span><br>
                                                            </td>
                                                            <br>
                                                            <br>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" width="600" valign="top">
                                                                <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'.$sem_con_sp_bm_message.'</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p style="color: #000000; font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 11px; text-align: right; padding: 0">
                                                                    &nbsp;© 2015 / '.$sem_con_sp_bm_concessionary.'
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td height="11" valign="top" width="11"></td>
                                        </tr>
                                        <tr>
                                            <td width="11">
                                                <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display:block;border:0" border="0" class="CToWUd">
                                            </td>
                                            <td width="11">
                                                <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display:block;border:0" border="0" class="CToWUd">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
                ',
                'subject' => $sem_con_sp_bm_concessionary,
                'from_email' => $sem_con_sp_bm_email,
                'from_name' => $sem_con_sp_bm_name,
                'to' => array(
                    array(
                        //'email' => 'hevelmo060683@gmail.com',
                        'email' => $sem_con_sp_bm_sen_email,
                        'name' => $sem_con_sp_bm_concessionary,
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => $sem_con_sp_bm_sen_email),
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'bcc_address' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,

                'tags' => array('orden-new-notificacion'),
                'google_analytics_domains' => array('http://camcar.mx/'),
                'google_analytics_campaign' => 'marina.reyes@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/'),

            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '';
            $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
            //print_r($result);

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }
    // SEND MAIL JOB BOARD
    function send_mail_job_board($send_job_board_date_time, $send_job_board_first_name, $send_job_board_last_name, $send_job_board_email, $send_job_board_phone, $send_job_board_department, $send_job_board_message, $file_name, $send_job_board_concessionary, $send_job_board_logo) {
        try {
            $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
            $message = array(
                'html' => '
                    <html>
                        <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
                        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
                        <style>
                            html{width: 100%;}
                            * {
                                margin: 0 auto;
                                padding: 0;
                            }
                            body{
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1)!important;
                                -moz-osx-font-smoothing: grayscale;
                                -webkit-font-smoothing: antialiased;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            .ExternalClass {
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1) !important;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            *:before, *:after {
                                -webkit-box-sizing: border-box;
                                -moz-box-sizing: border-box;
                                box-sizing: border-box;
                            }
                        </style>
                        </head>

                        <body>

                            <div style="background-color: rgba(225, 222, 223, 1); padding: 20px;border-bottom: 0px" width="600">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: rgba(255,255,255, 1); border-radius: 5px;">
                                    <tbody>
                                        <tr>
                                            <td width="11"></td>
                                            <td style="background-color: rgba(255, 255, 255, 1); border-radius: 5px 5px 0 0; border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                                <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="15" width="100">
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    <img src="http://camcar.mx/resources/public/img/'.$send_job_board_logo.'" alt="CAMCAR" width="150">
                                                                </p>
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    BOLSA DE TRABAJO
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width="11"></td>
                                        </tr>
                                        <tr>
                                            <td height="11" valign="top" width="11"></td>
                                            <td rowspan="2" style="border:1px solid #fff;border-top:0" bgcolor="#ffffff">
                                                <table style="padding:15px 60px 15px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Fecha:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'. $send_job_board_date_time .'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Nombre(s):
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'. $send_job_board_first_name . ' ' . $send_job_board_last_name .'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Correo Electrónico:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$send_job_board_email.'</span><br>
                                                            </td>
                                                            <br>
                                                            <br>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Telefono:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$send_job_board_phone.'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="250">
                                                                <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Departamento:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">
                                                                    Dirigido al departamento de <div style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; display: inline-block;">'. $send_job_board_department .'</div>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" width="600" valign="top">
                                                                <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'.$send_job_board_message.'</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p style="color: #000000; font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 11px; text-align: right; padding: 0">
                                                                    &nbsp;© 2015 / '.$send_job_board_concessionary.' BOLSA DE TRABAJO
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td height="11" valign="top" width="11"></td>
                                        </tr>
                                        <tr>
                                            <td width="11">
                                                <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display:block;border:0" border="0" class="CToWUd">
                                            </td>
                                            <td width="11">
                                                <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display:block;border:0" border="0" class="CToWUd">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
                ',
                'subject' => $send_job_board_concessionary,
                'from_email' => $send_job_board_email,
                'from_name' => $send_job_board_first_name . ' ' . $send_job_board_last_name,
                'to' => array(
                    array(
                        'email' => 'hevelmo060683@gmail.com',
                        //'email' => 'reclutamiento@camcar.mx',
                        'name' => $send_job_board_concessionary . ' - Bolsa de Trabajo',
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'reclutamiento@camcar.mx'),
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'bcc_address' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,

                'tags' => array('orden-new-notificacion'),
                'google_analytics_domains' => array('http://camcar.mx/sitio/'),
                'google_analytics_campaign' => 'reclutamiento@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/sitio/'),

            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = '';
            $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
            //print_r($result);

        } catch(Mandrill_Error $e) {
            // Mandrill errors are thrown as exceptions
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
            throw $e;
        }
    }
    */
