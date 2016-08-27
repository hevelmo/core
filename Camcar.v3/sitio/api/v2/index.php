<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../../../incorporate/db_connect.php';
include '../../../incorporate/functions.php';
include '../../../incorporate/queryintojson.php';
include '../Mandrill.php';

sec_session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');

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


// POST route
    // SEND CONTACT
    $app->post('/contacto/seminuevos/premium', 'sendContactoSEMPREM');
    $app->post('/contacto/seminuevos/premium/modelo', 'sendContactoSEMPREMByModel');


// INSERT
//$app->post('/new/table', /*'mw1',*/ 'addTable');

// UPDATE
//$app->post('/set/table/:idTable', /*'mw1',*/ 'setTable');


// GET route

// SELECT
$app->get('/get/seminuevos/:mrc_nombre_short/:mdo_nombre_short/:senId', /*'mw1',*/ 'getSeminuevos');

$app->get('/get/categoria', /*'mw1',*/ 'getCategory');
$app->get('/get/categoria/:catId', /*'mw1',*/ 'getCategoryById');
$app->get('/get/marca/:idMrc', /*'mw1',*/ 'getCategoryByMarc');
$app->get('/get/modelo/:idCategory/:idMarc', /*'mw1',*/ 'getCategoryByModel');
$app->get('/get/seminuevos/filtros/:category/:marca/:modelo', /*'mw1',*/ 'getSeminuevosByFilter');
$app->get('/get/categoria/precio/:priceId', /*'mw1',*/ 'getCategoryPrice');
$app->get('/get/seminuevos/slider/:mrc_nombre_short/:mdo_nombre_short/:senId', /*'mw1',*/ 'getSeminuevosById');
$app->get('/get/seminuevos/marca/:senMarc', /*'mw1',*/ 'getSeminuevosByMarc');
$app->get('/get/seminuevos/modelo/:senModel', /*'mw1',*/ 'getSeminuevosByModel');
$app->get('/get/catalogo/:marId', /*'mw1',*/ 'getCatalogoByMarc');
$app->get('/get/marca', /*'mw1',*/ 'getMarca');
$app->get('/get/modelo', /*'mw1',*/ 'getModelo');
$app->get('/get/transmision', /*'mw1',*/ 'getTransmision');


// DELETE
//$app->get('/del/table/:idTable', /*'mw1',*/ 'delTable');
$app->run();

