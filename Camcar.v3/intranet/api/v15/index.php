<?php

include_once '../../PHPExcel/ExcelMaker2.php';
include_once '../../../incorporate/db_connect.php';
include_once '../../../incorporate/functions.php';
include_once '../../../incorporate/queryintojson.php';
include_once '../Mandrill.php';

sec_session_start();

/**
 * 
 * [Initial V 15.0]
 * 
 */

require '../Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim(array(
    'mode' => 'development',
    'cookies.httponly' => true
));

//Only invoked if mode is "production"
$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'log.enable' => true,
        'debug' => false
    ));
});

//Only invoked if mode is "development"
$app->configureMode('development', function () use ($app) {
    $app->config(array(
        'log.enable' => false,
        'debug' => true
    ));
});

/**
 * [Routes Deep V 1.0]
 */

//·······GET route    
   
$app->get('/kill', 'mws', function () {
    echo 'This is a Kill Get route';
});


//POST route

//GET route

//SELECT

$app->get('/get/test', 'mw1', 'getTest');

$app->get('/get/convenios', 'mw1', 'getConvenios');
$app->get('/get/convenios/:conId', 'mw1', 'getConveniosById');

//SESSION route

$app->get('/session/get/admin/access', 'mw1', 'getSessionAdminAccess');

//WEB SERVICE route

$app->get('/webservice/get/empleados', 'mw1', 'getEmpleados');
$app->get('/webservice/get/empleados/numeros_empleado/:no_empleado', 'mw1', 'getEmpleadosByNoEmpleado');
$app->get('/webservice/get/empleados/cumpleanos/:fecha', 'mw1', 'getEmpleadosByCumpleanos');
$app->get('/webservice/get/empleados/fechas_ingreso/:fecha', 'mw1', 'getEmpleadosByFechaIngreso');
$app->get('/webservice/get/empleados/filters/:sorter/:sort', 'mw1', 'getEmpleadosByFilters');
$app->get('/webservice/get/empleados/filters/:sorter/:sort/:mystery', 'mw1', 'getEmpleadosByFiltersSearch');
$app->get('/webservice/xls/empleados', 'mw1', 'xlsWSEmpleados');
$app->post('/webservice/set/empleados', 'mw1', 'setWSEmpleados');





// BG HEADER
$app->get('/get/header/agencias/:agnId', 'mw1', 'getHeaderAgencia');
$app->get('/get/header/agencias', 'mw1', 'getHeaderAgencias');





//POST route

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
    }
);


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

//----------------------

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

