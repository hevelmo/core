
<?php
include '../../../incorporate/db_connect.php';
include '../../../incorporate/functions.php';
include '../../../incorporate/queryintojson.php';
include '../Mandrill.php';
//sec_session_start_api();

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

    // ·······GET route    
   
$app->get('/kill', 'mws', function () {
    echo 'This is a Kill Get route';
});


//POST route

//INSERT
//$app->post('/new/seminuevos', /*'mws',*/ 'addSeminuevos');

//UPDATE
//$app->post('/set/seminuevos/:senId', /*'mws',*/ 'setSeminuevos');

//DELETE
//$app->post('/del/seminuevos/:senId', /*'mws',*/ 'delSeminuevos');

//GET route

//SELECT

$app->get('/get/test', /*'mws',*/ 'getTest');

$app->get('/webservice/get/empleados', /*'mws',*/ 'getWSEmpleados');
//$app->get('/get/seminuevos/:senId', /*'mws',*/ 'getSeminuevosById');


// POST route

$app->post(
    '/post',
    function () {
        $app = \Slim\Slim::getInstance();
           $request = $app->request();
           $propiedad = JSON_decode($request->getBody());          
            foreach ($propiedad as $key => $value) {
                //echo JSON_encode($value->entorno1);
                echo JSON_encode($value->tipo);
                echo JSON_encode($value->core);
            }
    });


/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */

$app->run();

function requestBody() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    return json_decode($request->getBody());
}

function getTest() {
    echo "test";
}

/*
----------------------------------------------------------------------------
    General Post Methods
----------------------------------------------------------------------------
*/

function addSeminuevos() {
    $property = requestBody();
    $sql = "INSERT INTO table(
    ) VALUES(
    )";
    $structure = array();
    $params = array(
    );
    echo changeQueryIntoJSON('caminpa', $structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);
}

function setSeminuevos($senId) {
    $property = requestBody();
    
    $sql = "UPDATE table
            SET 
            WHERE ";
    $structure = array();

    $params = array(
        
    );

    echo changeArrayIntoJSON('caminpa', array('process' => 'ok'));
}

function delSeminuevos($senId) {
    $property = requestBody();
    $sql = "";
    $structure = array();
    $params = array(
    );
    echo changeQueryIntoJSON('caminpa', $structure, getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
}

/*
----------------------------------------------------------------------------
    General Get Methods
----------------------------------------------------------------------------
*/

function getSeminuevosJSON($sql, $senId) {
    $result = getSeminuevosArray($sql, $senId);
    echo changeArrayIntoJSON('caminpa', $result);
}

function getSeminuevos() {
    $sql = "";
    getSeminuevosJSON($sql, '');
}

function getSeminuevosById($senId) {
    $sql = "";
    getSeminuevosJSON($sql, $senId);
}

/*
----------------------------------------------------------------------------
    General Web Services Methods
----------------------------------------------------------------------------
*/

function getWSEmpleadosArray() {
    $content = file_get_contents('http://camcar.com.mx/camcarservice/rest/Empleados');
    $content = str_replace(array("\n", "\r", "\t"), '', $content);
    $content = trim(str_replace('"', "'", $content));
    $array = simplexml_load_string($content);
    return $array;
}

function getWSEmpleadosJSON() {
    $array = getWSEmpleadosArray();
    $json = changeArrayIntoJSON('webservice', $array);
    $json = trim(str_replace('{}', '""', $json));
    return $json;
}

function getWSEmpleados() {
    echo getWSEmpleadosJSON();
}

/*
----------------------------------------------------------------------------
    Midelwere Methods
----------------------------------------------------------------------------
*/

function mw1(){
    $app = \Slim\Slim::getInstance();
    $db = getConnection();
    if (login_check($db) == true) {
        return true;
    } else {
        $app->halt(401, 'Token Requerido');               
    } 
}

function mws(){
    $app = \Slim\Slim::getInstance();
    if (user_check() == true) {
        return true;
    } else {
        $app->halt(401, 'No user');
    } 
}
