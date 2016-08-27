<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../../../incorporate/db_connect.php';
include_once '../../../incorporate/functions.php';
include_once '../../../incorporate/queryintojson.php';
include_once '../../../incorporate/json-file-decode.class.php';
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
 * [Routes Deep V 15.0]
**/
// POST route
// INSERT
// UPDATE
// GET route
// SELECT
    // HOME SECTION BANNERS
    $app->get('/get/banners', /*'mw1',*/ 'getBanners');
    // HOME SECTION OUR BRANDS
    $app->get('/get/agencia/nuevos/marcas/logotipos', /*'mw1',*/ 'getBrandsLogos');
    // HOME SECTION GROUP COUNTER
    $app->get('/get/grupo/camcar', /*'mw1',*/ 'getGroupCounter');
    // MAPA
    $app->get('/get/mapa/seminuevo', /*'mw1',*/ 'getMapa');
    // MAPA BY ID
    $app->get('/get/mapa/seminuevo/:senId', /*'mw1',*/ 'getMapaById');
    // AGENTS MAP AGENCIES
    $app->get('/get/agencias/mapa', /*'mw1',*/ 'getAgentsMapAgencies');

    // AGENCIES NEWS
    // HOME -> BRANDS AGENCIES
    //$app->get('/get/agencia/nuevos/marcas/logotipos', /*'mw1',*/ 'getBrandsLogos');
    // AGENCIES NEWS -> PRINCIPAL AGENCIE
    $app->get('/get/agencia/nuevos/principal/:agn_name_agencia', /*'mw1',*/ 'getAgenciesNewsByTypeAgencie');
    // AGENCIES NEWS
    $app->get('/get/agencia/nuevos', /*'mw1',*/ 'getAgenciesNews');
    $app->get('/get/agencia/nuevos/:agpid', /*'mw1',*/ 'getAgenciesNewsById');
    $app->get('/get/agencia/nuevos/mapas/:agn_id', /*'mw1',*/ 'getAgenciesNewsByMap');
    $app->get('/get/agencia/nuevos/:agn_nombre/:agn_id', /*'mw1',*/ 'getAgenciesNewsByAgencie');
    // PRINCIPAL AGENCIE NEWS
    $app->get('/get/agencias/nuevos', /*'mw1',*/ 'getAgenciesNewsPrincipales');
    $app->get('/get/agencias/nuevos/:nombre', /*'mw1',*/ 'getAgenciesNewsPrincipalesByAgencia');
    // LOGOS AGENCIES NEWS PRINCIPAL
    $app->get('/get/logos/agencia/nuevos', /*'mw1',*/ 'getLogosAgenciesNews');

    // AGENCIES NEWS -> PRINCIPAL AGENCIE
    $app->get('/get/agencia/camiones/principal/:agn_name_agencia', /*'mw1',*/ 'getAgenciesTrucksByTypeAgencie');
    // AGENCIES TRUCKS
    $app->get('/get/agencia/camiones', /*'mw1',*/ 'getAgenciesTrucks');
    $app->get('/get/agencia/camiones/:agpid', /*'mw1',*/ 'getAgenciesTrucksById');
    $app->get('/get/agencia/camiones/mapas/:agn_id', /*'mw1',*/ 'getAgenciesTrucksByMap');
    $app->get('/get/agencia/camiones/:agn_nombre/:agn_id', /*'mw1',*/ 'getAgenciesTrucksByAgencie');
    // PRINCIPAL AGENCIE TRUCKS
    $app->get('/get/agencias/camiones', /*'mw1',*/ 'getAgenciesTrucksPrincipales');
    $app->get('/get/agencias/camiones/:nombre', /*'mw1',*/ 'getAgenciesTrucksPrincipalesByAgencia');
    // LOGOS AGENCIES TRUCKS PRINCIPAL
    $app->get('/get/logos/agencia/camiones', /*'mw1',*/ 'getLogosAgenciesTrucks');

    // AGENCIES PRE-OWNED
    $app->get('/get/agencia/seminuevos', /*'mw1',*/ 'getAgenciesPreOwned');
    $app->get('/get/agencia/seminuevos/mapas/:agn_id', /*'mw1',*/ 'getAgenciesPreOwnedByMap');
    $app->get('/get/agencia/seminuevos/:preowned_agn_url/:preowned_agn_id', /*'mw1',*/ 'getAgenciesPreOwnedByAgencie');

    // INVENTORIES PRE-OWNED
    $app->get('/get/seminuevos', /*'mw1',*/ 'getSeminuevos');
    $app->get('/get/seminuevos/:mrc_nombre_short/:mdo_nombre_short/:senId', /*'mw1',*/ 'getSeminuevosById');
    // FILTERS
    $app->get('/get/seminuevos/filtros/:category/:marca/:modelo', /*'mw1',*/ 'getSeminuevosByFilter');
    // PICTURES
    $app->get('/get/pictures/seminuevo', /*'mw1',*/ 'getPictures');
    $app->get('/get/pictures/seminuevo/:picId', /*'mw1',*/ 'getPicturesById');
    // CATEGORY
    $app->get('/get/categoria', /*'mw1',*/ 'getCategory');
    //$app->get('/get/categoria/:catId', /*'mw1',*/ 'getCategoryById');
    // BRANDS
    $app->get('/get/categoria/marcas/:idMrc', /*'mw1',*/ 'getCategoryByMarc');
    // MODELS
    $app->get('/get/categoria/modelos/:idCategory/:idMarc', /*'mw1',*/ 'getCategoryModelsByCategoryByMarc');
    // CAROUSEL
    $app->get('/get/catalogo/marcas/:marId', /*'mw1',*/ 'getCatalogoByMarc');

    // SECTION WORKSHOP
    $app->get('/get/talleres', /*'mw1',*/ 'getWorkshop');
    $app->get('/get/talleres/logos', /*'mw1',*/ 'getWorkshopBrands');

    // SECTION RENTAL
    $app->get('/get/rentas/:agnRental', /*'mw1',*/ 'getRental');

    // SECTION BLOG
    $app->get('/get/blog', /*'mw1',*/ 'getBlog');
    // SECTION BLOG BY NEWS
    $app->get('/get/blog/noticia/:blogAgenciaShort/:blogTituloShort/:blogId', /*'mw1',*/ 'getBlogByPost');

    // ABOUT US CONTAC FORM MAIN
    $app->post('/contacto', /*'mw1',*/ 'post_form_contact_main');
    $app->post('/contacto/modelo', /*'mw1',*/ 'post_form_contact_main_by_model');

    // JOB OPPORTUNITIES
    $app->post('/post/bolsa-de-trabajo', /*'mw1',*/ 'postJobOpportunities');

// DELETE
//$app->get('/del/table/:idTable', /*'mw1',*/ 'delTable');
$app->run();