function getConveniosArray($sql, $conId) {
    $structure = array(
        'id' => 'CON_Id',
        'numero' => 'CON_Numero',
        'titulo' => 'CON_Titulo',
        'sector' => 'CON_Sector',
        'empresa' => 'CON_Empresa',
        'localidad' => 'CON_Localidad',
        'beneficio' => 'CON_Beneficio',
        'descripcion_corta' => 'CON_DescripcionCorta',
        'mecanicas' => 'CON_Mecanicas',
        'restricciones' => 'CON_Restricciones',
        'vigencia' => 'CON_Vigencia',
        'contacto' => 'CON_Contacto',
        'picture' => 'CON_Picture'
    );
    $params = array();
    ($conId !== '') ? $params['conId'] = $conId : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getConveniosJSON($sql, $conId) {
    $result = getConveniosArray($sql, $conId);
    echo changeArrayIntoJSON('caminpa', $result);
}

function getConvenios() {
    $sql = "SELECT * 
            FROM camConvenios
            WHERE CON_Status <> 0";
    getConveniosJSON($sql, '');
}

function getConveniosById($conId) {
    $sql = "SELECT * 
            FROM camConvenios
            WHERE CON_Status <> 0
            AND CON_Id = :conId";
    getConveniosJSON($sql, $conId);
}

/*
----------------------------------------------------------------------------
    General Session Methods
----------------------------------------------------------------------------
*/

function getSessionAdminAccess() {
    $access = (admin_access_check()) ? 1 : 0;
    echo changeArrayIntoJSON('caminpa', array('usr_adm_access'=>$access));
}

/*
----------------------------------------------------------------------------
    General Web Services Methods
----------------------------------------------------------------------------
*/



function getEmpleadosArray($sql, $no_empleado, $mes, $dia, $mystery) {
    $structure = array(
        'id' => 'USR_Id',
        'no_empleado' => 'USR_NumeroEmpleado',
        'username' => 'USR_Username',
        'nombre_completo' => 'USR_NombreCompleto',
        'apellido_paterno' => 'USR_ApellidoPaterno',
        'apellido_materno' => 'USR_ApellidoMaterno',
        'nombres' => 'USR_Nombres',
        'cumpleanos' => 'USR_Cumpleanos',
        'cumpleanos_anio' => 'USR_CumpleanosAnio',
        'cumpleanos_mes' => 'USR_CumpleanosMes',
        'cumpleanos_dia' => 'USR_CumpleanosDia',
        'edad' => 'USR_Edad',
        'telefono' => 'USR_Telefono',
        'correo' => 'USR_Mail',
        'estado' => 'USR_Estado',
        'ciudad' => 'USR_Ciudad',
        'agn_id' => 'USR_AGN_Id',
        'numero_agencia' => 'USR_NumeroAgencia',
        'agencia' => 'USR_Agencia',
        'marca' => 'USR_Marca',
        'area' => 'USR_Area',
        'cargo' => 'USR_Cargo',
        'fecha_ingreso' => 'USR_FechaIngreso',
        'fecha_ingreso_anio' => 'USR_FechaIngresoAnio',
        'fecha_ingreso_mes' => 'USR_FechaIngresoMes',
        'fecha_ingreso_dia' => 'USR_FechaIngresoDia',
        'aniversario' => 'USR_Aniversario',
        'tipo' => 'USR_Tipo',
        'admin_access' => 'USR_AdminAccess',
        'control' => 'USR_Control'
    );
    $params = array();
    ($no_empleado !== '') ? $params['no_empleado'] = $no_empleado : $params = $params;
    ($mes !== '') ? $params['mes'] = $mes : $params = $params;
    ($dia !== '') ? $params['dia'] = $dia : $params = $params;
    ($mystery !== '') ? $params['mystery'] = '%' . $mystery . '%' : $params = $params;
    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    return $result;
}

function getEmpleadosJSON($sql, $no_empleado, $mes, $dia, $mystery) {
    $result = getEmpleadosArray($sql, $no_empleado, $mes, $dia, $mystery);
    echo changeArrayIntoJSON('webservice', $result);
}

function getEmpleados() {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) as USR_NombreCompleto
            FROM(
                SELECT *, 
                        YEAR(USR_Cumpleanos) USR_CumpleanosAnio, 
                        MONTH(USR_Cumpleanos) USR_CumpleanosMes, 
                        DAY(USR_Cumpleanos) USR_CumpleanosDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Edad,
                        YEAR(USR_FechaIngreso) USR_FechaIngresoAnio, 
                        MONTH(USR_FechaIngreso) USR_FechaIngresoMes, 
                        DAY(USR_FechaIngreso) USR_FechaIngresoDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Aniversario
                FROM camUsuarios
                WHERE USR_Control <> 0
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY')
            ) epy
            ORDER BY epy.USR_ApellidoPaterno ASC, epy.USR_ApellidoMaterno ASC, epy.USR_Nombres ASC";
    getEmpleadosJSON($sql, '', '', '', '');
}

