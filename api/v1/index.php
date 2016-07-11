 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../../incorporate/db_connect.php';
include_once '../../incorporate/functions.php';
include_once '../../incorporate/queryintojson.php';
include_once '../../incorporate/json-file-decode.class.php';
include_once '../Mandrill.php';

date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');

/**
 *
 * [Initial V 15.0]
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
    $app->post('/post/financing/:model', /*'mw1',*/ 'getFinancingByModel');

// GET route

// SELECT

$app->run();

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
        echo changeQueryIntoJSON('sukpa', $structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);
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
        echo changeQueryIntoJSON('sukpa', $structure, getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
    }
    
    // GET FINANCING BY MODEL
    function getFinancingByModel() {
        $property = requestBody();
        
        $concesionaria = $property->concesionaria;
        $modelo = $property->modelo;
        $nombre = $property->nombre;
        $apellidos = $property->apellidos;
        $correo = $property->correo;
        $telefono = $property->telefono;
        $mensaje = $property->mensaje;
        $test_drive = $property->test_drive;
        $newsletter = $property->newsletter;

        echo changeArrayIntoJSON("sukpa", array('process'=>'ok', $property));
    }
/*
  ----------------------------------------------------------------------------
    General Get Methods
  ----------------------------------------------------------------------------
*/
/*
  ----------------------------------------------------------------------------
  General Get Mandril
  ----------------------------------------------------------------------------
*/
