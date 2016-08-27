
<?php
include '../../../incorporate/db_connect.php';
include '../../../incorporate/functions.php';
include '../../../incorporate/queryintojson.php';
include '../Mandrill.php';
//sec_session_start_api();

/**
 * 
 * [Initial V 2.0]
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

//$app->get('/get/seminuevos/:senId', /*'mws',*/ 'getSeminuevosById');

$app->get('/webservice/get/empleados', /*'mws',*/ 'getWSEmpleados');
$app->post('/webservice/set/empleados', /*'mws',*/ 'setWSEmpleados');



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
    $version = phpversion();
    echo "PHP Version: " . $version;
}

/*
----------------------------------------------------------------------------
    General Post Methods
----------------------------------------------------------------------------
*/

function addSeminuevos() {
    /*
    $property = requestBody();
    $sql = "INSERT INTO table(
    ) VALUES(
    )";
    $structure = array();
    $params = array(
    );
    echo changeQueryIntoJSON('caminpa', $structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);
    */
}

function setSeminuevos($senId) {
    /*
    $property = requestBody();
    $sql = "UPDATE table
            SET 
            WHERE ";
    $structure = array();
    $params = array(  
    );
    echo changeArrayIntoJSON('caminpa', array('process' => 'ok'));
    */
}

function delSeminuevos($senId) {
    /*
    $property = requestBody();
    $sql = "";
    $structure = array();
    $params = array(
    );
    echo changeQueryIntoJSON('caminpa', $structure, getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
    */
}

/*
----------------------------------------------------------------------------
    General Get Methods
----------------------------------------------------------------------------
*/

function getSeminuevosJSON($sql, $senId) {
    /*
    $result = getSeminuevosArray($sql, $senId);
    echo changeArrayIntoJSON('caminpa', $result);
    */
}

function getSeminuevos() {
    /*
    $sql = "";
    getSeminuevosJSON($sql, '');
    */
}

function getSeminuevosById($senId) {
    /*
    $sql = "";
    getSeminuevosJSON($sql, $senId);
    */
}

/*
----------------------------------------------------------------------------
    General Web Services Methods
----------------------------------------------------------------------------
*/

function getWSEmpleadosArray() {
    //Get contents from webservice provided by camcar
    $content = file_get_contents('http://camcar.com.mx/camcarservice/rest/Empleados');
    //Delete tabs, ends of line, and new lines
    $content = str_replace(array("\n", "\r", "\t"), '', $content);
    //Change all " into '
    $content = trim(str_replace('"', "'", $content));
    //Change content into an array of Simplexml objects
    $array = simplexml_load_string($content);
    //Cast the array of Simplexml objects into a simple array
    $array = (array)($array);

    //Itereate all the array
    foreach($array as $key1 => $value1) {
        //For each $key1 (first level)
        //Cast the array of Simplexml objects into a simple array
        $castedValueL1 = (array)($value1);
        //Declare an empty array to fill it with the new casted values of each level 2
        $castedArrayL2 = array();
        //Itereate all the array of the vurrent $castedValueL1 casted value
        foreach($castedValueL1 as $key2 => $value2) {
            //For each $key2 (second level)
            //Cast the array of Simplexml objects into a simple array
            $castedValueL2 = (array)($value2);
            //Declare an empty array to fill it with the new casted values of each level 3
            $castedArrayL3 = array();
            foreach($castedValueL2 as $key3 => $value3) {
                //For each $key3 (second level)
                //Cast the Simplexml value into a string
                $castedValueL3 = (string)($value3);
                //Asign the casted value in the $key3 of $castedArrayL3
                $castedArrayL3[$key3] = trim($castedValueL3);
            }
            //Asign the casted values array in the $key2 of $castedArrayL2
            $castedArrayL2[$key2] = $castedArrayL3;
        }
        //Asign the casted values array in the $key1 of $array (the main array)
        $array[$key1] = $castedArrayL2;
    }

    //Now the the array of Simplexml objects is a simple multilevel array
    //Return it
    return $array;
}

function getWSEmpleadosJSON() {
    $array = getWSEmpleadosArray();
    $json = changeArrayIntoJSON('webservice', $array);
    return $json;
}

function getWSEmpleados() {
    echo getWSEmpleadosJSON();
}