function getEmpleadosByFiltersMaster($sorter, $sort, $mystery) {
    $where = ' 1=1';

    $where_search = ($mystery !== '')
        ? ' epy.USR_ApellidoPaterno LIKE :mystery' .
          ' OR epy.USR_ApellidoMaterno LIKE :mystery' .
          ' OR epy.USR_Nombres LIKE :mystery' .
          ' OR epy.USR_Estado LIKE :mystery' .
          ' OR epy.USR_Ciudad LIKE :mystery' .
          ' OR epy.USR_Agencia LIKE :mystery' .
          ' OR epy.USR_Marca LIKE :mystery' .
          ' OR epy.USR_Mail LIKE :mystery' .
          ' OR epy.USR_NumeroEmpleado LIKE :mystery'
        : ' 1=1';

    //Keys whose values will perform like sort parameters
    $sortingField = 'epy.USR_NombreCompleto';

    //Depending on the $sorter value, the $sortingField will take different parameters values
    switch($sorter) {
        case 'n-emp':
            $sortingField = 'epy.USR_NumeroEmpleado';
            break;
        case 'agn':
            $sortingField = 'epy.USR_Agencia';
            break;
        case 'mar':
            $sortingField = 'epy.USR_Marca';
            break;
        case 'are':
            $sortingField = 'epy.USR_Area';
            break;
        case 'car':
            $sortingField = 'epy.USR_Cargo';
            break;
        case 'ciu':
            $sortingField = 'epy.USR_Ciudad';
            break;
        case 'est':
            $sortingField = 'epy.USR_Estado';
            break;
        case 'mail':
            $sortingField = 'epy.USR_Mail';
            break;
        case 'tel':
            $sortingField = 'epy.USR_Telefono';
            break;
        case 'nom':
        default:
            $sortingField = 'epy.USR_NombreCompleto';
            break;
    }

    $sql_epy = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) as USR_NombreCompleto
            FROM(
                SELECT *, 
                        YEAR(USR_Cumpleanos) USR_CumpleanosAnio, 
                        MONTH(USR_Cumpleanos) USR_CumpleanosMes, 
                        DAY(USR_Cumpleanos) USR_CumpleanosDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Edad,
                        YEAR(USR_FechaIngreso) USR_FechaIngresoAnio, 
                        MONTH(USR_FechaIngreso) USR_FechaIngresoMes, 
                        DAY(USR_FechaIngreso) USR_FechaIngresoDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Aniversario
                FROM camUsuarios
                WHERE USR_Control <> 0
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY')
            ) epy
            WHERE $where";

    $sql = "SELECT *
            FROM (
                $sql_epy
            ) epy
            WHERE $where_search
            ORDER BY $sortingField $sort";

    getEmpleadosJSON($sql, '', '', '', $mystery);
}

function getEmpleadosByFilters($sorter, $sort) {
    getEmpleadosByFiltersMaster($sorter, $sort, '');
}

function getEmpleadosByFiltersSearch($sorter, $sort, $mystery) {
    $mystery = str_replace('**47**', '/', $mystery);
    getEmpleadosByFiltersMaster($sorter, $sort, $mystery);
}

function getEmpleadosByNoEmpleado($no_empleado) {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) as USR_NombreCompleto
            FROM(
                SELECT *, 
                        YEAR(USR_Cumpleanos) USR_CumpleanosAnio, 
                        MONTH(USR_Cumpleanos) USR_CumpleanosMes, 
                        DAY(USR_Cumpleanos) USR_CumpleanosDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Edad,
                        YEAR(USR_FechaIngreso) USR_FechaIngresoAnio, 
                        MONTH(USR_FechaIngreso) USR_FechaIngresoMes, 
                        DAY(USR_FechaIngreso) USR_FechaIngresoDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Aniversario
                FROM camUsuarios
                WHERE USR_Control <> 0
                AND USR_NumeroEmpleado = :no_empleado
            ) epy
            LIMIT 1";
    getEmpleadosJSON($sql, $no_empleado, '', '', '');
}

function getEmpleadosByCumpleanos($fecha) {
    $elements = explode('-', $fecha);
    $anio = intval($elements[0]);
    $mes = intval($elements[1]);
    $dia = intval($elements[2]);
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) as USR_NombreCompleto
            FROM(
                SELECT *, 
                        YEAR(USR_Cumpleanos) USR_CumpleanosAnio, 
                        MONTH(USR_Cumpleanos) USR_CumpleanosMes, 
                        DAY(USR_Cumpleanos) USR_CumpleanosDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Edad,
                        YEAR(USR_FechaIngreso) USR_FechaIngresoAnio, 
                        MONTH(USR_FechaIngreso) USR_FechaIngresoMes, 
                        DAY(USR_FechaIngreso) USR_FechaIngresoDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Aniversario
                FROM camUsuarios
                WHERE USR_Control <> 0
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY')
            ) epy
            WHERE USR_CumpleanosMes = :mes
            AND USR_CumpleanosDia = :dia
            ORDER BY epy.USR_CumpleanosMes ASC, epy.USR_CumpleanosDia ASC, epy.USR_CumpleanosAnio ASC";
    getEmpleadosJSON($sql, '', $mes, $dia, '');
}

