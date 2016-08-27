<?php

include_once '../../PHPExcel/ExcelMaker2.php';
include_once '../../../incorporate/db_connect.php';
include_once '../../../incorporate/functions.php';
include_once '../../../incorporate/queryintojson.php';
include_once '../Mandrill.php';

sec_session_start();

/**
 *
 * [Initial V 20.0]
 *
 **/

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
 **/

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
$app->get('/xls/convenios', 'mw1', 'xlsConvenios');

//SESSION route

$app->get('/session/get/admin/access', 'mw1', 'getSessionAdminAccess');

//WEB SERVICE route

$app->get('/webservice/get/agencias', 'mw1', 'getWSAgencias');
$app->get('/webservice/get/marcas', 'mw1', 'getWSMarcas');
$app->get('/webservice/get/empleados', 'mw1', 'getEmpleados');
$app->get('/webservice/get/empleados/mail/:mail', 'mw1', 'getEmpleadosByMail');
$app->get('/webservice/get/empleados/numeros_empleado/:no_empleado', 'mw1', 'getEmpleadosByNoEmpleado');
$app->get('/webservice/get/empleados/cumpleanos/:fecha', 'mw1', 'getEmpleadosByCumpleanos');
$app->get('/webservice/get/empleados/fechas_ingreso/:fecha', 'mw1', 'getEmpleadosByFechaIngreso');
$app->get('/webservice/get/empleados/filters/:marca/:sorter/:sort', 'mw1', 'getEmpleadosByFilters');
$app->get('/webservice/get/empleados/filters/:marca/:sorter/:sort/:mystery', 'mw1', 'getEmpleadosByFiltersSearch');
$app->get('/webservice/xls/empleados', 'mw1', 'xlsWSEmpleados');
$app->get('/webservice/xls/actualizados', 'mw1', 'xlsWSEmpleadosActualizados');
$app->post('/webservice/set/empleados', 'mw1', 'setWSEmpleados');

//MAILING
$app->get('/intranet/register/:mail', 'intranetRegister');
$app->get('/intranet/recovery/:mail', 'intranetRecovery');

//BG HEADER
$app->get('/get/header/agencias/:agnId', 'mw1', 'getHeaderAgencia');
$app->get('/get/header/agencias', 'mw1', 'getHeaderAgencias');

//POST SEND A MESSAGE
$app->post('/post/welcome/mensaje/cumpleanos', 'mw1', 'sendBirthdayMesage');
$app->post('/post/directory/mensaje', 'mw1', 'sendDirectoryMessage');

//POST route

$app->post(
    '/post',
    function () {
        $app = \Slim\Slim::getInstance();
        $request = $app->request();
        $propiedad = JSON_decode($request->getBody());
        foreach($propiedad as $key => $value) {
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
**/

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
    if(user_check() == true) {
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
    echo "<b>PHP Version:</b> ".$version;
}

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
        'vigencia_formato' => 'CON_VigenciaFormat',
        'contacto' => 'CON_Contacto',
        'picture' => 'CON_Picture',
        'panel_picture' => 'CON_PanelPicture',
        'preview_info' => 'CON_PreviewInfo'
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
            WHERE CON_Status <> 0
            ORDER BY CON_Id DESC";
    getConveniosJSON($sql, '');
}

function getConveniosById($conId) {
    $sql = "SELECT *
            FROM camConvenios
            WHERE CON_Status <> 0
            AND CON_Id = :conId
            ORDER BY CON_Id DESC";
    getConveniosJSON($sql, $conId);
}

function xlsGeneral($nameFileExcel, $nameSheetExcel, $ths, $trs) {
    $em = new ExcelMaker2($nameFileExcel, $nameSheetExcel, $ths, $trs);
    $em->makeFileCreator();
    $url = $em->getCreatorReference();
    //header("Location: $url");
    echo changeArrayIntoJSON('caminpa', array('url' => $url));
}

function xlsConvenios() {
    $sql = "SELECT *
            FROM camConvenios
            WHERE CON_Status <> 0
            ORDER BY CON_Id DESC";
    $result = getConveniosArray($sql, '');
    $ths = array(
        '#',
        'nÚmero de convenio',
        'tÍtulo',
        'sector',
        'empresa',
        'localidad',
        'beneficio',
        'descripciÓn corta',
        'mecÁnicas',
        'restricciones',
        'vigencia',
        'contacto',
        'imagen'
    );
    xlsGeneral('Convenios_Camcar', 'Convenios', $ths, $result);
}

/*
----------------------------------------------------------------------------
    General Session Methods
----------------------------------------------------------------------------
*/

function getSessionAdminAccess() {
    $access = (admin_access_check()) ? 1 : 0;
    echo changeArrayIntoJSON('caminpa', array('usr_adm_access' => $access));
}

/*
----------------------------------------------------------------------------
    General Web Services Methods
----------------------------------------------------------------------------
*/

function getWSAgenciasArray($sql) {
    $orderBy = array();
    $structure = array(
        /*
        'estados' => array(
            'estado' => 'USR_Estado',
        ),
        */
        'ciudades' => array(
            'ciudad' => 'USR_Ciudad',
            'estado' => 'USR_Estado',
        ),
        'agencias' => array(
            'agencia' => 'USR_Agencia',
            'numero_agencia' => 'USR_NumeroAgencia',
            'numero_empleados' => 'USR_AgenciaNoEmpleados',
            'agn_id' => 'USR_AGN_Id',
            'ciudad' => 'USR_Ciudad',
            'estado' => 'USR_Estado',
        )
    );
    $params = array();
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    $restructure = multiLevelJSON($result, $structure, $orderBy);
    return $restructure;
}

function getWSAgenciasJSON($sql) {
    $result = getWSAgenciasArray($sql);
    echo changeArrayIntoJSON('webservice', $result);
}

function getWSAgencias() {
    $sql = "SELECT *, COUNT(*) USR_AgenciaNoEmpleados
            FROM camUsuarios
            WHERE USR_Control <> 0
            AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
            -- GROUP BY USR_Estado ASC, USR_Ciudad ASC, USR_Agencia ASC
            GROUP BY USR_Ciudad ASC, USR_Agencia ASC";
    getWSAgenciasJSON($sql);
}

function getWSMarcasArray($sql) {
    $orderBy = array();
    $structure = array(
        'marcas' => array(
            'marca' => 'USR_Marca'
        ),
        'ciudades' => array(
            'ciudad' => 'USR_Ciudad',
            'estado' => 'USR_Estado',
            'numero_empleados' => 'USR_MarcaNoEmpleados',
            'marca' => 'USR_Marca',
        )
    );
    $params = array();
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    $restructure = multiLevelJSON($result, $structure, $orderBy);
    foreach($restructure as $keyMar => $marca) {
        $restructure[$keyMar]['numero_empleados'] = 0;
        foreach($restructure[$keyMar]['ciudades'] as $keyCit => $ciudad) {
            $restructure[$keyMar]['numero_empleados'] += $ciudad['numero_empleados'];
            ksort($restructure[$keyMar]['ciudades']);
        }
        ksort($restructure[$keyMar]);
    }
    return $restructure;
}

function getWSMarcasJSON($sql) {
    $result = getWSMarcasArray($sql);
    echo changeArrayIntoJSON('webservice', $result);
}

function getWSMarcas() {
    $sql = "SELECT *, COUNT(*) USR_MarcaNoEmpleados
            FROM camUsuarios
            WHERE USR_Control <> 0
            AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
            GROUP BY USR_Marca ASC, USR_Ciudad ASC";
    getWSMarcasJSON($sql);
}

function getEmpleadosArray($sql, $marca, $no_empleado, $mes, $dia, $mail, $mystery, $date_start, $date_end) {
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
        'fecha_alta' => 'USR_FechaAlta',
        'fecha_modificado' => 'USR_FechaModificado',
        'tipo' => 'USR_Tipo',
        'admin_access' => 'USR_AdminAccess',
        'control' => 'USR_Control'
    );
    $params = array();
    ($marca !== '') ? $params['marca'] = $marca : $params = $params;
    ($no_empleado !== '') ? $params['no_empleado'] = $no_empleado : $params = $params;
    ($mes !== '') ? $params['mes'] = $mes : $params = $params;
    ($dia !== '') ? $params['dia'] = $dia : $params = $params;
    ($mail !== '') ? $params['mail'] = $mail : $params = $params;
    ($mystery !== '') ? $params['mystery'] = '%' . $mystery . '%' : $params = $params;
    ($date_start !== '') ? $params['date_start'] = '%' . $date_start . '%' : $params = $params;
    ($date_end !== '') ? $params['date_end'] = '%' . $date_end . '%' : $params = $params;
    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    return $result;
}

function getEmpleadosJSON($sql, $marca, $no_empleado, $mes, $dia, $mail, $mystery, $date_start, $date_end) {
    $result = getEmpleadosArray($sql, $marca, $no_empleado, $mes, $dia, $mail, $mystery, $date_start, $date_end);
    echo changeArrayIntoJSON('webservice', $result);
}

function getEmpleados() {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
            AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
        ) epy
        ORDER BY epy.USR_ApellidoPaterno ASC, epy.USR_ApellidoMaterno ASC, epy.USR_Nombres ASC";
    getEmpleadosJSON($sql, '', '', '', '', '', '', '', '');
}

function getEmpleadosByMail($mail) {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_Mail = :mail
            ) epy
            LIMIT 1";
    getEmpleadosJSON($sql, '', '', '', '', $mail, '', '', '');
}

function getEmpleadosByFiltersMaster($marca, $sorter, $sort, $mystery) {
    $marca = ($marca === '0') ? '' : $marca;
    
    $where = ' 1=1';
    $where .= ($marca !== '') ? ' AND USR_Marca = :marca' : '';

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

    $sql_epy = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
                FROM (
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
                    AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
                ) epy
                WHERE $where";

    $sql = "SELECT *
            FROM (
                $sql_epy
            ) epy
            WHERE $where_search
            ORDER BY $sortingField $sort";

    getEmpleadosJSON($sql, $marca, '', '', '', '', $mystery, '', '');
}

function getEmpleadosByFilters($marca, $sorter, $sort) {
    getEmpleadosByFiltersMaster($marca, $sorter, $sort, '');
}

function getEmpleadosByFiltersSearch($marca, $sorter, $sort, $mystery) {
    $mystery = str_replace('**47**', '/', $mystery);
    getEmpleadosByFiltersMaster($marca, $sorter, $sort, $mystery);
}

function getEmpleadosByNoEmpleado($no_empleado) {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
    getEmpleadosJSON($sql, '', $no_empleado, '', '', '', '', '', '');
}

function getEmpleadosByCumpleanos($fecha) {
    $elements = explode('-', $fecha);
    $anio = intval($elements[0]);
    $mes = intval($elements[1]);
    $dia = intval($elements[2]);
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
            ) epy
            WHERE USR_CumpleanosMes = :mes
            AND USR_CumpleanosDia = :dia
            ORDER BY epy.USR_CumpleanosMes ASC, epy.USR_CumpleanosDia ASC, epy.USR_CumpleanosAnio ASC";
    getEmpleadosJSON($sql, '', '', $mes, $dia, '', '', '', '');
}

function getEmpleadosByFechaIngreso($fecha) {
    $elements = explode('-', $fecha);
    $anio = intval($elements[0]);
    $mes = intval($elements[1]);
    $dia = intval($elements[2]);
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
            ) epy
            WHERE USR_FechaIngresoMes = :mes
            AND USR_FechaIngresoDia = :dia
            ORDER BY epy.USR_FechaIngresoMes ASC, epy.USR_FechaIngresoDia ASC, epy.USR_FechaIngresoAnio ASC";
    getEmpleadosJSON($sql, '', '', $mes, $dia, '', '', '', '');
}

function xlsWSEmpleados() {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
            ) epy
            ORDER BY epy.USR_NumeroEmpleado ASC, epy.USR_ApellidoPaterno ASC, epy.USR_ApellidoMaterno ASC, epy.USR_Nombres ASC, epy.USR_Agencia";
    $result = getEmpleadosArray($sql, '', '', '', '', '', '', '', '');
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
    $ths = array(
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
    );
    xlsGeneral('Empleados_Camcar', 'Empleados', $ths, $result);
}

