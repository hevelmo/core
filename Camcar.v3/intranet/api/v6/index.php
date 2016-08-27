<?php

include_once '../../../incorporate/db_connect.php';
include_once '../../../incorporate/functions.php';
include_once '../../../incorporate/queryintojson.php';
include_once '../Mandrill.php';

sec_session_start();

/**
 * 
 * [Initial V 6.0]
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

//GET route

//SELECT

$app->get('/get/test', 'mw1', 'getTest');

//WEB SERVICE route

$app->get('/webservice/get/empleados', 'mw1', 'getWSEmpleados');
$app->get('/webservice/get/empleados/agencias/:agencia', 'mw1', 'getWSEmpleadosByAgencia');
$app->get('/webservice/get/empleados/aniversarios/:aniversario', 'mw1', 'getWSEmpleadosByAniversario');
$app->get('/webservice/get/empleados/apellidos_maternos/:apellido_materno', 'mw1', 'getWSEmpleadosByApellidoMaterno');
$app->get('/webservice/get/empleados/apellidos_paternos/:apellido_paterno', 'mw1', 'getWSEmpleadosByApellidoPaterno');
$app->get('/webservice/get/empleados/areas/:area', 'mw1', 'getWSEmpleadosByArea');
$app->get('/webservice/get/empleados/cargos/:cargo', 'mw1', 'getWSEmpleadosByCargo');
$app->get('/webservice/get/empleados/ciudades/:ciudad', 'mw1', 'getWSEmpleadosByCiudad');
$app->get('/webservice/get/empleados/correos/:correo', 'mw1', 'getWSEmpleadosByCorreo');
$app->get('/webservice/get/empleados/cumpleanos/:fecha', 'mw1', 'getWSEmpleadosByCumpleanos');
$app->get('/webservice/get/empleados/edades/:edad', 'mw1', 'getWSEmpleadosByEdad');
$app->get('/webservice/get/empleados/estados/:estado', 'mw1', 'getWSEmpleadosByEstado');
$app->get('/webservice/get/empleados/fechas_ingreso/:fecha', 'mw1', 'getWSEmpleadosByFechaIngreso');
$app->get('/webservice/get/empleados/marcas/:marca', 'mw1', 'getWSEmpleadosByMarca');
$app->get('/webservice/get/empleados/numeros_agencia/:no_agencia', 'mw1', 'getWSEmpleadosByNoAgencia');
$app->get('/webservice/get/empleados/numeros_empleado/:no_empleado', 'mw1', 'getWSEmpleadosByNoEmpleado');
$app->get('/webservice/get/empleados/nombres/:nombres', 'mw1', 'getWSEmpleadosByNombres');
$app->get('/webservice/get/empleados/telefonos/:telefono', 'mw1', 'getWSEmpleadosByTelefono');

$app->post('/webservice/set/empleados', 'mw1', 'setWSEmpleados');




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

/*
----------------------------------------------------------------------------
    Midelwere Methods
----------------------------------------------------------------------------
*/

function mw1() {
    $app = \Slim\Slim::getInstance();
    if(login_check() == true) {
        return true;
    } else {
        $app->halt(401, 'Acceso Denegado');
    }
}

function mws() {
    $app = \Slim\Slim::getInstance();
    if (user_check() == true) {
        return true;
    } else {
        $app->halt(401, 'No user');
    } 
}

// ----------------------

function requestBody() {
    $app = \Slim\Slim::getInstance();
    $request = $app->request();
    return json_decode($request->getBody());
}

function getTest() {
    $version = phpversion();
    echo "<b>PHP Version:</b> " . $version;
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


/*
----------------------------------------------------------------------------
    General Web Services Methods
----------------------------------------------------------------------------
*/

function getWSEmpleadosArray() {
    $today = new DateTime(date('o-m-d'));
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
                $castedValueL3 = ($key3 !== 'correo') 
                    ? strtoupper(trim($castedValueL3))
                    : trim($castedValueL3);
                //If there is a date change it into format yyyy-mm-dd
                if(strtolower($key3) === 'cumpleanos' || strtolower($key3) === 'fecha_ingreso') {
                    //$castedArrayL3[$key3] = str_replace('T00:00:00', '', $castedValueL3);
                    $castedArrayL3[$key3] = substr($castedValueL3, 0, 10);

                    $date = new DateTime($castedValueL3);
                    $interval = $date->diff($today);
                    $years = (string)($interval->format('%r%y'));

                    if(strtolower($key3) === 'cumpleanos') {
                        $castedArrayL3['edad'] = $years;
                    } else {
                        $castedArrayL3['aniversario'] = $years;
                    }

                } else {
                    $castedArrayL3[strtolower($key3)] = $castedValueL3;
                }
            }
            //Sort array by key
            ksort($castedArrayL3);
            //Asign the casted values array in the $key2 of $castedArrayL2
            $castedArrayL2[strtolower($key2)] = $castedArrayL3;
        }
        //Asign the casted values array in the $key1 of $array (the main array)
        $array[strtolower($key1)] = $castedArrayL2;
    }
    //Now the the array of Simplexml objects is a simple multilevel array
    //Return it
    return array_values($array['empleado']);
}

