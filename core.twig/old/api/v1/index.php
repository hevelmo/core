<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//include '../../incorporate/db_connect.php';
//include '../../incorporate/functions.php';
include '../../incorporate/queryintojson.php';
include '../Mandrill.php';

//sec_session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');

/**
 *
 * [Initial V 1.0]
 *
 */
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
 */

// Send Contact
$app->post('/contacto', 'contacto');
//$app->post('/index.php/contacto', 'contacto');

$app->get('/get/test', /*'mw1',*/ 'getTest');
$app->post('/post/test', /*'mw1',*/ 'postTest');

$app->run();
//TEST
function getTest() {
    $today = date('o-m-d H:i:s');
    $array = array('date' => $today);
    echo changeArrayIntoJSON('propa', $array);
}

function postTest() {
    $array = array('process' => 'ok');
    echo changeArrayIntoJSON('propa', $array);
    echo "string";
}

//SEND CONTACT
function contacto() {
    $property = requestBody();
    $sendname = $property->dex_name;
    $sendemail = $property->dex_email;
    $sendmensaje = $property->dex_message;
    $sendcia = $property->dex_cia;

    contact($sendname, $sendemail, $sendmensaje, $sendcia);

    echo changeArrayIntoJSON("dexpa", array('process'=>'ok'));
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

/*
  ----------------------------------------------------------------------------
  General Get Methods
  ----------------------------------------------------------------------------
 */


function contact($sendname, $sendemail, $sendmensaje, $sendcia) {
    try {
        $mandrill = new Mandrill('D7crIdqlRL443tnEZPW5-Q');
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
                            font-family: "ProximaNovaRegular","Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                            background: rgba(225, 223, 223, 1) !important;
                            -moz-osx-font-smoothing: grayscale;
                            -webkit-font-smoothing: antialiased;
                            color: #777;
                            font-size: 14px;
                            line-height: 24px;
                            text-transform: uppercase;
                        }
                        .ExternalClass {
                            font-family: "ProximaNovaRegular","Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                            background: rgba(225, 223, 223, 1) !important;
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

                        <div style="background-color: rgba(12, 18, 28, 0.2); padding: 20px;border-bottom: 0px" width="600">
                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td width="11">
                                            <img src="http://directexpress.medigraf.com.mx/img/spacer.png" style="display: block; border: 0" border="0">
                                        </td>
                                        <td style="background-color: rgba(255, 255, 255, 1); border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                            <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td height="15" width="100">
                                                            <a style="display: inline-block; vertical-align: middle; border: 0; padding-right: 15px;" href="http://directexpress.medigraf.com.mx" target="_blank" rel="noreferrer">
                                                                <img src="http://directexpress.medigraf.com.mx/img/logo_directxpress.png" style="display: block; border: 0"  border="0" width="75">
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="11">
                                            <img src="http://directexpress.medigraf.com.mx/img/spacer.png" style="display: block; border: 0" border="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="78" width="11" style="background-color: rgba(176, 47, 31, 1)">
                                            <p style="display: block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase;">
                                                '.$sendcia.'
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="11" valign="top" width="11">
                                            <img style="display:block;border:0" src="http://directexpress.medigraf.com.mx/img/shadow-left.png" border="0" class="CToWUd">
                                        </td>
                                        <td rowspan="2" style="border:1px solid #ebe9ea;border-top:0" bgcolor="#ffffff">
                                            <table style="padding:15px 60px 15px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td height="20" valign="top" width="150">
                                                            <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                Nombre(s):
                                                            </strong>
                                                        </td>
                                                        <td height="20" valign="top">
                                                            <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sendname.'</span><br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20" valign="top" width="150">
                                                            <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                Correo Electrónico:
                                                            </strong>
                                                        </td>
                                                        <td height="20" valign="top">
                                                            <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sendemail.'</span><br>
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
                                                            <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'.$sendmensaje.'</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <p style="color: #000000; font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 11px; text-align: right; padding: 0">
                                                                &nbsp;© 2015 / Direct Express - El Taller de Servicio de Volkswagen
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td height="11" valign="top" width="11">
                                            <img style="display:block;border:0" src="http://directexpress.medigraf.com.mx/img/shadow-right.png" border="0" class="CToWUd">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="11">
                                            <img src="http://directexpress.medigraf.com.mx/img/spacer.png" style="display:block;border:0" border="0" class="CToWUd">
                                        </td>
                                        <td width="11">
                                            <img src="http://directexpress.medigraf.com.mx/img/spacer.png" style="display:block;border:0" border="0" class="CToWUd">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </body>
                </html>
            ',
            'subject' => $sendcia,
            'from_email' => $sendemail,
            'from_name' => $sendname,
            'to' => array(
                array(
                    'email' => 'gdelgado@euroalemana.com.mx',
                    //'email' => 'heriberto@medigraf.com.mx',
                    'name' => $sendcia,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'gdelgado@euroalemana.com.mx'),
            //'headers' => array('Reply-To' => 'hevelmo060683@gmail.com'),
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
            'google_analytics_domains' => array('directexpresss.com'),
            'google_analytics_campaign' => 'contacto.hevelmo060683@gmail.com',
            'metadata' => array('website' => 'www.directexpresss.com'),

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