function setWSEmpleados() {
    $sql = "SELECT *
            FROM camUsuarios
            WHERE USR_NumeroEmpleado <> :no_empleado
            ORDER BY USR_Id ASC";
    $structure = array(
        'id' => 'USR_Id',
        'no_empleado' => 'USR_NumeroEmpleado',
        'correo' => 'USR_Mail',
        'tipo' => 'USR_Tipo',
        'admin_access' => 'USR_AdminAccess',
        'usercontrol' => 'USR_Control'
    );
    $params = array(
        'no_empleado' => 'XXXX'
    );
    //Get empleados from table 'camUsuarios' of database
    $empleadosDB = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    //Get empleados from webservice
    $empleadosWS = getWSEmpleadosArray();
    $empleadosWS = $empleadosWS['Empleado'];
    //UPDATE DB USERS FROM WS
    $empleadosDB = updateFromWS($empleadosDB, $empleadosWS);
    //UPDATE DB USERS FROM WS
    deleteFromWS($empleadosDB);
    echo changeArrayIntoJSON('caminpa', array('process' => 'ok'));
}

function updateFromWS($empleadosDB, $empleadosWS) {
    $sql_i = "INSERT INTO camUsuarios(
                USR_Mail,
                USR_NumeroEmpleado,
                USR_Tipo,
                USR_Control,
                USR_AdminAccess,
                USR_Password,
                USR_Salt
            ) VALUES (
                :correo,
                :no_empleado,
                :tipo,
                :usercontrol,
                :admin_access,
                :password,
                :salt
            )";
    $sql_u = "UPDATE camUsuarios
              SET USR_Mail = :correo,
                  USR_Control = :usercontrol
              WHERE USR_Id = :id";
    $sha = hash('sha512', '123456');
    //Get all 'no_empleado' array values
    $acEmpleadosDB = ownArrayColumn($empleadosDB, 'no_empleado');
    foreach($empleadosWS as $keyWS => $empleadoWS) {
        $no_empleadoWS = $empleadoWS['no_empleado'];
        $no_empleadoWS = trim($no_empleadoWS);
        $correoWS = $empleadoWS['correo'];
        $correoWS = trim($correoWS);
        $keyDB = array_search($no_empleadoWS, $acEmpleadosDB, true);
        $type = gettype($keyDB);
        //There is a new user from WS
        if($type === 'boolean') {
            $params_i = array(
                'correo' => trim($correoWS),
                'no_empleado' => trim($no_empleadoWS),
                'tipo' => 2,
                'usercontrol' => 2,
                'admin_access' => 0,
                'password' => $sha,
                'salt' => $sha
            );
            $result_i = generalQuery(getConnection(), $sql_i, $params_i, 1, PDO::FETCH_ASSOC);
        //The user exists in DB
        } else {
            $empleadoDB = $empleadosDB[$keyDB];
            $no_empleadoDB = $empleadoDB['no_empleado'];
            $correoDB = $empleadoDB['correo'];
            $idEmpleadoDB = (integer)($empleadoDB['id']);
            $usercontrolDB = (integer)($empleadoDB['usercontrol']);
            //If the use
            if(trim($correoWS) !== trim($correoDB) || !$usercontrolDB) {
                $newUsercontrol = (!$usercontrolDB) ? 2 : $usercontrolDB;
                $newCorreo = (trim($correoWS) !== trim($correoDB)) ? $correoWS : $correoDB;
                $newCorreo = trim($newCorreo);
                $params_u = array(
                    'id' => $idEmpleadoDB,
                    'correo' => trim($newCorreo),
                    'usercontrol' => $newUsercontrol
                );
                $result_u = generalQuery(getConnection(), $sql_u, $params_u, 2, PDO::FETCH_ASSOC);
            }
            unset($empleadosDB[$keyDB]);
            unset($acEmpleadosDB[$keyDB]);
        }
        unset($empleadosWS[$keyWS]);
    }
    $empleadosDB = array_values($empleadosDB);
    return $empleadosDB;
}

function deleteFromWS($empleadosDB) {
    $sql = "UPDATE camUsuarios
            SET USR_Control = :usercontrol
            WHERE USR_Id = :id";
    foreach($empleadosDB as $keyDB => $empleadoDB) {
        $idEmpleadoDB = (integer)($empleadoDB['id']);
        $usercontrolDB = (integer)($empleadoDB['usercontrol']);
        if($usercontrolDB) {
            $params = array(
                'id' => $idEmpleadoDB,
                'usercontrol' => 0
            );
            $result = generalQuery(getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
        }
        unset($empleadosDB[$keyDB]);
    }
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