function getWSEmpleadosJSON($array) {
    $json = changeArrayIntoJSON('webservice', $array);
    return $json;
}

function getWSEmpleados() {
    $array = getWSEmpleadosArray();
    echo getWSEmpleadosJSON($array);
}

function getEmployeesByAnySpecificKey($keyWS, $valueWS, $getAll) {
    $array = getWSEmpleadosArray();
    $newArray = array();
    if(count($array)) {
        //Prepare $getAll param, default value is false
        $getAll = ($getAll === true) ? $getAll : false;
        //Trim values of $keyWS and $valueWS
        $keyWS =  strtolower(trim($keyWS));
        $valueWS = strtoupper(trim($valueWS));
        //Get only the values in the key $keyWS
        $acEmpleados = ownArrayColumn($array, $keyWS);
        //Get all occurrences
        if($getAll) {
            //Get an $array of indexes of $acEmpleados where $valueWS is found
            //This $array could be empty
            $idxsDB = array_keys($acEmpleados, $valueWS);
            //Look for each $idxsDB value in $array
            foreach($idxsDB as $idxDB) {
                //Assign, in the new array, each found array 
                $newArray[] = $array[$idxDB];
            }
        //Get only the first of the occurrences
        } else {
            $idxDB = array_search($valueWS, $acEmpleados, true);
            $type = gettype($idxDB);
            //Look for $idxDB (the first ocurrence) in $array
            //Only if it exists in $acEmpleados
            if($type !== 'boolean') {
                ////Assign, in the new array, the only one found array
                $newArray[] = $array[$idxDB];
            }
        }
    }
    //Return the new array with the found arrays
    return $newArray;
}

function getEmployeesByDataRange($dateKey, $dateStart, $dateEnd, $dateFilterParams, $sortGo, $sortMode) {
    $array = getWSEmpleadosArray();
    //Make empty the array that allocates the elements that fulfill the date conditions
    $newArray = array();
    //Determinate if it is necessary to sort the array
    $sortGo = ($sortGo === true) ? $sortGo : false;
    //If it is necessary to sort the array
    //Determinate the sort mode ASC: Ascendant, DESC: Descendant or any
    if($sortGo) {
        //Sort mode is defined
        if(isset($sortMode)) {
            //Make it string
            $sortMode = (string)($sortMode);
            //Change it into UPER case
            $sortMode = strtoupper($sortMode);
            //If there is a correct kind of sort mode keep it, otherwise make it empty
            $sortMode = ($sortMode === 'ASC' || $sortMode === 'DESC') ? $sortMode : '';
        //Sort mode is undefined
        } else {
            //Default sort mode is ASC
            $sortMode = 'ASC';
        }
    } else {
        //Any kind of sort mode
        $sortMode = '';
    }
    //
    if(count($array)) {
        //Validates both dates have a correct format date
        $format = 'Y-m-d';
        if(validateDate($dateStart, $format) && validateDate($dateEnd, $format)) {
            //Prepare dateFilterParams string
            $dateFilterParams = isset($dateFilterParams) ? $dateFilterParams : '';
            $dateFilterParams = trim($dateFilterParams);
            $dateFilterParams = strtoupper($dateFilterParams);
            //Validate from $dateFilterParams if it is necessary search the year
            $searchYear = (strpos($dateFilterParams, 'Y') !== false);
            //Validate from $dateFilterParams if it is necessary search the month
            $searchMonth = (strpos($dateFilterParams, 'M') !== false);
            //Validate from $dateFilterParams if it is necessary search the day
            $searchDay = (strpos($dateFilterParams, 'D') !== false);
            //Get start elements (year, month, day)
            $dateStartElements = explode('-', $dateStart);
            $dayStart = (integer)($dateStartElements[2]);
            $monthStart = (integer)($dateStartElements[1]);
            $yearStart = (integer)($dateStartElements[0]);
            //Get end elements (year, month, day)
            $dateEndElements = explode('-', $dateEnd);
            $dayEnd = (integer)($dateEndElements[2]);
            $monthEnd = (integer)($dateEndElements[1]);
            $yearEnd = (integer)($dateEndElements[0]);
            for($idx = 0; $idx < count($array); $idx++) {
                //By default year, month and day permits to get the current element
                $yearGo = true;
                $monthGo = true;
                $dayGo = true;
                //Get the element and is current date by key
                $currentElement = $array[$idx];
                $dateCurrent = $currentElement[$dateKey];
                //Get current date elements (year, month, day)
                $dateCurrentElements = explode('-', $dateCurrent);
                $dayCurrent = (integer)($dateCurrentElements[2]);
                $monthCurrent = (integer)($dateCurrentElements[1]);
                $yearCurrent = (integer)($dateCurrentElements[0]);
                //Make the validation only if there is necessary look for the year
                if($searchYear) {
                    //Permit only is the year ins in the start - end range
                    $yearGo = ($yearCurrent >= $yearStart && $yearCurrent <= $yearEnd) ? true : false;
                }
                //Make the validation only if there is necessary look for the month
                if($searchMonth) {
                    //Permit only is the month ins in the start - end range
                    $monthGo = ($monthCurrent >= $monthStart && $monthCurrent <= $monthEnd) ? true : false;
                }
                //Make the validation only if there is necessary look for the day
                if($searchDay) {
                    //Permit only is the day ins in the start - end range
                    $dayGo = ($dayCurrent >= $dayStart && $dayCurrent <= $dayEnd) ? true : false;
                }
                //Get the elementh only ¡f the three conditions (year, month, day) permit it
                if($yearGo && $monthGo && $dayGo) {
                    $newArray[] = $array[$idx];
                }
            }
        }
    }
    return $newArray;   
}