function getEmpleadosByFechaIngreso($fecha) {
    $elements = explode('-', $fecha);
    $anio = intval($elements[0]);
    $mes = intval($elements[1]);
    $dia = intval($elements[2]);
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) as USR_NombreCompleto
            FROM(
                SELECT *, 
                        YEAR(USR_Cumpleanos) USR_CumpleanosAnio, 
                        MONTH(USR_Cumpleanos) USR_CumpleanosMes, 
                        DAY(USR_Cumpleanos) USR_CumpleanosDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Edad,
                        YEAR(USR_FechaIngreso) USR_FechaIngresoAnio, 
                        MONTH(USR_FechaIngreso) USR_FechaIngresoMes, 
                        DAY(USR_FechaIngreso) USR_FechaIngresoDia,
                        FLOOR(DATEDIFF(CURDATE(), USR_Cumpleanos)/365) USR_Aniversario
                FROM camUsuarios
                WHERE USR_Control <> 0
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY')
            ) epy
            WHERE USR_FechaIngresoMes = :mes
            AND USR_FechaIngresoDia = :dia
            ORDER BY epy.USR_FechaIngresoMes ASC, epy.USR_FechaIngresoDia ASC, epy.USR_FechaIngresoAnio ASC";
    getEmpleadosJSON($sql, '', $mes, $dia, '');
}

//---------------------

