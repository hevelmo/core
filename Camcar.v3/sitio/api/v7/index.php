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
 * [Initial V 7.0]
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
    $app->post('/contacto/seminuevo/premium', 'sendContactoSEMPREM');
    $app->post('/contacto/seminuevo/premium/modelo', 'sendContactoSEMPREMByModel');


// INSERT
//$app->post('/new/table', /*'mw1',*/ 'addTable');

// UPDATE
//$app->post('/set/table/:idTable', /*'mw1',*/ 'setTable');


// GET route

// SELECT
    // Seminuevos
    $app->get('/get/seminuevos', /*'mw1',*/ 'getSeminuevos');
    $app->get('/get/seminuevos/:mrc_nombre_short/:mdo_nombre_short/:senId', /*'mw1',*/ 'getSeminuevosById');

    // Filtros
    $app->get('/get/seminuevos/filtros/:category/:marca/:modelo', /*'mw1',*/ 'getSeminuevosByFilter');

    // Pictures
    $app->get('/get/pictures/seminuevo', /*'mw1',*/ 'getPictures');
    $app->get('/get/pictures/seminuevo/:picId', /*'mw1',*/ 'getPicturesById');

    // Mapa
    $app->get('/get/mapa/seminuevo', /*'mw1',*/ 'getMap');
    $app->get('/get/mapa/seminuevo/:senId', /*'mw1',*/ 'getMapById');

    // Categoria
    $app->get('/get/categoria', /*'mw1',*/ 'getCategory');
    //$app->get('/get/categoria/:catId', /*'mw1',*/ 'getCategoryById');

    // Marca
    $app->get('/get/categoria/marcas/:idMrc', /*'mw1',*/ 'getCategoryByMarc');

    // Modelo
    $app->get('/get/categoria/modelos/:idCategory/:idMarc', /*'mw1',*/ 'getCategoryModelsByCategoryByMarc');

    // CAROUSEL
    $app->get('/get/catalogo/marcas/:marId', /*'mw1',*/ 'getCatalogoByMarc');

    // AGENCIES PRE-OWNED
    $app->get('/get/agencia/seminuevos', /*'mw1',*/ 'getAgenciesPreOwned');
    $app->get('/get/agencia/seminuevos/mapas/:agn_id', /*'mw1',*/ 'getAgenciesPreOwnedByMap');
    $app->get('/get/agencia/seminuevos/:agn_nombre/:agn_id', /*'mw1',*/ 'getAgenciesPreOwnedByAgencie');
    // AGENCIES NEWS
    $app->get('/get/agencia/nuevos', /*'mw1',*/ 'getAgenciesNews');
    $app->get('/get/agencia/nuevos/mapas/:agn_id', /*'mw1',*/ 'getAgenciesNewsByMap');
    $app->get('/get/agencia/nuevos/:agn_nombre/:agn_id', /*'mw1',*/ 'getAgenciesNewsByAgencie');

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
    // STRUCTURE SMINUEVOS JSON
    function getSeminuevosJSON($sql, $mrc_nombre_short, $mdo_nombre_short, $senId){//, $category, $marca, $modelo
        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'id_agencia' => 'AGN_Id',
            'id_cat' => 'CAT_Id',
            'id_model' => 'MDO_Id',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'descripcion' => 'SEN_Descripcion',
            'agencia' => 'AGN_Nombre',
            'agnAddress' => 'AGN_Direccion',
            'telefonos' => array(
                'agnTelefono' => 'TEL_Telefono'
            ),
            'llamanos' => array(
                'agnCall' => 'TEL_Call'
            ),
            'folder' => 'AGN_Folder',
            'logo' => 'AGN_Logo1',
            'url' => 'AGN_Url',
            'categoria' => 'CAT_Nombre',
            'marca' => 'MAR_Nombre',
            'mrc_nombre' => 'MAR_NombreShort',
            'modelo' => 'MDO_Nombre',
            'mdo_nombre' => 'MDO_NombreShort',
            'directorio' => 'PIC_MDO_Folder',
            'foto' => 'PIC_Nombre',
            'thumb' => 'THM_Nombre',
            'pic_id' => 'PIC_Id',
            'pic_nombre' => 'PIC_Nombre',
            'pic_mdo_folder' => 'PIC_MDO_Folder',
            'agencia_folder' => 'AGN_Folder',
            'mar_nombreshort' => 'MAR_NombreShort',
            'mdo_nombreshort' => 'MDO_NombreShort'
        );
        $params = array();

        // PARAMS SEMINUEVOS BY ID
        ($mrc_nombre_short !== '') ? $params['mrc_nombre_short'] = $mrc_nombre_short : $params = $params;
        ($mdo_nombre_short !== '') ? $params['mdo_nombre_short'] = $mdo_nombre_short : $params = $params;
        ($senId !== '') ? $params['senId'] = $senId : $params = $params;

        // PARAMS BY FILTERS
        /*($category !== '') ? $params['category'] = $category : $params = $params;
        ($marca !== '') ? $params['marca'] = $marca : $params = $params;
        ($modelo !== '') ? $params['modelo'] = $modelo : $params = $params;*/

        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // STRUCTURE SMINUEVOS BY FILTERS JSON
    function getSeminuevosByFilterJSON($sql, $category, $marca, $modelo){
        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'id_agencia' => 'AGN_Id',
            'id_cat' => 'CAT_Id',
            'id_model' => 'MDO_Id',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'descripcion' => 'SEN_Descripcion',
            'telefonos' => array(
                'agnTelefono' => 'TEL_Telefono'
            ),
            'llamanos' => array(
                'agnCall' => 'TEL_Call'
            ),
            'agencia' => 'AGN_Nombre',
            'agnAddress' => 'AGN_Direccion',
            'folder' => 'AGN_Folder',
            'logo' => 'AGN_Logo1',
            'categoria' => 'CAT_Nombre',
            'marca' => 'MAR_Nombre',
            'mrc_nombre' => 'MAR_NombreShort',
            'modelo' => 'MDO_Nombre',
            'mdo_nombre' => 'MDO_NombreShort',
            'directorio' => 'PIC_MDO_Folder',
            'foto' => 'PIC_Nombre',
            'thumb' => 'THM_Nombre',
            'pic_id' => 'PIC_Id',
            'pic_nombre' => 'PIC_Nombre',
            'pic_mdo_folder' => 'PIC_MDO_Folder',
            'mar_nombreshort' => 'MAR_NombreShort',
            'mdo_nombreshort' => 'MDO_NombreShort'
        );
        $params = array();

        // PARAMS BY FILTERS
        ($category !== '') ? $params['category'] = $category : $params = $params;
        ($marca !== '') ? $params['marca'] = $marca : $params = $params;
        ($modelo !== '') ? $params['modelo'] = $modelo : $params = $params;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        
        for($idx = 0; $idx < count($result); $idx++) {
            $result[$idx]['si_thumb'] = ($result[$idx]['thumb'] == 'thm_default_camcar.jpg') ? '' : '1';
        }

        echo changeArrayIntoJSON('campa', $result);
    }
    // STRUCTURE PICTURES JSON
    function getPicturesJSON($sql, $picId) {
        $structure = array(
            'sen_id' => 'SEN_Id',
            'agn_folder' => 'AGN_Folder',
            'pic_id' => 'PIC_Id',
            'pic_nombre' => 'PIC_Nombre',
            'pic_mdo_folder' => 'PIC_MDO_Folder',
        );
        $params = array();

        // PARAMS PICTURES BY ID
        ($picId !== '') ? $params['picId'] = $picId : $params = $params;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        
        for($idx = 0; $idx < count($result); $idx++) {
            $result[$idx]['si_pic'] = ($result[$idx]['pic_mdo_folder'] == 'default') ? '' : '1';
        }

        echo changeArrayIntoJSON('campa', $result);
    }
    // STRUCTURE MAP JSON
    function getMapJSON($sql, $senId) {
        $structure = array(
            'sen_id' => 'SEN_Id',
            'agn_nombre' => 'AGN_Nombre',
            'agn_direccion' => 'AGN_Direccion',
            'agn_folder' => 'AGN_Folder',
            'agn_logo' => 'AGN_Logo1',
            'agn_latitud' => 'AGN_MLatitud',
            'agn_longitud' => 'AGN_MLongitud'
        );
        $params = array();

        // PARAMS MAP BY ID
        ($senId !== '') ? $params['senId'] = $senId : $params = $params;

        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // STRUCTURE CATEGORY
    function getCategoryJSON($sql) {
        $structure = array(
            'id_cat' => 'CAT_Id',
            'categoria' => 'CAT_Nombre'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // STRUCTURE MARC
    function getCategoryByMarcJSON($sql, $idMrc) {
        $structure = array(
            'id_marc' => 'MAR_Id',
            'marca' => 'MAR_Nombre'
        );
        $params = array();
        ($idMrc !== '') ? $params['idMrc'] = $idMrc : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // STRUCTURE MODEL
    function getCategoryModelsByCategoryByMarcJSON($sql, $idCategory, $idMarc) {
        $structure = array(
            'id_model' => 'MDO_Id',
            'modelo' => 'MDO_Nombre'
        );
        $params = array();
        ($idCategory !== '') ? $params['idCategory'] = $idCategory : $params = $params;
        ($idMarc !== '') ? $params['idMarc'] = $idMarc : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // STRUCTURE CATALOGO BY ID MARC -> COROUSEL
    function getCatalogoJSON($sql, $marId) {
        $structure = array(
            'id' => 'SEN_Id',
            'id_marc' => 'MAR_Id',
            'agencia' => 'AGN_Nombre',
            'logo' => 'AGN_Logo1',
            'marca' => 'MAR_Nombre',
            'categoria' => 'CAT_Nombre',
            'modelo' => 'MDO_Nombre',
            'mrc_nombre' => 'MAR_NombreShort',
            'mdo_nombre' => 'MDO_NombreShort',
            'year' => 'SEN_Year',
            'precio' => 'SEN_Precio',
            'cilindros' => 'SEN_Cilindros',
            'transmision' => 'SEN_Transmision',
            'color' => 'SEN_Color',
            'interior' => 'SEN_Interior',
            'agencia' => 'AGN_Nombre',
            'folder' => 'AGN_Folder',
            'thumb' => 'THM_Nombre',
            'telefonos' => array(
                'agnTelefono' => 'TEL_Telefono'
            ),
            'llamanos' => array(
                'agnCall' => 'TEL_Call'
            )
        );
        $params = array();
        ($marId !== '') ? $params['marId'] = $marId : $params = $params;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        
        for($idx = 0; $idx < count($result); $idx++) {
            $result[$idx]['si_thumb'] = ($result[$idx]['thumb'] == 'thm_default_camcar.jpg') ? '' : '1';
        }

        echo changeArrayIntoJSON('campa', $result);
    }

    // STRUCTURE AGENCIES PRE OWNED
    // Get Agencies Pre-owned
    function getAgenciesPreOwnedJSON($sql) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agnurl' => 'AGN_Url',
            'agnsmall' => 'AGN_Small',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud',
            'agngmapurl' => 'AGN_MUrl'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getAgenciesPreOwnedByMapsJSON($sql, $agnid) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agndireccion' => 'AGN_Direccion',
            'agnfolder' => 'AGN_Folder',
            'agnlogo' => 'AGN_Logo1',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud'
        );
        $params = array();
        ($agnid !== '') ? $params['agnid'] = $agnid : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // Get Agencies Pre-owned by Agencies
    function getAgenciesPreOwnedByAgencieJSON($sql, $agn_nombre, $agn_id) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agndireccion' => 'AGN_Direccion',
            'agnTelefono' => 'TEL_Telefono',
            'agncall' => 'TEL_Call',
            'agnurl' => 'AGN_Url',
            'horarios' => array(
                'agnhrventas' => 'HRS_HVentas',
                'agnhrservicio' => 'HRS_HServicio',
                'agnhrrefaccion' => 'HRS_HRefacciones'
            ),
            'agnfolder' => 'AGN_Folder',
            'agnlogo' => 'AGN_Logo1',
            'agnfachada' => 'AGN_Fachada',
            'agnsmall' => 'AGN_Small',
            'sociales' => array(
                'agnwebsite' => 'SOC_WebSite',
                'agnface' => 'SOC_Facebook',
                'agntwit' => 'SOC_Twitter'
            ),
            'mapas' => array(
                'agnlatitud' => 'AGN_MLatitud',
                'agnlongitud' => 'AGN_MLongitud',
                'agngmapurl' => 'AGN_MUrl'
            )
        );
        $params = array();
        ($agn_nombre !== '') ? $params['agn_nombre'] = $agn_nombre : $params = $params;
        ($agn_id !== '') ? $params['agn_id'] = $agn_id : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }

    // STRUCTURE AGENCIES NEWS
    // Get Agencies News
    function getAgenciesNewsJSON($sql) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agnurl' => 'AGN_Url',
            'agnitem' => 'AGN_Item',
            'agnsmall' => 'AGN_Small',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud',
            'agngmapurl' => 'AGN_MUrl'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getAgenciesNewsByMapsJSON($sql, $agn_id) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agndireccion' => 'AGN_Direccion',
            'agnfolder' => 'AGN_Folder',
            'logo' => array(
                'agnlogo1' => 'AGN_Logo1',
                'agnlogo2' => 'AGN_Logo2'
            ),
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud'
        );
        $params = array();
        ($agn_id !== '') ? $params['agn_id'] = $agn_id : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // Get Agencies News by Agencies
    function getAgenciesNewsByAgencieJSON($sql, $agn_nombre, $agn_id) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agndireccion' => 'AGN_Direccion',
            'agntelefono' => 'TEL_Telefono',
            'agncall' => 'TEL_Call',
            'agnurl' => 'AGN_Url',
            'horarios' => array(
                'agnhrventas' => 'HRS_HVentas',
                'agnhrservicio' => 'HRS_HServicio',
                'agnhrrefaccion' => 'HRS_HRefacciones'
            ),
            'agnfolder' => 'AGN_Folder',
            'logotipos' => array(
                'agnlogo1' => 'AGN_Logo1',
                'agnlogo2' => 'AGN_Logo2'
            ),
            'agnfachada' => 'AGN_Fachada',
            'agnsmall' => 'AGN_Small',
            'sociales' => array(
                'agnwebsite' => 'SOC_WebSite',
                'agnface' => 'SOC_Facebook',
                'agntwit' => 'SOC_Twitter'
            ),
            'mapas' => array(
                'agnlatitud' => 'AGN_MLatitud',
                'agnlongitud' => 'AGN_MLongitud',
                'agngmapurl' => 'AGN_MUrl'
            )
        );
        $params = array();
        ($agn_nombre !== '') ? $params['agn_nombre'] = $agn_nombre : $params = $params;
        ($agn_id !== '') ? $params['agn_id'] = $agn_id : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // CONSULTA
    // SEMINUEVOS
    function getSeminuevos() {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camCategorias cat
                ON sen.SEN_CAT_Id = cat.CAT_Id
                INNER JOIN camModelos mdo
                ON sen.SEN_MDO_Id = mdo.MDO_Id
                INNER JOIN camMarcas mrc
                ON sen.SEN_MAR_Id = mrc.MAR_Id
                INNER JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id
                INNER JOIN camThumbs thm
                ON sen.SEN_Id = thm.THM_SEN_Id
                ";
        getSeminuevosJSON($sql, '', '', '');
    }
    // SEMINUEVOS BY ID
    function getSeminuevosById($mrc_nombre_short, $mdo_nombre_short, $senId) {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camHorarios hrs
                ON agn.AGN_Id = hrs.HRS_AGN_Id
                INNER JOIN camSociales soc
                ON agn.AGN_Id = soc.SOC_AGN_Id
                INNER JOIN camCategorias cat
                ON sen.SEN_CAT_Id = cat.CAT_Id
                INNER JOIN camModelos mdo
                ON sen.SEN_MDO_Id = mdo.MDO_Id
                INNER JOIN camMarcas mrc
                ON sen.SEN_MAR_Id = mrc.MAR_Id
                INNER JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id
                INNER JOIN camThumbs thm
                ON sen.SEN_Id = thm.THM_SEN_Id
                WHERE MAR_NombreShort = :mrc_nombre_short
                AND MDO_NombreShort = :mdo_nombre_short
                AND SEN_Id = :senId
                GROUP BY SEN_Id
                ";
        getSeminuevosJSON($sql, $mrc_nombre_short, $mdo_nombre_short, $senId);
    }
    // SEMINUEVOS BY FILTERS
    function getSeminuevosByFilter($category, $marca, $modelo) {
        $category = ($category) ? $category : '';
        $marca = ($marca) ? $marca : '';
        $modelo = ($modelo) ? $modelo : '';
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camCategorias cat
                ON sen.SEN_CAT_Id = cat.CAT_Id
                INNER JOIN camModelos mdo
                ON sen.SEN_MDO_Id = mdo.MDO_Id
                INNER JOIN camMarcas mrc
                ON sen.SEN_MAR_Id = mrc.MAR_Id
                INNER JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id
                INNER JOIN camThumbs thm
                ON sen.SEN_Id = thm.THM_Id
                WHERE 1 = 1
                ";
        $params = array();

        if ($category !== '') {
            $sql.= " AND SEN_CAT_Id = :category";
            $params["category"] = $category;
        }
        if ($marca !== '') {
            $sql.= " AND SEN_MAR_Id = :marca";
            $params["marca"] = $marca;
        }
        if ($modelo !== '') {
            $sql.= " AND SEN_MDO_Id = :modelo";
            $params["modelo"] = $modelo;
        }
        $sql.= "
                GROUP BY SEN_Id
                ORDER BY SEN_Id DESC
                ";
        getSeminuevosByFilterJSON($sql, $category, $marca, $modelo);
    }
    // PICTURES
    function getPictures() {
        $sql = "SELECT *
            FROM camPictures pic
            INNER JOIN camSeminuevos sen
            ON sen.SEN_Id = pic.PIC_SEN_Id
            INNER JOIN (
                SELECT * 
                FROM camAgencias
                WHERE AGN_Tipo = 0
            ) agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            GROUP BY PIC_Id
            ";
        getPicturesJSON($sql, '', '', '');
    }
    // PICTURES BY ID
    function getPicturesById($picId) {
        $sql = "SELECT *
            FROM camPictures pic
            INNER JOIN camSeminuevos sen
            ON sen.SEN_Id = pic.PIC_SEN_Id
            INNER JOIN (
                SELECT * 
                FROM camAgencias
                WHERE AGN_Tipo = 0
            ) agn
            ON sen.SEN_AGN_Id = agn.AGN_Id
            WHERE PIC_SEN_Id = :picId
            GROUP BY PIC_Id
            ";
        getPicturesJSON($sql, $picId);
    }
    // MAP
    function getMap() {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                ";
        getMapJSON($sql, '');
    }
    // MAP BY ID
    function getMapById($senId) {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                WHERE SEN_Id = :senId
                ";
        getMapJSON($sql, $senId);
    }
    // CATEGORY
    function getCategory() {
        $sql = "SELECT *
                FROM camCategorias cat
                ";
        getCategoryJSON($sql, '');
    }
    // MARC BY ID
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
        getCategoryByMarcJSON($sql, $idMrc);
    }
    // MODEL BY CATEGORY, BY MARC
    function getCategoryModelsByCategoryByMarc($idCategory, $idMarc) {
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
        getCategoryModelsByCategoryByMarcJSON($sql, $idCategory, $idMarc);
    }
    // CATALOGO BY ID MARC -> CAROUSEL
    function getCatalogoByMarc($marId) {
        $sql = "SELECT *
                FROM camSeminuevos sen
                INNER JOIN (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camCategorias cat
                ON sen.SEN_CAT_Id = cat.CAT_Id
                INNER JOIN camModelos mdo
                ON sen.SEN_MDO_Id = mdo.MDO_Id
                INNER JOIN camMarcas mrc
                ON sen.SEN_MAR_Id = mrc.MAR_Id
                INNER JOIN camThumbs thm
                ON sen.SEN_Id = thm.THM_Id
                WHERE SEN_MAR_Id = :marId
                ORDER BY MAR_Id
                ";
        getCatalogoJSON($sql, $marId);
    }

    // AGENCIES PRE-OWNED
    function getAgenciesPreOwned() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ";
        getAgenciesPreOwnedJSON($sql, '', '');
    }
    function getAgenciesPreOwnedByMap($agnid) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camHorarios hrs
                ON agn.AGN_Id = hrs.HRS_AGN_Id
                INNER JOIN camSociales soc
                ON agn.AGN_Id = soc.SOC_AGN_Id
                WHERE AGN_Id = :agnid
                ";
        getAgenciesPreOwnedByMapsJSON($sql, $agnid);
    }
    // AGENCIES PRE-OWNED BY AGENCIE
    function getAgenciesPreOwnedByAgencie($agn_nombre, $agn_id) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camHorarios hrs
                ON agn.AGN_Id = hrs.HRS_AGN_Id
                INNER JOIN camSociales soc
                ON agn.AGN_Id = soc.SOC_AGN_Id
                WHERE AGN_Id = :agn_id
                AND AGN_Url = :agn_nombre
                ORDER BY AGN_Id
                ";
        getAgenciesPreOwnedByAgencieJSON($sql, $agn_nombre, $agn_id);
    }

    // AGENCIES NEWS
    function getAgenciesNews() {
        $sql = "SELECT *
                FROM (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                ) agn
                ";
        getAgenciesNewsJSON($sql, '', '');
    }
    function getAgenciesNewsByMap($agn_id) {
        $sql = "SELECT *
                FROM (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                ) agn
                WHERE AGN_Id = :agn_id
                ";
        getAgenciesNewsByMapsJSON($sql, $agn_id);
    }
    // AGENCIES NEWS BY AGENCIES
    function getAgenciesNewsByAgencie($agn_nombre, $agn_id) {
        $sql = "SELECT *
                FROM (
                    SELECT * 
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                ) agn
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camHorarios hrs
                ON agn.AGN_Id = hrs.HRS_AGN_Id
                INNER JOIN camSociales soc
                ON agn.AGN_Id = soc.SOC_AGN_Id
                WHERE AGN_Id = :agn_id
                AND AGN_Url = :agn_nombre
                ORDER BY AGN_Id
                ";
        getAgenciesNewsByAgencieJSON($sql, $agn_nombre, $agn_id);
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
                    'email' => 'informacion@camcar.mx',
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