//Functions
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
    // GET HOME SECTION BANNERS JSON
    function getBannersJSON ($sql) {
        $structure = array(
            'banId' => 'BAN_Id',
            'agnNombre' => 'BAN_AGN_Nombre',
            'banSrc650' => 'BAN_SRC650x277',
            'banSrc900' => 'BAN_SRC900x586',
            'banSrc1600' => 'BAN_SRC1600x900',
            'banTitle' => 'BAN_Title',
            'headingTextSub' => array(
                'subtitle01' => 'BAN_Subtitle01',
                'subtitle02' => 'BAN_Subtitle02',
                'subtitle03' => 'BAN_Subtitle03',
                'subtitle04' => 'BAN_Subtitle04',
            ),
            'banner_tipo' => 'BAN_Tipo',
            'primaryLinkurl' => 'BAN_PrimaryLinkUrl',
            'primaryLinkTitle' => 'BAN_PrimaryLinkSub'
        );
        $params = array();
        $result_link_container = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        for ($idx=0; $idx < count($result_link_container); $idx++) {
            $ban_target = $agn_type = $result_link_container[$idx]['banner_tipo'];
            $result_link_container[$idx]['target_noticia'] = ($agn_type != 'noticia' ) ? '' : '_self';
            $result_link_container[$idx]['target_sitio'] = ($agn_type != 'sitio' ) ? '' : '_blank';
            $result_link_container[$idx]['target_agencia'] = ($agn_type != 'agencia' ) ? '' : '_self';
            $result_link_container[$idx]['target_agencias'] = ($agn_type != 'agencias' ) ? '' : '_self';
            $result_link_container[$idx]['target_promo'] = ($agn_type != 'promo' ) ? '' : '_blank';
        }
        $json = changeArrayIntoJSON('campa', $result_link_container);
        echo $json;
        //echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // GET HOME SECTION BANNERS
    function getBanners() {
        $sql = "SELECT *
                FROM camBanners
                WHERE BAN_Status = 1
                ORDER BY BAN_Id DESC
                ";
        getBannersJSON($sql);
    }
    // GET HOME SECTION OUR BRANDS JSON
    function getBrandsLogosJSON ($sql) {
        $structure = array(
            'agn_id' => 'AGN_Id',
            'agn_index' => 'BRD_Index',
            'agn_ruta' => 'AGN_Url',
            'agn_nombre' => 'AGN_Nombre',
            'agp_agencia' => 'AGP_Agencia',
            'agp_short' => 'AGP_Short',
            'tipo' => 'AGN_Tipo',
            'logoId' => 'BRD_Id',
            'logoIndex' => 'BRD_Index',
            'agnPrincipal' => 'BRD_AGP_Id',
            'logo' => 'BRD_Logo',
            'agnBreadcrumb_name' => 'AGN_Breadcrumb_Nombre',
            'agnBreadcrumb_key' => 'AGN_Breadcrumb_Key'
        );
        $params = array();
        $result_agencie = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        for ($idx=0; $idx < count($result_agencie); $idx++) {
            $agn_type = $result_agencie[$idx]['tipo'];
            $result_agencie[$idx]['action-seminuevo'] = ($agn_type != 0 ) ? '' : 'seminuevo';
            $result_agencie[$idx]['action-nuevo'] = ($agn_type != 1 ) ? '' : 'nuevo';
            $result_agencie[$idx]['action-taller'] = ($agn_type != 2 ) ? '' : 'taller';
            $result_agencie[$idx]['action-rentas'] = ($agn_type != 3 ) ? '' : 'rentas';
        }
        $json = changeArrayIntoJSON('campa', $result_agencie);
        echo $json;
        //echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // GET HOME SECTION OUR BRANDS
    function getBrandsLogos() {
        $sql = "SELECT * FROM (
                    SELECT *
                    FROM camBrandsLogos
                    WHERE BRD_Status = 1
                ) brd
                LEFT JOIN (
                    SELECT *
                    FROM camAgenciasPrincipales
                ) agp
                ON agp.AGP_Id = brd.BRD_AGP_Id
                LEFT JOIN (
                    SELECT * 
                    FROM camAgencias
                ) agn
                ON agn.AGN_AGP_Id = agp.AGP_Id
                GROUP BY BRD_Id
                ORDER BY BRD_Index
                ";
        getBrandsLogosJSON($sql);
    }
    // GET HOME SECTION GROUP COUNTER JSON
    function getGroupCounterJSON ($sql) {
        $structure = array(
            'grupo_marcas' => 'GRU_Marcas',
            'grupo_agencias' => 'GRU_Agencias',
            'grupo_ciudades' => 'GRU_Ciudades',
            'grupo_profesionales' => 'GRU_Profesionales'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // GET HOME SECTION GROUP COUNTER
    function getGroupCounter () {
        $sql = "SELECT *
                FROM camGrupoCamcar
                ";
        getGroupCounterJSON($sql);
    }
    // STRUCTURE AGENTS MAP JSON
    function getMapaJSON($sql, $senId) {
        $structure = array(
            'sen_id' => 'SEN_Id',
            'agn_nombre' => 'AGN_Nombre',
            'agn_direccion' => 'AGN_Direccion',
            'agn_folder' => 'AGN_Folder',
            'agn_logo1' => 'AGN_Logo1',
            'agn_logo2' => 'AGN_Logo2',
            'agn_latitud' => 'AGN_MLatitud',
            'agn_longitud' => 'AGN_MLongitud',
            'map_url' => 'AGN_MUrl'
        );
        $params = array();
        // PARAMS MAP BY ID
        ($senId !== '') ? $params['senId'] = $senId : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // AGENCTS MAP AGENCIES JSON
    function getAgentsMapAgenciesJSON($sql) {
        $structure = array(
            'agn_id' => 'AGN_Id',
            'agn_nombre' => 'AGN_Nombre',
            'agn_direccion' => 'AGN_Direccion',
            'agn_folder' => 'AGN_Folder',
            'agn_logo1' => 'AGN_Logo1',
            'agn_logo2' => 'AGN_Logo2',
            'agn_latitud' => 'AGN_MLatitud',
            'agn_longitud' => 'AGN_MLongitud',
            'map_url' => 'AGN_MUrl'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // AGENTS MAP
    function getMapa() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camSeminuevos
                ) sen
                INNER JOIN (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Status = 1
                    AND AGN_IsMap_Agencia = 1
                ) agn
                GROUP BY AGN_Id";
        getMapaJSON($sql, '');
    }
    // AGENCTS MAP AGENCIES
    function getAgentsMapAgencies() {
        $sql = "SELECT * FROM camAgencias WHERE AGN_Status = 1 AND AGN_isMap_Agencia = 1";
        getAgentsMapAgenciesJSON($sql);
    }

    // AGENTS MAP BY ID
    function getMapaById($senId) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                INNER JOIN (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                WHERE SEN_Id = :senId";
        getMapaJSON($sql, $senId);
    }
    // AGENCIES NEWS
    function getAgenciesNewsJSON($sql, $agpid) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agpagencia' => 'AGP_Agencia',
            'agpshort' => 'AGP_Short',
            'agnnombre' => 'AGN_Nombre',
            'agnurl' => 'AGN_Url',
            'agnsmall' => 'AGN_Small',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud',
            'agngmapurl' => 'AGN_MUrl'
        );
        $params = array();
        ($agpid !== '') ? $params['agpid'] = $agpid : $params = $params;
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
    function getAgenciesNewsByAgencieJSON($sql, $agn_nombre, $agn_id) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agpagencia' => 'AGP_Agencia',
            'agpshort' => 'AGP_Short',
            'agnnombre' => 'AGN_Nombre',
            'agndireccion' => 'AGN_Direccion',
            'telefonos' => array(
                'ventas' => array(
                    'agntelefonoventaslinea1' => 'TEL_Telefono_Ventas_linea1',
                    'agntelefonoventaslinea2' => 'TEL_Telefono_Ventas_linea2',
                    'agncallventaslinea1' => 'TEL_Call_Ventas_linea1',
                    'agncallventaslinea2' => 'TEL_Call_Ventas_linea2'
                ),
                'servicios' => array(
                    'agntelefonoserviciolinea1' => 'TEL_Telefono_Servicio_linea1',
                    'agntelefonoserviciolinea2' => 'TEL_Telefono_Servicio_linea2',
                    'agncallserviciolinea1' => 'TEL_Call_Servicio_linea1',
                    'agncallserviciolinea2' => 'TEL_Call_Servicio_linea2'
                )
            ),
            'agnurl' => 'AGN_Url',
            'horarios' => array(
                'ventas' => array(
                    'agnhrventas' => 'HRS_HVentas'
                ),
                'servicios' => array(
                    'agnhrservicio' => 'HRS_HServicio'
                ),
                'refacciones' => array(
                    'agnhrrefaccion' => 'HRS_HRefacciones'
                )
            ),
            'agnfolder' => 'AGN_Folder',
            'logotipos' => array(
                'agnlogo1' => 'AGN_Logo1',
                'agnlogo2' => 'AGN_Logo2'
            ),
            'agnfachada' => 'AGN_Fachada',
            'agnsmall' => 'AGN_Small',
            'sociales' => array(
                'sitio_web' => array(
                    'agnwebsite' => 'SOC_WebSite'
                ),
                'facebook' => array(
                    'agntitle_facebook_cta1' => 'SOC_Facebok_Nombre_Cta1',
                    'agnfacebookcta1' => 'SOC_Facebook_Cta1',
                    'agntitle_facebook_cta2' => 'SOC_Facebok_Nombre_Cta2',
                    'agnfacebookcta2' => 'SOC_Facebook_Cta2'
                ),
                'twitter' => array(
                    'agntitle_twitter' => 'SOC_Nombre_Twitter',
                    'agntwitter' => 'SOC_Twitter'
                ),
                'instagram' => array(
                    'agntitle_instagram' => 'SOC_Instagram_Nombre_Cta1',
                    'agninstagram' => 'SOC_Instagram_Cta1'
                )
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
    function getAgenciesNews() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                ) agn
                INNER JOIN camAgenciasPrincipales agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                ";

        getAgenciesNewsJSON($sql, '');
    }
    function getAgenciesNewsById($agpid) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                    AND AGN_AGP_Id = :agpid
                ) agn
                INNER JOIN camAgenciasPrincipales agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                ";

        getAgenciesNewsJSON($sql, $agpid);
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
    function getAgenciasLogosJSON ($sql) {
        $structure = array(
            'agpid' => 'AGN_AGP_Id',
            'principal' => 'AGP_Logo',
            'brand' => 'BRD_Logo',
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getAgenciesNewsPrincipales() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                ) agn
                INNER JOIN (
                    SELECT *
                    FROM camAgenciasPrincipales
                 ) agp
                 INNER JOIN (
                    SELECT *
                    FROM camBrandsLogos
                 ) brd
                 ORDER BY AGN_AGP_Id";
        getAgenciasLogosJSON($sql);
    }
    // LOGO BRANDS AGENCIES NEWS
    function getLogosAgenciesNews() {
        $sql = "SELECT *
                FROM camAgenciasPrincipales agp
                INNER JOIN (
                    SELECT *
                    FROM camMarcasLogosAgencias
                ) mla
                ON agp.AGP_Id = mla.MLA_AGP_Id
                ORDER BY AGP_Index
                ";
        $params = array();
        $structure = array(
            'agencia_principal' => array(
                'agpid' => 'AGP_Id',
                'agpindex' => 'AGP_Index',
                'agpnombre' => 'AGP_Agencia',
                'agpshort' => 'AGP_Short',
                'logo' => 'AGP_Logo'
            ),
            'marcas' => array(
                'mlaid' => 'MLA_Id',
                'brand' => 'MLA_Logo',
                'mlastatus' => 'MLA_Status'
            )
        );
        $orderBy = array();
        $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        $result = multiLevelJSON($result, $structure, $orderBy);

        $counter = 1;

        for ($i=0; $i < count($result); $i++) {
            $tltip = ($counter <= 6) ? 'top' : 'down';
            $result[$i]['tltip'] = $tltip;

            $animate = ($counter <= 6) ? 'animation-slideUp' : 'animation-slideDown';
            $result[$i]['animate'] = $animate;

            $longmarcas = count($result[$i]['marcas']);
            $longcount = 0;

            foreach ($result[$i]['marcas'] as $marca) {
                if ($marca['mlastatus'] == 0) {
                    $longcount++;
                }
            }
            if ($longcount == $longmarcas) {
                $result[$i]['marcas'] = array();
            }

            $counter++;
        }

        echo changeArrayIntoJSON('campa', $result);
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
                INNER JOIN camAgenciasPrincipales agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                WHERE AGN_Id = :agn_id
                AND AGN_Url = :agn_nombre
                ORDER BY AGN_Id";
        getAgenciesNewsByAgencieJSON($sql, $agn_nombre, $agn_id);
    }
    // BRANDS AGENCIES NEWS BY NAME AGENCIE
    function getAgenciesNewsPrincipalesByAgencia($nombre) {
        $sql = "SELECT *
                FROM camAgenciasPrincipales agp
                INNER JOIN (
                    SELECT *
                    FROM camMarcasLogosAgencias
                ) mla
                ON agp.AGP_Id = mla.MLA_AGP_Id
                WHERE AGP_Agencia = :nombre
                ORDER BY AGP_Id, MLA_Logo
                ";
        $params = array();
        $structure = array(
            'agpid' => 'AGP_Id',
            'agpnombre' => 'AGP_Short'
        );
        ($nombre !== '') ? $params['nombre'] = $nombre : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // EVENT ALL AGENCIES BY TYPE AGENCIE
    function getAgenciesNewsByTypeAgencie($agn_name_agencia) {
        $sql = "SELECT *
                FROM camAgencias agn
                LEFT JOIN (
                    SELECT *
                    FROM camAgenciasPrincipales
                ) agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                WHERE AGP_Short = :agn_name_agencia
                AND AGN_Tipo = 1
                ";
        $params = array();
        $structure = array(
            'agn_id' => 'AGN_Id',
            'agp_id' => 'AGP_Id',
            'agn_agp_id' => 'AGN_AGP_Id',
            'agp_agencia' => 'AGP_Agencia',
            'agp_short' => 'AGP_Short',
            'tipo' => 'AGN_Tipo'
        );
        ($agn_name_agencia !== '') ? $params['agn_name_agencia'] = $agn_name_agencia : $params = $params;
        //($agn_type !== '') ? $params['agn_type'] = $agn_type : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }

    // AGENCIES TRUCKS
    function getAgenciesTrucksJSON($sql, $agpid) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agpagencia' => 'AGP_Agencia',
            'agpshort' => 'AGP_Short',
            'agnnombre' => 'AGN_Nombre',
            'agnurl' => 'AGN_Url',
            'agnsmall' => 'AGN_Small',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud',
            'agngmapurl' => 'AGN_MUrl'
        );
        $params = array();
        ($agpid !== '') ? $params['agpid'] = $agpid : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getAgenciesTrucksByMapsJSON($sql, $agn_id) {
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
    function getAgenciesTrucksByAgencieJSON($sql, $agn_nombre, $agn_id) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agpagencia' => 'AGP_Agencia',
            'agpshort' => 'AGP_Short',
            'agnnombre' => 'AGN_Nombre',
            'agndireccion' => 'AGN_Direccion',
            'telefonos' => array(
                'ventas' => array(
                    'agntelefonoventaslinea1' => 'TEL_Telefono_Ventas_linea1',
                    'agntelefonoventaslinea2' => 'TEL_Telefono_Ventas_linea2',
                    'agncallventaslinea1' => 'TEL_Call_Ventas_linea1',
                    'agncallventaslinea2' => 'TEL_Call_Ventas_linea2'
                ),
                'servicios' => array(
                    'agntelefonoserviciolinea1' => 'TEL_Telefono_Servicio_linea1',
                    'agntelefonoserviciolinea2' => 'TEL_Telefono_Servicio_linea2',
                    'agncallserviciolinea1' => 'TEL_Call_Servicio_linea1',
                    'agncallserviciolinea2' => 'TEL_Call_Servicio_linea2'
                )
            ),
            'agnurl' => 'AGN_Url',
            'horarios' => array(
                'ventas' => array(
                    'agnhrventas' => 'HRS_HVentas'
                ),
                'servicios' => array(
                    'agnhrservicio' => 'HRS_HServicio'
                ),
                'refacciones' => array(
                    'agnhrrefaccion' => 'HRS_HRefacciones'
                )
            ),
            'agnfolder' => 'AGN_Folder',
            'logotipos' => array(
                'agnlogo1' => 'AGN_Logo1',
                'agnlogo2' => 'AGN_Logo2'
            ),
            'agnfachada' => 'AGN_Fachada',
            'agnsmall' => 'AGN_Small',
            'sociales' => array(
                'sitio_web' => array(
                    'agnwebsite' => 'SOC_WebSite'
                ),
                'facebook' => array(
                    'agntitle_facebook_cta1' => 'SOC_Facebok_Nombre_Cta1',
                    'agnfacebookcta1' => 'SOC_Facebook_Cta1',
                    'agntitle_facebook_cta2' => 'SOC_Facebok_Nombre_Cta2',
                    'agnfacebookcta2' => 'SOC_Facebook_Cta2'
                ),
                'twitter' => array(
                    'agntitle_twitter' => 'SOC_Nombre_Twitter',
                    'agntwitter' => 'SOC_Twitter'
                )
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
    function getAgenciesTrucks() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                    AND AGN_IsAgencieTrucks = 1
                ) agn
                INNER JOIN camAgenciasPrincipales agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                ";

        getAgenciesTrucksJSON($sql, '');
    }
    function getAgenciesTrucksById($agpid) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                    AND AGN_AGP_Id = :agpid
                    AND AGN_IsAgencieTrucks = 1
                ) agn
                INNER JOIN camAgenciasPrincipales agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                ";

        getAgenciesTrucksJSON($sql, $agpid);
    }
    function getAgenciesTrucksByMap($agn_id) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                    AND AGN_IsAgencieTrucks = 1
                ) agn
                WHERE AGN_Id = :agn_id
                ";
        getAgenciesTrucksByMapsJSON($sql, $agn_id);
    }
    function getAgenciesTrucksPrincipales() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                    AND AGN_IsAgencieTrucks = 1
                ) agn
                INNER JOIN (
                    SELECT *
                    FROM camAgenciasPrincipales
                 ) agp
                 INNER JOIN (
                    SELECT *
                    FROM camBrandsLogos
                 ) brd
                 ORDER BY AGN_AGP_Id";
        getAgenciasLogosJSON($sql);
    }
    // LOGO BRANDS AGENCIES TRUCKS
    function getLogosAgenciesTrucks() {
        $sql = "SELECT *
                FROM camAgenciasPrincipales agp
                INNER JOIN (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_IsAgencieTrucks = 1
                    AND AGN_Tipo = 1
                    AND AGN_Status = 1
                ) agn
                ON agp.AGP_Id = agn.AGN_AGP_Id
                INNER JOIN (
                    SELECT *
                    FROM camMarcasLogosAgencias
                    WHERE MLA_IsTrucks = 1
                ) mla
                ON agp.AGP_Id = mla.MLA_AGP_Id
                ORDER BY AGP_Index
                ";
        $params = array();
        $structure = array(
            'agencia_principal' => array(
                'agnid' => 'AGN_Id',
                'agpid' => 'AGP_Id',
                'agpindex' => 'AGP_Index',
                'agpnombre' => 'AGP_Agencia',
                'agpshort' => 'AGP_Short',
                'logo' => 'AGN_Logo1',
                'agpagencia' => 'AGP_Agencia',
                'agpshort' => 'AGP_Short',
                'agnnombre' => 'AGN_Nombre',
                'agnurl' => 'AGN_Url'
            ),
            'marcas' => array(
                'mlaid' => 'MLA_Id',
                'brand' => 'MLA_Logo',
                'mlastatus' => 'MLA_Status'
            )
        );
        $orderBy = array();
        $result = generalQuery(getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        $result = multiLevelJSON($result, $structure, $orderBy);

        $counter = 1;

        for ($i=0; $i < count($result); $i++) {
            $tltip = ($counter <= 1) ? 'top' : 'none';
            $result[$i]['tltip'] = $tltip;

            $animate = ($counter <= 1) ? 'animation-slideUp' : 'animation-none';
            $result[$i]['animate'] = $animate;

            $longmarcas = count($result[$i]['marcas']);
            $longcount = 0;

            foreach ($result[$i]['marcas'] as $marca) {
                if ($marca['mlastatus'] == 0) {
                    $longcount++;
                }
            }
            if ($longcount == $longmarcas) {
                $result[$i]['marcas'] = array();
            }

            $counter++;
        }

        echo changeArrayIntoJSON('campa', $result);
    }
    // AGENCIES TRUCKS BY AGENCIES
    function getAgenciesTrucksByAgencie($agn_nombre, $agn_id) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 1
                    AND AGN_IsAgencieTrucks = 1
                ) agn
                INNER JOIN camTelefonos tel
                ON agn.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camHorarios hrs
                ON agn.AGN_Id = hrs.HRS_AGN_Id
                INNER JOIN camSociales soc
                ON agn.AGN_Id = soc.SOC_AGN_Id
                INNER JOIN camAgenciasPrincipales agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                WHERE AGN_Id = :agn_id
                AND AGN_Url = :agn_nombre
                ORDER BY AGN_Id";
        getAgenciesTrucksByAgencieJSON($sql, $agn_nombre, $agn_id);
    }
    // BRANDS AGENCIES TRUCKS BY NAME AGENCIE
    function getAgenciesTrucksPrincipalesByAgencia($nombre) {
        $sql = "SELECT *
                FROM camAgenciasPrincipales agp
                INNER JOIN (
                    SELECT *
                    FROM camMarcasLogosAgencias
                ) mla
                ON agp.AGP_Id = mla.MLA_AGP_Id
                WHERE AGP_Agencia = :nombre
                ORDER BY AGP_Id, MLA_Logo
                ";
        $params = array();
        $structure = array(
            'agpid' => 'AGP_Id',
            'agpnombre' => 'AGP_Short'
        );
        ($nombre !== '') ? $params['nombre'] = $nombre : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // EVENT ALL AGENCIES BY TYPE AGENCIE
    function getAgenciesTrucksByTypeAgencie($agn_name_agencia) {
        $sql = "SELECT *
                FROM camAgencias agn
                LEFT JOIN (
                    SELECT *
                    FROM camAgenciasPrincipales
                ) agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                WHERE AGP_Short = :agn_name_agencia
                AND AGN_Tipo = 1
                AND AGN_IsAgencieTrucks = 1
                ";
        $params = array();
        $structure = array(
            'agn_id' => 'AGN_Id',
            'agp_id' => 'AGP_Id',
            'agn_agp_id' => 'AGN_AGP_Id',
            'agp_agencia' => 'AGP_Agencia',
            'agp_short' => 'AGP_Short',
            'tipo' => 'AGN_Tipo'
        );
        ($agn_name_agencia !== '') ? $params['agn_name_agencia'] = $agn_name_agencia : $params = $params;
        //($agn_type !== '') ? $params['agn_type'] = $agn_type : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }

    // AGENICES PRE-OWNED
    function getAgenciesPreOwnedJSON($sql) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agnseudonimo' => 'AGN_Seudonimo',
            'agnurl' => 'AGN_Url',
            'agnsmall' => 'AGN_Small',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud',
            'agngmapurl' => 'AGN_MUrl'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getAgenciesPreOwned() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn";
        getAgenciesPreOwnedJSON($sql, '', '');
    }
    function getAgenciesPreOwnedByMapsJSON($sql, $agnid) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agnseudonimo' => 'AGN_Seudonimo',
            'agndireccion' => 'AGN_Direccion',
            'agnfolder' => 'AGN_Folder',
            'agnlogo' => 'AGN_Logo1',
            'agnlatitud' => 'AGN_MLatitud',
            'agnlongitud' => 'AGN_MLongitud',
            'agngmapurl' => 'AGN_MUrl'
        );
        $params = array();
        ($agnid !== '') ? $params['agnid'] = $agnid : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
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
                WHERE AGN_Id = :agnid";
        getAgenciesPreOwnedByMapsJSON($sql, $agnid);
    }
    // AGENCIES PRE-OWNED BY AGENCIE
    function getAgenciesPreOwnedByAgencieJSON($sql, $preowned_agn_url, $preowned_agn_id) {
        $structure = array(
            'agnid' => 'AGN_Id',
            'agnnombre' => 'AGN_Nombre',
            'agnseudonimo' => 'AGN_Seudonimo',
            'agndireccion' => 'AGN_Direccion',
            'telefonos' => array(
                'ventas' => array(
                    'agntelefonoventaslinea1' => 'TEL_Telefono_Ventas_linea1',
                    'agntelefonoventaslinea2' => 'TEL_Telefono_Ventas_linea2',
                    'agncallventaslinea1' => 'TEL_Call_Ventas_linea1',
                    'agncallventaslinea2' => 'TEL_Call_Ventas_linea2'
                ),
                'servicios' => array(
                    'agntelefonoserviciolinea1' => 'TEL_Telefono_Servicio_linea1',
                    'agntelefonoserviciolinea2' => 'TEL_Telefono_Servicio_linea2',
                    'agncallserviciolinea1' => 'TEL_Call_Servicio_linea1',
                    'agncallserviciolinea2' => 'TEL_Call_Servicio_linea2'
                )
            ),
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
                'sitio_web' => array(
                    'agnwebsite' => 'SOC_WebSite'
                ),
                'facebook' => array(
                    'agntitle_facebook_cta1' => 'SOC_Facebok_Nombre_Cta1',
                    'agnfacebookcta1' => 'SOC_Facebook_Cta1',
                    'agntitle_facebook_cta2' => 'SOC_Facebok_Nombre_Cta2',
                    'agnfacebookcta2' => 'SOC_Facebook_Cta2'
                ),
                'twitter' => array(
                    'agntitle_twitter' => 'SOC_Nombre_Twitter',
                    'agntwitter' => 'SOC_Twitter'
                )
            ),
            'mapas' => array(
                'agnlatitud' => 'AGN_MLatitud',
                'agnlongitud' => 'AGN_MLongitud',
                'agngmapurl' => 'AGN_MUrl'
            )
        );
        $params = array();
        ($preowned_agn_url !== '') ? $params['preowned_agn_url'] = $preowned_agn_url : $params = $params;
        ($preowned_agn_id !== '') ? $params['preowned_agn_id'] = $preowned_agn_id : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getAgenciesPreOwnedByAgencie($preowned_agn_url, $preowned_agn_id) {
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
                WHERE AGN_Id = :preowned_agn_id
                AND AGN_Url = :preowned_agn_url
                ORDER BY AGN_Id";
        getAgenciesPreOwnedByAgencieJSON($sql, $preowned_agn_url, $preowned_agn_id);
    }

    // INVENTORIES PRE-OWNED
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
            'email' => 'AGN_Mail',
            'telefonos' => array(
                'ventas' => array(
                    'agntelefonoventaslinea1' => 'TEL_Telefono_Ventas_linea1',
                    'agncallventaslinea1' => 'TEL_Call_Ventas_linea1'
                )
            ),
            'folder' => 'AGN_Folder',
            'logo' => 'AGN_Logo1',
            'url' => 'AGN_Url',
            'categoria' => 'CAT_Nombre',
            'marca' => 'MAR_Nombre',
            'mrc_nombre' => 'MAR_NombreShort',
            'modelo' => 'MDO_Nombre',
            'mdo_nombre' => 'MDO_NombreShort',
            'directorio' => 'PIC_Folder',
            'foto' => 'PIC_Nombre',
            'pic_id' => 'PIC_Id',
            'pic_nombre' => 'PIC_Nombre',
            'pic_mdo_folder' => 'PIC_Folder',
            'agencia_folder' => 'AGN_Folder',
            'mar_nombreshort' => 'MAR_NombreShort',
            'mdo_nombreshort' => 'MDO_NombreShort',
            'map_url' => 'AGN_MUrl'
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
                'ventas' => array(
                    'agntelefonoventaslinea1' => 'TEL_Telefono_Ventas_linea1',
                    'agncallventaslinea1' => 'TEL_Call_Ventas_linea1'
                )
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
            'directorio' => 'PIC_Folder',
            //'foto' => 'PIC_Nombre',
            'thumb' => 'PIC_Nombre',
            //'pic_id' => 'PIC_Id',
            //'pic_nombre' => 'PIC_Nombre',
            'pic_mdo_folder' => 'PIC_Folder',
            'mar_nombreshort' => 'MAR_NombreShort',
            'mdo_nombreshort' => 'MDO_NombreShort'
        );
        $params = array();

        // PARAMS BY FILTERS
        ($category !== '') ? $params['category'] = $category : $params = $params;
        ($marca !== '') ? $params['marca'] = $marca : $params = $params;
        ($modelo !== '') ? $params['modelo'] = $modelo : $params = $params;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

        echo changeArrayIntoJSON('campa', $result);
    }
    // STRUCTURE PICTURES JSON
    function getPicturesJSON($sql, $picId) {
        $structure = array(
            'sen_id' => 'SEN_Id',
            'agn_folder' => 'AGN_Folder',
            'pic_id' => 'PIC_Id',
            'pic_nombre' => 'PIC_Nombre',
            'pic_mdo_folder' => 'PIC_Folder',
        );
        $params = array();

        // PARAMS PICTURES BY ID
        ($picId !== '') ? $params['picId'] = $picId : $params = $params;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

        echo changeArrayIntoJSON('campa', $result);
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
            'pic_folder' => 'PIC_Folder',
            'thumb' => 'PIC_Nombre'
        );
        $params = array();
        ($marId !== '') ? $params['marId'] = $marId : $params = $params;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

        echo changeArrayIntoJSON('campa', $result);
    }
    // SEMINUEVOS
    function getSeminuevos() {
        $sql = "SELECT sen.*, tel.*, pic.PIC_Id,
                       COALESCE(pic.PIC_Nombre, 'default_camcar.jpg') PIC_Nombre,
                       COALESCE(pic.PIC_SEN_Id, 'default') PIC_Folder
                FROM (
                    SELECT *
                    FROM v_camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                INNER JOIN camTelefonos tel
                ON sen.AGN_Id = tel.TEL_AGN_Id
                LEFT JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id";
        getSeminuevosJSON($sql, '', '', '');
    }
    // SEMINUEVOS BY ID
    function getSeminuevosById($mrc_nombre_short, $mdo_nombre_short, $senId) {
        $sql = "SELECT sen.*, tel.*, hrs.*, soc.*,
                       pic.PIC_Id,
                       COALESCE(pic.PIC_Nombre, 'default_camcar.jpg') PIC_Nombre,
                       COALESCE(pic.PIC_SEN_Id, 'default') PIC_Folder
                FROM (
                    SELECT *
                    FROM v_camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                INNER JOIN camTelefonos tel
                ON sen.AGN_Id = tel.TEL_AGN_Id
                INNER JOIN camHorarios hrs
                ON sen.AGN_Id = hrs.HRS_AGN_Id
                INNER JOIN camSociales soc
                ON sen.AGN_Id = soc.SOC_AGN_Id
                LEFT JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id
                WHERE MAR_NombreShort = :mrc_nombre_short
                AND MDO_NombreShort = :mdo_nombre_short
                AND SEN_Id = :senId
                GROUP BY SEN_Id";
        getSeminuevosJSON($sql, $mrc_nombre_short, $mdo_nombre_short, $senId);
    }
    // SEMINUEVOS BY FILTERS
    function getSeminuevosByFilter($category, $marca, $modelo) {
        $category = ($category) ? $category : '';
        $marca = ($marca) ? $marca : '';
        $modelo = ($modelo) ? $modelo : '';
        $sql = "SELECT sen.*, tel.*,
                       thm.PIC_Id,
                       COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') PIC_Nombre,
                       COALESCE(thm.PIC_SEN_Id, 'default') PIC_Folder
                FROM (
                    SELECT *
                    FROM v_camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                INNER JOIN camTelefonos tel
                ON sen.AGN_Id = tel.TEL_AGN_Id
                LEFT JOIN (
                    SELECT *
                    FROM camPictures
                    WHERE PIC_Thum = 1
                ) thm
                ON sen.SEN_Id = thm.PIC_SEN_Id
                WHERE 1 = 1";
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
        $sql.= " GROUP BY SEN_Id
                ORDER BY SEN_Id DESC";
        getSeminuevosByFilterJSON($sql, $category, $marca, $modelo);
    }
    // PICTURES
    function getPictures() {
        $sql = "SELECT sen.*, agn.*,
                       pic.PIC_Id,
                       COALESCE(pic.PIC_Nombre, 'default_camcar.jpg') PIC_Nombre,
                       COALESCE(pic.PIC_SEN_Id, 'default') PIC_Folder
                FROM (
                    SELECT *
                    FROM camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                INNER JOIN (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                LEFT JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id
                GROUP BY PIC_Id";
        getPicturesJSON($sql, '', '', '');
    }
    // PICTURES BY ID
    function getPicturesById($picId) {
        $sql = "SELECT sen.*, agn.*,
                       pic.PIC_Id,
                       COALESCE(pic.PIC_Nombre, 'default_camcar.jpg') PIC_Nombre,
                       COALESCE(pic.PIC_SEN_Id, 'default') PIC_Folder
                FROM (
                    SELECT *
                    FROM camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                INNER JOIN (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 0
                ) agn
                ON sen.SEN_AGN_Id = agn.AGN_Id
                LEFT JOIN camPictures pic
                ON sen.SEN_Id = pic.PIC_SEN_Id
                WHERE SEN_Id = :picId";
        getPicturesJSON($sql, $picId);
    }
    // CATEGORY
    function getCategory() {
        $sql = "SELECT *
                FROM v_camSeminuevos
                GROUP BY CAT_Id
                ORDER BY CAT_Nombre ASC";
        getCategoryJSON($sql, '');
    }
    // MARC BY ID
    function getCategoryByMarc($idMrc) {
        $sql = "SELECT MAR_Id, MAR_Nombre
                FROM (
                    SELECT *
                    FROM v_camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                WHERE  SEN_CAT_Id = :idMrc
                GROUP BY SEN_MAR_Id
                ORDER BY MAR_Id";
        getCategoryByMarcJSON($sql, $idMrc);
    }
    // MODEL BY CATEGORY, BY MARC
    function getCategoryModelsByCategoryByMarc($idCategory, $idMarc) {
        $sql = "SELECT MDO_Id, MDO_Nombre
                FROM (
                    SELECT *
                    FROM v_camSeminuevos
                    WHERE SEN_Status = 1
                ) sen
                WHERE CAT_Id = :idCategory
                AND MAR_Id = :idMarc
                GROUP BY SEN_MDO_Id
                ORDER BY CAT_Id, MAR_Id, MDO_Id";
        getCategoryModelsByCategoryByMarcJSON($sql, $idCategory, $idMarc);
    }
    // CATALOGO BY ID MARC -> CAROUSEL
    function getCatalogoByMarc($marId) {
        $sql = "SELECT sen.*, tel.*, thm.PIC_Id,
                       COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') PIC_Nombre,
                       COALESCE(thm.PIC_SEN_Id, 'default') PIC_Folder
                       FROM (
                        SELECT *
                        FROM v_camSeminuevos
                        WHERE SEN_Status = 1
                    ) sen
                INNER JOIN camTelefonos tel
                ON sen.AGN_Id = tel.TEL_AGN_Id
                LEFT JOIN (
                    SELECT *
                    FROM camPictures
                    WHERE PIC_Thum = 1
                ) thm
                ON sen.SEN_Id = thm.PIC_SEN_Id
                WHERE SEN_MAR_Id = :marId
                ORDER BY MAR_Id";
        getCatalogoJSON($sql, $marId);
    }

    // WORKSHOP
    function getWorkshop() {
        $sql_agencias = "SELECT *
                        FROM (
                            SELECT *
                            FROM camAgencias
                            WHERE AGN_Tipo = 2
                        ) agn
                        ORDER BY AGN_Index
                        ";
        $sql_telefonos ="SELECT *
                        FROM camTelefonos
                        WHERE TEL_AGN_Id = :telefonos
                        ";
        $sql_horarios ="SELECT *
                        FROM camHorarios
                        WHERE HRS_AGN_Id = :horarios
                        ";
        $sql_sociales = "SELECT *
                        FROM camSociales
                        WHERE SOC_AGN_Id = :sociales
                        ";
        $params_agencias = array();
        $structure_agencias = array(
            'agnId' => 'AGN_Id',
            'agpid' => 'AGN_AGP_Id',
            'agnTipo' => 'AGN_Tipo',
            'agnNombre' => 'AGN_Nombre',
            'agnDireccion' => 'AGN_Direccion',
            'agnSmall' => 'AGN_Small'
        );
        $structure_telefonos = array(
            'ventas' => array(
                'agntelefonoventaslinea1' => 'TEL_Telefono_Ventas_linea1'
            )
        );
        $structure_horarios = array(
            'hrsId' => 'HRS_AGN_Id',
            'ventas' => 'HRS_HVentas',
            'refacciones' => 'HRS_HRefacciones',
            'servicios' => 'HRS_HServicio'
        );
        $structure_sociales = array(
            'socId' => 'SOC_AGN_Id',
            'website' => 'SOC_WebSite'
        );

        $result_agencias = restructureQuery($structure_agencias, getConnection(), $sql_agencias, $params_agencias, 0, PDO::FETCH_ASSOC);

        for ($idx=0; $idx < count($result_agencias); $idx++) {
            $agnId = $result_agencias[$idx]['agnId'];

            $result_agencias[$idx]['columns'] = ($idx % 2 === 0) ? 'col-md-offset-7 col-sm-offset-6' : '';
            $result_agencias[$idx]['textAlign'] = ($idx % 2 === 0) ? 'text-left' : 'text-right';
            $result_agencias[$idx]['direction'] = ($idx % 2 === 0) ? 'pull-left' : 'pull-right';

            // TELEFONOS
            $params_telefonos = array(
                'telefonos' => $agnId
            );

            $result_telefonos = generalQuery(getConnection(), $sql_telefonos, $params_telefonos, 0, PDO::FETCH_ASSOC);

            $result_telefonos = (count($result_telefonos) > 0)
                ? restructureRow($result_telefonos[0], $structure_telefonos)
                : array();

            $result_agencias[$idx]['telefonos'] = $result_telefonos;

            // HORARIOS
            $params_horarios = array(
                'horarios' => $agnId
            );

            $result_horarios = generalQuery(getConnection(), $sql_horarios, $params_horarios, 0, PDO::FETCH_ASSOC);

            $result_horarios = (count($result_horarios) > 0)
                ? restructureRow($result_horarios[0], $structure_horarios)
                : array();

            $result_agencias[$idx]['horarios'] = $result_horarios;

            // SOCIALES
            $params_sociales = array(
                'sociales' => $agnId
            );

            $result_sociales = generalQuery(getConnection(), $sql_sociales, $params_sociales, 0, PDO::FETCH_ASSOC);

            $result_sociales = (count($result_sociales) > 0)
                ? restructureRow($result_sociales[0], $structure_sociales)
                : array();

            $result_agencias[$idx]['sociales'] = $result_sociales;
        }

        //$result = restructureArray($result, $structure);

        $json = changeArrayIntoJSON('campa', $result_agencias);

        $json = str_replace('"sociales":[]', '"sociales":{}', $json);

        echo $json;
    }
    function getWorkshopBrands() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camAgencias
                    WHERE AGN_Tipo = 2
                    GROUP BY AGN_Logo1
                ) agn
                ORDER BY AGN_Index
                ";
        $params = array();
        $structure = array(
            'agnId' => 'AGN_Id',
            'agnTipo' => 'AGN_Tipo',
            'agnlogo1' => 'AGN_Logo1'
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }

    // RENTAL
    function getRental() {
        $sql_agencias = "SELECT *
                        FROM (
                            SELECT *
                            FROM camAgencias
                            WHERE AGN_Tipo = 3
                        ) agn
                        ";
        $sql_telefonos ="SELECT *
                        FROM camTelefonos
                        WHERE TEL_AGN_Id = :telefonos
                        ";
        $sql_sociales ="SELECT *
                        FROM camSociales
                        WHERE SOC_AGN_Id = :sociales
                        ";
        $params_agencias = array();
        $structure_agencias = array(
            'agnId' => 'AGN_Id',
            'agpid' => 'AGN_AGP_Id',
            'agnTipo' => 'AGN_Tipo',
            'agnNombre' => 'AGN_Nombre',
            'agnUrl' => 'AGN_Url',
            'agnDireccion' => 'AGN_Direccion',
            'agnSmall' => 'AGN_Small',
            'agnBreadcrumb' => 'AGN_Breadcrumb_Nombre'
        );
        $structure_telefonos = array(
            'telId' => 'TEL_AGN_Id',
            'telefono' => 'TEL_Telefono_Ventas_linea1',
            'call' => 'TEL_Call_Ventas_linea1'
        );
        $structure_sociales = array(
            'socId' => 'SOC_AGN_Id',
            'website' => 'SOC_WebSite'
        );

        $result_agencias = restructureQuery($structure_agencias, getConnection(), $sql_agencias, $params_agencias, 0, PDO::FETCH_ASSOC);

        for ($idx=0; $idx < count($result_agencias); $idx++) {
            $agnId = $result_agencias[$idx]['agnId'];

            $result_agencias[$idx]['columns'] = ($idx % 2 === 0) ? 'col-md-offset-7 col-sm-offset-6' : '';
            $result_agencias[$idx]['textAlign'] = ($idx % 2 === 0) ? 'text-left' : 'text-right';
            $result_agencias[$idx]['direction'] = ($idx % 2 === 0) ? 'pull-left' : 'pull-right';

            // TELEFONOS
            $params_telefonos = array(
                'telefonos' => $agnId
            );

            $result_telefonos = generalQuery(getConnection(), $sql_telefonos, $params_telefonos, 0, PDO::FETCH_ASSOC);

            $result_telefonos = (count($result_telefonos) > 0)
                ? restructureRow($result_telefonos[0], $structure_telefonos)
                : array();

            $result_agencias[$idx]['telefonos'] = $result_telefonos;

            // SOCIALES
            $params_sociales = array(
                'sociales' => $agnId
            );
            $result_sociales = generalQuery(getConnection(), $sql_sociales, $params_sociales, 0, PDO::FETCH_ASSOC);

            $result_sociales = (count($result_sociales) > 0)
                ? restructureRow($result_sociales[0], $structure_sociales)
                : array();

            $result_agencias[$idx]['sociales'] = $result_sociales;
        }

        $json = changeArrayIntoJSON('campa', $result_agencias);

        echo $json;
    }

    // BLOG JSON
    function getBlogJSON($sql) {
        $structure = array(
            'blogId' => 'BLG_Id',
            'blogTitulo' => 'BLG_Titulo',
            'blogTituloShort' => 'BLG_TituloShort',
            'blogSubTitulo' => 'BLG_SubTitulo',
            'blogFeatureImage' => 'BLG_PostImage',
            'blogSmallTitulo' => 'BLG_SmallTitulo',
            'blogSmallDescripcion' => 'BLG_SmallDescripcion',
            'blogDescripcion' => 'BLG_Descripcion',
            'blogPostParrafo1' => 'BLG_BlogPostParrafo1',
            'blogPostParrafo2' => 'BLG_BlogPostParrafo2',
            'blogPostSubTitulo' => 'BLG_BlogPostSubTitulo',
            'blogPostFeatureImage1' => 'BLG_BlogPostFeatureImage1',
            'blogPostFeatureImage2' => 'BLG_BlogPostFeatureImage2',
            'blogPostBlockquote' => 'BLG_BlogPostBlockquote',
            'blogAgencia' => 'BLG_Agencia',
            'blogAgenciaShort' => 'BLG_AgenciaShort',
            'blogSmall' => 'BLG_Small',
            'blogPrimaryLinkUrl' => 'BLG_PrimaryLinkUrl',
            'blogPrimaryLinkName' => 'BLG_PrimaryLinkName',
            'blogPublicacion' => 'BLG_Publicacion'
        );
        $params = array();
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    function getBlogByPostJSON($sql, $blogAgenciaShort, $blogTituloShort, $blogId) {
        $structure = array(
            'blogId' => 'BLG_Id',
            'blogTitulo' => 'BLG_Titulo',
            'blogTituloShort' => 'BLG_TituloShort',
            'blogSubTitulo' => 'BLG_SubTitulo',
            'blogFeatureImage' => 'BLG_PostImage',
            'blogSmallTitulo' => 'BLG_SmallTitulo',
            'blogSmallDescripcion' => 'BLG_SmallDescripcion',
            'blogDescripcion' => 'BLG_Descripcion',
            'blogPostParrafo1' => 'BLG_BlogPostParrafo1',
            'blogPostParrafo2' => 'BLG_BlogPostParrafo2',
            'blogPostSubTitulo' => 'BLG_BlogPostSubTitulo',
            'blogPostFeatureImage1' => 'BLG_BlogPostFeatureImage1',
            'blogPostFeatureImage2' => 'BLG_BlogPostFeatureImage2',
            'blogPostBlockquote' => 'BLG_BlogPostBlockquote',
            'blogAgencia' => 'BLG_Agencia',
            'blogAgenciaShort' => 'BLG_AgenciaShort',
            'blogSmall' => 'BLG_Small',
            'blogPrimaryLinkUrl' => 'BLG_PrimaryLinkUrl',
            'blogPrimaryLinkName' => 'BLG_PrimaryLinkName',
            'blogPublicacion' => 'BLG_Publicacion',
            'blogSubFolder' => 'BLG_SubFolder',
            'blogGaleria' => 'GAL_Galeria',
            'blogVideo' => 'VDO_Video',
            'agencias' => array(
                'blogAddress' => 'BLG_Address'
            )
        );
        $params = array();
        ($blogAgenciaShort !== '') ? $params['blogAgenciaShort'] = $blogAgenciaShort : $params = $params;
        ($blogTituloShort !== '') ? $params['blogTituloShort'] = $blogTituloShort : $params = $params;
        ($blogId !== '') ? $params['blogId'] = $blogId : $params = $params;
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }
    // GET BLOG
    function getBlog() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camBlog
                    WHERE BLG_Status = 1
                    ORDER BY BLG_Id
                    DESC
                ) blg
                ";
        getBlogJSON($sql);
    }
    // GET BLOG BY POST
    function getBlogByPost($blogAgenciaShort, $blogTituloShort, $blogId) {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camBlog
                    WHERE BLG_AgenciaShort = :blogAgenciaShort
                    AND BLG_TituloShort = :blogTituloShort
                    AND BLG_Id = :blogId
                ) blg
                LEFT JOIN (
                    SELECT *
                    FROM camBlogGaleria
                ) gal
                ON blg.BLG_Id = gal.GAL_BLG_Id
                LEFT JOIN (
                    SELECT *
                    FROM camBlogVideos
                ) vdo
                ON blg.BLG_Id = vdo.VDO_BLG_Id
                ";
        getBlogByPostJSON($sql, $blogAgenciaShort, $blogTituloShort, $blogId);
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

    // CONTACT MAIN
    function post_form_contact_main() {
        $property = requestBody();
        $contact_main_name = $property->contact_main_name;
        $contact_main_email = $property->contact_main_email;
        $contact_main_message = $property->contact_main_message;

        contact_main($contact_main_name, $contact_main_email, $contact_main_message);

        echo changeArrayIntoJSON("campa", array('process'=>'ok'));
    }
    // Contacto SEMINUEVOS PREMIUM BY MODEL
    function post_form_contact_main_by_model() {
        $property = requestBody();
        $sem_con_sp_bm_name = $property->sem_premium_by_model_contact_name;
        $sem_con_sp_bm_email = $property->sem_premium_by_model_contact_email;
        $sem_con_sp_bm_phone = $property->sem_premium_by_model_contact_phone;
        $sem_con_sp_bm_message = $property->sem_premium_by_model_contact_message;
        $sem_con_sp_bm_sen_email = $property->sem_premium_by_model_contact_send_email;
        $sem_con_sp_bm_concessionary = $property->sem_premium_by_model_contact_concessionary;
        $sem_con_sp_bm_logo_seminuevos = $property->sem_premium_by_model_contact_logo_seminuevos;
        $sem_con_sp_bm_logo_agencia = $property->sem_premium_by_model_contact_logo_agencia;
        $sem_con_sp_bm_marc = $property->sem_premium_by_model_contact_marc;
        $sem_con_sp_bm_model = $property->sem_premium_by_model_contact_model;
        $sem_con_sp_bm_picture = $property->sem_premium_by_model_contact_picture;

        contact_main_by_model($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_sen_email, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture);

        echo changeArrayIntoJSON("campa", array('process'=>'ok'));
    }

    // JOB OPPRTUNITIES
    function postJobOpportunities() {
        $property = requestBody();
        $job_opportunities_first_name = $property->job_opportunities_first_name;
        $job_opportunities_last_name = $property->job_opportunities_last_name;
        $job_opportunities_email = $property->job_opportunities_email;
        $job_opportunities_phone = $property->job_opportunities_phone;
        $job_opportunities_message = $property->job_opportunities_message;
        $job_opportunities_date = $property->job_opportunities_date;
        $job_opportunities_file_name = $property->job_opportunities_file_name;
        $job_opportunities_mime = $property->job_opportunities_mime;
        $job_opportunities_file_content = $property->job_opportunities_file_content;
        $job_opportunities_concessionary = $property->job_opportunities_concessionary;
        $job_opportunities_logo = $property->job_opportunities_logo;

        $attachments = array(
            array(
                'type' => $job_opportunities_mime,
                'name' => $job_opportunities_file_name,
                'content' => $job_opportunities_file_content
            )
        );

        jobOpportunities($job_opportunities_first_name, $job_opportunities_last_name, $job_opportunities_email, $job_opportunities_phone, $job_opportunities_message, $job_opportunities_date, $attachments, $job_opportunities_concessionary, $job_opportunities_logo);

        echo changeArrayIntoJSON("campa", array('process'=>'ok', $property));
    }
/*
  ----------------------------------------------------------------------------
  General Get Mandril
  ----------------------------------------------------------------------------
*/
    function contact_main($contact_main_name, $contact_main_email, $contact_main_message) {
        try {
            $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
            $message = array(
                'html' => '
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full2"  bgcolor="#ffffff"style="background-color: rgb(255, 255, 255);">
                        <tr>
                            <td style="background-color: rgba(0,161,220,0.3); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: -120px -15px; background-attachment: fixed; background-repeat: no-repeat;" id="not6">

                                                    <!-- Mobile Wrapper -->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" style="background: rgb(178, 17, 23);">
                                    <tr>
                                        <td width="100%" align="center">

                                            <div class="sortable_inner ui-sortable">
                                            <!-- Space -->
                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="50"></td>
                                                </tr>
                                            </table><!-- End Space -->

                                            <!-- Space -->
                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="50"></td>
                                                </tr>
                                            </table><!-- End Space -->

                                            <!-- Start Top -->
                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#4edeb5" style="border-top-left-radius: 5px; border-top-right-radius: 5px; background-color: rgba(255,255,255,0.85);" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center" class="logo">

                                                        <!-- Header Text -->
                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%"><span ><img src="http://camcar.mx/resources/public/img/logo_camcar.png" width="225" alt="" border="0" ></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 23px; color: rgb(63, 67, 69); line-height: 30px; font-weight: 100;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal; text-align: center; display: block;"><!--<![endif]-->Contacto <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal;"><!--<![endif]-->
                                                                        <hr style="border: 0; border-top: 1px solid #00a1dc; display: block; width: 100%; margin-top: 0%;">
                                                                        <ol type="1">
                                                                            <li style="list-style-type: disc;">
                                                                                <b>Nombre: </b>
                                                                                <ul>
                                                                                    <li>
                                                                                         <i>' . $contact_main_name . '</i>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li style="list-style-type: disc;">
                                                                                <b>Email:</b>
                                                                                <ul>
                                                                                    <li>
                                                                                         <i>' . $contact_main_email . '</i>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ol>
                                                                        <hr style="border: 0; border-top: 1px solid #00a1dc; display: block; width: 100%; margin-bottom: 2%;">

                                                                <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="10"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 19px; color: rgb(63, 67, 69); line-height: 30px; font-weight: bold;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal; text-align: left; display: block; margin-bottom: 20px;"><!--<![endif]-->Mensaje. <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal; word-break: break-all;"><!--<![endif]-->
                                                                    ' . $contact_main_message . '
                                                                    <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="10"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>



                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; background-color: rgba(255, 255, 255, 1);" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="10"></td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="full2" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="30"></td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" object="drag-module-small">
                                                <tr>
                                                    <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 15px; color: rgba(255, 255, 255, 1); line-height: 15px; text-align: center">
                                                       <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal;"><!--<![endif]-->&copy; 2016 Camcar Grupo Automotriz <!--<![endif]--></span><!--[if !mso]><!-->
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="30"></td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="29"></td>
                                                </tr>
                                                <tr>
                                                    <td width="100%" height="1"></td>
                                                </tr>
                                            </table>
                                            </div>

                                        </td>
                                    </tr>
                                </table>

                            </div>
                            </td>
                        </tr>
                    </table>
                ',
                'subject' => 'Contacto',
                'from_email' => 'respuesta.segura@camcar.mx',
                'from_name' => $contact_main_name,
                'to' => array(
                    array(
                        'email' => 'marina.reyes@camcar.mx',
                        //'email' => 'hevelmo060683@gmail.com',
                        'name' => 'Contacto Camcar',
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'marina.reyes@camcar.mx'),
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

                'tags' => array('orden-new-notificacion-camcar-sitio'),
                'google_analytics_domains' => array('http://camcar.mx/'),
                'google_analytics_campaign' => 'marina.reyes@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/'),
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
    // SEND MAIL CONTACT BY MODEL
    function contact_main_by_model($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_sen_email, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture) {
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
                                background: rgba(225, 222, 223, 1)!important;
                                -moz-osx-font-smoothing: grayscale;
                                -webkit-font-smoothing: antialiased;
                                color: #777;
                                font-size: 14px;
                                line-height: 24px;
                                text-transform: uppercase;
                            }
                            .ExternalClass {
                                font-family: "Montserrat", "Helvetica Neue", Helvetica, Arial, sans-serif;
                                background: rgba(225, 222, 223, 1) !important;
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

                            <div style="background-color: rgba(225, 222, 223, 1); padding: 20px;border-bottom: 0px" width="600">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" style="background-color: rgba(255,255,255, 1); border-radius: 5px;">
                                    <tbody>
                                        <tr>
                                            <td width="11"></td>
                                            <td style="background-color: rgba(255, 255, 255, 1); border-radius: 5px 5px 0 0; border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                                <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="15" width="100">
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    <img src="http://camcar.mx/resources/public/img/'.$sem_con_sp_bm_logo_seminuevos.'" alt="Modelo" width="150">
                                                                </p>
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-right: 0px; float: right;">
                                                                    <img src="http://camcar.mx/resources/public/img/logos_agencias/'.$sem_con_sp_bm_logo_agencia.'" alt="Modelo" width="120">
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td width="11"></td>
                                        </tr>
                                        <tr>
                                            <td height="11" valign="top" width="11"></td>
                                            <td rowspan="2" style="border:1px solid #fff;border-top:0" bgcolor="#ffffff">
                                                <table style="padding:15px 60px 15px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" valign="top" width="250">
                                                                <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Marca:
                                                                </strong>
                                                                <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_bm_marc.
                                                                '</span><br>
                                                                <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Modelo:
                                                                </strong>
                                                                <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_bm_model.
                                                                '</span><br>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <img src="http://camcar.mx/intranet/admin/cdn/img/seminuevos/'.$sem_con_sp_bm_picture.'" alt="Modelo" width="250">
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
                                            <td height="11" valign="top" width="11"></td>
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
                'from_email' => 'respuesta.segura@camcar.mx',
                'from_name' => $sem_con_sp_bm_name,
                'to' => array(
                    array(
                        //'email' => 'hevelmo060683@gmail.com',
                        'email' => $sem_con_sp_bm_sen_email,
                        'name' => $sem_con_sp_bm_concessionary,
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => $sem_con_sp_bm_sen_email),
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

                'tags' => array('orden-new-notificacion-camcar-sitio'),
                'google_analytics_domains' => array('http://camcar.mx/'),
                'google_analytics_campaign' => 'marina.reyes@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/'),

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

    // JOP OPPORTUNITIES
    function jobOpportunities($job_opportunities_first_name, $job_opportunities_last_name, $job_opportunities_email, $job_opportunities_phone, $job_opportunities_message, $job_opportunities_date, $attachments, $job_opportunities_concessionary, $job_opportunities_logo) {
        try {
            $mandrill = new Mandrill('V6ypCDEnJAgL9FsOyyDxAw');
            $message = array(
                'html' => '
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="full2"  bgcolor="#ffffff"style="background-color: rgb(255, 255, 255);">
                        <tr>
                            <td style="background-color: rgba(0,161,220,0.3); -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; background-position: -120px -15px; background-attachment: fixed; background-repeat: no-repeat;" id="not6">

                                                    <!-- Mobile Wrapper -->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" style="background: rgb(178, 17, 23);">
                                    <tr>
                                        <td width="100%" align="center">

                                            <div class="sortable_inner ui-sortable">
                                            <!-- Space -->
                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="50"></td>
                                                </tr>
                                            </table><!-- End Space -->

                                            <!-- Space -->
                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="full" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="50"></td>
                                                </tr>
                                            </table><!-- End Space -->

                                            <!-- Start Top -->
                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#4edeb5" style="border-top-left-radius: 5px; border-top-right-radius: 5px; background-color: rgba(255,255,255,0.85);" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center" class="logo">

                                                        <!-- Header Text -->
                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%"><span ><img src="http://camcar.mx/img/logos/logo_camcar.png" width="225" alt="" border="0" ></span></td>
                                                            </tr>
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 23px; color: rgb(63, 67, 69); line-height: 30px; font-weight: 100;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal; text-align: center; display: block;"><!--<![endif]-->Contacto <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="30"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal;"><!--<![endif]-->
                                                                        <hr style="border: 0; border-top: 1px solid #00a1dc; display: block; width: 100%; margin-top: 0%;">
                                                                        <ol type="1">
                                                                            <li style="list-style-type: disc;">
                                                                                <b>Nombre: </b>
                                                                                <ul>
                                                                                    <li>
                                                                                         <i>' . $job_opportunities_first_name . ' '. $job_opportunities_last_name .'</i>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li style="list-style-type: disc;">
                                                                                <b>Email:</b>
                                                                                <ul>
                                                                                    <li>
                                                                                         <i>' . $job_opportunities_email . '</i>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                            <li style="list-style-type: disc;">
                                                                                <b>Email:</b>
                                                                                <ul>
                                                                                    <li>
                                                                                         <i>' . $job_opportunities_phone . '</i>
                                                                                    </li>
                                                                                </ul>
                                                                            </li>
                                                                        </ol>
                                                                        <hr style="border: 0; border-top: 1px solid #00a1dc; display: block; width: 100%; margin-bottom: 2%;">

                                                                <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="10"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 19px; color: rgb(63, 67, 69); line-height: 30px; font-weight: bold;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal; text-align: left; display: block; margin-bottom: 20px;"><!--<![endif]-->Mensaje. <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: rgb(63, 67, 69); line-height: 24px;">
                                                                    <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal; word-break: break-all;"><!--<![endif]-->
                                                                    ' . $job_opportunities_message . '
                                                                    <!--[if !mso]><!--></span><!--<![endif]-->
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"object="drag-module-small" style="background-color: rgba(255, 255, 255, 1);">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="10"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>



                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" bgcolor="#ffffff"style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px; background-color: rgba(255, 255, 255, 1);" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" valign="middle" align="center">

                                                        <table width="540" border="0" cellpadding="0" cellspacing="0" align="center" style="text-align: center; border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;" class="fullCenter2">
                                                            <tr>
                                                                <td width="100%" height="10"></td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="full2" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="30"></td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" object="drag-module-small">
                                                <tr>
                                                    <td valign="middle" width="100%" style="text-align: left; font-family: Helvetica, Arial, sans-serif; font-size: 15px; color: rgba(255, 255, 255, 1); line-height: 15px; text-align: center">
                                                       <!--[if !mso]><!--><span style="font-family: Helvetica; font-weight: normal;"><!--<![endif]-->&copy; 2016 Camcar Grupo Automotriz <!--<![endif]--></span><!--[if !mso]><!-->
                                                    </td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="30"></td>
                                                </tr>
                                            </table>

                                            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="mobile2" object="drag-module-small">
                                                <tr>
                                                    <td width="100%" height="29"></td>
                                                </tr>
                                                <tr>
                                                    <td width="100%" height="1"></td>
                                                </tr>
                                            </table>
                                            </div>

                                        </td>
                                    </tr>
                                </table>

                            </div>
                            </td>
                        </tr>
                    </table>
                ',
                'subject' => 'Bolsa de Trabajo',
                'from_email' => 'respuesta.segura@camcar.mx',
                'from_name' => $job_opportunities_first_name . ' '. $job_opportunities_last_name,
                'to' => array(
                    array(
                        'email' => 'reclutamiento@camcar.mx',
                        //'email' => 'hevelmo060683@gmail.com',
                        'name' => 'Bolsa de Trabajo Camcar',
                        'type' => 'to'
                    )
                ),
                'headers' => array('Reply-To' => 'reclutamiento@camcar.mx'),
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
                "attachments" => $attachments,
                'tags' => array('orden-new-notificacion-camcar-sitio'),
                'google_analytics_domains' => array('http://camcar.mx/'),
                'google_analytics_campaign' => 'reclutamiento@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/'),
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
