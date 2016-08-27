<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../incorporate/db_connect.php';
include '../../../incorporate/functions.php';
include '../../../incorporate/queryintojson.php';
//include '../Mandrill.php';

sec_session_start();
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


// POST route


// INSERT
//$app->post('/new/table', /*'mw1',*/ 'addTable');

// UPDATE
//$app->post('/set/table/:idTable', /*'mw1',*/ 'setTable');


// GET route

// SELECT
$app->get('/get/seminuevos', /*'mw1',*/ 'getSeminuevos');
$app->get('/get/categoria', /*'mw1',*/ 'getCategory');
$app->get('/get/categoria/marca', /*'mw1',*/ 'getCategoryMarc');
$app->get('/get/categoria/modelo', /*'mw1',*/ 'getCategoryModel');
$app->get('/get/categoria/year', /*'mw1',*/ 'getCategoryYear');
$app->get('/get/categoria/precio/:priceId', /*'mw1',*/ 'getCategoryPrice');
$app->get('/get/seminuevos/:senId', /*'mw1',*/ 'getSeminuevosById');
$app->get('/get/seminuevos/marca/:senMarc', /*'mw1',*/ 'getSeminuevosByMarc');
$app->get('/get/seminuevos/modelo/:senModel', /*'mw1',*/ 'getSeminuevosByModel');

/*$app->get('/get/seminuevos/filtros/:senCat/:yearMin/:yearMax/:idModel/:idMarc', 'getSemYearFilters');
$app->get('/get/seminuevos/filtros/:senCat/:priceMin/:priceMax/:idModel/:idMarc', 'getSemPriceFilters');*/

$app->get('/get/catalogo/:marId', /*'mw1',*/ 'getCatalogoByMarc');
$app->get('/get/marca', /*'mw1',*/ 'getMarca');
$app->get('/get/modelo', /*'mw1',*/ 'getModelo');
$app->get('/get/transmision', /*'mw1',*/ 'getTransmision');

// DELETE
//$app->get('/del/table/:idTable', /*'mw1',*/ 'delTable');


//TEST


$app->get('/get/test', /*'mw1',*/ 'getTest');
$app->post('/post/test', /*'mw1',*/ 'postTest');


$app->run();


//TEST

function getTest() {
    $today = date('o-m-d H:i:s');
    $array = array('date' => $today);
    echo changeArrayIntoJSON('campa', $array);
}