//Functions
    // Contacto SEMINUEVOS PREMIUM
    function sendContactoSEMPREM() {
        $property = requestBody();
        $sem_con_sp_name = $property->sem_premium_contact_name;
        $sem_con_sp_email = $property->sem_premium_contact_email;
        $sem_con_sp_message = $property->sem_premium_contact_message;
        $sem_con_sp_concesionarie = $property->sem_premium_contact_concessionary;

        sem_premium_contacto($sem_con_sp_name, $sem_con_sp_email, $sem_con_sp_message, $sem_con_sp_concesionarie);

        echo changeArrayIntoJSON("campa", array('process'=>'ok'));
    }
    // Contacto SEMINUEVOS PREMIUM BY MODEL
    function sendContactoSEMPREMByModel() {
        $property = requestBody();
        $sem_con_sp_bm_name = $property->sem_premium_by_model_contact_name;
        $sem_con_sp_bm_email = $property->sem_premium_by_model_contact_email;
        $sem_con_sp_bm_phone = $property->sem_premium_by_model_contact_phone;
        $sem_con_sp_bm_message = $property->sem_premium_by_model_contact_message;
        $sem_con_sp_bm_concessionary = $property->sem_premium_by_model_contact_concessionary;
        $sem_con_sp_bm_logo_seminuevos = $property->sem_premium_by_model_contact_logo_seminuevos;
        $sem_con_sp_bm_logo_agencia = $property->sem_premium_by_model_contact_logo_agencia;
        $sem_con_sp_bm_marc = $property->sem_premium_by_model_contact_marc;
        $sem_con_sp_bm_model = $property->sem_premium_by_model_contact_model;
        $sem_con_sp_bm_picture = $property->sem_premium_by_model_contact_picture;

        sem_premium_bymodel_contacto($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture);

        echo changeArrayIntoJSON("campa", array('process'=>'ok'));
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
/* Seminuevos */
    function getSeminuevos($mrc_nombre_short, $mdo_nombre_short, $senId) {
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
                ON sen.SEN_PIC_Id = pic.PIC_Id
                INNER JOIN camThumb thm
                ON sen.SEN_THM_Id = thm.THM_Id
                WHERE MAR_NombreShort = :mrc_nombre_short
                AND MDO_NombreShort = :mdo_nombre_short
                AND SEN_Id = :senId
                ";
        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'logo' => 'AGN_Logo',
            'categoria' => 'CAT_Nombre',
            'marca' => 'MAR_Nombre',
            'mrc_nombre' => 'MAR_NombreShort',
            'modelo' => 'MDO_Nombre',
            'mdo_nombre' => 'MDO_NombreShort',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'descripcion' => 'SEN_Descripcion',
            'directorio' => 'PIC_MDO_Folder',
            'foto' => 'PIC_Nombre',
            'thumb' => 'THM_Nombre'
        );
        $params = array();
        ($mrc_nombre_short !== '') ? $params['mrc_nombre_short'] = $mrc_nombre_short : $params = $params;
        ($mdo_nombre_short !== '') ? $params['mdo_nombre_short'] = $mdo_nombre_short : $params = $params;
        ($senId !== '') ? $params['senId'] = $senId : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
/**/
/* Seminuevos By ID */
    function getSeminuevosJSON($sql, $mrc_nombre_short, $mdo_nombre_short, $senId) {
        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'agencia' => 'AGN_Nombre',
            'logo' => 'AGN_Logo',
            'marca' => 'MAR_Nombre',
            'categoria' => 'CAT_Nombre',
            'modelo' => 'MDO_Nombre',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'descripcion' => 'SEN_Descripcion',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'directorio' => 'PIC_MDO_Folder',
            'foto' => 'PIC_Nombre'
        );
        $params = array();
        ($mrc_nombre_short !== '') ? $params['mrc_nombre_short'] = $mrc_nombre_short : $params = $params;
        ($mdo_nombre_short !== '') ? $params['mdo_nombre_short'] = $mdo_nombre_short : $params = $params;
        ($senId !== '') ? $params['senId'] = $senId : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getSeminuevosById($mrc_nombre_short, $mdo_nombre_short, $senId) {
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
                WHERE MAR_NombreShort = :mrc_nombre_short
                AND MDO_NombreShort = :mdo_nombre_short
                AND SEN_Id = :senId
                ";
        getSeminuevosJSON($sql, $mrc_nombre_short, $mdo_nombre_short, $senId);
    }
/**/
/* Carousel */
    function getCatalogoJSON($sql, $marId) {
        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'agencia' => 'AGN_Nombre',
            'logo' => 'AGN_Logo',
            'marca' => 'MAR_Nombre',
            'categoria' => 'CAT_Nombre',
            'modelo' => 'MDO_Nombre',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'thumb' => 'THM_Nombre'
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
/**/
/* FILTROS */
    //function getSeminuevosByFilter($category, $marca, $modelo, $yearStart, $yearFinal, $priceStart, $priceFinal) {
    function getSeminuevosByFilter($category, $marca, $modelo) {
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
                WHERE 1 = 1
                ";
        $params = array();

        if ($category) {
            $sql.= " AND SEN_CAT_Id = :category";
            $params["category"] = $category;
        }
        if ($marca) {
            $sql.= " AND SEN_MAR_Id = :marca";
            $params["marca"] = $marca;
        }
        if ($modelo) {
            $sql.= " AND SEN_MDO_Id = :modelo";
            $params["modelo"] = $modelo;
        }
        /*if ($yearStart && $yearFinal) {
            $sql.= " AND SEN_Year BETWEEN :yearStart AND :yearFinal";
            $params["yearStart"] = $yearStart;
            $params["yearFinal"] = $yearFinal;
        }
        if ($priceStart && $priceFinal) {
            $sql.= " AND SEN_Precio BETWEEN :priceStart AND :priceFinal";
            $params["priceStart"] = $priceStart;
            $params["priceFinal"] = $priceFinal;
        }*/

        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'agencia' => 'AGN_Nombre',
            'logo' => 'AGN_Logo',
            'marca' => 'MAR_Nombre',
            'mrc_nombre' => 'MAR_NombreShort',
            'categoria' => 'CAT_Nombre',
            'modelo' => 'MDO_Nombre',
            'mdo_nombre' => 'MDO_NombreShort',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'descripcion' => 'SEN_Descripcion',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'thumb' => 'THM_Nombre'
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // SELECT CATEGORY
        function getCategory() {
            $sql = "SELECT CAT_Id, CAT_Nombre FROM camCategorias cat";
            $structure = array(
                'id_cat' => 'CAT_Id',
                'categoria' => 'CAT_Nombre'
            );
            $params = array();
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
        function getCategoryJSON($sql, $catId) {
            $structure = array(
                'id' => 'SEN_Id',
                'id_cat' => 'CAT_Id',
                'id_marc' => 'MAR_Id',
                'agencia' => 'AGN_Nombre',
                'logo' => 'AGN_Logo',
                'marca' => 'MAR_Nombre',
                'categoria' => 'CAT_Nombre',
                'modelo' => 'MDO_Nombre',
                'year' => 'SEN_Year',
                'precio' => 'SEN_Precio',
                'cilindros' => 'SEN_Cilindros',
                'transmision' => 'SEN_Transmision',
                'color' => 'SEN_Color',
                'interior' => 'SEN_Interior',
                'agencia' => 'AGN_Nombre',
                'folder' => 'AGN_Folder',
                'thumb' => 'THM_Nombre'
            );
            $params = array();
            ($catId !== '') ? $params['catId'] = $catId : $params = $params;
            //var_dump($params);
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
        function getCategoryById($catId) {
            $sql = "SELECT * FROM camSeminuevos sen
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
                    WHERE SEN_CAT_Id = :catId
                    ORDER BY CAT_Id";
            getCategoryJSON($sql, $catId, '');
        }
    /****/
    // SELECT MARC
        function getCategoryByMarc($idMrc) {
            $sql = "SELECT MAR_Id, MAR_Nombre
                    FROM camSeminuevos sen
                    INNER JOIN camCategorias cat
                    ON sen.SEN_CAT_Id = cat.CAT_Id
                    INNER JOIN camMarcas mrc
                    ON sen.SEN_MAR_Id = mrc.MAR_Id
                    WHERE  SEN_CAT_Id = :idMrc
                    GROUP BY SEN_MAR_Id
                    ORDER BY MAR_Id
                    ";
            $structure = array(
                'id_marc' => 'MAR_Id',
                'marca' => 'MAR_Nombre'
            );
            $params = array();
            ($idMrc !== '') ? $params['idMrc'] = $idMrc : $params = $params;
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
        /*function getCategoryByMarcJSON($sql, $marcId) {
            $structure = array(
                'id' => 'SEN_Id',
                'id_cat' => 'CAT_Id',
                'agencia' => 'AGN_Nombre',
                'marca' => 'MAR_Nombre',
                'categoria' => 'CAT_Nombre',
                'modelo' => 'MDO_Nombre',
                'year' => 'SEN_Year',
                'precio' => 'SEN_Precio',
                'cilindros' => 'SEN_Cilindros',
                'transmision' => 'SEN_Transmision',
                'color' => 'SEN_Color',
                'interior' => 'SEN_Interior',
                'agencia' => 'AGN_Nombre',
                'folder' => 'AGN_Folder',
                'thumb' => 'THM_Nombre'
            );
            $params = array();
            ($marcId !== '') ? $params['marcId'] = $marcId : $params = $params;
            //var_dump($params);
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
        function getCategoryByMarcById($marcId) {
            $sql = "SELECT * FROM camSeminuevos sen
                    INNER JOIN camAgencias agn
                    ON sen.SEN_AGN_Id = agn.AGN_Id
                    INNER JOIN camCategorias cat
                    ON sen.SEN_CAT_Id = cat.CAT_Id
                    INNER JOIN camMarcas mrc
                    ON sen.SEN_MAR_Id = mrc.MAR_Id
                    INNER JOIN camModelos mdo
                    ON sen.SEN_MDO_Id = mdo.MDO_Id
                    INNER JOIN camThumb thm
                    ON sen.SEN_THM_Id = thm.THM_Id
                    WHERE SEN_MAR_Id = :marcId
                    ORDER BY SEN_MAR_Id
                    ";
            getCategoryByMarcJSON($sql, $marcId, '');
        }*/
    /****/
    // SELECT MODEL
        function getCategoryByModel($idCategory, $idMarc) {
            $sql = "SELECT MDO_Id, MDO_Nombre
                    FROM camSeminuevos sen
                    INNER JOIN camCategorias cat
                    ON sen.SEN_CAT_Id = cat.CAT_Id
                    INNER JOIN camMarcas mrc
                    ON sen.SEN_MAR_Id = mrc.MAR_Id
                    INNER JOIN camModelos mdo
                    ON sen.SEN_MDO_Id = mdo.MDO_Id
                    WHERE CAT_Id = :idCategory
                    AND MAR_Id = :idMarc
                    GROUP BY SEN_MDO_Id
                    ORDER BY CAT_Id, MAR_Id, MDO_Id
                    ";
            $structure = array(
                'id_model' => 'MDO_Id',
                'modelo' => 'MDO_Nombre'
            );
            $params = array();
            ($idCategory !== '') ? $params['idCategory'] = $idCategory : $params = $params;
            ($idMarc !== '') ? $params['idMarc'] = $idMarc : $params = $params;
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
    /****/
    // INPUTS YEAR
        function getCategoryByYearByIdJSON($sql, $senMinYear, $senMaxYear) {
            $structure = array(
                'id' => 'SEN_Id',
                'id_marc' => 'MAR_Id',
                'id_cat' => 'CAT_Id',
                'agencia' => 'AGN_Nombre',
                'logo' => 'AGN_Logo',
                'marca' => 'MAR_Nombre',
                'categoria' => 'CAT_Nombre',
                'modelo' => 'MDO_Nombre',
                'year' => 'SEN_Year',
                'precio' => 'SEN_Precio',
                'cilindros' => 'SEN_Cilindros',
                'transmision' => 'SEN_Transmision',
                'color' => 'SEN_Color',
                'interior' => 'SEN_Interior',
                'agencia' => 'AGN_Nombre',
                'folder' => 'AGN_Folder',
                'thumb' => 'THM_Nombre'
            );
            $params = array();
            ($senMinYear !== '') ? $params['senMinYear'] = $senMinYear : $params = $params;
            ($senMaxYear !== '') ? $params['senMaxYear'] = $senMaxYear : $params = $params;
            //var_dump($params);
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
        function getCategoryByYearById($senMinYear, $senMaxYear) {
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
            getCategoryByYearByIdJSON($sql, $senMinYear, $senMaxYear);
        }
        /*function getCategoryByYearById() {
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
                'id_cat' => 'CAT_Id',
                'agencia' => 'AGN_Nombre',
                'marca' => 'MAR_Nombre',
                'categoria' => 'CAT_Nombre',
                'modelo' => 'MDO_Nombre',
                'year' => 'SEN_Year',
                'precio' => 'SEN_Precio',
                'cilindros' => 'SEN_Cilindros',
                'transmision' => 'SEN_Transmision',
                'color' => 'SEN_Color',
                'interior' => 'SEN_Interior',
                'agencia' => 'AGN_Nombre',
                'folder' => 'AGN_Folder',
                'thumb' => 'THM_Nombre'
            );
            $params = array(
                'senMinYear' => '2008',
                'senMaxYear' => '2015'
            );
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }*/
    /****/
    // INPUTS PRICE
        function getCategoryPriceJSON($sql, $priceId) {
            $structure = array(
                'id' => 'SEN_Id',
                'id_marc' => 'MAR_Id',
                'id_cat' => 'CAT_Id',
                'agencia' => 'AGN_Nombre',
                'marca' => 'MAR_Nombre',
                'categoria' => 'CAT_Nombre',
                'modelo' => 'MDO_Nombre',
                'year' => 'SEN_Year',
                'precio' => 'SEN_Precio',
                'cilindros' => 'SEN_Cilindros',
                'transmision' => 'SEN_Transmision',
                'color' => 'SEN_Color',
                'interior' => 'SEN_Interior',
                'agencia' => 'AGN_Nombre',
                'folder' => 'AGN_Folder',
                'thumb' => 'THM_Nombre'
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

/**/

function getSeminuevosByMarcJSON($sql, $senMarc) {
    $structure = array(
        'id' => 'SEN_Id',
        'id_marc' => 'MAR_Id',
        'id_cat' => 'CAT_Id',
        'agencia' => 'AGN_Nombre',
        'logo' => 'AGN_Logo',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'precio' => 'SEN_Precio',
        'cilindros' => 'SEN_Cilindros',
        'transmision' => 'SEN_Transmision',
        'color' => 'SEN_Color',
        'interior' => 'SEN_Interior',
        'agencia' => 'AGN_Nombre',
        'folder' => 'AGN_Folder',
        'thumb' => 'THM_Nombre'
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
        'id_marc' => 'MAR_Id',
        'id_cat' => 'CAT_Id',
        'agencia' => 'AGN_Nombre',
        'marca' => 'MAR_Nombre',
        'categoria' => 'CAT_Nombre',
        'modelo' => 'MDO_Nombre',
        'year' => 'SEN_Year',
        'precio' => 'SEN_Precio',
        'cilindros' => 'SEN_Cilindros',
        'transmision' => 'SEN_Transmision',
        'color' => 'SEN_Color',
        'interior' => 'SEN_Interior',
        'agencia' => 'AGN_Nombre',
        'folder' => 'AGN_Folder',
        'thumb' => 'THM_Nombre'
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

// OLD Functions
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

/*
/*
  ----------------------------------------------------------------------------
  General Get Mandril
  ----------------------------------------------------------------------------
*/
function sem_premium_contacto($sem_con_sp_name, $sem_con_sp_email, $sem_con_sp_message, $sem_con_sp_concesionarie) {
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
                            background: rgba(225, 223, 223, 1) !important;
                            -moz-osx-font-smoothing: grayscale;
                            -webkit-font-smoothing: antialiased;
                            color: #777;
                            font-size: 14px;
                            line-height: 24px;
                            text-transform: uppercase;
                        }
                        .ExternalClass {
                            font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
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
                                            <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display: block; border: 0" border="0">
                                        </td>
                                        <td style="background-color: rgba(255, 255, 255, 1); border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                            <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td height="15" width="100">
                                                            <p style="display: inline-block; vertical-align: middle; color:#0000;font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase;">
                                                                '.$sem_con_sp_concesionarie.'
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="11">
                                            <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display: block; border: 0" border="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="78" width="11" style="background-color: rgba(72, 72, 72, 0.6)">
                                            <p style="display: block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase;">
                                                Contacto
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="11" valign="top" width="11">
                                            <img style="display:block;border:0" src="http://jaguar.medigraf.com.mx/img/shadow-left.png" border="0" class="CToWUd">
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
                                                            <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_name.'</span><br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="20" valign="top" width="150">
                                                            <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                Correo Electrónico:
                                                            </strong>
                                                        </td>
                                                        <td height="20" valign="top">
                                                            <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_email.'</span><br>
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
                                                            <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'.$sem_con_sp_message.'</span>
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
                                        <td height="11" valign="top" width="11">
                                            <img style="display:block;border:0" src="http://jaguar.medigraf.com.mx/img/shadow-right.png" border="0" class="CToWUd">
                                        </td>
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
            'subject' => $sem_con_sp_concesionarie,
            'from_email' => $sem_con_sp_email,
            'from_name' => $sem_con_sp_name,
            'to' => array(
                array(
                    'email' => 'heriberto@medigraf.com.mx',
                    'name' => $sem_con_sp_concesionarie,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'hevelmo060683@gmail.com'),
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
            'google_analytics_domains' => array('seminuevos.com'),
            'google_analytics_campaign' => 'contacto.hevelmo060683@gmail.com',
            'metadata' => array('website' => 'www.seminuevos.com'),

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
function sem_premium_bymodel_contacto($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture) {
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
                            background: rgba(225, 223, 223, 1) !important;
                            -moz-osx-font-smoothing: grayscale;
                            -webkit-font-smoothing: antialiased;
                            color: #777;
                            font-size: 14px;
                            line-height: 24px;
                            text-transform: uppercase;
                        }
                        .ExternalClass {
                            font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
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
                                            <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display: block; border: 0" border="0">
                                        </td>
                                        <td style="background-color: rgba(255, 255, 255, 1); border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                            <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td height="15" width="100">
                                                            <p style="display: inline-block; vertical-align: middle; color:#0000;font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 20px; text-align: center; padding: 0; text-transform: uppercase; margin: 0 auto; width: 100%;">
                                                                '.$sem_con_sp_bm_concessionary.'
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td width="11">
                                            <img src="http://jaguar.medigraf.com.mx/img/spacer.png" style="display: block; border: 0" border="0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" height="78" width="11" style="background-color: rgba(12, 18, 28, 1)">
                                            <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 55px; float: left;">
                                                <img src="http://seminuevos.medigraf.com.mx/'.$sem_con_sp_bm_logo_seminuevos.'" alt="Modelo" width="100">
                                            </p>
                                            <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-right: 55px; float: right;">
                                                <img src="http://seminuevos.medigraf.com.mx/img/'.$sem_con_sp_bm_logo_agencia.'" alt="Modelo" width="100">
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="11" valign="top" width="11">
                                            <img style="display:block;border:0" src="http://jaguar.medigraf.com.mx/img/shadow-left.png" border="0" class="CToWUd">
                                        </td>
                                        <td rowspan="2" style="border:1px solid #ebe9ea;border-top:0" bgcolor="#ffffff">
                                            <table style="padding:15px 60px 15px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                <tbody>
                                                    <tr>
                                                        <td height="20" valign="top" width="250">
                                                            <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                Marca:
                                                            </strong> <br>
                                                            <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_bm_marc.'</span><br>
                                                            <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                Modelo:
                                                            </strong> <br>
                                                            <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$sem_con_sp_bm_model.'</span><br>
                                                        </td>
                                                        <td height="20" valign="top">
                                                            <img src="http://seminuevos.medigraf.com.mx/img/'.$sem_con_sp_bm_picture.'" alt="Modelo" width="250">
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
                                        <td height="11" valign="top" width="11">
                                            <img style="display:block;border:0" src="http://jaguar.medigraf.com.mx/img/shadow-right.png" border="0" class="CToWUd">
                                        </td>
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
                    'email' => 'heriberto@medigraf.com.mx',
                    'name' => $sem_con_sp_bm_concessionary,
                    'type' => 'to'
                )
            ),
            'headers' => array('Reply-To' => 'hevelmo060683@gmail.com'),
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
            'google_analytics_domains' => array('seminuevos.com'),
            'google_analytics_campaign' => 'contacto.hevelmo060683@gmail.com',
            'metadata' => array('website' => 'www.seminuevos.com'),

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