function getWSEmpleadosArray() {
    $today = new DateTime(date('o-m-d'));
    //Get contents from webservice provided by camcar
    $content = file_get_contents('http://camcar.com.mx/camcarservice/rest/Empleados');
    //Trim the content
    $content = trim($content);
    //Delete tabs, ends of line, and new lines
    $content = str_replace(array("\n", "\r", "\t"), '', $content);
    //Trim the content
    $content = trim($content);
    //Change all " into '
    $content = trim(str_replace('"', "'", $content));
    //Trim the content
    $content = trim($content);
    //Get String Content length
    $lengthContent = strlen($content);
    //Change content into an array of Simplexml objects
    $array = ($lengthContent > 0) 
        ? simplexml_load_string($content, 'SimpleXMLElement', LIBXML_COMPACT|LIBXML_PARSEHUGE) 
        : array();
    //Cast the array of Simplexml objects into a simple array
    $array = (array)($array);
    //Result array is empty by default
    $result = array();
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

                    //Divide in numeric year, month and day
                    $elements = explode('-', $castedArrayL3[$key3]);
                    $dateYear = intval($elements[0]);
                    $dateMonth = intval($elements[1]);
                    $dateDay = intval($elements[2]);

                    $date = new DateTime($castedValueL3);
                    $interval = $date->diff($today);
                    $years = (string)($interval->format('%r%y'));

                    if(strtolower($key3) === 'cumpleanos') {
                        $castedArrayL3['cumpleanos_anio'] = $dateYear;
                        $castedArrayL3['cumpleanos_mes'] = $dateMonth;
                        $castedArrayL3['cumpleanos_dia'] = $dateDay;
                        $castedArrayL3['edad'] = $years;
                    } else {
                        $castedArrayL3['fecha_ingreso_anio'] = $dateYear;
                        $castedArrayL3['fecha_ingreso_mes'] = $dateMonth;
                        $castedArrayL3['fecha_ingreso_dia'] = $dateDay;
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
    //Assign it to de result array
    $result = (array_key_exists('empleado', $array)) 
        ? $array['empleado'] 
        : $result;
    
    //Return it
    return array_values($result);
}

function setWSEmpleados() {
    $sql = "SELECT *
            FROM camUsuarios
            WHERE USR_NumeroEmpleado NOT IN(:no_empleado, :no_empleado_2)
            ORDER BY USR_Id ASC";
    $structure = array(
        'id' => 'USR_Id',
        'no_empleado' => 'USR_NumeroEmpleado',
        'apellido_paterno' => 'USR_ApellidoPaterno',
        'apellido_materno' => 'USR_ApellidoMaterno',
        'nombres' => 'USR_Nombres',
        'cumpleanos' => 'USR_Cumpleanos',
        'telefono' => 'USR_Telefono',
        'correo' => 'USR_Mail',
        'estado' => 'USR_Estado',
        'ciudad' => 'USR_Ciudad',
        'numero_agencia' => 'USR_NumeroAgencia',
        'agencia' => 'USR_Agencia',
        'marca' => 'USR_Marca',
        'area' => 'USR_Area',
        'cargo' => 'USR_Cargo',
        'fecha_ingreso' => 'USR_FechaIngreso',
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
                USR_ApellidoPaterno,
                USR_ApellidoMaterno,
                USR_Nombres,
                USR_Cumpleanos,
                USR_Telefono,
                USR_Estado,
                USR_Ciudad,
                USR_NumeroAgencia,
                USR_Agencia,
                USR_Marca,
                USR_Area,
                USR_Cargo,
                USR_FechaIngreso,
                USR_Username,
                USR_Tipo,
                USR_Control,
                USR_AdminAccess,
                USR_Password,
                USR_Salt
            ) VALUES (
                :correo,
                :no_empleado,
                :apellido_paterno,
                :apellido_materno,
                :nombres,
                :cumpleanos,
                :telefono,
                :estado,
                :ciudad,
                :numero_agencia,
                :agencia,
                :marca,
                :area,
                :cargo,
                :fecha_ingreso,
                :username,
                :tipo,
                :usercontrol,
                :admin_access,
                :password,
                :salt
            )";
    $sql_u = "UPDATE camUsuarios
              SET USR_ApellidoPaterno = :apellido_paterno,
                  USR_ApellidoMaterno = :apellido_materno,
                  USR_Nombres = :nombres,
                  USR_Cumpleanos = :cumpleanos,
                  USR_Telefono = :telefono,
                  USR_Mail = :correo,
                  USR_Estado = :estado,
                  USR_Ciudad = :ciudad,
                  USR_NumeroAgencia = :numero_agencia,
                  USR_Agencia = :agencia,
                  USR_Marca = :marca,
                  USR_Area = :area,
                  USR_Cargo = :cargo,
                  USR_FechaIngreso = :fecha_ingreso,
                  USR_Control = :usercontrol
              WHERE USR_Id = :id";
    $sha = hash('sha512', '123456');
    //Get all 'no_empleado' array values
    $acEmpleadosDB = ownArrayColumn($empleadosDB, 'no_empleado');
    foreach($empleadosWS as $keyWS => $empleadoWS) {
        $no_empleadoWS = $empleadoWS['no_empleado'];
        $no_empleadoWS = trim($no_empleadoWS);
        $apPatWS = $empleadoWS['apellido_paterno'];
        $apPatWS = trim($apPatWS);
        $apMatWS = $empleadoWS['apellido_materno'];
        $apMatWS = trim($apMatWS);
        $apMatWS = trim($apMatWS);
        $nombresWS = $empleadoWS['nombres'];
        $cumpleanosWS = $empleadoWS['cumpleanos'];
        $cumpleanosWS = trim($cumpleanosWS);
        $telefonoWS = $empleadoWS['telefono'];
        $telefonoWS = trim($telefonoWS);
        $correoWS = $empleadoWS['correo'];
        $correoWS = trim($correoWS);
        $estadoWS = $empleadoWS['estado'];
        $estadoWS = trim($estadoWS);
        $ciudadWS = $empleadoWS['ciudad'];
        $ciudadWS = trim($ciudadWS);
        $numero_agenciaWS = $empleadoWS['numero_agencia'];
        $numero_agenciaWS = trim($numero_agenciaWS);
        $agenciaWS = $empleadoWS['agencia'];
        $agenciaWS = trim($agenciaWS);
        $marcaWS = $empleadoWS['marca'];
        $marcaWS = trim($marcaWS);
        $areaWS = $empleadoWS['area'];
        $areaWS = trim($areaWS);
        $cargoWS = $empleadoWS['cargo'];
        $cargoWS = trim($cargoWS);
        $fecha_ingresoWS = $empleadoWS['fecha_ingreso'];
        $fecha_ingresoWS = trim($fecha_ingresoWS);
        
        $keyDB = array_search($no_empleadoWS, $acEmpleadosDB, true);
        $type = gettype($keyDB);
        //There is a new user from WS
        if($type === 'boolean') {
            $params_i = array(
                'correo' => trim($correoWS),
                'no_empleado' => trim($no_empleadoWS),
                'apellido_paterno' => trim($apPatWS),
                'apellido_materno' => trim($apMatWS),
                'nombres' => trim($nombresWS),
                'cumpleanos' => trim($cumpleanosWS),
                'telefono' => trim($telefonoWS),
                'estado' => trim($estadoWS),
                'ciudad' => trim($ciudadWS),
                'numero_agencia' => trim($numero_agenciaWS),
                'agencia' => trim($agenciaWS),
                'marca' => trim($marcaWS),
                'area' => trim($areaWS),
                'cargo' => trim($cargoWS),
                'fecha_ingreso' => trim($fecha_ingresoWS),
                'username' => '',
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
            $apPatDB = $empleadoDB['apellido_paterno'];
            $apPatDB = trim($apPatDB);
            $apMatDB = $empleadoDB['apellido_materno'];
            $apMatDB = trim($apMatDB);
            $nombresDB = $empleadoDB['nombres'];
            $nombresDB = trim($nombresDB);
            $cumpleanosDB = $empleadoDB['cumpleanos'];
            $cumpleanosDB = trim($cumpleanosDB);
            $telefonoDB = $empleadoDB['telefono'];
            $telefonoDB = trim($telefonoDB);
            $correoDB = $empleadoDB['correo'];
            $correoDB = trim($correoDB);
            $estadoDB = $empleadoDB['estado'];
            $estadoDB = trim($estadoDB);
            $ciudadDB = $empleadoDB['ciudad'];
            $ciudadDB = trim($ciudadDB);
            $numero_agenciaDB = $empleadoDB['numero_agencia'];
            $numero_agenciaDB = trim($numero_agenciaDB);
            $agenciaDB = $empleadoDB['agencia'];
            $agenciaDB = trim($agenciaDB);
            $marcaDB = $empleadoDB['marca'];
            $marcaDB = trim($marcaDB);
            $areaDB = $empleadoDB['area'];
            $areaDB = trim($areaDB);
            $cargoDB = $empleadoDB['cargo'];
            $cargoDB = trim($cargoDB);
            $fecha_ingresoDB = $empleadoDB['fecha_ingreso'];
            $fecha_ingresoDB = trim($fecha_ingresoDB);

            $idEmpleadoDB = (integer)($empleadoDB['id']);
            $usercontrolDB = (integer)($empleadoDB['usercontrol']);
            //If the use
            //if(trim($correoWS) !== trim($correoDB) || !$usercontrolDB) {
                $newUsercontrol = (!$usercontrolDB) ? 2 : $usercontrolDB;
                $newCorreo = (trim($correoWS) !== trim($correoDB)) ? $correoWS : $correoDB;
                $newCorreo = trim($newCorreo);

                $newApPat = (trim($apPatWS) !== trim($apPatDB)) ? $apPatWS : $apPatDB;
                $newApPat = trim($newApPat);
                $newApMat = (trim($apMatWS) !== trim($apMatDB)) ? $apMatWS : $apMatDB;
                $newApMat = trim($newApMat);
                $newNombres = (trim($nombresWS) !== trim($nombresDB)) ? $nombresWS : $nombresDB;
                $newNombres = trim($newNombres);
                $newCumpleanos = (trim($cumpleanosWS) !== trim($cumpleanosDB)) ? $cumpleanosWS : $cumpleanosDB;
                $newCumpleanos = trim($newCumpleanos);
                $newTelefono = (trim($telefonoWS) !== trim($telefonoDB)) ? $telefonoWS : $telefonoDB;
                $newTelefono = trim($newTelefono);
                $newEstado = (trim($estadoWS) !== trim($estadoDB)) ? $estadoWS : $estadoDB;
                $newEstado = trim($newEstado);
                $newCiudad = (trim($ciudadWS) !== trim($ciudadDB)) ? $ciudadWS : $ciudadDB;
                $newCiudad = trim($newCiudad);
                $newNumero_agencia = (trim($numero_agenciaWS) !== trim($numero_agenciaDB)) ? $numero_agenciaWS : $numero_agenciaDB;
                $newNumero_agencia = trim($newNumero_agencia);
                $newAgencia = (trim($agenciaWS) !== trim($agenciaDB)) ? $agenciaWS : $agenciaDB;
                $newAgencia = trim($newAgencia);
                $newMarca = (trim($marcaWS) !== trim($marcaDB)) ? $marcaWS : $marcaDB;
                $newMarca = trim($newMarca);
                $newArea = (trim($areaWS) !== trim($areaDB)) ? $areaWS : $areaDB;
                $newArea = trim($newArea);
                $newCargo = (trim($cargoWS) !== trim($cargoDB)) ? $cargoWS : $cargoDB;
                $newCargo = trim($newCargo);
                $newFecha_ingreso = (trim($fecha_ingresoWS) !== trim($fecha_ingresoDB)) ? $fecha_ingresoWS : $fecha_ingresoDB;
                $newFecha_ingreso = trim($newFecha_ingreso);

                $params_u = array(
                    'id' => $idEmpleadoDB,
                    'apellido_paterno' => trim($newApPat),
                    'apellido_materno' => trim($newApMat),
                    'nombres' => trim($newNombres),
                    'cumpleanos' => trim($newCumpleanos),
                    'telefono' => trim($newTelefono),
                    'correo' => trim($newCorreo),
                    'estado' => trim($newEstado),
                    'ciudad' => trim($newCiudad),
                    'numero_agencia' => trim($newNumero_agencia),
                    'agencia' => trim($newAgencia),
                    'marca' => trim($newMarca),
                    'area' => trim($newArea),
                    'cargo' => trim($newCargo),
                    'fecha_ingreso' => trim($newFecha_ingreso),
                    'usercontrol' => $newUsercontrol
                );
                $result_u = generalQuery(getConnection(), $sql_u, $params_u, 2, PDO::FETCH_ASSOC);
            //}
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

function xlsWSEmpleados() {
    $result = getWSEmpleadosArray();
    $result = sortArrayByKeys($result, array(
        'no_empleado',
        'apellido_paterno',
        'apellido_materno',
        'nombres',
        'agencia'
    ));
    $result = restructureArray($result, array(
        'no_empleado' => 'no_empleado',
        'apellido_paterno' => 'apellido_paterno',
        'apellido_materno' => 'apellido_materno',
        'nombres' => 'nombres',
        'numero_agencia' => 'numero_agencia',
        'agencia' => 'agencia',
        'marca' => 'marca',
        'area' => 'area',
        'cargo' => 'cargo',
        'estado' => 'estado',
        'ciudad' => 'ciudad',
        'correo' => 'correo',
        'telefono' => 'telefono',
        'cumpleanos' => 'cumpleanos',
        'fecha_ingreso' => 'fecha_ingreso'
    ));
    foreach($result as $key => $value) {
        $result[$key]['no_empleado'] = "   " . $result[$key]['no_empleado'] . "   ";
    }
    $em = new ExcelMaker2(
        'Empleados_Camcar', 
        'Empleados', 
        array(
            'NÚmero de Empleado',
            'Appellido Paterno',
            'Appellido Materno',
            'Nombres',
            'No. Agencia',
            'Agencia',
            'Marca',
            'Área',
            'Cargo',
            'Estado',
            'Ciudad',
            'Correo',
            'TelÉfono',
            'CumpleaÑos',
            'Fecha de Ingreso'
        ), 
        $result
    );
    $em->makeFileCreator();
    $url = $em->getCreatorReference();
    //header("Location: $url");
    echo changeArrayIntoJSON('caminpa', array('url' => $url));
}


// GET HEADER AGENCIES


function getAgenciasJSON($sql, $agnId) {
    $result = getAgenciasArray($sql, $agnId);
    echo changeArrayIntoJSON('caminpa', $result);
}

function getHeaderAgenciaJSON($sql, $agnId) {
    $structure = array(
        'agn_id' => 'AGN_Id',
        'agn_name' => 'AGN_Nombre',
        'agn_style' => 'AGN_Url',
        'agn_header' => 'AGN_Header'
    );
    $params = array();
    ($agnId !== '') ? $params['agn_id'] = $agnId : $params = $params;
    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    echo changeArrayIntoJSON('caminpa', $result);
}

function getHeaderAgencias() {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Tipo = 0";
    getHeaderAgenciaJSON($sql, '');
}

function getHeaderAgencia($agnId) {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Tipo = 0
            AND AGN_Id = :agn_id";
    getHeaderAgenciaJSON($sql, $agnId);
}