function getWSEmpleadosByAgencia($agencia) {
    $array = getEmployeesByAnySpecificKey('agencia', $agencia, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByAniversario($aniversario) {
    $array = getEmployeesByAnySpecificKey('aniversario', $aniversario, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByApellidoMaterno($apellido_materno) {
    $array = getEmployeesByAnySpecificKey('apellido_materno', $apellido_materno, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByApellidoPaterno($apellido_paterno) {
    $array = getEmployeesByAnySpecificKey('apellido_paterno', $apellido_paterno, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByArea($area) {
    $array = getEmployeesByAnySpecificKey('area', $area, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByCargo($cargo) {
    $array = getEmployeesByAnySpecificKey('cargo', $cargo, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByCiudad($ciudad) {
    $array = getEmployeesByAnySpecificKey('ciudad', $ciudad, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByCorreo($correo) {
    $array = getEmployeesByAnySpecificKey('correo', $correo, false);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByCumpleanos($fecha) {
    $array = getEmployeesByDataRange('cumpleanos', $fecha, $fecha, 'md', true, 'DESC');
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByEdad($edad) {
    $array = getEmployeesByAnySpecificKey('edad', $edad, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByEstado($estado) {
    $array = getEmployeesByAnySpecificKey('estado', $estado, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByFechaIngreso($fecha) {
    $array = getEmployeesByDataRange('fecha_ingreso', $fecha, $fecha, 'md', true, 'DESC');
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByMarca($marca) {
    $array = getEmployeesByAnySpecificKey('marca', $marca, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByNoAgencia($numero_agencia) {
    $array = getEmployeesByAnySpecificKey('numero_agencia', $numero_agencia, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByNoEmpleado($no_empleado) {
    $array = getEmployeesByAnySpecificKey('no_empleado', $no_empleado, false);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByNombres($nombres) {
    $array = getEmployeesByAnySpecificKey('nombres', $nombres, true);
    echo getWSEmpleadosJSON($array);
}

function getWSEmpleadosByTelefono($telefono) {
    $array = getEmployeesByAnySpecificKey('telefono', $telefono, true);
    echo getWSEmpleadosJSON($array);
}

function setWSEmpleados() {
    $sql = "SELECT *
            FROM camUsuarios
            WHERE USR_NumeroEmpleado NOT IN(:no_empleado, :no_empleado_2)
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
        'no_empleado' => 'XXXX',
        'no_empleado_2' => 'YYYY'
    );
    //Get empleados from table 'camUsuarios' of database
    $empleadosDB = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    //Get empleados from webservice
    $empleadosWS = getWSEmpleadosArray();
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
