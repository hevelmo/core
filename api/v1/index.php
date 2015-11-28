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