function xlsWSEmpleadosActualizados() {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_NumeroEmpleado NOT IN ('XXXX', 'YYYY', 'ZZZZ', 'WWWW', 'AAAA', 'BBBB', 'CCCC', 'DDDD')
                AND USR_FechaModificado BETWEEN '2016-04-26 00:00:00' AND '2016-06-17 00:00:00'
            ) epy
            ORDER BY epy.USR_NumeroEmpleado ASC, epy.USR_ApellidoPaterno ASC, epy.USR_ApellidoMaterno ASC, epy.USR_Nombres ASC, epy.USR_Agencia";
    $date_start = date('o-m-d') . ' 00:00:00';
    $date_end = date('Y-m-d H:i:s', strtotime($date_start . ' +1 day'));
    //$result = getEmpleadosArray($sql, '', '', '', '', '', '', $date_start, $date_end);
    $result = getEmpleadosArray($sql, '', '', '', '', '', '', '', '');
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
    $ths = array(
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
    );
    xlsGeneral('Empleados_Camcar_Actualizados', 'Empleados', $ths, $result);
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
    $array = (array) ($array);
    //Result array is empty by default
    $result = array();
    //Itereate all the array
    foreach($array as $key1 => $value1) {
        //For each $key1 (first level)
        //Cast the array of Simplexml objects into a simple array
        $castedValueL1 = (array) ($value1);
        //Declare an empty array to fill it with the new casted values of each level 2
        $castedArrayL2 = array();
        //Itereate all the array of the vurrent $castedValueL1 casted value
        foreach($castedValueL1 as $key2 => $value2) {
            //For each $key2 (second level)
            //Cast the array of Simplexml objects into a simple array
            $castedValueL2 = (array) ($value2);
            //Declare an empty array to fill it with the new casted values of each level 3
            $castedArrayL3 = array();
            foreach($castedValueL2 as $key3 => $value3) {
                //For each $key3 (second level)
                //Cast the Simplexml value into a string
                $castedValueL3 = (string) ($value3);
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
                    $years = (string) ($interval->format('%r%y'));

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
            WHERE USR_NumeroEmpleado NOT IN(:no_empleado_1, :no_empleado_2, :no_empleado_3, :no_empleado_4, :no_empleado_5, :no_empleado_6, :no_empleado_7, :no_empleado_8)
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
        'fecha_alta' => 'USR_FechaAlta',
        'fecha_modificado' => 'USR_FechaModificado',
        'tipo' => 'USR_Tipo',
        'admin_access' => 'USR_AdminAccess',
        'usercontrol' => 'USR_Control'
    );
    $params = array(
        'no_empleado_1' => 'XXXX',
        'no_empleado_2' => 'YYYY',
        'no_empleado_3' => 'ZZZZ',
        'no_empleado_4' => 'WWWW',
        'no_empleado_5' => 'AAAA',
        'no_empleado_6' => 'BBBB',
        'no_empleado_7' => 'CCCC',
        'no_empleado_8' => 'DDDD'
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
                USR_FechaAlta,
                USR_FechaModificado,
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
                :fecha_alta,
                :fecha_modificado,
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
                  USR_FechaModificado = :fecha_modificado,
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
            $fecha_alta = date('o-m-d H:i:s');
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
                'fecha_alta' => $fecha_alta,
                'fecha_modificado' => $fecha_alta,
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

            $idEmpleadoDB = (integer) ($empleadoDB['id']);
            $usercontrolDB = (integer) ($empleadoDB['usercontrol']);
            //If the use
            //if(trim($correoWS) !== trim($correoDB) || !$usercontrolDB) {
                $newUsercontrol = (!$usercontrolDB) ? 2 : $usercontrolDB;
                $newCorreo = (trim($correoWS) !== trim($correoDB)) ? $correoWS : $correoDB;
                $newCorreo = trim($newCorreo);

                $newFecha_modificado = (trim($correoWS) !== trim($correoDB)) ? date('o-m-d H:i:s') : $empleadoDB['fecha_modificado'];

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
                    'fecha_modificado' => trim($newFecha_modificado),
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
        $idEmpleadoDB = (integer) ($empleadoDB['id']);
        $usercontrolDB = (integer) ($empleadoDB['usercontrol']);
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

//GET HEADER AGENCIES

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

//-------------------------------------

function generateCryptId($elements) {
    $cryptId = hash('sha512', date('o-m-d H:i:s'));
    foreach($elements as $element) {
        $cryptId .= hash('sha512', $element);
    }
    $cryptId .= hash('sha512', uniqid(mt_rand(), TRUE));
    $cryptId = hash('sha512', strtoupper($cryptId));
    return $cryptId;
}

function getCryptId($id, $elements) {
    $sql_s = "SELECT *
              FROM camUsuarios
              WHERE USR_Control <> :control
              AND USR_Id = :id
              LIMIT 1";
    $structure_s = array(
        'id' => 'USR_Id',
        'no_empleado' => 'USR_NumeroEmpleado',
        'correo' => 'USR_Mail',
        'tipo' => 'USR_Tipo',
        'admin_access' => 'USR_AdminAccess',
        'control' => 'USR_Control',
        'crypt_id' => 'USR_Password'
    );
    $params_s = array(
        'control' => 0,
        'id' => $id
    );
    $result_s = restructureQuery($structure_s, getConnection(), $sql_s, $params_s, 0, PDO::FETCH_ASSOC);
    $cryptId = $result_s[0]['crypt_id'];
    $control = (int) ($result_s[0]['control']);
    if($control !== 3) {
        $cryptId = generateCryptId($elements);
        $sql_u = "UPDATE camUsuarios
                  SET USR_Password = :password,
                      USR_Salt = :salt,
                      USR_Control = :control
                  WHERE USR_Id = :id";
        $params_u = array(
            'id' => $id,
            'password' => $cryptId,
            'salt' => $cryptId,
            'control' => 3
        );
        $result_u = generalQuery(getConnection(), $sql_u, $params_u, 2, PDO::FETCH_ASSOC);
    }
    return $cryptId;
}

function intranetRegister($mail) {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_Mail = :mail
            ) epy
            LIMIT 1";
    $result = getEmpleadosArray($sql, '', '', '', '', $mail, '', '', '');
    if(rightResult($result)) {
        $name = $result[0]['nombre_completo'];
        $name = strtoupper($name);
        $cryptId = getCryptId($result[0]['id'], $result[0]);
        sendRegister($mail, $name, $cryptId);
    }
}

function intranetRecovery($mail) {
    $sql = "SELECT epy.*, CONCAT(USR_ApellidoPaterno, ' ', USR_ApellidoMaterno, ' ', USR_Nombres) USR_NombreCompleto
            FROM (
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
                AND USR_Mail = :mail
            ) epy
            LIMIT 1";
    $result = getEmpleadosArray($sql, '', '', '', '', $mail, '', '', '');
    if(rightResult($result)) {
        $name = $result[0]['nombre_completo'];
        $name = strtoupper($name);
        $cryptId = getCryptId($result[0]['id'], $result[0]);
        sendRecovery($mail, $name, $cryptId);
    }
}

//-------------------------------------

function sendBirthdayMesage() {
    $property = requestBody();
    $name_cum_send_message = 'cum-send-message';
    $name_cum_send_from = 'cum-send-from';
    $name_cum_send_to = 'cum-send-to';
    $name_cum_send_email = 'cum-send-email';
    $name_cum_send_email_to = 'cum-send-email-to';
    $name_cum_send_date = 'cum-send-date';

    $cum_send_message = $property->$name_cum_send_message;
    $cum_send_from = $property->$name_cum_send_from;
    $cum_send_to = $property->$name_cum_send_to;
    $cum_send_email = $property->$name_cum_send_email;
    $cum_send_email_to = $property->$name_cum_send_email_to;
    $cum_send_date = $property->$name_cum_send_date;

    send_birthday_message($cum_send_message, $cum_send_from, $cum_send_to, $cum_send_email, $cum_send_email_to, $cum_send_date);

    echo changeArrayIntoJSON("caminpa", array('process' => 'ok'));
}

function sendDirectoryMessage() {
    $property = requestBody();
    $name_dir_send_message = 'dir-send-message';
    $name_dir_send_from = 'dir-send-from';
    $name_dir_send_to = 'dir-send-to';
    $name_dir_send_email = 'dir-send-email';
    $name_dir_send_email_to = 'dir-send-email-to';
    $name_dir_send_date = 'dir-send-date';

    $dir_send_message = $property->$name_dir_send_message;
    $dir_send_from = $property->$name_dir_send_from;
    $dir_send_to = $property->$name_dir_send_to;
    $dir_send_email = $property->$name_dir_send_email;
    $dir_send_email_to = $property->$name_dir_send_email_to;
    $dir_send_date = $property->$name_dir_send_date;

    send_directory_message($dir_send_message, $dir_send_from, $dir_send_to, $dir_send_email, $dir_send_email_to, $dir_send_date);

    echo changeArrayIntoJSON("caminpa", array('process' => 'ok'));
}

/*
----------------------------------------------------------------------------
    General Post Methods
----------------------------------------------------------------------------
*/

//SEND REGITER

function sendRegister($mailTo, $nameTo, $cryptId) {
    $devserverlist = array('127.0.0.1','::1','192.168.0.102','localhost');
    $server = (!in_array($_SERVER['SERVER_NAME'], $devserverlist))
        ? "camcar.mx"
        : "localhost/camcar";
    $mailReplay = 'marina.reyes@camcar.mx';
    /*
    $mailFrom = 'javier@medigraf.com.mx';
    $mailFrom = 'hevelmo060683@gmail.com';
    */
    $mailFrom = 'respuesta.segura@camcar.mx';
    $nameFrom = 'Camcar Intranet';
    try {
        $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
        $message = array(
            'html' => "
                <head>
                    <title></title>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
                    <style type='text/css' media='screen'>
                        .font-sans-serif{font-family:sans-serif}.font-avenir{font-family:Avenir,sans-serif}.mso .font-avenir{font-family:sans-serif!important}.font-lato{font-family:Lato,Tahoma,sans-serif}.mso .font-lato{font-family:Tahoma,sans-serif!important}.font-cabin{font-family:Cabin,Avenir,sans-serif}.mso .font-cabin{font-family:sans-serif!important}.font-open-Sans{font-family:'Open Sans',sans-serif}.mso .font-open-Sans{font-family:sans-serif!important}.font-roboto{font-family:Roboto,Tahoma,sans-serif}.mso .font-roboto{font-family:Tahoma,sans-serif!important}.font-ubuntu{font-family:Ubuntu,sans-serif}.mso .font-ubuntu{font-family:sans-serif!important}.font-pt-sans{font-family:'PT Sans','Trebuchet MS',sans-serif}.mso .font-pt-sans{font-family:'Trebuchet MS',sans-serif!important}.font-georgia{font-family:Georgia,serif}.font-merriweather{font-family:Merriweather,Georgia,serif}.mso .font-merriweather{font-family:Georgia,serif!important}.font-bitter{font-family:Bitter,Georgia,serif}.mso .font-bitter{font-family:Georgia,serif!important}.font-pt-serif{font-family:'PT Serif',Georgia,serif}.mso .font-pt-serif{font-family:Georgia,serif!important}.font-pompiere{font-family:Pompiere,'Trebuchet MS',sans-serif}.mso .font-pompiere{font-family:'Trebuchet MS',sans-serif!important}.font-roboto-slab{font-family:'Roboto Slab',Georgia,serif}.mso .font-roboto-slab{font-family:Georgia,serif!important}
                        body,td{padding:0}.image img,.logo img{display:block}.contents,.spacer,.wrapper{width:100%}.btn a:hover,.footer .links a:hover{opacity:.8}.contents,.wrapper,table.wrapper{table-layout:fixed}@media only screen and (max-width:620px){.wrapper .column .size-8{font-size:8px!important;line-height:14px!important}.wrapper .column .size-9{font-size:9px!important;line-height:16px!important}.wrapper .column .size-10{font-size:10px!important;line-height:18px!important}.wrapper .column .size-11{font-size:11px!important;line-height:19px!important}.wrapper .column .size-12{font-size:12px!important;line-height:19px!important}.wrapper .column .size-13{font-size:13px!important;line-height:21px!important}.wrapper .column .size-14{font-size:14px!important;line-height:21px!important}.wrapper .column .size-15{font-size:15px!important;line-height:23px!important}.wrapper .column .size-16{font-size:16px!important;line-height:24px!important}.wrapper .column .size-17,.wrapper .column .size-18,.wrapper .column .size-20{font-size:17px!important;line-height:26px!important}.wrapper .column .size-22{font-size:18px!important;line-height:26px!important}.wrapper .column .size-24{font-size:20px!important;line-height:28px!important}.wrapper .column .size-26{font-size:22px!important;line-height:31px!important}.wrapper .column .size-28{font-size:24px!important;line-height:32px!important}.wrapper .column .size-30{font-size:26px!important;line-height:34px!important}.wrapper .column .size-32{font-size:28px!important;line-height:36px!important}.wrapper .column .size-34,.wrapper .column .size-36{font-size:30px!important;line-height:38px!important}.wrapper .column .size-40{font-size:32px!important;line-height:40px!important}.wrapper .column .size-44{font-size:34px!important;line-height:43px!important}.wrapper .column .size-48{font-size:36px!important;line-height:43px!important}.wrapper .column .size-56{font-size:40px!important;line-height:47px!important}.wrapper .column .size-64{font-size:44px!important;line-height:50px!important}}body{margin:0;min-width:100%}.mso body{mso-line-height-rule:exactly}.footer .links,.footer .right td,.image,.logo{mso-line-height-rule:at-least}.no-padding .wrapper .column .column-bottom,.no-padding .wrapper .column .column-top{font-size:0;line-height:0}table{border-collapse:collapse;border-spacing:0}td{vertical-align:top}.border,.spacer{font-size:1px;line-height:1px}img{border:0;-ms-interpolation-mode:bicubic}.image{font-size:12px}strong{font-weight:700}.image,blockquote,h1,h2,h3,ol,p,ul{font-style:normal;font-weight:400}li,ol,ul{padding-left:0}blockquote{margin-left:0;margin-right:0;padding-right:0}.centered,.divider,.one-col,.three-col,.two-col{margin-left:auto;margin-right:auto}.column-bottom,.column-top{font-size:34px;line-height:34px;transition-timing-function:cubic-bezier(0,0,.2,1);transition-duration:150ms;transition-property:all}.half-padding .column .column-bottom,.half-padding .column .column-top{font-size:17px;line-height:17px}.column{text-align:left}.padded{padding-left:32px;padding-right:32px;word-break:break-word;word-wrap:break-word}.wrapper{display:table;min-width:620px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}.wrapper a{transition:opacity .2s ease-in}.one-col,.three-col,.two-col{width:600px}.btn a{border-radius:3px;display:inline-block;font-size:14px;font-weight:700;line-height:24px;padding:13px 35px 12px;text-align:center;text-decoration:none!important}.two-col .btn a{font-size:12px;line-height:22px;padding:10px 28px}.three-col .btn a{font-size:11px;line-height:19px;padding:6px 18px 5px}@media only screen and (max-width:620px){.btn a{display:block!important;font-size:14px!important;line-height:24px!important;padding:13px 10px 12px!important}}.two-col .column{width:300px}.three-col .column{width:200px}.three-col .first .padded{padding-left:32px;padding-right:12px}.three-col .second .padded{padding-left:22px;padding-right:22px}.three-col .third .padded{padding-left:12px;padding-right:32px}@media only screen and (min-width:0){.wrapper{text-rendering:optimizeLegibility}}@media only screen and (max-width:620px){[class=wrapper]{min-width:320px!important;width:100%!important}[class=wrapper] .one-col,[class=wrapper] .three-col,[class=wrapper] .two-col{width:320px!important}[class=wrapper] .column,[class=wrapper] .gutter{display:block;float:left;width:320px!important}[class=wrapper] .padded{padding-left:20px!important;padding-right:20px!important}[class=wrapper] .block{display:block!important}[class=wrapper] .hide{display:none!important}[class=wrapper] .image img{height:auto!important;width:100%!important}}.footer{width:100%}.footer .inner{padding:58px 0 29px;width:600px}.footer .left td,.footer .right td{font-size:12px;line-height:22px}.footer .left td{text-align:left;width:400px}.footer .right td{max-width:200px}.footer .links{line-height:26px;margin-bottom:26px}.footer .links img{vertical-align:middle}.footer .address,.footer .campaign{margin-bottom:18px}.footer .campaign a{font-weight:700;text-decoration:none}.footer .sharing div{margin-bottom:5px}.wrapper .footer .fblike,.wrapper .footer .forwardtoafriend,.wrapper .footer .linkedinshare,.wrapper .footer .tweet{background-repeat:no-repeat;background-size:200px 56px;border-radius:2px;color:#fff;display:block;font-size:11px;font-weight:700;line-height:11px;padding:8px 11px 7px 28px;text-align:left;text-decoration:none}.wrapper .footer .fblike:hover,.wrapper .footer .forwardtoafriend:hover,.wrapper .footer .linkedinshare:hover,.wrapper .footer .tweet:hover{color:#fff!important;opacity:.8}.footer .fblike{background-image:url(https://i3.createsend1.com/static/eb/master/08-tint/imgf/fblike.png)}.footer .tweet{background-image:url(https://i4.createsend1.com/static/eb/master/08-tint/imgf/tweet.png)}.footer .linkedinshare{background-image:url(https://i5.createsend1.com/static/eb/master/08-tint/imgf/lishare.png)}.footer .forwardtoafriend{background-image:url(https://i6.createsend1.com/static/eb/master/08-tint/imgf/forward.png)}@media only screen and (-webkit-min-device-pixel-ratio:2),only screen and (min--moz-device-pixel-ratio:2),only screen and (-o-min-device-pixel-ratio:2/1),only screen and (min-device-pixel-ratio:2),only screen and (min-resolution:192dpi),only screen and (min-resolution:2dppx){.footer .fblike{background-image:url(https://i7.createsend1.com/static/eb/master/08-tint/imgf/fblike@2x.png)!important}.footer .tweet{background-image:url(https://i9.createsend1.com/static/eb/master/08-tint/imgf/tweet@2x.png)!important}.footer .linkedinshare{background-image:url(https://i10.createsend1.com/static/eb/master/08-tint/imgf/lishare@2x.png)!important}.footer .forwardtoafriend{background-image:url(https://i8.createsend1.com/static/eb/master/08-tint/imgf/forward@2x.png)!important}}@media only screen and (max-width:620px){.footer{width:320px!important}.footer td{display:none}.footer .inner,.footer .inner td{display:block;text-align:center!important;max-width:320px!important;width:320px!important}.footer .sharing{margin-bottom:40px}.footer .sharing div{display:inline-block}.footer .fblike,.footer .forwardtoafriend,.footer .linkedinshare,.footer .tweet{display:inline-block!important}}.btn,.divider,.image,.wrapper blockquote,.wrapper h1,.wrapper h2,.wrapper h3,.wrapper li,.wrapper ol,.wrapper p,.wrapper ul{margin-bottom:0;margin-top:0}.wrapper .column h1+*{margin-top:18px}.wrapper .column h2+*{margin-top:12px}.wrapper .column h3+*{margin-top:10px}.image+.contents td>:first-child,.wrapper .column blockquote+*,.wrapper .column ol+*,.wrapper .column p+*,.wrapper .column ul+*{margin-top:25px}.contents:nth-last-child(n+3) h1:last-child,.no-padding .contents:nth-last-child(n+2) h1:last-child{margin-bottom:18px}.contents:nth-last-child(n+3) h2:last-child,.no-padding .contents:nth-last-child(n+2) h2:last-child{margin-bottom:12px}.contents:nth-last-child(n+3) h3:last-child,.no-padding .contents:nth-last-child(n+2) h3:last-child{margin-bottom:10px}.contents:nth-last-child(n+3) .btn,.contents:nth-last-child(n+3) .divider,.contents:nth-last-child(n+3) .image,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn,.no-padding .contents:nth-last-child(n+2) .divider,.no-padding .contents:nth-last-child(n+2) .image,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px}.two-col .column blockquote+*,.two-col .column ol+*,.two-col .column p+*,.two-col .column ul+*,.two-col .image+.contents td>:first-child{margin-top:28px}.no-padding .two-col .contents:nth-last-child(n+2) .btn,.no-padding .two-col .contents:nth-last-child(n+2) .divider,.no-padding .two-col .contents:nth-last-child(n+2) .image,.no-padding .two-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .two-col .contents:nth-last-child(n+2) p:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ul:last-child,.two-col .contents:nth-last-child(n+3) .btn,.two-col .contents:nth-last-child(n+3) .divider,.two-col .contents:nth-last-child(n+3) .image,.two-col .contents:nth-last-child(n+3) blockquote:last-child,.two-col .contents:nth-last-child(n+3) ol:last-child,.two-col .contents:nth-last-child(n+3) p:last-child,.two-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:28px}.three-col .column blockquote+*,.three-col .column ol+*,.three-col .column p+*,.three-col .column ul+*,.three-col .image+.contents td>:first-child{margin-top:18px}.no-padding .three-col .contents:nth-last-child(n+2) .btn,.no-padding .three-col .contents:nth-last-child(n+2) .divider,.no-padding .three-col .contents:nth-last-child(n+2) .image,.no-padding .three-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .three-col .contents:nth-last-child(n+2) p:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ul:last-child,.three-col .contents:nth-last-child(n+3) .btn,.three-col .contents:nth-last-child(n+3) .divider,.three-col .contents:nth-last-child(n+3) .image,.three-col .contents:nth-last-child(n+3) blockquote:last-child,.three-col .contents:nth-last-child(n+3) ol:last-child,.three-col .contents:nth-last-child(n+3) p:last-child,.three-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:18px}.preheader{font-size:11px;line-height:17px}.preheader .title{padding:9px;text-align:left;width:50%}.preheader .webversion{padding:9px;text-align:right;width:50%}.logo div.logo-center,.one-col-feature .btn,.one-col-feature h1,.one-col-feature h2,.one-col-feature h3,.one-col-feature p{text-align:center}.separator{font-size:34px;line-height:34px}.divider{font-size:3px;line-height:3px;width:60px}.mso .divider{margin-left:238px;margin-right:238px}.mso .two-col .divider{margin-left:96px;margin-right:96px}.mso .three-col .divider{margin-left:48px;margin-right:48px}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a{text-decoration:none}.wrapper h1{font-size:36px;line-height:44px}.wrapper h2{font-size:24px;line-height:32px}.wrapper h3{font-size:14px;line-height:22px}.wrapper ol,.wrapper p,.wrapper ul{font-size:16px;line-height:25px}.mso .wrapper li{padding-left:5px!important;margin-left:10px!important}.mso .wrapper ol,.mso .wrapper ul{margin-left:20px!important}.wrapper blockquote{margin-left:0;padding-right:0;font-style:italic}.one-col-bg,.one-col-feature-bg,.three-col-bg,.two-col-bg{width:100%}.one-col,.one-col-feature,.three-col,.two-col{background-color:#fff;table-layout:fixed}.one-col ol,.one-col ul{margin-left:17px}.three-col ol,.three-col ul,.two-col ol,.two-col ul{margin-left:15px}.one-col li{padding-left:4px}.one-col blockquote{padding-left:16px}.two-col li{padding-left:3px}.two-col blockquote{padding-left:13px}.three-col li{padding-left:4px}.three-col blockquote{padding-left:13px}.one-col-feature .column{width:600px}.header,.preheader{width:100%}.one-col-feature-top{padding-top:32px}.one-col-feature-bottom{padding-bottom:32px}.one-col-feature .border{font-size:3px;line-height:3px;margin-left:32px;margin-right:32px}.one-col-feature ol{margin-left:31px}.one-col-feature ol li{padding-left:0}.one-col-feature ul{margin-left:23px}.one-col-feature ul li{padding-left:9px}.wrapper .one-col-feature blockquote{border-left:none;margin-left:0;padding-left:0}.wrapper h1,.wrapper h2{font-weight:500}.wrapper h3{font-weight:700}.header a,.preheader a{font-weight:700;letter-spacing:.01em;text-decoration:none}.two-col .first .padded{padding-left:32px;padding-right:16px}.two-col .second .padded{padding-left:16px;padding-right:32px}.logo{width:600px}.logo div{font-weight:400}.logo div.logo-center img{margin-left:auto;margin-right:auto}@media only screen and (max-width:620px){.image+.contents td>:first-child,.wrapper blockquote+*,.wrapper ol+*,.wrapper p+*,.wrapper ul+*{margin-top:25px!important}.contents:nth-last-child(n+3) .btn:last-child,.contents:nth-last-child(n+3) .divider:last-child,.contents:nth-last-child(n+3) .image:last-child,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn:last-child,.no-padding .contents:nth-last-child(n+2) .divider:last-child,.no-padding .contents:nth-last-child(n+2) .image:last-child,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px!important}[class=wrapper] .preheader .title,[class=wrapper] .second .column-top,[class=wrapper] .third .column-top{display:none}[class=wrapper] blockquote{border-left-width:5px!important;padding-left:15px!important}[class=wrapper] .preheader .webversion{text-align:center!important}[class=wrapper] .logo{width:280px!important;padding-left:10px!important;padding-right:10px!important}[class=wrapper] .logo img{max-width:280px!important;height:auto!important}[class=wrapper] h1{font-size:36px!important;line-height:44px!important}[class=wrapper] h2{font-size:24px!important;line-height:32px!important}[class=wrapper] h3{font-size:14px!important;line-height:22px!important}[class=wrapper] ol,[class=wrapper] p,[class=wrapper] ul{line-height:25px!important;font-size:16px!important}[class=wrapper] ol,[class=wrapper] ul{margin-left:17px}[class=wrapper] li{padding-left:4px}[class=wrapper] .divider{margin:0 auto 25px auto!important;width:60px}[class=wrapper] .separator{width:320px!important}[class=wrapper] .one-col-feature ol{margin-left:28px!important}[class=wrapper] .one-col-feature ol li{padding-left:0!important}[class=wrapper] .one-col-feature ul{margin-left:20px!important}[class=wrapper] .one-col-feature ul li{padding-left:8px!important}[class=wrapper] .one-col-feature blockquote{border-left:none!important;padding-left:0!important}}
                        .wrapper h1{}.wrapper h1{font-family:Avenir,sans-serif}.mso .wrapper h1{font-family:sans-serif !important}.wrapper h2{}.wrapper h2{font-family:Avenir,sans-serif}.mso .wrapper h2{font-family:sans-serif !important}.wrapper h3{}.wrapper h3{font-family:Avenir,sans-serif}.mso .wrapper h3{font-family:sans-serif !important}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{font-family:Avenir,sans-serif}.mso .wrapper p,.mso .wrapper ol,.mso .wrapper ul,.mso .wrapper .image{font-family:sans-serif !important}.wrapper .btn a{}.wrapper .btn a{font-family:Avenir,sans-serif}.mso .wrapper .btn a{font-family:sans-serif !important}.logo div{}.logo div{font-family:'PT Sans','Trebuchet MS',sans-serif}.mso .logo div{font-family:'Trebuchet MS',sans-serif
                        !important}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{font-family:Avenir,sans-serif}.mso .title,.mso .webversion,.mso .fblike,.mso .tweet,.mso .linkedinshare,.mso .forwardtoafriend,.mso .link,.mso .address,.mso .permission,.mso .campaign{font-family:sans-serif !important}body,.wrapper,.emb-editor-canvas{background-color:#c5cbd1}.mso body{background-color:#fff !important}.mso .separator,.mso .header,.mso .footer,.mso .one-col-bg,.mso .two-col-bg,.mso .three-col-bg,.mso .one-col-feature-bg{background-color:#c5cbd1}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a,.wrapper p a,.wrapper li a{color:#438fd1}.wrapper h1 a:hover,.wrapper h2 a:hover,.wrapper h3 a:hover,.wrapper p a:hover,.wrapper li a:hover{color:#2c75b5 !important}.wrapper
                        h1{color:#44596b}.wrapper h2{color:#44596b}.wrapper h3{color:#44596b}.wrapper p,.wrapper ol,.wrapper ul{color:#8e8e8e}.wrapper .image{color:#8e8e8e}.wrapper .one-col-feature h1 a,.wrapper .one-col-feature h2 a,.wrapper .one-col-feature h3 a,.wrapper .one-col-feature p a,.wrapper .one-col-feature li a{color:#438fd1}.wrapper .one-col-feature h1 a:hover,.wrapper .one-col-feature h2 a:hover,.wrapper .one-col-feature h3 a:hover,.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature li a:hover{color:#2c75b5 !important}.wrapper blockquote{border-left:5px solid #aeb5bc}.wrapper .btn a{background-color:#386994;color:#fff}.wrapper .btn a:hover{color:#fff !important}.logo div{color:#606b75}.logo div a{color:#606b75}.logo div a:hover{color:#606b75 !important}.divider{background-color:#aeb5bc}.one-col-feature .border{background-color:#aeb5bc}.preheader td,.footer .inner
                        td{color:#606b75}.wrapper .preheader a,.wrapper .footer a{color:#606b75}.wrapper .preheader a:hover,.wrapper .footer a:hover{color:#3e454b !important}.preheader .title{background-color:#bac0c6}.preheader .webversion{background-color:#b2b9c0}.emb-editor-canvas{background-color:#b7bdc4}@media (min-width:0){body{background-color:#b7bdc4}}.wrapper .footer .fblike,.wrapper .footer .tweet,.wrapper .footer .linkedinshare,.wrapper .footer .forwardtoafriend{background-color:#636669}
                        #facebox,#facebox .content{font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important}#facebox{position:absolute;top:0;left:0;z-index:100;text-align:left}#facebox .popup{position:relative;border:7px solid rgba(0,0,0,.445);-webkit-border-radius:7px;-moz-border-radius:7px;border-radius:7px;padding:0}#facebox .content{display:block;width:470px;overflow:show;padding:0;background:#fff}#facebox .content>p:first-child{margin-top:0}#facebox .content>p:last-child{margin-bottom:0}#facebox .image,#facebox .loading{text-align:center}#facebox img{border:0;margin:0}#facebox_overlay{position:fixed;top:0;left:0;height:100%;width:100%}#fblike,.fblikeContent{font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;position:relative}.facebox_hide{z-index:-100}.facebox_overlayBG{background-color:#000;z-index:99}#fblike{margin:0;padding:0;background-color:#fff;display:none}#fblike h1,h1.fb{background-color:#6d84b4!important;font-size:14px!important;color:#fff!important;padding:5px 10px!important;margin:0!important;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;letter-spacing:normal!important}.fblikeContent{border-bottom:1px solid #ccc;padding:10px;font-size:12px;height:120px !IE;min-height:80px!important;overflow:hidden;z-index:1}.fblikeContent span{height:auto!important}h2.fbCustomURL{background-color:#f2f2f2!important;border-bottom:1px solid #ccc!important;color:#999!important;font-size:12px!important;font-weight:400!important;margin:0 0 10px!important;padding:5px 10px!important;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;font-style:normal!important;line-height:1.2!important}#closeBox a,#closeBox a:hover{color:#fff!important}.fblikeContent iframe{min-height:80px!important;position:relative!important}.fblikeContent p{margin-top:0!important;margin-bottom:15px;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important}#closeBox{display:none!important;background-color:#f2f2f2;height:41px;position:relative;width:420px;padding:0;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;z-index:2}#closeBox a{text-decoration:none;font-size:11px;font-weight:700;background-color:#5d76aa;border:1px solid #2a437e;-webkit-box-shadow:inset 0 1px 0 #8a9cc2;padding:3px 6px;position:absolute;right:10px;top:10px}
                    </style>
                    <meta name='robots' content='noindex,nofollow'>
                    <meta property='og:title' content='INGRESAR CONTRASEÑA'>
                </head>
                <!--[if mso]>
                <body class='mso'>
                <![endif]-->
                <!--[if !mso]><!-->
                <body style='margin: 0;padding: 0;min-width: 100%;background-color: #f2f2f2;'>
                <!--<![endif]-->
                    <center class='wrapper' style='display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #f2f2f2;'>
                        <table class='preheader' style='border-collapse: collapse;border-spacing: 0;font-size: 11px;line-height: 17px;width: 100%;'>
                            <tbody>
                                <tr>
                                    <td class='title' style='padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: left;width: 50%;background-color: #fff;'></td>
                                    <td class='webversion' style='padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: right;width: 50%;background-color: rgba(178, 17, 23, 1);'></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class='header' style='border-collapse: collapse;border-spacing: 0;width: 100%;' align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;</td>
                                    <td class='logo emb-logo-padding-box' style='padding: 0;vertical-align: top;mso-line-height-rule: at-least;width: 600px;padding-top: 32px;padding-bottom: 20px;'>
                                        <div class='logo-center' style='font-weight: 400;font-family: &quot;PT Sans&quot;,&quot;Trebuchet MS&quot;,sans-serif;color: #606b75;text-align: center;font-size: 0px !important;line-height: 0 !important;' align='center' id='emb-email-header'>
                                            <img style='border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 100%;' src='http://camcar.mx/img/logos/logo_camcar.png' alt='' height='55'>
                                        </div>
                                    </td>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class='one-col-bg' style='border-collapse: collapse;border-spacing: 0;width: 100%;'>
                            <tbody>
                                <tr>
                                    <td style='padding: 0;vertical-align: top;' align='center'>
                                        <table class='one-col centered' style='border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;table-layout: fixed;' emb-background-style=''>
                                            <tbody>
                                                <tr>
                                                    <td class='column' style='padding: 0;vertical-align: top;text-align: left;'>
                                                        <div>
                                                            <div class='column-top'>&nbsp;</div>
                                                        </div>
                                                        <table class='contents' style='border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%;'>
                                                            <tbody>
                                                                <tr>
                                                                    <td class='padded' style='padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word;'>
                                                                        <h1 style='text-align: center;'>
                                                                            Bienvenido <br> $nameTo
                                                                        </h1>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class='contents' style='border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%;'>
                                                            <tbody>
                                                                <tr>
                                                                    <td class='padded' style='padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word;'>
                                                                        <div class='btn' style='margin-bottom: 0;margin-top: 0;text-align: center;'>
                                                                            <!--[if !mso]-->
                                                                                <a style='border-radius: 3px;display: inline-block;font-size: 14px;font-weight: 700;line-height: 24px;padding: 13px 35px 12px 35px;text-align: center;text-decoration: none !important;transition: opacity 0.2s ease-in;font-family: Avenir,sans-serif;background-color: #b21117;color: #fff;' href='http://$server/intranet/password/index.php?iur=$cryptId&m=$mailTo&nc=$nameTo' target='_blank'>
                                                                                    INGRESAR CONTRASEÑA
                                                                                </a>
                                                                            <!--[endif]-->
                                                                            <!--[if mso]>
                                                                                <v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='http://$server/intranet/password/index.php?iur=$cryptId&m=$mailTo&nc=$nameTo' style='width:178px' arcsize='7%' fillcolor='#b21117' stroke='f'>
                                                                                    <v:textbox style='mso-fit-shape-to-text:t' inset='0px,12px,0px,11px'>
                                                                                        <center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:sans-serif;font-weight:700;mso-line-height-rule:exactly;mso-text-raise:4px'>
                                                                                            INGRESAR CONTRASEÑA
                                                                                        </center>
                                                                                    </v:textbox>
                                                                                </v:roundrect>
                                                                            <![endif]-->
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class='column-bottom' style='font-size: 34px;line-height: 34px;transition-timing-function: cubic-bezier(0, 0, 0.2, 1);transition-duration: 150ms;transition-property: all;'>&nbsp;
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class='spacer' style='font-size: 1px;line-height:0px;width: 100%;'>&nbsp;
                        </div>
                        <table class='footer centered' style='border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 100%;'>
                            <tbody>
                                <tr>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;
                                    </td>
                                    <td class='inner' style='padding: 58px 0 29px 0;vertical-align: top;width: 600px;'>
                                        <table class='center' style='border-collapse: collapse;border-spacing: 0;' align='center'>
                                            <tbody>
                                                <tr>
                                                    <td style='padding: 0;vertical-align: top;color: #606b75;font-size: 12px;line-height: 22px;text-align: left;width: 400px;'>
                                                        <div class='campaign' style='font-family: Avenir,sans-serif;margin-bottom: 18px; text-align: center;'>
                                                            <span>
                                                                © 2016 Camcar Grupo Automotriz
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td style='padding: 0;vertical-align: top;color: #606b75;font-size: 12px;line-height: 22px;text-align: left;width: 400px;'>
                                                        <div class='campaign' style='font-family: Avenir,sans-serif;margin-bottom: 18px; text-align: center;'>
                                                            <span>
                                                                <a href='http://camcar.mx/'>
                                                                    camcar.mx
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </body>
            ",
            'subject' => 'Bienvenido a la Intranet de Camcar',
            'from_email' => $mailFrom,
            'from_name' => $nameFrom,
            'to' => array(
                array(
                    'email' => $mailTo,
                    'name' => $nameTo,
                    'type' => 'to'
                )
            ),
            'headers' => array(
                'Reply-To' => $mailReplay
            ),
            'important' => true,
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
            'tags' => array('new-user-register-intranet', 'Bienvenido a la Intranet de Camcar'),
            /*
            'google_analytics_domains' => array('http://camcar.mx/'),
            'google_analytics_campaign' => 'marina.reyes@camcar.mx',
            'metadata' => array('website' => 'http://camcar.mx/'),
            */
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = '';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        //echo "<pre>", print_r($result), "</pre>";
    } catch (Mandrill_Error $e) {
        //Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        //A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
}

//SEND RECOVERY

function sendRecovery($mailTo, $nameTo, $cryptId) {
    $devserverlist = array('127.0.0.1','::1','192.168.0.102','localhost');
    $server = (!in_array($_SERVER['SERVER_NAME'], $devserverlist))
        ? "camcar.mx"
        : "localhost/camcar";
    $mailReplay = 'marina.reyes@camcar.mx';
    /*
    $mailFrom = 'javier@medigraf.com.mx';
    $mailFrom = 'hevelmo060683@gmail.com';
    */
    $mailFrom = 'respuesta.segura@camcar.mx';
    $nameFrom = 'Camcar Intranet';
    try {
        $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
        $message = array(
            'html' => "
                <head>
                    <title></title>
                    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
                    <style type='text/css' media='screen'>
                        .font-sans-serif{font-family:sans-serif}.font-avenir{font-family:Avenir,sans-serif}.mso .font-avenir{font-family:sans-serif!important}.font-lato{font-family:Lato,Tahoma,sans-serif}.mso .font-lato{font-family:Tahoma,sans-serif!important}.font-cabin{font-family:Cabin,Avenir,sans-serif}.mso .font-cabin{font-family:sans-serif!important}.font-open-Sans{font-family:'Open Sans',sans-serif}.mso .font-open-Sans{font-family:sans-serif!important}.font-roboto{font-family:Roboto,Tahoma,sans-serif}.mso .font-roboto{font-family:Tahoma,sans-serif!important}.font-ubuntu{font-family:Ubuntu,sans-serif}.mso .font-ubuntu{font-family:sans-serif!important}.font-pt-sans{font-family:'PT Sans','Trebuchet MS',sans-serif}.mso .font-pt-sans{font-family:'Trebuchet MS',sans-serif!important}.font-georgia{font-family:Georgia,serif}.font-merriweather{font-family:Merriweather,Georgia,serif}.mso .font-merriweather{font-family:Georgia,serif!important}.font-bitter{font-family:Bitter,Georgia,serif}.mso .font-bitter{font-family:Georgia,serif!important}.font-pt-serif{font-family:'PT Serif',Georgia,serif}.mso .font-pt-serif{font-family:Georgia,serif!important}.font-pompiere{font-family:Pompiere,'Trebuchet MS',sans-serif}.mso .font-pompiere{font-family:'Trebuchet MS',sans-serif!important}.font-roboto-slab{font-family:'Roboto Slab',Georgia,serif}.mso .font-roboto-slab{font-family:Georgia,serif!important}
                        body,td{padding:0}.image img,.logo img{display:block}.contents,.spacer,.wrapper{width:100%}.btn a:hover,.footer .links a:hover{opacity:.8}.contents,.wrapper,table.wrapper{table-layout:fixed}@media only screen and (max-width:620px){.wrapper .column .size-8{font-size:8px!important;line-height:14px!important}.wrapper .column .size-9{font-size:9px!important;line-height:16px!important}.wrapper .column .size-10{font-size:10px!important;line-height:18px!important}.wrapper .column .size-11{font-size:11px!important;line-height:19px!important}.wrapper .column .size-12{font-size:12px!important;line-height:19px!important}.wrapper .column .size-13{font-size:13px!important;line-height:21px!important}.wrapper .column .size-14{font-size:14px!important;line-height:21px!important}.wrapper .column .size-15{font-size:15px!important;line-height:23px!important}.wrapper .column .size-16{font-size:16px!important;line-height:24px!important}.wrapper .column .size-17,.wrapper .column .size-18,.wrapper .column .size-20{font-size:17px!important;line-height:26px!important}.wrapper .column .size-22{font-size:18px!important;line-height:26px!important}.wrapper .column .size-24{font-size:20px!important;line-height:28px!important}.wrapper .column .size-26{font-size:22px!important;line-height:31px!important}.wrapper .column .size-28{font-size:24px!important;line-height:32px!important}.wrapper .column .size-30{font-size:26px!important;line-height:34px!important}.wrapper .column .size-32{font-size:28px!important;line-height:36px!important}.wrapper .column .size-34,.wrapper .column .size-36{font-size:30px!important;line-height:38px!important}.wrapper .column .size-40{font-size:32px!important;line-height:40px!important}.wrapper .column .size-44{font-size:34px!important;line-height:43px!important}.wrapper .column .size-48{font-size:36px!important;line-height:43px!important}.wrapper .column .size-56{font-size:40px!important;line-height:47px!important}.wrapper .column .size-64{font-size:44px!important;line-height:50px!important}}body{margin:0;min-width:100%}.mso body{mso-line-height-rule:exactly}.footer .links,.footer .right td,.image,.logo{mso-line-height-rule:at-least}.no-padding .wrapper .column .column-bottom,.no-padding .wrapper .column .column-top{font-size:0;line-height:0}table{border-collapse:collapse;border-spacing:0}td{vertical-align:top}.border,.spacer{font-size:1px;line-height:1px}img{border:0;-ms-interpolation-mode:bicubic}.image{font-size:12px}strong{font-weight:700}.image,blockquote,h1,h2,h3,ol,p,ul{font-style:normal;font-weight:400}li,ol,ul{padding-left:0}blockquote{margin-left:0;margin-right:0;padding-right:0}.centered,.divider,.one-col,.three-col,.two-col{margin-left:auto;margin-right:auto}.column-bottom,.column-top{font-size:34px;line-height:34px;transition-timing-function:cubic-bezier(0,0,.2,1);transition-duration:150ms;transition-property:all}.half-padding .column .column-bottom,.half-padding .column .column-top{font-size:17px;line-height:17px}.column{text-align:left}.padded{padding-left:32px;padding-right:32px;word-break:break-word;word-wrap:break-word}.wrapper{display:table;min-width:620px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}.wrapper a{transition:opacity .2s ease-in}.one-col,.three-col,.two-col{width:600px}.btn a{border-radius:3px;display:inline-block;font-size:14px;font-weight:700;line-height:24px;padding:13px 35px 12px;text-align:center;text-decoration:none!important}.two-col .btn a{font-size:12px;line-height:22px;padding:10px 28px}.three-col .btn a{font-size:11px;line-height:19px;padding:6px 18px 5px}@media only screen and (max-width:620px){.btn a{display:block!important;font-size:14px!important;line-height:24px!important;padding:13px 10px 12px!important}}.two-col .column{width:300px}.three-col .column{width:200px}.three-col .first .padded{padding-left:32px;padding-right:12px}.three-col .second .padded{padding-left:22px;padding-right:22px}.three-col .third .padded{padding-left:12px;padding-right:32px}@media only screen and (min-width:0){.wrapper{text-rendering:optimizeLegibility}}@media only screen and (max-width:620px){[class=wrapper]{min-width:320px!important;width:100%!important}[class=wrapper] .one-col,[class=wrapper] .three-col,[class=wrapper] .two-col{width:320px!important}[class=wrapper] .column,[class=wrapper] .gutter{display:block;float:left;width:320px!important}[class=wrapper] .padded{padding-left:20px!important;padding-right:20px!important}[class=wrapper] .block{display:block!important}[class=wrapper] .hide{display:none!important}[class=wrapper] .image img{height:auto!important;width:100%!important}}.footer{width:100%}.footer .inner{padding:58px 0 29px;width:600px}.footer .left td,.footer .right td{font-size:12px;line-height:22px}.footer .left td{text-align:left;width:400px}.footer .right td{max-width:200px}.footer .links{line-height:26px;margin-bottom:26px}.footer .links img{vertical-align:middle}.footer .address,.footer .campaign{margin-bottom:18px}.footer .campaign a{font-weight:700;text-decoration:none}.footer .sharing div{margin-bottom:5px}.wrapper .footer .fblike,.wrapper .footer .forwardtoafriend,.wrapper .footer .linkedinshare,.wrapper .footer .tweet{background-repeat:no-repeat;background-size:200px 56px;border-radius:2px;color:#fff;display:block;font-size:11px;font-weight:700;line-height:11px;padding:8px 11px 7px 28px;text-align:left;text-decoration:none}.wrapper .footer .fblike:hover,.wrapper .footer .forwardtoafriend:hover,.wrapper .footer .linkedinshare:hover,.wrapper .footer .tweet:hover{color:#fff!important;opacity:.8}.footer .fblike{background-image:url(https://i3.createsend1.com/static/eb/master/08-tint/imgf/fblike.png)}.footer .tweet{background-image:url(https://i4.createsend1.com/static/eb/master/08-tint/imgf/tweet.png)}.footer .linkedinshare{background-image:url(https://i5.createsend1.com/static/eb/master/08-tint/imgf/lishare.png)}.footer .forwardtoafriend{background-image:url(https://i6.createsend1.com/static/eb/master/08-tint/imgf/forward.png)}@media only screen and (-webkit-min-device-pixel-ratio:2),only screen and (min--moz-device-pixel-ratio:2),only screen and (-o-min-device-pixel-ratio:2/1),only screen and (min-device-pixel-ratio:2),only screen and (min-resolution:192dpi),only screen and (min-resolution:2dppx){.footer .fblike{background-image:url(https://i7.createsend1.com/static/eb/master/08-tint/imgf/fblike@2x.png)!important}.footer .tweet{background-image:url(https://i9.createsend1.com/static/eb/master/08-tint/imgf/tweet@2x.png)!important}.footer .linkedinshare{background-image:url(https://i10.createsend1.com/static/eb/master/08-tint/imgf/lishare@2x.png)!important}.footer .forwardtoafriend{background-image:url(https://i8.createsend1.com/static/eb/master/08-tint/imgf/forward@2x.png)!important}}@media only screen and (max-width:620px){.footer{width:320px!important}.footer td{display:none}.footer .inner,.footer .inner td{display:block;text-align:center!important;max-width:320px!important;width:320px!important}.footer .sharing{margin-bottom:40px}.footer .sharing div{display:inline-block}.footer .fblike,.footer .forwardtoafriend,.footer .linkedinshare,.footer .tweet{display:inline-block!important}}.btn,.divider,.image,.wrapper blockquote,.wrapper h1,.wrapper h2,.wrapper h3,.wrapper li,.wrapper ol,.wrapper p,.wrapper ul{margin-bottom:0;margin-top:0}.wrapper .column h1+*{margin-top:18px}.wrapper .column h2+*{margin-top:12px}.wrapper .column h3+*{margin-top:10px}.image+.contents td>:first-child,.wrapper .column blockquote+*,.wrapper .column ol+*,.wrapper .column p+*,.wrapper .column ul+*{margin-top:25px}.contents:nth-last-child(n+3) h1:last-child,.no-padding .contents:nth-last-child(n+2) h1:last-child{margin-bottom:18px}.contents:nth-last-child(n+3) h2:last-child,.no-padding .contents:nth-last-child(n+2) h2:last-child{margin-bottom:12px}.contents:nth-last-child(n+3) h3:last-child,.no-padding .contents:nth-last-child(n+2) h3:last-child{margin-bottom:10px}.contents:nth-last-child(n+3) .btn,.contents:nth-last-child(n+3) .divider,.contents:nth-last-child(n+3) .image,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn,.no-padding .contents:nth-last-child(n+2) .divider,.no-padding .contents:nth-last-child(n+2) .image,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px}.two-col .column blockquote+*,.two-col .column ol+*,.two-col .column p+*,.two-col .column ul+*,.two-col .image+.contents td>:first-child{margin-top:28px}.no-padding .two-col .contents:nth-last-child(n+2) .btn,.no-padding .two-col .contents:nth-last-child(n+2) .divider,.no-padding .two-col .contents:nth-last-child(n+2) .image,.no-padding .two-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .two-col .contents:nth-last-child(n+2) p:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ul:last-child,.two-col .contents:nth-last-child(n+3) .btn,.two-col .contents:nth-last-child(n+3) .divider,.two-col .contents:nth-last-child(n+3) .image,.two-col .contents:nth-last-child(n+3) blockquote:last-child,.two-col .contents:nth-last-child(n+3) ol:last-child,.two-col .contents:nth-last-child(n+3) p:last-child,.two-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:28px}.three-col .column blockquote+*,.three-col .column ol+*,.three-col .column p+*,.three-col .column ul+*,.three-col .image+.contents td>:first-child{margin-top:18px}.no-padding .three-col .contents:nth-last-child(n+2) .btn,.no-padding .three-col .contents:nth-last-child(n+2) .divider,.no-padding .three-col .contents:nth-last-child(n+2) .image,.no-padding .three-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .three-col .contents:nth-last-child(n+2) p:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ul:last-child,.three-col .contents:nth-last-child(n+3) .btn,.three-col .contents:nth-last-child(n+3) .divider,.three-col .contents:nth-last-child(n+3) .image,.three-col .contents:nth-last-child(n+3) blockquote:last-child,.three-col .contents:nth-last-child(n+3) ol:last-child,.three-col .contents:nth-last-child(n+3) p:last-child,.three-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:18px}.preheader{font-size:11px;line-height:17px}.preheader .title{padding:9px;text-align:left;width:50%}.preheader .webversion{padding:9px;text-align:right;width:50%}.logo div.logo-center,.one-col-feature .btn,.one-col-feature h1,.one-col-feature h2,.one-col-feature h3,.one-col-feature p{text-align:center}.separator{font-size:34px;line-height:34px}.divider{font-size:3px;line-height:3px;width:60px}.mso .divider{margin-left:238px;margin-right:238px}.mso .two-col .divider{margin-left:96px;margin-right:96px}.mso .three-col .divider{margin-left:48px;margin-right:48px}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a{text-decoration:none}.wrapper h1{font-size:36px;line-height:44px}.wrapper h2{font-size:24px;line-height:32px}.wrapper h3{font-size:14px;line-height:22px}.wrapper ol,.wrapper p,.wrapper ul{font-size:16px;line-height:25px}.mso .wrapper li{padding-left:5px!important;margin-left:10px!important}.mso .wrapper ol,.mso .wrapper ul{margin-left:20px!important}.wrapper blockquote{margin-left:0;padding-right:0;font-style:italic}.one-col-bg,.one-col-feature-bg,.three-col-bg,.two-col-bg{width:100%}.one-col,.one-col-feature,.three-col,.two-col{background-color:#fff;table-layout:fixed}.one-col ol,.one-col ul{margin-left:17px}.three-col ol,.three-col ul,.two-col ol,.two-col ul{margin-left:15px}.one-col li{padding-left:4px}.one-col blockquote{padding-left:16px}.two-col li{padding-left:3px}.two-col blockquote{padding-left:13px}.three-col li{padding-left:4px}.three-col blockquote{padding-left:13px}.one-col-feature .column{width:600px}.header,.preheader{width:100%}.one-col-feature-top{padding-top:32px}.one-col-feature-bottom{padding-bottom:32px}.one-col-feature .border{font-size:3px;line-height:3px;margin-left:32px;margin-right:32px}.one-col-feature ol{margin-left:31px}.one-col-feature ol li{padding-left:0}.one-col-feature ul{margin-left:23px}.one-col-feature ul li{padding-left:9px}.wrapper .one-col-feature blockquote{border-left:none;margin-left:0;padding-left:0}.wrapper h1,.wrapper h2{font-weight:500}.wrapper h3{font-weight:700}.header a,.preheader a{font-weight:700;letter-spacing:.01em;text-decoration:none}.two-col .first .padded{padding-left:32px;padding-right:16px}.two-col .second .padded{padding-left:16px;padding-right:32px}.logo{width:600px}.logo div{font-weight:400}.logo div.logo-center img{margin-left:auto;margin-right:auto}@media only screen and (max-width:620px){.image+.contents td>:first-child,.wrapper blockquote+*,.wrapper ol+*,.wrapper p+*,.wrapper ul+*{margin-top:25px!important}.contents:nth-last-child(n+3) .btn:last-child,.contents:nth-last-child(n+3) .divider:last-child,.contents:nth-last-child(n+3) .image:last-child,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn:last-child,.no-padding .contents:nth-last-child(n+2) .divider:last-child,.no-padding .contents:nth-last-child(n+2) .image:last-child,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px!important}[class=wrapper] .preheader .title,[class=wrapper] .second .column-top,[class=wrapper] .third .column-top{display:none}[class=wrapper] blockquote{border-left-width:5px!important;padding-left:15px!important}[class=wrapper] .preheader .webversion{text-align:center!important}[class=wrapper] .logo{width:280px!important;padding-left:10px!important;padding-right:10px!important}[class=wrapper] .logo img{max-width:280px!important;height:auto!important}[class=wrapper] h1{font-size:36px!important;line-height:44px!important}[class=wrapper] h2{font-size:24px!important;line-height:32px!important}[class=wrapper] h3{font-size:14px!important;line-height:22px!important}[class=wrapper] ol,[class=wrapper] p,[class=wrapper] ul{line-height:25px!important;font-size:16px!important}[class=wrapper] ol,[class=wrapper] ul{margin-left:17px}[class=wrapper] li{padding-left:4px}[class=wrapper] .divider{margin:0 auto 25px auto!important;width:60px}[class=wrapper] .separator{width:320px!important}[class=wrapper] .one-col-feature ol{margin-left:28px!important}[class=wrapper] .one-col-feature ol li{padding-left:0!important}[class=wrapper] .one-col-feature ul{margin-left:20px!important}[class=wrapper] .one-col-feature ul li{padding-left:8px!important}[class=wrapper] .one-col-feature blockquote{border-left:none!important;padding-left:0!important}}
                        .wrapper h1{}.wrapper h1{font-family:Avenir,sans-serif}.mso .wrapper h1{font-family:sans-serif !important}.wrapper h2{}.wrapper h2{font-family:Avenir,sans-serif}.mso .wrapper h2{font-family:sans-serif !important}.wrapper h3{}.wrapper h3{font-family:Avenir,sans-serif}.mso .wrapper h3{font-family:sans-serif !important}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{font-family:Avenir,sans-serif}.mso .wrapper p,.mso .wrapper ol,.mso .wrapper ul,.mso .wrapper .image{font-family:sans-serif !important}.wrapper .btn a{}.wrapper .btn a{font-family:Avenir,sans-serif}.mso .wrapper .btn a{font-family:sans-serif !important}.logo div{}.logo div{font-family:'PT Sans','Trebuchet MS',sans-serif}.mso .logo div{font-family:'Trebuchet MS',sans-serif
                        !important}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{font-family:Avenir,sans-serif}.mso .title,.mso .webversion,.mso .fblike,.mso .tweet,.mso .linkedinshare,.mso .forwardtoafriend,.mso .link,.mso .address,.mso .permission,.mso .campaign{font-family:sans-serif !important}body,.wrapper,.emb-editor-canvas{background-color:#c5cbd1}.mso body{background-color:#fff !important}.mso .separator,.mso .header,.mso .footer,.mso .one-col-bg,.mso .two-col-bg,.mso .three-col-bg,.mso .one-col-feature-bg{background-color:#c5cbd1}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a,.wrapper p a,.wrapper li a{color:#438fd1}.wrapper h1 a:hover,.wrapper h2 a:hover,.wrapper h3 a:hover,.wrapper p a:hover,.wrapper li a:hover{color:#2c75b5 !important}.wrapper
                        h1{color:#44596b}.wrapper h2{color:#44596b}.wrapper h3{color:#44596b}.wrapper p,.wrapper ol,.wrapper ul{color:#8e8e8e}.wrapper .image{color:#8e8e8e}.wrapper .one-col-feature h1 a,.wrapper .one-col-feature h2 a,.wrapper .one-col-feature h3 a,.wrapper .one-col-feature p a,.wrapper .one-col-feature li a{color:#438fd1}.wrapper .one-col-feature h1 a:hover,.wrapper .one-col-feature h2 a:hover,.wrapper .one-col-feature h3 a:hover,.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature li a:hover{color:#2c75b5 !important}.wrapper blockquote{border-left:5px solid #aeb5bc}.wrapper .btn a{background-color:#386994;color:#fff}.wrapper .btn a:hover{color:#fff !important}.logo div{color:#606b75}.logo div a{color:#606b75}.logo div a:hover{color:#606b75 !important}.divider{background-color:#aeb5bc}.one-col-feature .border{background-color:#aeb5bc}.preheader td,.footer .inner
                        td{color:#606b75}.wrapper .preheader a,.wrapper .footer a{color:#606b75}.wrapper .preheader a:hover,.wrapper .footer a:hover{color:#3e454b !important}.preheader .title{background-color:#bac0c6}.preheader .webversion{background-color:#b2b9c0}.emb-editor-canvas{background-color:#b7bdc4}@media (min-width:0){body{background-color:#b7bdc4}}.wrapper .footer .fblike,.wrapper .footer .tweet,.wrapper .footer .linkedinshare,.wrapper .footer .forwardtoafriend{background-color:#636669}
                        #facebox,#facebox .content{font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important}#facebox{position:absolute;top:0;left:0;z-index:100;text-align:left}#facebox .popup{position:relative;border:7px solid rgba(0,0,0,.445);-webkit-border-radius:7px;-moz-border-radius:7px;border-radius:7px;padding:0}#facebox .content{display:block;width:470px;overflow:show;padding:0;background:#fff}#facebox .content>p:first-child{margin-top:0}#facebox .content>p:last-child{margin-bottom:0}#facebox .image,#facebox .loading{text-align:center}#facebox img{border:0;margin:0}#facebox_overlay{position:fixed;top:0;left:0;height:100%;width:100%}#fblike,.fblikeContent{font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;position:relative}.facebox_hide{z-index:-100}.facebox_overlayBG{background-color:#000;z-index:99}#fblike{margin:0;padding:0;background-color:#fff;display:none}#fblike h1,h1.fb{background-color:#6d84b4!important;font-size:14px!important;color:#fff!important;padding:5px 10px!important;margin:0!important;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;letter-spacing:normal!important}.fblikeContent{border-bottom:1px solid #ccc;padding:10px;font-size:12px;height:120px !IE;min-height:80px!important;overflow:hidden;z-index:1}.fblikeContent span{height:auto!important}h2.fbCustomURL{background-color:#f2f2f2!important;border-bottom:1px solid #ccc!important;color:#999!important;font-size:12px!important;font-weight:400!important;margin:0 0 10px!important;padding:5px 10px!important;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;font-style:normal!important;line-height:1.2!important}#closeBox a,#closeBox a:hover{color:#fff!important}.fblikeContent iframe{min-height:80px!important;position:relative!important}.fblikeContent p{margin-top:0!important;margin-bottom:15px;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important}#closeBox{display:none!important;background-color:#f2f2f2;height:41px;position:relative;width:420px;padding:0;font-family:'lucida grande',tahoma,verdana,arial,sans-serif!important;z-index:2}#closeBox a{text-decoration:none;font-size:11px;font-weight:700;background-color:#5d76aa;border:1px solid #2a437e;-webkit-box-shadow:inset 0 1px 0 #8a9cc2;padding:3px 6px;position:absolute;right:10px;top:10px}
                    </style>
                    <meta name='robots' content='noindex,nofollow'>
                    <meta property='og:title' content='INGRESAR CONTRASEÑA'>
                </head>
                <!--[if mso]>
                <body class='mso'>
                <![endif]-->
                <!--[if !mso]><!-->
                <body style='margin: 0;padding: 0;min-width: 100%;background-color: #f2f2f2;'>
                <!--<![endif]-->
                    <center class='wrapper' style='display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #f2f2f2;'>
                        <table class='preheader' style='border-collapse: collapse;border-spacing: 0;font-size: 11px;line-height: 17px;width: 100%;'>
                            <tbody>
                                <tr>
                                    <td class='title' style='padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: left;width: 50%;background-color: #fff;'></td>
                                    <td class='webversion' style='padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: right;width: 50%;background-color: rgba(178, 17, 23, 1);'></td>
                                </tr>
                            </tbody>
                        </table>
                        <table class='header' style='border-collapse: collapse;border-spacing: 0;width: 100%;' align='center'>
                            <tbody>
                                <tr>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;</td>
                                    <td class='logo emb-logo-padding-box' style='padding: 0;vertical-align: top;mso-line-height-rule: at-least;width: 600px;padding-top: 32px;padding-bottom: 20px;'>
                                        <div class='logo-center' style='font-weight: 400;font-family: &quot;PT Sans&quot;,&quot;Trebuchet MS&quot;,sans-serif;color: #606b75;text-align: center;font-size: 0px !important;line-height: 0 !important;' align='center' id='emb-email-header'>
                                            <img style='border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 100%;' src='http://camcar.mx/img/logos/logo_camcar.png' alt='' height='55'>
                                        </div>
                                    </td>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class='one-col-bg' style='border-collapse: collapse;border-spacing: 0;width: 100%;'>
                            <tbody>
                                <tr>
                                    <td style='padding: 0;vertical-align: top;' align='center'>
                                        <table class='one-col centered' style='border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;table-layout: fixed;' emb-background-style=''>
                                            <tbody>
                                                <tr>
                                                    <td class='column' style='padding: 0;vertical-align: top;text-align: left;'>
                                                        <div>
                                                            <div class='column-top'>&nbsp;</div>
                                                        </div>
                                                        <table class='contents' style='border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%;'>
                                                            <tbody>
                                                                <tr>
                                                                    <td class='padded' style='padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word;'>
                                                                        <h1 style='text-align: center;'>
                                                                            Recuperación de contraseña <br> $nameTo
                                                                        </h1>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class='contents' style='border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%;'>
                                                            <tbody>
                                                                <tr>
                                                                    <td class='padded' style='padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word;'>
                                                                        <div class='btn' style='margin-bottom: 0;margin-top: 0;text-align: center;'>
                                                                            <!--[if !mso]-->
                                                                                <a style='border-radius: 3px;display: inline-block;font-size: 14px;font-weight: 700;line-height: 24px;padding: 13px 35px 12px 35px;text-align: center;text-decoration: none !important;transition: opacity 0.2s ease-in;font-family: Avenir,sans-serif;background-color: #b21117;color: #fff;' href='http://$server/intranet/recovery_password/index.php?iur=$cryptId&m=$mailTo&nc=$nameTo' target='_blank'>
                                                                                    CREAR NUEVA CONTRASEÑA
                                                                                </a>
                                                                            <!--[endif]-->
                                                                            <!--[if mso]>
                                                                                <v:roundrect xmlns:v='urn:schemas-microsoft-com:vml' href='http://$server/intranet/recovery_password/index.php?iur=$cryptId&m=$mailTo&nc=$nameTo' style='width:178px' arcsize='7%' fillcolor='#b21117' stroke='f'>
                                                                                    <v:textbox style='mso-fit-shape-to-text:t' inset='0px,12px,0px,11px'>
                                                                                        <center style='font-size:14px;line-height:24px;color:#FFFFFF;font-family:sans-serif;font-weight:700;mso-line-height-rule:exactly;mso-text-raise:4px'>
                                                                                            CREAR NUEVA CONTRASEÑA
                                                                                        </center>
                                                                                    </v:textbox>
                                                                                </v:roundrect>
                                                                            <![endif]-->
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <div class='column-bottom' style='font-size: 34px;line-height: 34px;transition-timing-function: cubic-bezier(0, 0, 0.2, 1);transition-duration: 150ms;transition-property: all;'>&nbsp;
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class='spacer' style='font-size: 1px;line-height:0px;width: 100%;'>&nbsp;
                        </div>
                        <table class='footer centered' style='border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 100%;'>
                            <tbody>
                                <tr>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;
                                    </td>
                                    <td class='inner' style='padding: 58px 0 29px 0;vertical-align: top;width: 600px;'>
                                        <table class='center' style='border-collapse: collapse;border-spacing: 0;' align='center'>
                                            <tbody>
                                                <tr>
                                                    <td style='padding: 0;vertical-align: top;color: #606b75;font-size: 12px;line-height: 22px;text-align: left;width: 400px;'>
                                                        <div class='campaign' style='font-family: Avenir,sans-serif;margin-bottom: 18px; text-align: center;'>
                                                            <span>
                                                                © 2016 Camcar Grupo Automotriz
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td style='padding: 0;vertical-align: top;color: #606b75;font-size: 12px;line-height: 22px;text-align: left;width: 400px;'>
                                                        <div class='campaign' style='font-family: Avenir,sans-serif;margin-bottom: 18px; text-align: center;'>
                                                            <span>
                                                                <a href='http://camcar.mx/'>
                                                                    camcar.mx
                                                                </a>
                                                            </span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td style='padding: 0;vertical-align: top;'>&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                </body>
            ",
            'subject' => 'Recuperación de contraseña',
            'from_email' => $mailFrom,
            'from_name' => $nameFrom,
            'to' => array(
                array(
                    'email' => $mailTo,
                    'name' => $nameTo,
                    'type' => 'to'
                )
            ),
            'headers' => array(
                'Reply-To' => $mailReplay
            ),
            'important' => true,
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
            'tags' => array('new-user-register-intranet', 'Recuparación de Contraseña'),
            /*
            'google_analytics_domains' => array('http://camcar.mx/'),
            'google_analytics_campaign' => 'marina.reyes@camcar.mx',
            'metadata' => array('website' => 'http://camcar.mx/'),
            */
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = '';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        //echo "<pre>", print_r($result), "</pre>";
    } catch (Mandrill_Error $e) {
        //Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
        //A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
}

//SEND CONGRATULATIONS BIRTHDAY

function send_birthday_message($cum_send_message, $cum_send_from, $cum_send_to, $cum_send_email, $cum_send_email_to, $cum_send_date) {
    try {
        $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
        $message = array(
            'html' => '
                <html>
                    <head>
                        <title></title>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                        <style type="text/css" media="screen">
                            .font-sans-serif{font-family:sans-serif}.font-avenir{font-family:Avenir,sans-serif}.mso .font-avenir{font-family:sans-serif!important}.font-lato{font-family:Lato,Tahoma,sans-serif}.mso .font-lato{font-family:Tahoma,sans-serif!important}.font-cabin{font-family:Cabin,Avenir,sans-serif}.mso .font-cabin{font-family:sans-serif!important}.font-open-Sans{font-family:"Open Sans",sans-serif}.mso .font-open-Sans{font-family:sans-serif!important}.font-roboto{font-family:Roboto,Tahoma,sans-serif}.mso .font-roboto{font-family:Tahoma,sans-serif!important}.font-ubuntu{font-family:Ubuntu,sans-serif}.mso .font-ubuntu{font-family:sans-serif!important}.font-pt-sans{font-family:"PT Sans","Trebuchet MS",sans-serif}.mso .font-pt-sans{font-family:"Trebuchet MS",sans-serif!important}.font-georgia{font-family:Georgia,serif}.font-merriweather{font-family:Merriweather,Georgia,serif}.mso .font-merriweather{font-family:Georgia,serif!important}.font-bitter{font-family:Bitter,Georgia,serif}.mso .font-bitter{font-family:Georgia,serif!important}.font-pt-serif{font-family:"PT Serif",Georgia,serif}.mso .font-pt-serif{font-family:Georgia,serif!important}.font-pompiere{font-family:Pompiere,"Trebuchet MS",sans-serif}.mso .font-pompiere{font-family:"Trebuchet MS",sans-serif!important}.font-roboto-slab{font-family:"Roboto Slab",Georgia,serif}.mso .font-roboto-slab{font-family:Georgia,serif!important}
                            body,td{padding:0}.image img,.logo img{display:block}.contents,.spacer,.wrapper{width:100%}.btn a:hover,.footer .links a:hover{opacity:.8}.contents,.wrapper,table.wrapper{table-layout:fixed}@media only screen and (max-width:620px){.wrapper .column .size-8{font-size:8px!important;line-height:14px!important}.wrapper .column .size-9{font-size:9px!important;line-height:16px!important}.wrapper .column .size-10{font-size:10px!important;line-height:18px!important}.wrapper .column .size-11{font-size:11px!important;line-height:19px!important}.wrapper .column .size-12{font-size:12px!important;line-height:19px!important}.wrapper .column .size-13{font-size:13px!important;line-height:21px!important}.wrapper .column .size-14{font-size:14px!important;line-height:21px!important}.wrapper .column .size-15{font-size:15px!important;line-height:23px!important}.wrapper .column .size-16{font-size:16px!important;line-height:24px!important}.wrapper .column .size-17,.wrapper .column .size-18,.wrapper .column .size-20{font-size:17px!important;line-height:26px!important}.wrapper .column .size-22{font-size:18px!important;line-height:26px!important}.wrapper .column .size-24{font-size:20px!important;line-height:28px!important}.wrapper .column .size-26{font-size:22px!important;line-height:31px!important}.wrapper .column .size-28{font-size:24px!important;line-height:32px!important}.wrapper .column .size-30{font-size:26px!important;line-height:34px!important}.wrapper .column .size-32{font-size:28px!important;line-height:36px!important}.wrapper .column .size-34,.wrapper .column .size-36{font-size:30px!important;line-height:38px!important}.wrapper .column .size-40{font-size:32px!important;line-height:40px!important}.wrapper .column .size-44{font-size:34px!important;line-height:43px!important}.wrapper .column .size-48{font-size:36px!important;line-height:43px!important}.wrapper .column .size-56{font-size:40px!important;line-height:47px!important}.wrapper .column .size-64{font-size:44px!important;line-height:50px!important}}body{margin:0;min-width:100%}.mso body{mso-line-height-rule:exactly}.footer .links,.footer .right td,.image,.logo{mso-line-height-rule:at-least}.no-padding .wrapper .column .column-bottom,.no-padding .wrapper .column .column-top{font-size:0;line-height:0}table{border-collapse:collapse;border-spacing:0}td{vertical-align:top}.border,.spacer{font-size:1px;line-height:1px}img{border:0;-ms-interpolation-mode:bicubic}.image{font-size:12px}strong{font-weight:700}.image,blockquote,h1,h2,h3,ol,p,ul{font-style:normal;font-weight:400}li,ol,ul{padding-left:0}blockquote{margin-left:0;margin-right:0;padding-right:0}.centered,.divider,.one-col,.three-col,.two-col{margin-left:auto;margin-right:auto}.column-bottom,.column-top{font-size:34px;line-height:34px;transition-timing-function:cubic-bezier(0,0,.2,1);transition-duration:150ms;transition-property:all}.half-padding .column .column-bottom,.half-padding .column .column-top{font-size:17px;line-height:17px}.column{text-align:left}.padded{padding-left:32px;padding-right:32px;word-break:break-word;word-wrap:break-word}.wrapper{display:table;min-width:620px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}.wrapper a{transition:opacity .2s ease-in}.one-col,.three-col,.two-col{width:600px}.btn a{border-radius:3px;display:inline-block;font-size:14px;font-weight:700;line-height:24px;padding:13px 35px 12px;text-align:center;text-decoration:none!important}.two-col .btn a{font-size:12px;line-height:22px;padding:10px 28px}.three-col .btn a{font-size:11px;line-height:19px;padding:6px 18px 5px}@media only screen and (max-width:620px){.btn a{display:block!important;font-size:14px!important;line-height:24px!important;padding:13px 10px 12px!important}}.two-col .column{width:300px}.three-col .column{width:200px}.three-col .first .padded{padding-left:32px;padding-right:12px}.three-col .second .padded{padding-left:22px;padding-right:22px}.three-col .third .padded{padding-left:12px;padding-right:32px}@media only screen and (min-width:0){.wrapper{text-rendering:optimizeLegibility}}@media only screen and (max-width:620px){[class=wrapper]{min-width:320px!important;width:100%!important}[class=wrapper] .one-col,[class=wrapper] .three-col,[class=wrapper] .two-col{width:320px!important}[class=wrapper] .column,[class=wrapper] .gutter{display:block;float:left;width:320px!important}[class=wrapper] .padded{padding-left:20px!important;padding-right:20px!important}[class=wrapper] .block{display:block!important}[class=wrapper] .hide{display:none!important}[class=wrapper] .image img{height:auto!important;width:100%!important}}.footer{width:100%}.footer .inner{padding:58px 0 29px;width:600px}.footer .left td,.footer .right td{font-size:12px;line-height:22px}.footer .left td{text-align:left;width:400px}.footer .right td{max-width:200px}.footer .links{line-height:26px;margin-bottom:26px}.footer .links img{vertical-align:middle}.footer .address,.footer .campaign{margin-bottom:18px}.footer .campaign a{font-weight:700;text-decoration:none}.footer .sharing div{margin-bottom:5px}.wrapper .footer .fblike,.wrapper .footer .forwardtoafriend,.wrapper .footer .linkedinshare,.wrapper .footer .tweet{background-repeat:no-repeat;background-size:200px 56px;border-radius:2px;color:#fff;display:block;font-size:11px;font-weight:700;line-height:11px;padding:8px 11px 7px 28px;text-align:left;text-decoration:none}.wrapper .footer .fblike:hover,.wrapper .footer .forwardtoafriend:hover,.wrapper .footer .linkedinshare:hover,.wrapper .footer .tweet:hover{color:#fff!important;opacity:.8}.footer .fblike{background-image:url(https://i3.createsend1.com/static/eb/master/08-tint/imgf/fblike.png)}.footer .tweet{background-image:url(https://i4.createsend1.com/static/eb/master/08-tint/imgf/tweet.png)}.footer .linkedinshare{background-image:url(https://i5.createsend1.com/static/eb/master/08-tint/imgf/lishare.png)}.footer .forwardtoafriend{background-image:url(https://i6.createsend1.com/static/eb/master/08-tint/imgf/forward.png)}@media only screen and (-webkit-min-device-pixel-ratio:2),only screen and (min--moz-device-pixel-ratio:2),only screen and (-o-min-device-pixel-ratio:2/1),only screen and (min-device-pixel-ratio:2),only screen and (min-resolution:192dpi),only screen and (min-resolution:2dppx){.footer .fblike{background-image:url(https://i7.createsend1.com/static/eb/master/08-tint/imgf/fblike@2x.png)!important}.footer .tweet{background-image:url(https://i9.createsend1.com/static/eb/master/08-tint/imgf/tweet@2x.png)!important}.footer .linkedinshare{background-image:url(https://i10.createsend1.com/static/eb/master/08-tint/imgf/lishare@2x.png)!important}.footer .forwardtoafriend{background-image:url(https://i8.createsend1.com/static/eb/master/08-tint/imgf/forward@2x.png)!important}}@media only screen and (max-width:620px){.footer{width:320px!important}.footer td{display:none}.footer .inner,.footer .inner td{display:block;text-align:center!important;max-width:320px!important;width:320px!important}.footer .sharing{margin-bottom:40px}.footer .sharing div{display:inline-block}.footer .fblike,.footer .forwardtoafriend,.footer .linkedinshare,.footer .tweet{display:inline-block!important}}.btn,.divider,.image,.wrapper blockquote,.wrapper h1,.wrapper h2,.wrapper h3,.wrapper li,.wrapper ol,.wrapper p,.wrapper ul{margin-bottom:0;margin-top:0}.wrapper .column h1+*{margin-top:18px}.wrapper .column h2+*{margin-top:12px}.wrapper .column h3+*{margin-top:10px}.image+.contents td>:first-child,.wrapper .column blockquote+*,.wrapper .column ol+*,.wrapper .column p+*,.wrapper .column ul+*{margin-top:25px}.contents:nth-last-child(n+3) h1:last-child,.no-padding .contents:nth-last-child(n+2) h1:last-child{margin-bottom:18px}.contents:nth-last-child(n+3) h2:last-child,.no-padding .contents:nth-last-child(n+2) h2:last-child{margin-bottom:12px}.contents:nth-last-child(n+3) h3:last-child,.no-padding .contents:nth-last-child(n+2) h3:last-child{margin-bottom:10px}.contents:nth-last-child(n+3) .btn,.contents:nth-last-child(n+3) .divider,.contents:nth-last-child(n+3) .image,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn,.no-padding .contents:nth-last-child(n+2) .divider,.no-padding .contents:nth-last-child(n+2) .image,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px}.two-col .column blockquote+*,.two-col .column ol+*,.two-col .column p+*,.two-col .column ul+*,.two-col .image+.contents td>:first-child{margin-top:28px}.no-padding .two-col .contents:nth-last-child(n+2) .btn,.no-padding .two-col .contents:nth-last-child(n+2) .divider,.no-padding .two-col .contents:nth-last-child(n+2) .image,.no-padding .two-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .two-col .contents:nth-last-child(n+2) p:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ul:last-child,.two-col .contents:nth-last-child(n+3) .btn,.two-col .contents:nth-last-child(n+3) .divider,.two-col .contents:nth-last-child(n+3) .image,.two-col .contents:nth-last-child(n+3) blockquote:last-child,.two-col .contents:nth-last-child(n+3) ol:last-child,.two-col .contents:nth-last-child(n+3) p:last-child,.two-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:28px}.three-col .column blockquote+*,.three-col .column ol+*,.three-col .column p+*,.three-col .column ul+*,.three-col .image+.contents td>:first-child{margin-top:18px}.no-padding .three-col .contents:nth-last-child(n+2) .btn,.no-padding .three-col .contents:nth-last-child(n+2) .divider,.no-padding .three-col .contents:nth-last-child(n+2) .image,.no-padding .three-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .three-col .contents:nth-last-child(n+2) p:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ul:last-child,.three-col .contents:nth-last-child(n+3) .btn,.three-col .contents:nth-last-child(n+3) .divider,.three-col .contents:nth-last-child(n+3) .image,.three-col .contents:nth-last-child(n+3) blockquote:last-child,.three-col .contents:nth-last-child(n+3) ol:last-child,.three-col .contents:nth-last-child(n+3) p:last-child,.three-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:18px}.preheader{font-size:11px;line-height:17px}.preheader .title{padding:9px;text-align:left;width:50%}.preheader .webversion{padding:9px;text-align:right;width:50%}.logo div.logo-center,.one-col-feature .btn,.one-col-feature h1,.one-col-feature h2,.one-col-feature h3,.one-col-feature p{text-align:center}.separator{font-size:34px;line-height:34px}.divider{font-size:3px;line-height:3px;width:60px}.mso .divider{margin-left:238px;margin-right:238px}.mso .two-col .divider{margin-left:96px;margin-right:96px}.mso .three-col .divider{margin-left:48px;margin-right:48px}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a{text-decoration:none}.wrapper h1{font-size:36px;line-height:44px}.wrapper h2{font-size:24px;line-height:32px}.wrapper h3{font-size:14px;line-height:22px}.wrapper ol,.wrapper p,.wrapper ul{font-size:16px;line-height:25px}.mso .wrapper li{padding-left:5px!important;margin-left:10px!important}.mso .wrapper ol,.mso .wrapper ul{margin-left:20px!important}.wrapper blockquote{margin-left:0;padding-right:0;font-style:italic}.one-col-bg,.one-col-feature-bg,.three-col-bg,.two-col-bg{width:100%}.one-col,.one-col-feature,.three-col,.two-col{background-color:#fff;table-layout:fixed}.one-col ol,.one-col ul{margin-left:17px}.three-col ol,.three-col ul,.two-col ol,.two-col ul{margin-left:15px}.one-col li{padding-left:4px}.one-col blockquote{padding-left:16px}.two-col li{padding-left:3px}.two-col blockquote{padding-left:13px}.three-col li{padding-left:4px}.three-col blockquote{padding-left:13px}.one-col-feature .column{width:600px}.header,.preheader{width:100%}.one-col-feature-top{padding-top:32px}.one-col-feature-bottom{padding-bottom:32px}.one-col-feature .border{font-size:3px;line-height:3px;margin-left:32px;margin-right:32px}.one-col-feature ol{margin-left:31px}.one-col-feature ol li{padding-left:0}.one-col-feature ul{margin-left:23px}.one-col-feature ul li{padding-left:9px}.wrapper .one-col-feature blockquote{border-left:none;margin-left:0;padding-left:0}.wrapper h1,.wrapper h2{font-weight:500}.wrapper h3{font-weight:700}.header a,.preheader a{font-weight:700;letter-spacing:.01em;text-decoration:none}.two-col .first .padded{padding-left:32px;padding-right:16px}.two-col .second .padded{padding-left:16px;padding-right:32px}.logo{width:600px}.logo div{font-weight:400}.logo div.logo-center img{margin-left:auto;margin-right:auto}@media only screen and (max-width:620px){.image+.contents td>:first-child,.wrapper blockquote+*,.wrapper ol+*,.wrapper p+*,.wrapper ul+*{margin-top:25px!important}.contents:nth-last-child(n+3) .btn:last-child,.contents:nth-last-child(n+3) .divider:last-child,.contents:nth-last-child(n+3) .image:last-child,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn:last-child,.no-padding .contents:nth-last-child(n+2) .divider:last-child,.no-padding .contents:nth-last-child(n+2) .image:last-child,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px!important}[class=wrapper] .preheader .title,[class=wrapper] .second .column-top,[class=wrapper] .third .column-top{display:none}[class=wrapper] blockquote{border-left-width:5px!important;padding-left:15px!important}[class=wrapper] .preheader .webversion{text-align:center!important}[class=wrapper] .logo{width:280px!important;padding-left:10px!important;padding-right:10px!important}[class=wrapper] .logo img{max-width:280px!important;height:auto!important}[class=wrapper] h1{font-size:36px!important;line-height:44px!important}[class=wrapper] h2{font-size:24px!important;line-height:32px!important}[class=wrapper] h3{font-size:14px!important;line-height:22px!important}[class=wrapper] ol,[class=wrapper] p,[class=wrapper] ul{line-height:25px!important;font-size:16px!important}[class=wrapper] ol,[class=wrapper] ul{margin-left:17px}[class=wrapper] li{padding-left:4px}[class=wrapper] .divider{margin:0 auto 25px auto!important;width:60px}[class=wrapper] .separator{width:320px!important}[class=wrapper] .one-col-feature ol{margin-left:28px!important}[class=wrapper] .one-col-feature ol li{padding-left:0!important}[class=wrapper] .one-col-feature ul{margin-left:20px!important}[class=wrapper] .one-col-feature ul li{padding-left:8px!important}[class=wrapper] .one-col-feature blockquote{border-left:none!important;padding-left:0!important}}
                            .wrapper h1{}.wrapper h1{font-family:Avenir,sans-serif}.mso .wrapper h1{font-family:sans-serif !important}.wrapper h2{}.wrapper h2{font-family:Avenir,sans-serif}.mso .wrapper h2{font-family:sans-serif !important}.wrapper h3{}.wrapper h3{font-family:Avenir,sans-serif}.mso .wrapper h3{font-family:sans-serif !important}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{font-family:Avenir,sans-serif}.mso .wrapper p,.mso .wrapper ol,.mso .wrapper ul,.mso .wrapper .image{font-family:sans-serif !important}.wrapper .btn a{}.wrapper .btn a{font-family:Avenir,sans-serif}.mso .wrapper .btn a{font-family:sans-serif !important}.logo div{}.logo div{font-family:"PT Sans","Trebuchet MS",sans-serif}.mso .logo div{font-family:"Trebuchet MS",sans-serif
                            !important}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{font-family:Avenir,sans-serif}.mso .title,.mso .webversion,.mso .fblike,.mso .tweet,.mso .linkedinshare,.mso .forwardtoafriend,.mso .link,.mso .address,.mso .permission,.mso .campaign{font-family:sans-serif !important}body,.wrapper,.emb-editor-canvas{background-color:#c5cbd1}.mso body{background-color:#fff !important}.mso .separator,.mso .header,.mso .footer,.mso .one-col-bg,.mso .two-col-bg,.mso .three-col-bg,.mso .one-col-feature-bg{background-color:#c5cbd1}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a,.wrapper p a,.wrapper li a{color:#438fd1}.wrapper h1 a:hover,.wrapper h2 a:hover,.wrapper h3 a:hover,.wrapper p a:hover,.wrapper li a:hover{color:#2c75b5 !important}.wrapper
                            h1{color:#44596b}.wrapper h2{color:#44596b}.wrapper h3{color:#44596b}.wrapper p,.wrapper ol,.wrapper ul{color:#8e8e8e}.wrapper .image{color:#8e8e8e}.wrapper .one-col-feature h1 a,.wrapper .one-col-feature h2 a,.wrapper .one-col-feature h3 a,.wrapper .one-col-feature p a,.wrapper .one-col-feature li a{color:#438fd1}.wrapper .one-col-feature h1 a:hover,.wrapper .one-col-feature h2 a:hover,.wrapper .one-col-feature h3 a:hover,.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature li a:hover{color:#2c75b5 !important}.wrapper blockquote{border-left:5px solid #aeb5bc}.wrapper .btn a{background-color:#386994;color:#fff}.wrapper .btn a:hover{color:#fff !important}.logo div{color:#606b75}.logo div a{color:#606b75}.logo div a:hover{color:#606b75 !important}.divider{background-color:#aeb5bc}.one-col-feature .border{background-color:#aeb5bc}.preheader td,.footer .inner
                            td{color:#606b75}.wrapper .preheader a,.wrapper .footer a{color:#606b75}.wrapper .preheader a:hover,.wrapper .footer a:hover{color:#3e454b !important}.preheader .title{background-color:#bac0c6}.preheader .webversion{background-color:#b2b9c0}.emb-editor-canvas{background-color:#b7bdc4}@media (min-width:0){body{background-color:#b7bdc4}}.wrapper .footer .fblike,.wrapper .footer .tweet,.wrapper .footer .linkedinshare,.wrapper .footer .forwardtoafriend{background-color:#636669}
                            #facebox,#facebox .content{font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important}#facebox{position:absolute;top:0;left:0;z-index:100;text-align:left}#facebox .popup{position:relative;border:7px solid rgba(0,0,0,.445);-webkit-border-radius:7px;-moz-border-radius:7px;border-radius:7px;padding:0}#facebox .content{display:block;width:470px;overflow:show;padding:0;background:#fff}#facebox .content>p:first-child{margin-top:0}#facebox .content>p:last-child{margin-bottom:0}#facebox .image,#facebox .loading{text-align:center}#facebox img{border:0;margin:0}#facebox_overlay{position:fixed;top:0;left:0;height:100%;width:100%}#fblike,.fblikeContent{font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;position:relative}.facebox_hide{z-index:-100}.facebox_overlayBG{background-color:#000;z-index:99}#fblike{margin:0;padding:0;background-color:#fff;display:none}#fblike h1,h1.fb{background-color:#6d84b4!important;font-size:14px!important;color:#fff!important;padding:5px 10px!important;margin:0!important;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;letter-spacing:normal!important}.fblikeContent{border-bottom:1px solid #ccc;padding:10px;font-size:12px;height:120px !IE;min-height:80px!important;overflow:hidden;z-index:1}.fblikeContent span{height:auto!important}h2.fbCustomURL{background-color:#f2f2f2!important;border-bottom:1px solid #ccc!important;color:#999!important;font-size:12px!important;font-weight:400!important;margin:0 0 10px!important;padding:5px 10px!important;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;font-style:normal!important;line-height:1.2!important}#closeBox a,#closeBox a:hover{color:#fff!important}.fblikeContent iframe{min-height:80px!important;position:relative!important}.fblikeContent p{margin-top:0!important;margin-bottom:15px;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important}#closeBox{display:none!important;background-color:#f2f2f2;height:41px;position:relative;width:420px;padding:0;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;z-index:2}#closeBox a{text-decoration:none;font-size:11px;font-weight:700;background-color:#5d76aa;border:1px solid #2a437e;-webkit-box-shadow:inset 0 1px 0 #8a9cc2;padding:3px 6px;position:absolute;right:10px;top:10px}
                        </style>
                        <meta name="robots" content="noindex,nofollow">
                        <meta property="og:title" content="My First Campaign">
                    </head>
                    <!--[if mso]>
                    <body class="mso">
                    <![endif]-->
                    <!--[if !mso]><!-->
                    <body style="margin: 0;padding: 0;min-width: 100%;background-color: #f2f2f2;">
                    <!--<![endif]-->
                        <center class="wrapper" style="display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #f2f2f2;">
                            <table class="preheader" style="border-collapse: collapse;border-spacing: 0;font-size: 11px;line-height: 17px;width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="title" style="padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: left;width: 50%;background-color: #fff;"></td>
                                        <td class="webversion" style="padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: right;width: 50%;background-color: rgba(178, 17, 23, 1);"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="header" style="border-collapse: collapse;border-spacing: 0;width: 100%;" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                        <td class="logo emb-logo-padding-box" style="padding: 0;vertical-align: top;mso-line-height-rule: at-least;width: 600px;padding-top: 32px;padding-bottom: 20px;">
                                            <div class="logo-center" style="font-weight: 400;font-family: &quot;PT Sans&quot;,&quot;Trebuchet MS&quot;,sans-serif;color: #606b75;text-align: center;font-size: 0px !important;line-height: 0 !important;" align="center" id="emb-email-header">
                                                <img style="border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 100%;" src="http://camcar.mx/img/logos/logo_camcar.png" alt="" height="55">
                                            </div>
                                        </td>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="one-col-bg" style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0;vertical-align: top;" align="center">
                                            <table class="one-col centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;table-layout: fixed;" emb-background-style="">
                                                <tbody>
                                                    <tr>
                                                        <td class="column" style="padding: 0;vertical-align: top;text-align: left;">
                                                            <div class="image" style="font-size: 12px;mso-line-height-rule: at-least;font-style: normal;font-weight: 400;margin-bottom: 0;margin-top: 0;font-family: Avenir,sans-serif;color: #8e8e8e;" align="center">
                                                                <img class="gnd-corner-image gnd-corner-image-center gnd-corner-image-top" style="border: 0;-ms-interpolation-mode: bicubic;display: block;max-width: 900px;" src="http://camcar.mx/img/dashboard/mail/felicitacion-cumpleanos.jpg" alt="" width="600" height="314">
                                                            </div>
                                                            <table class="contents" style="border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded font-sans-serif" style="padding: 10px 15px;vertical-align: top;word-break: break-word;word-wrap: break-word; border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                                            <span style="text-align: left; padding: 5px 0; margin-top: 0px; display: block;">
                                                                                <strong>De: </strong>
                                                                                ' . $cum_send_from.'
                                                                            </span>
                                                                            <span style="text-align: left; padding: 5px 0; margin-top: 0px; display: block;">
                                                                                <strong>Para: </strong>
                                                                                ' . $cum_send_to.'
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="contents" style="border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%; margin-top: 15px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded" style="padding: 0px 15px 15px;vertical-align: top;word-break: break-word;word-wrap: break-word;">
                                                                            <span style="text-align: right; padding: 5px 0; margin-top: 0px; display: block;">
                                                                                ' . $cum_send_date.'
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="padded" style="padding: 0px 15px 15px;vertical-align: top;word-break: break-word;word-wrap: break-word; border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                                            <p>
                                                                                ' . $cum_send_message.'
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="contents" style="border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%; margin-top: 15px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded" style="padding: 20px 15px 0px;vertical-align: top;word-break: break-word;word-wrap: break-word;">
                                                                            <div class="btn" style="margin-bottom: 0;margin-top: 0;text-align: center;">
                                                                                <!--[if !mso]-->
                                                                                <a style="border-radius: 3px;display: inline-block;font-size: 14px;font-weight: 700;line-height: 24px;padding: 13px 35px 12px 35px;text-align: center;text-decoration: none !important;transition: opacity 0.2s ease-in;font-family: Avenir,sans-serif;background-color: #b21117;color: #fff;"
                                                                                    href="mailto:' . $cum_send_email.'">
                                                                                    RESPONDER
                                                                                </a>
                                                                                <!--[endif]-->
                                                                                <!--[if mso]>
                                                                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                                                                    href="mailto:' . $cum_send_email.'"
                                                                                    style="width:178px" arcsize="7%" fillcolor="#b21117" stroke="f">
                                                                                    <v:textbox style="mso-fit-shape-to-text:t" inset="0px,12px,0px,11px">
                                                                                        <center style="font-size:14px;line-height:24px;color:#FFFFFF;font-family:sans-serif;font-weight:700;mso-line-height-rule:exactly;mso-text-raise:4px">
                                                                                            RESPONDER
                                                                                        </center>
                                                                                    </v:textbox>
                                                                                </v:roundrect>
                                                                                <![endif]-->
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="column-bottom" style="font-size: 34px;line-height: 34px;transition-timing-function: cubic-bezier(0, 0, 0.2, 1);transition-duration: 150ms;transition-property: all;">&nbsp;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="spacer" style="font-size: 1px;line-height:0px;width: 100%;">&nbsp;</div>
                            <table class="footer centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                        <td class="inner" style="padding: 58px 0 29px 0;vertical-align: top;width: 600px;">
                                            <table class="center" style="border-collapse: collapse;border-spacing: 0;" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 0;vertical-align: top;color: #606b75;font-size: 12px;line-height: 22px;text-align: left;width: 400px;">
                                                            <div class="campaign" style="font-family: Avenir,sans-serif;margin-bottom: 18px; text-align: center;">
                                                                <span>
                                                                    © 2016 <a href="http://camcar.mx/">Camcar Grupo Automotriz</a>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </body>
                </html>
            ',
            'subject' => 'Envio de Felicitación de cumpleaños.',
            'from_email' => 'respuesta.segura@camcar.mx',
            'from_name' => $cum_send_from,
            'to' => array(
                array(
                    //'email' => 'marina.reyes@camcar.mx',
                    'email' => $cum_send_email_to,
                    //'email' => 'hevelmo060683@gmail.com',
                    'name' => $cum_send_from.' te ha enviado una felicitación',
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $cum_send_email),
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
            //"attachments" => $attachments,
            'tags' => array('Envio de Felicitación de cumpleaños.'),
            //'google_analytics_domains' => array('http://camcar.mx/'),
            //'google_analytics_campaign' => 'reclutamiento@camcar.mx',
            //'metadata' => array('website' => 'http://camcar.mx/')
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = '';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        //print_r($result);
    } catch (Mandrill_Error $e) {
        //Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: '.get_class($e) . ' - ' . $e->getMessage();
        //A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
}

//SEND MESSAGE CONTACT

function send_directory_message($dir_send_message, $dir_send_from, $dir_send_to, $dir_send_email, $dir_send_email_to, $dir_send_date) {
    try {
        $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
        $message = array(
            'html' => '
                <html>
                    <head>
                        <title></title>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                        <style type="text/css" media="screen">
                            .font-sans-serif{font-family:sans-serif}.font-avenir{font-family:Avenir,sans-serif}.mso .font-avenir{font-family:sans-serif!important}.font-lato{font-family:Lato,Tahoma,sans-serif}.mso .font-lato{font-family:Tahoma,sans-serif!important}.font-cabin{font-family:Cabin,Avenir,sans-serif}.mso .font-cabin{font-family:sans-serif!important}.font-open-Sans{font-family:"Open Sans",sans-serif}.mso .font-open-Sans{font-family:sans-serif!important}.font-roboto{font-family:Roboto,Tahoma,sans-serif}.mso .font-roboto{font-family:Tahoma,sans-serif!important}.font-ubuntu{font-family:Ubuntu,sans-serif}.mso .font-ubuntu{font-family:sans-serif!important}.font-pt-sans{font-family:"PT Sans","Trebuchet MS",sans-serif}.mso .font-pt-sans{font-family:"Trebuchet MS",sans-serif!important}.font-georgia{font-family:Georgia,serif}.font-merriweather{font-family:Merriweather,Georgia,serif}.mso .font-merriweather{font-family:Georgia,serif!important}.font-bitter{font-family:Bitter,Georgia,serif}.mso .font-bitter{font-family:Georgia,serif!important}.font-pt-serif{font-family:"PT Serif",Georgia,serif}.mso .font-pt-serif{font-family:Georgia,serif!important}.font-pompiere{font-family:Pompiere,"Trebuchet MS",sans-serif}.mso .font-pompiere{font-family:"Trebuchet MS",sans-serif!important}.font-roboto-slab{font-family:"Roboto Slab",Georgia,serif}.mso .font-roboto-slab{font-family:Georgia,serif!important}
                            body,td{padding:0}.image img,.logo img{display:block}.contents,.spacer,.wrapper{width:100%}.btn a:hover,.footer .links a:hover{opacity:.8}.contents,.wrapper,table.wrapper{table-layout:fixed}@media only screen and (max-width:620px){.wrapper .column .size-8{font-size:8px!important;line-height:14px!important}.wrapper .column .size-9{font-size:9px!important;line-height:16px!important}.wrapper .column .size-10{font-size:10px!important;line-height:18px!important}.wrapper .column .size-11{font-size:11px!important;line-height:19px!important}.wrapper .column .size-12{font-size:12px!important;line-height:19px!important}.wrapper .column .size-13{font-size:13px!important;line-height:21px!important}.wrapper .column .size-14{font-size:14px!important;line-height:21px!important}.wrapper .column .size-15{font-size:15px!important;line-height:23px!important}.wrapper .column .size-16{font-size:16px!important;line-height:24px!important}.wrapper .column .size-17,.wrapper .column .size-18,.wrapper .column .size-20{font-size:17px!important;line-height:26px!important}.wrapper .column .size-22{font-size:18px!important;line-height:26px!important}.wrapper .column .size-24{font-size:20px!important;line-height:28px!important}.wrapper .column .size-26{font-size:22px!important;line-height:31px!important}.wrapper .column .size-28{font-size:24px!important;line-height:32px!important}.wrapper .column .size-30{font-size:26px!important;line-height:34px!important}.wrapper .column .size-32{font-size:28px!important;line-height:36px!important}.wrapper .column .size-34,.wrapper .column .size-36{font-size:30px!important;line-height:38px!important}.wrapper .column .size-40{font-size:32px!important;line-height:40px!important}.wrapper .column .size-44{font-size:34px!important;line-height:43px!important}.wrapper .column .size-48{font-size:36px!important;line-height:43px!important}.wrapper .column .size-56{font-size:40px!important;line-height:47px!important}.wrapper .column .size-64{font-size:44px!important;line-height:50px!important}}body{margin:0;min-width:100%}.mso body{mso-line-height-rule:exactly}.footer .links,.footer .right td,.image,.logo{mso-line-height-rule:at-least}.no-padding .wrapper .column .column-bottom,.no-padding .wrapper .column .column-top{font-size:0;line-height:0}table{border-collapse:collapse;border-spacing:0}td{vertical-align:top}.border,.spacer{font-size:1px;line-height:1px}img{border:0;-ms-interpolation-mode:bicubic}.image{font-size:12px}strong{font-weight:700}.image,blockquote,h1,h2,h3,ol,p,ul{font-style:normal;font-weight:400}li,ol,ul{padding-left:0}blockquote{margin-left:0;margin-right:0;padding-right:0}.centered,.divider,.one-col,.three-col,.two-col{margin-left:auto;margin-right:auto}.column-bottom,.column-top{font-size:34px;line-height:34px;transition-timing-function:cubic-bezier(0,0,.2,1);transition-duration:150ms;transition-property:all}.half-padding .column .column-bottom,.half-padding .column .column-top{font-size:17px;line-height:17px}.column{text-align:left}.padded{padding-left:32px;padding-right:32px;word-break:break-word;word-wrap:break-word}.wrapper{display:table;min-width:620px;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}.wrapper a{transition:opacity .2s ease-in}.one-col,.three-col,.two-col{width:600px}.btn a{border-radius:3px;display:inline-block;font-size:14px;font-weight:700;line-height:24px;padding:13px 35px 12px;text-align:center;text-decoration:none!important}.two-col .btn a{font-size:12px;line-height:22px;padding:10px 28px}.three-col .btn a{font-size:11px;line-height:19px;padding:6px 18px 5px}@media only screen and (max-width:620px){.btn a{display:block!important;font-size:14px!important;line-height:24px!important;padding:13px 10px 12px!important}}.two-col .column{width:300px}.three-col .column{width:200px}.three-col .first .padded{padding-left:32px;padding-right:12px}.three-col .second .padded{padding-left:22px;padding-right:22px}.three-col .third .padded{padding-left:12px;padding-right:32px}@media only screen and (min-width:0){.wrapper{text-rendering:optimizeLegibility}}@media only screen and (max-width:620px){[class=wrapper]{min-width:320px!important;width:100%!important}[class=wrapper] .one-col,[class=wrapper] .three-col,[class=wrapper] .two-col{width:320px!important}[class=wrapper] .column,[class=wrapper] .gutter{display:block;float:left;width:320px!important}[class=wrapper] .padded{padding-left:20px!important;padding-right:20px!important}[class=wrapper] .block{display:block!important}[class=wrapper] .hide{display:none!important}[class=wrapper] .image img{height:auto!important;width:100%!important}}.footer{width:100%}.footer .inner{padding:58px 0 29px;width:600px}.footer .left td,.footer .right td{font-size:12px;line-height:22px}.footer .left td{text-align:left;width:400px}.footer .right td{max-width:200px}.footer .links{line-height:26px;margin-bottom:26px}.footer .links img{vertical-align:middle}.footer .address,.footer .campaign{margin-bottom:18px}.footer .campaign a{font-weight:700;text-decoration:none}.footer .sharing div{margin-bottom:5px}.wrapper .footer .fblike,.wrapper .footer .forwardtoafriend,.wrapper .footer .linkedinshare,.wrapper .footer .tweet{background-repeat:no-repeat;background-size:200px 56px;border-radius:2px;color:#fff;display:block;font-size:11px;font-weight:700;line-height:11px;padding:8px 11px 7px 28px;text-align:left;text-decoration:none}.wrapper .footer .fblike:hover,.wrapper .footer .forwardtoafriend:hover,.wrapper .footer .linkedinshare:hover,.wrapper .footer .tweet:hover{color:#fff!important;opacity:.8}.footer .fblike{background-image:url(https://i3.createsend1.com/static/eb/master/08-tint/imgf/fblike.png)}.footer .tweet{background-image:url(https://i4.createsend1.com/static/eb/master/08-tint/imgf/tweet.png)}.footer .linkedinshare{background-image:url(https://i5.createsend1.com/static/eb/master/08-tint/imgf/lishare.png)}.footer .forwardtoafriend{background-image:url(https://i6.createsend1.com/static/eb/master/08-tint/imgf/forward.png)}@media only screen and (-webkit-min-device-pixel-ratio:2),only screen and (min--moz-device-pixel-ratio:2),only screen and (-o-min-device-pixel-ratio:2/1),only screen and (min-device-pixel-ratio:2),only screen and (min-resolution:192dpi),only screen and (min-resolution:2dppx){.footer .fblike{background-image:url(https://i7.createsend1.com/static/eb/master/08-tint/imgf/fblike@2x.png)!important}.footer .tweet{background-image:url(https://i9.createsend1.com/static/eb/master/08-tint/imgf/tweet@2x.png)!important}.footer .linkedinshare{background-image:url(https://i10.createsend1.com/static/eb/master/08-tint/imgf/lishare@2x.png)!important}.footer .forwardtoafriend{background-image:url(https://i8.createsend1.com/static/eb/master/08-tint/imgf/forward@2x.png)!important}}@media only screen and (max-width:620px){.footer{width:320px!important}.footer td{display:none}.footer .inner,.footer .inner td{display:block;text-align:center!important;max-width:320px!important;width:320px!important}.footer .sharing{margin-bottom:40px}.footer .sharing div{display:inline-block}.footer .fblike,.footer .forwardtoafriend,.footer .linkedinshare,.footer .tweet{display:inline-block!important}}.btn,.divider,.image,.wrapper blockquote,.wrapper h1,.wrapper h2,.wrapper h3,.wrapper li,.wrapper ol,.wrapper p,.wrapper ul{margin-bottom:0;margin-top:0}.wrapper .column h1+*{margin-top:18px}.wrapper .column h2+*{margin-top:12px}.wrapper .column h3+*{margin-top:10px}.image+.contents td>:first-child,.wrapper .column blockquote+*,.wrapper .column ol+*,.wrapper .column p+*,.wrapper .column ul+*{margin-top:25px}.contents:nth-last-child(n+3) h1:last-child,.no-padding .contents:nth-last-child(n+2) h1:last-child{margin-bottom:18px}.contents:nth-last-child(n+3) h2:last-child,.no-padding .contents:nth-last-child(n+2) h2:last-child{margin-bottom:12px}.contents:nth-last-child(n+3) h3:last-child,.no-padding .contents:nth-last-child(n+2) h3:last-child{margin-bottom:10px}.contents:nth-last-child(n+3) .btn,.contents:nth-last-child(n+3) .divider,.contents:nth-last-child(n+3) .image,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn,.no-padding .contents:nth-last-child(n+2) .divider,.no-padding .contents:nth-last-child(n+2) .image,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px}.two-col .column blockquote+*,.two-col .column ol+*,.two-col .column p+*,.two-col .column ul+*,.two-col .image+.contents td>:first-child{margin-top:28px}.no-padding .two-col .contents:nth-last-child(n+2) .btn,.no-padding .two-col .contents:nth-last-child(n+2) .divider,.no-padding .two-col .contents:nth-last-child(n+2) .image,.no-padding .two-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .two-col .contents:nth-last-child(n+2) p:last-child,.no-padding .two-col .contents:nth-last-child(n+2) ul:last-child,.two-col .contents:nth-last-child(n+3) .btn,.two-col .contents:nth-last-child(n+3) .divider,.two-col .contents:nth-last-child(n+3) .image,.two-col .contents:nth-last-child(n+3) blockquote:last-child,.two-col .contents:nth-last-child(n+3) ol:last-child,.two-col .contents:nth-last-child(n+3) p:last-child,.two-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:28px}.three-col .column blockquote+*,.three-col .column ol+*,.three-col .column p+*,.three-col .column ul+*,.three-col .image+.contents td>:first-child{margin-top:18px}.no-padding .three-col .contents:nth-last-child(n+2) .btn,.no-padding .three-col .contents:nth-last-child(n+2) .divider,.no-padding .three-col .contents:nth-last-child(n+2) .image,.no-padding .three-col .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ol:last-child,.no-padding .three-col .contents:nth-last-child(n+2) p:last-child,.no-padding .three-col .contents:nth-last-child(n+2) ul:last-child,.three-col .contents:nth-last-child(n+3) .btn,.three-col .contents:nth-last-child(n+3) .divider,.three-col .contents:nth-last-child(n+3) .image,.three-col .contents:nth-last-child(n+3) blockquote:last-child,.three-col .contents:nth-last-child(n+3) ol:last-child,.three-col .contents:nth-last-child(n+3) p:last-child,.three-col .contents:nth-last-child(n+3) ul:last-child{margin-bottom:18px}.preheader{font-size:11px;line-height:17px}.preheader .title{padding:9px;text-align:left;width:50%}.preheader .webversion{padding:9px;text-align:right;width:50%}.logo div.logo-center,.one-col-feature .btn,.one-col-feature h1,.one-col-feature h2,.one-col-feature h3,.one-col-feature p{text-align:center}.separator{font-size:34px;line-height:34px}.divider{font-size:3px;line-height:3px;width:60px}.mso .divider{margin-left:238px;margin-right:238px}.mso .two-col .divider{margin-left:96px;margin-right:96px}.mso .three-col .divider{margin-left:48px;margin-right:48px}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a{text-decoration:none}.wrapper h1{font-size:36px;line-height:44px}.wrapper h2{font-size:24px;line-height:32px}.wrapper h3{font-size:14px;line-height:22px}.wrapper ol,.wrapper p,.wrapper ul{font-size:16px;line-height:25px}.mso .wrapper li{padding-left:5px!important;margin-left:10px!important}.mso .wrapper ol,.mso .wrapper ul{margin-left:20px!important}.wrapper blockquote{margin-left:0;padding-right:0;font-style:italic}.one-col-bg,.one-col-feature-bg,.three-col-bg,.two-col-bg{width:100%}.one-col,.one-col-feature,.three-col,.two-col{background-color:#fff;table-layout:fixed}.one-col ol,.one-col ul{margin-left:17px}.three-col ol,.three-col ul,.two-col ol,.two-col ul{margin-left:15px}.one-col li{padding-left:4px}.one-col blockquote{padding-left:16px}.two-col li{padding-left:3px}.two-col blockquote{padding-left:13px}.three-col li{padding-left:4px}.three-col blockquote{padding-left:13px}.one-col-feature .column{width:600px}.header,.preheader{width:100%}.one-col-feature-top{padding-top:32px}.one-col-feature-bottom{padding-bottom:32px}.one-col-feature .border{font-size:3px;line-height:3px;margin-left:32px;margin-right:32px}.one-col-feature ol{margin-left:31px}.one-col-feature ol li{padding-left:0}.one-col-feature ul{margin-left:23px}.one-col-feature ul li{padding-left:9px}.wrapper .one-col-feature blockquote{border-left:none;margin-left:0;padding-left:0}.wrapper h1,.wrapper h2{font-weight:500}.wrapper h3{font-weight:700}.header a,.preheader a{font-weight:700;letter-spacing:.01em;text-decoration:none}.two-col .first .padded{padding-left:32px;padding-right:16px}.two-col .second .padded{padding-left:16px;padding-right:32px}.logo{width:600px}.logo div{font-weight:400}.logo div.logo-center img{margin-left:auto;margin-right:auto}@media only screen and (max-width:620px){.image+.contents td>:first-child,.wrapper blockquote+*,.wrapper ol+*,.wrapper p+*,.wrapper ul+*{margin-top:25px!important}.contents:nth-last-child(n+3) .btn:last-child,.contents:nth-last-child(n+3) .divider:last-child,.contents:nth-last-child(n+3) .image:last-child,.contents:nth-last-child(n+3) blockquote:last-child,.contents:nth-last-child(n+3) ol:last-child,.contents:nth-last-child(n+3) p:last-child,.contents:nth-last-child(n+3) ul:last-child,.no-padding .contents:nth-last-child(n+2) .btn:last-child,.no-padding .contents:nth-last-child(n+2) .divider:last-child,.no-padding .contents:nth-last-child(n+2) .image:last-child,.no-padding .contents:nth-last-child(n+2) blockquote:last-child,.no-padding .contents:nth-last-child(n+2) ol:last-child,.no-padding .contents:nth-last-child(n+2) p:last-child,.no-padding .contents:nth-last-child(n+2) ul:last-child{margin-bottom:25px!important}[class=wrapper] .preheader .title,[class=wrapper] .second .column-top,[class=wrapper] .third .column-top{display:none}[class=wrapper] blockquote{border-left-width:5px!important;padding-left:15px!important}[class=wrapper] .preheader .webversion{text-align:center!important}[class=wrapper] .logo{width:280px!important;padding-left:10px!important;padding-right:10px!important}[class=wrapper] .logo img{max-width:280px!important;height:auto!important}[class=wrapper] h1{font-size:36px!important;line-height:44px!important}[class=wrapper] h2{font-size:24px!important;line-height:32px!important}[class=wrapper] h3{font-size:14px!important;line-height:22px!important}[class=wrapper] ol,[class=wrapper] p,[class=wrapper] ul{line-height:25px!important;font-size:16px!important}[class=wrapper] ol,[class=wrapper] ul{margin-left:17px}[class=wrapper] li{padding-left:4px}[class=wrapper] .divider{margin:0 auto 25px auto!important;width:60px}[class=wrapper] .separator{width:320px!important}[class=wrapper] .one-col-feature ol{margin-left:28px!important}[class=wrapper] .one-col-feature ol li{padding-left:0!important}[class=wrapper] .one-col-feature ul{margin-left:20px!important}[class=wrapper] .one-col-feature ul li{padding-left:8px!important}[class=wrapper] .one-col-feature blockquote{border-left:none!important;padding-left:0!important}}
                            .wrapper h1{}.wrapper h1{font-family:Avenir,sans-serif}.mso .wrapper h1{font-family:sans-serif !important}.wrapper h2{}.wrapper h2{font-family:Avenir,sans-serif}.mso .wrapper h2{font-family:sans-serif !important}.wrapper h3{}.wrapper h3{font-family:Avenir,sans-serif}.mso .wrapper h3{font-family:sans-serif !important}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{}.wrapper p,.wrapper ol,.wrapper ul,.wrapper .image{font-family:Avenir,sans-serif}.mso .wrapper p,.mso .wrapper ol,.mso .wrapper ul,.mso .wrapper .image{font-family:sans-serif !important}.wrapper .btn a{}.wrapper .btn a{font-family:Avenir,sans-serif}.mso .wrapper .btn a{font-family:sans-serif !important}.logo div{}.logo div{font-family:"PT Sans","Trebuchet MS",sans-serif}.mso .logo div{font-family:"Trebuchet MS",sans-serif
                            !important}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{}.title,.webversion,.fblike,.tweet,.linkedinshare,.forwardtoafriend,.link,.address,.permission,.campaign{font-family:Avenir,sans-serif}.mso .title,.mso .webversion,.mso .fblike,.mso .tweet,.mso .linkedinshare,.mso .forwardtoafriend,.mso .link,.mso .address,.mso .permission,.mso .campaign{font-family:sans-serif !important}body,.wrapper,.emb-editor-canvas{background-color:#c5cbd1}.mso body{background-color:#fff !important}.mso .separator,.mso .header,.mso .footer,.mso .one-col-bg,.mso .two-col-bg,.mso .three-col-bg,.mso .one-col-feature-bg{background-color:#c5cbd1}.wrapper h1 a,.wrapper h2 a,.wrapper h3 a,.wrapper p a,.wrapper li a{color:#438fd1}.wrapper h1 a:hover,.wrapper h2 a:hover,.wrapper h3 a:hover,.wrapper p a:hover,.wrapper li a:hover{color:#2c75b5 !important}.wrapper
                            h1{color:#44596b}.wrapper h2{color:#44596b}.wrapper h3{color:#44596b}.wrapper p,.wrapper ol,.wrapper ul{color:#8e8e8e}.wrapper .image{color:#8e8e8e}.wrapper .one-col-feature h1 a,.wrapper .one-col-feature h2 a,.wrapper .one-col-feature h3 a,.wrapper .one-col-feature p a,.wrapper .one-col-feature li a{color:#438fd1}.wrapper .one-col-feature h1 a:hover,.wrapper .one-col-feature h2 a:hover,.wrapper .one-col-feature h3 a:hover,.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature li a:hover{color:#2c75b5 !important}.wrapper blockquote{border-left:5px solid #aeb5bc}.wrapper .btn a{background-color:#386994;color:#fff}.wrapper .btn a:hover{color:#fff !important}.logo div{color:#606b75}.logo div a{color:#606b75}.logo div a:hover{color:#606b75 !important}.divider{background-color:#aeb5bc}.one-col-feature .border{background-color:#aeb5bc}.preheader td,.footer .inner
                            td{color:#606b75}.wrapper .preheader a,.wrapper .footer a{color:#606b75}.wrapper .preheader a:hover,.wrapper .footer a:hover{color:#3e454b !important}.preheader .title{background-color:#bac0c6}.preheader .webversion{background-color:#b2b9c0}.emb-editor-canvas{background-color:#b7bdc4}@media (min-width:0){body{background-color:#b7bdc4}}.wrapper .footer .fblike,.wrapper .footer .tweet,.wrapper .footer .linkedinshare,.wrapper .footer .forwardtoafriend{background-color:#636669}
                            #facebox,#facebox .content{font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important}#facebox{position:absolute;top:0;left:0;z-index:100;text-align:left}#facebox .popup{position:relative;border:7px solid rgba(0,0,0,.445);-webkit-border-radius:7px;-moz-border-radius:7px;border-radius:7px;padding:0}#facebox .content{display:block;width:470px;overflow:show;padding:0;background:#fff}#facebox .content>p:first-child{margin-top:0}#facebox .content>p:last-child{margin-bottom:0}#facebox .image,#facebox .loading{text-align:center}#facebox img{border:0;margin:0}#facebox_overlay{position:fixed;top:0;left:0;height:100%;width:100%}#fblike,.fblikeContent{font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;position:relative}.facebox_hide{z-index:-100}.facebox_overlayBG{background-color:#000;z-index:99}#fblike{margin:0;padding:0;background-color:#fff;display:none}#fblike h1,h1.fb{background-color:#6d84b4!important;font-size:14px!important;color:#fff!important;padding:5px 10px!important;margin:0!important;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;letter-spacing:normal!important}.fblikeContent{border-bottom:1px solid #ccc;padding:10px;font-size:12px;height:120px !IE;min-height:80px!important;overflow:hidden;z-index:1}.fblikeContent span{height:auto!important}h2.fbCustomURL{background-color:#f2f2f2!important;border-bottom:1px solid #ccc!important;color:#999!important;font-size:12px!important;font-weight:400!important;margin:0 0 10px!important;padding:5px 10px!important;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;font-style:normal!important;line-height:1.2!important}#closeBox a,#closeBox a:hover{color:#fff!important}.fblikeContent iframe{min-height:80px!important;position:relative!important}.fblikeContent p{margin-top:0!important;margin-bottom:15px;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important}#closeBox{display:none!important;background-color:#f2f2f2;height:41px;position:relative;width:420px;padding:0;font-family:"lucida grande",tahoma,verdana,arial,sans-serif!important;z-index:2}#closeBox a{text-decoration:none;font-size:11px;font-weight:700;background-color:#5d76aa;border:1px solid #2a437e;-webkit-box-shadow:inset 0 1px 0 #8a9cc2;padding:3px 6px;position:absolute;right:10px;top:10px}
                        </style>
                        <meta name="robots" content="noindex,nofollow">
                        <meta property="og:title" content="My First Campaign">
                    </head>
                    <!--[if mso]>
                    <body class="mso">
                    <![endif]-->
                    <!--[if !mso]><!-->
                    <body style="margin: 0;padding: 0;min-width: 100%;background-color: #f2f2f2;">
                    <!--<![endif]-->
                        <center class="wrapper" style="display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #f2f2f2;">
                            <table class="preheader" style="border-collapse: collapse;border-spacing: 0;font-size: 11px;line-height: 17px;width: 100%;">
                                <tbody>
                                    <tr>
                                        <td class="title" style="padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: left;width: 50%;background-color: #fff;"></td>
                                        <td class="webversion" style="padding: 9px;vertical-align: top;font-family: Avenir,sans-serif;color: #606b75;text-align: right;width: 50%;background-color: rgba(178, 17, 23, 1);"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="header" style="border-collapse: collapse;border-spacing: 0;width: 100%;" align="center">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                        <td class="logo emb-logo-padding-box" style="padding: 0;vertical-align: top;mso-line-height-rule: at-least;width: 600px;padding-top: 32px;padding-bottom: 20px;">
                                            <div class="logo-center" style="font-weight: 400;font-family: &quot;PT Sans&quot;,&quot;Trebuchet MS&quot;,sans-serif;color: #606b75;text-align: center;font-size: 0px !important;line-height: 0 !important;" align="center" id="emb-email-header">
                                                <img style="border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 100%;" src="http://camcar.mx/img/logos/logo_camcar.png" alt="" height="55">
                                            </div>
                                        </td>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="one-col-bg" style="border-collapse: collapse;border-spacing: 0;width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0;vertical-align: top;" align="center">
                                            <table class="one-col centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;table-layout: fixed;" emb-background-style="">
                                                <tbody>
                                                    <tr>
                                                        <td class="column" style="padding: 0;vertical-align: top;text-align: left;">
                                                            <table class="contents" style="border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded font-sans-serif" style="padding: 10px 15px;vertical-align: top;word-break: break-word;word-wrap: break-word; border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                                            <span style="text-align: left; padding: 5px 0; margin-top: 0px; display: block;">
                                                                                <strong>De: </strong>
                                                                                ' . $dir_send_from.'
                                                                            </span>
                                                                            <span style="text-align: left; padding: 5px 0; margin-top: 0px; display: block;">
                                                                                <strong>Para: </strong>
                                                                                ' . $dir_send_to.'
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="contents" style="border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%; margin-top: 15px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded" style="padding: 0px 15px 15px;vertical-align: top;word-break: break-word;word-wrap: break-word;">
                                                                            <span style="text-align: right; padding: 5px 0; margin-top: 0px; display: block;">
                                                                                ' . $dir_send_date.'
                                                                            </span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="padded" style="padding: 0px 15px 15px;vertical-align: top;word-break: break-word;word-wrap: break-word; border-bottom: 1px solid rgba(0,0,0,0.1);">
                                                                            <p>
                                                                                ' . $dir_send_message.'
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table class="contents" style="border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%; margin-top: 15px;">
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="padded" style="padding: 20px 15px 0px;vertical-align: top;word-break: break-word;word-wrap: break-word;">
                                                                            <div class="btn" style="margin-bottom: 0;margin-top: 0;text-align: center;">
                                                                                <!--[if !mso]-->
                                                                                <a style="border-radius: 3px;display: inline-block;font-size: 14px;font-weight: 700;line-height: 24px;padding: 13px 35px 12px 35px;text-align: center;text-decoration: none !important;transition: opacity 0.2s ease-in;font-family: Avenir,sans-serif;background-color: #b21117;color: #fff;"
                                                                                    href="mailto:' . $dir_send_email.'">
                                                                                    RESPONDER
                                                                                </a>
                                                                                <!--[endif]-->
                                                                                <!--[if mso]>
                                                                                <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml"
                                                                                    href="mailto:' . $dir_send_email.'"
                                                                                    style="width:178px" arcsize="7%" fillcolor="#b21117" stroke="f">
                                                                                    <v:textbox style="mso-fit-shape-to-text:t" inset="0px,12px,0px,11px">
                                                                                        <center style="font-size:14px;line-height:24px;color:#FFFFFF;font-family:sans-serif;font-weight:700;mso-line-height-rule:exactly;mso-text-raise:4px">
                                                                                            RESPONDER
                                                                                        </center>
                                                                                    </v:textbox>
                                                                                </v:roundrect>
                                                                                <![endif]-->
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <div class="column-bottom" style="font-size: 34px;line-height: 34px;transition-timing-function: cubic-bezier(0, 0, 0.2, 1);transition-duration: 150ms;transition-property: all;">&nbsp;</div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="spacer" style="font-size: 1px;line-height:0px;width: 100%;">&nbsp;</div>
                            <table class="footer centered" style="border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                        <td class="inner" style="padding: 58px 0 29px 0;vertical-align: top;width: 600px;">
                                            <table class="center" style="border-collapse: collapse;border-spacing: 0;" align="center">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 0;vertical-align: top;color: #606b75;font-size: 12px;line-height: 22px;text-align: left;width: 400px;">
                                                            <div class="campaign" style="font-family: Avenir,sans-serif;margin-bottom: 18px; text-align: center;">
                                                                <span>
                                                                    © 2016 <a href="http://camcar.mx/">Camcar Grupo Automotriz</a>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td style="padding: 0;vertical-align: top;">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>
                    </body>
                </html>
            ',
            'subject' => 'Mensaje de contacto.',
            'from_email' => 'respuesta.segura@camcar.mx',
            'from_name' => $dir_send_from,
            'to' => array(
                array(
                    //'email' => 'marina.reyes@camcar.mx',
                    'email' => $dir_send_email_to,
                    //'email' => 'hevelmo060683@gmail.com',
                    'name' => $dir_send_from.' te ha enviado un mensaje.',
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => $dir_send_email),
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
            //"attachments" => $attachments,
            'tags' => array('orden-new-notificacion', 'Directorio -> Mensaje contacto'),
            //'google_analytics_domains' => array('http://camcar.mx/'),
            //'google_analytics_campaign' => 'reclutamiento@camcar.mx',
            //'metadata' => array('website' => 'http://camcar.mx/')
        );
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = '';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        //print_r($result);
    } catch (Mandrill_Error $e) {
        //Mandrill errors are thrown as exceptions
        echo 'A mandrill error occurred: '.get_class($e) . ' - ' . $e->getMessage();
        //A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
        throw $e;
    }
}