function postTest() {
    $array = array('process' => 'ok');
    //echo changeArrayIntoJSON('campa', $array);
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
  /*
function getYearJSON($sql, $yearID) {
    SELECT * FROM camSeminuevos sen WHERE SEN_Year BETWEEN 2008 AND 2015 GROUP BY SEN_Year
}*/
// SELECT CATEGORY
    function getCategory() {
        $sql = "SELECT CAT_Id, CAT_Nombre FROM camCategorias cat GROUP BY CAT_Id";
        $structure = array(
            'id_cat' => 'CAT_Id',
            'name_cat' => 'CAT_Nombre'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
/****/
// SELECT MARC
    function getCategoryMarc() {
        $sql = "SELECT MAR_Id, MAR_Nombre FROM camMarcas cat GROUP BY MAR_Id";
        $structure = array(
            'id_marc' => 'MAR_Id',
            'name_marc' => 'MAR_Nombre'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
/****/
// SELECT MODEL
    function getCategoryModel() {
        $sql = "SELECT MDO_Id, MDO_Nombre FROM camModelos cat GROUP BY MDO_Id";
        $structure = array(
            'id_mdo' => 'MDO_Id',
            'name_mdo' => 'MDO_Nombre'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
/****/
// INPUTS YEAR
    function getCategoryYear() {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN camAgencias agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                INNER JOIN camCategorias cat
                ON sen.SEN_CAT_Id = cat.CAT_Id
                INNER JOIN camModelos mdo
                ON sen.SEN_MDO_Id = mdo.MDO_Id
                INNER JOIN camMarcas mrc
                ON sen.SEN_MAR_Id = mrc.MAR_Id
                INNER JOIN camThumb thm
                ON sen.SEN_THM_Id = thm.THM_Id
                WHERE SEN_Year BETWEEN :senMinYear AND :senMaxYear
                GROUP BY SEN_Year
            ";
        $structure = array(
            'id' => 'SEN_Id',
            'agencia' => 'AGN_Nombre',
            'marca' => 'MAR_Nombre',
            'categoria' => 'CAT_Nombre',
            'modelo' => 'MDO_Nombre',
            'year' => 'SEN_Year',
            'km' => 'SEN_Kilometraje',
            'transmision' => 'SEN_Transmision',
            'version' => 'SEN_Version',
            'interior' => 'SEN_Interior',
            'color_exterior' => 'SEN_ColorExterior',
            'precio' => 'SEN_Precio',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'mini' => 'THM_Nombre'
        );
        $params = array(
            'senMinYear' => '2008',
            'senMaxYear' => '2015'
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
/****/
// INPUTS PRICE
    function getCategoryPriceJSON($sql, $priceId) {
        $structure = array(
            'id' => 'SEN_Id',
            'agencia' => 'AGN_Nombre',
            'marca' => 'MAR_Nombre',
            'categoria' => 'CAT_Nombre',
            'modelo' => 'MDO_Nombre',
            'year' => 'SEN_Year',
            'km' => 'SEN_Kilometraje',
            'transmision' => 'SEN_Transmision',
            'version' => 'SEN_Version',
            'interior' => 'SEN_Interior',
            'color_exterior' => 'SEN_ColorExterior',
            'precio' => 'SEN_Precio',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'mini' => 'THM_Nombre'
        );
        $params = array(
            'senMinPrice' => '455000',
            'senMaxPrice' => '515000'
        );
        ($priceId !== '') ? $params['priceId'] = $priceId : $params = $params;
        //var_dump($params);
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getCategoryPrice($priceId) {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN camAgencias agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                INNER JOIN camCategorias cat
                ON sen.SEN_CAT_Id = cat.CAT_Id
                INNER JOIN camModelos mdo
                ON sen.SEN_MDO_Id = mdo.MDO_Id
                INNER JOIN camMarcas mrc
                ON sen.SEN_MAR_Id = mrc.MAR_Id
                INNER JOIN camThumb thm
                ON sen.SEN_THM_Id = thm.THM_Id
                WHERE SEN_Precio BETWEEN :senMinPrice AND :senMaxPrice
                GROUP BY SEN_Precio
                ";
        getCategoryPriceJSON($sql, '', '');
    }
/****/

function getCatalogoJSON($sql, $marId) {
    $structure = array(
        'id' => 'SEN_Id',
        'agencia' => 'AGN_Nombre',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'km' => 'SEN_Kilometraje',
        'transmision' => 'SEN_Transmision',
        'version' => 'SEN_Version',
        'interior' => 'SEN_Interior',
        'color_exterior' => 'SEN_ColorExterior',
        'precio' => 'SEN_Precio',
        'agencia' => 'AGN_Nombre',
        'folder' => 'AGN_Folder',
        'mini' => 'THM_Nombre'
    );
    $params = array();
    ($marId !== '') ? $params['marId'] = $marId : $params = $params;
    echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getCatalogoByMarc($marId) {
    $sql = "SELECT *
            FROM camSeminuevos sen
            INNER JOIN camAgencias agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            INNER JOIN camCategorias cat
            ON sen.SEN_CAT_Id = cat.CAT_Id
            INNER JOIN camModelos mdo
            ON sen.SEN_MDO_Id = mdo.MDO_Id
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            INNER JOIN camThumb thm
            ON sen.SEN_THM_Id = thm.THM_Id
            WHERE SEN_MAR_Id = :marId
            ORDER BY MAR_Id
            ";
    getCatalogoJSON($sql, $marId, '');
}

function getSeminuevos() {
    $sql = "SELECT *
            FROM camSeminuevos sen
            INNER JOIN camAgencias agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            INNER JOIN camCategorias cat
            ON sen.SEN_CAT_Id = cat.CAT_Id
            INNER JOIN camModelos mdo
            ON sen.SEN_MDO_Id = mdo.MDO_Id
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            INNER JOIN camThumb thm
            ON sen.SEN_THM_Id = thm.THM_Id
            ";
    $structure = array(
        'id' => 'SEN_Id',
        'agencia' => 'AGN_Nombre',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'km' => 'SEN_Kilometraje',
        'transmision' => 'SEN_Transmision',
        'version' => 'SEN_Version',
        'interior' => 'SEN_Interior',
        'color_exterior' => 'SEN_ColorExterior',
        'precio' => 'SEN_Precio',
        'observaciones' => 'SEN_Observaciones',
        'agencia' => 'AGN_Nombre',
        'folder' => 'AGN_Folder',
        'mini' => 'THM_Nombre'
    );
    $params = array();
    echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getSeminuevosJSON($sql, $senId) {
    $structure = array(
        'id' => 'SEN_Id',
        'id_mar' => 'MAR_Id',
        'agencia' => 'AGN_Nombre',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'km' => 'SEN_Kilometraje',
        'transmision' => 'SEN_Transmision',
        'version' => 'SEN_Version',
        'interior' => 'SEN_Interior',
        'color_exterior' => 'SEN_ColorExterior',
        'precio' => 'SEN_Precio',
        'observaciones' => 'SEN_Observaciones',
        'agencia' => 'AGN_Nombre',
        'folder' => 'AGN_Folder',
        'directorio' => 'PIC_MDO_Folder',
        'foto' => 'PIC_Nombre'
    );
    $params = array();
    ($senId !== '') ? $params['senId'] = $senId : $params = $params;
    echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getSeminuevosById($senId) {
    $sql = "SELECT *
            FROM camSeminuevos sen
            INNER JOIN camAgencias agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            INNER JOIN camCategorias cat
            ON sen.SEN_CAT_Id = cat.CAT_Id
            INNER JOIN camModelos mdo
            ON sen.SEN_MDO_Id = mdo.MDO_Id
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            INNER JOIN camPictures pic
            ON sen.SEN_PIC_Id = pic.PIC_SEN_Id
            WHERE SEN_Id = :senId
            ";
    getSeminuevosJSON($sql, $senId, '');
}

function getSeminuevosByMarcJSON($sql, $senMarc) {
    $structure = array(
        'id' => 'SEN_Id',
        'agencia' => 'AGN_Nombre',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'km' => 'SEN_Kilometraje',
        'transmision' => 'SEN_Transmision',
        'version' => 'SEN_Version',
        'interior' => 'SEN_Interior',
        'color_exterior' => 'SEN_ColorExterior',
        'precio' => 'SEN_Precio',
        'observaciones' => 'SEN_Observaciones',
        'agencia' => 'AGN_Nombre',
        'mini' => 'THM_Nombre'
    );
    $params = array();
    ($senMarc !== '') ? $params['senMarc'] = $senMarc : $params = $params;
    echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getSeminuevosByMarc($senMarc) {
    $sql = "SELECT *
            FROM camSeminuevos sen
            INNER JOIN camAgencias agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            INNER JOIN camCategorias cat
            ON sen.SEN_CAT_Id = cat.CAT_Id
            INNER JOIN camModelos mdo
            ON sen.SEN_MDO_Id = mdo.MDO_Id
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            INNER JOIN camThumb thm
            ON sen.SEN_THM_Id = thm.THM_Id
            WHERE SEN_MAR_Id = :senMarc
            ";
    getSeminuevosByMarcJSON($sql, $senMarc, '');
}

function getSeminuevosByModelJSON($sql, $senModel) {
    $structure = array(
        'id' => 'SEN_Id',
        'agencia' => 'AGN_Nombre',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'km' => 'SEN_Kilometraje',
        'transmision' => 'SEN_Transmision',
        'version' => 'SEN_Version',
        'interior' => 'SEN_Interior',
        'color_exterior' => 'SEN_ColorExterior',
        'precio' => 'SEN_Precio',
        'observaciones' => 'SEN_Observaciones',
        'agencia' => 'AGN_Nombre',
        'mini' => 'THM_Nombre'
    );
    $params = array();
    ($senModel !== '') ? $params['senModel'] = $senModel : $params = $params;
    echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getSeminuevosByModel($senModel) {
    $sql = "SELECT *
            FROM camSeminuevos sen
            INNER JOIN camAgencias agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            INNER JOIN camCategorias cat
            ON sen.SEN_CAT_Id = cat.CAT_Id
            INNER JOIN camModelos mdo
            ON sen.SEN_MDO_Id = mdo.MDO_Id
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            INNER JOIN camThumb thm
            ON sen.SEN_THM_Id = thm.THM_Id
            WHERE SEN_MDO_Id = :senModel
            ";
    getSeminuevosByModelJSON($sql, $senModel, '');
}

/*function getSemPicturesJSON($sql, $picId) {
    $structure = array(
        'id' => 'SEN_Id',
        'folder' => 'AGN_Folder',
        'foto' => 'PIC_Nombre'
    );
    $params = array();
    ($picId !== '') ? $params['picId'] = $picId : $params = $params;
    echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getSemPicturesById($picId) {
    $sql = "SELECT *
            FROM camSeminuevos sen
            INNER JOIN camAgencias agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            INNER JOIN camPictures pic
            ON sen.SEN_PIC_Id = pic.PIC_SEN_Id
            WHERE SEN_PIC_Id = :picId
            ";
    getSemPicturesJSON($sql, $picId, '');
}*/

function getMarca() {
    $sql = "SELECT *, COUNT(*) AS MAR_Number
            FROM camSeminuevos sen
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            GROUP BY MAR_Id
            ORDER BY MAR_Id ASC
            ";
    $structure = array(
        "marca" => array(
            'id_marc' => 'MAR_Id',
            'nombre_marc' => 'MAR_Nombre',
            "cantidad" => "MAR_Number"
        ),

    );
    $params = array();
    $orderBy = array();
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    $detail = array();
    $detail = multiLevelJSON($result, $structure, $orderBy);
    echo changeArrayIntoJSON('campa', $detail);
    //echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getModelo() {
    $sql = "SELECT *, COUNT(*) AS MAR_Number
            FROM camSeminuevos sen
            INNER JOIN camMarcas mrc
            ON sen.SEN_MAR_Id = mrc.MAR_Id
            INNER JOIN camModelos mdo
            ON sen.SEN_MDO_Id = mdo.MDO_Id
            GROUP BY MDO_Id, MAR_Id
            ORDER BY MAR_Id ASC
            ";
    /*$structure = array(
        'id_mdo' => 'MDO_Id',
        'nombre_mdo' => 'MDO_Nombre',
        'id_marc' => 'MAR_Id',
        'nombre_marc' => 'MAR_Nombre',
        'cantidad' => 'MAR_Number',
    );*/
    $structure = array(
        "modelo" => array(
            "id_mdo" => "MDO_Id",
            "id_marc" => "MAR_Id",
            'nombre_mdo' => 'MDO_Nombre',
            "cantidad" => "MAR_Number"
        )
    );
    $params = array();
    $orderBy = array();
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    $detail = array();
    $detail = multiLevelJSON($result, $structure, $orderBy);
    echo changeArrayIntoJSON('campa', $detail);
    //echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}
function getTransmision() {
    $sql = "SELECT *, COUNT(*) AS SEN_Number
            FROM camSeminuevos sen
            GROUP BY SEN_Transmision
            ORDER BY SEN_Id ASC
            ";
    /*$structure = array(
        'id_mdo' => 'MDO_Id',
        'nombre_mdo' => 'MDO_Nombre',
        'id_marc' => 'MAR_Id',
        'nombre_marc' => 'MAR_Nombre',
        'cantidad' => 'MAR_Number',
    );*/
    $structure = array(
        "modelo" => array(
            "transmision" => "SEN_Transmision",
            "id_sen" => "SEN_Id",
            "cantidad" => "SEN_Number"
        )
    );
    $params = array();
    $orderBy = array();
    $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    $detail = array();
    $detail = multiLevelJSON($result, $structure, $orderBy);
    echo changeArrayIntoJSON('campa', $detail);
    //echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
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
