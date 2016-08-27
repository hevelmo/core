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
 * [Initial V 13.0]
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
 * [Routes Deep V 13.0]
 */


// POST route
    // SEND CONTACT
    $app->post('/contacto/seminuevo/premium', 'sendContactoSEMPREM');
    $app->post('/contacto/seminuevo/premium/modelo', 'sendContactoSEMPREMByModel');
    $app->post('/bolsa-de-trabajo', 'senMailJobBoard');
    $app->post('/bolsa-de-trabajo/new/file', 'addFileUpload');



// INSERT
//$app->post('/new/table', /*'mw1',*/ 'addTable');

// UPDATE
//$app->post('/set/table/:idTable', /*'mw1',*/ 'setTable');


// GET route

// SELECT
    /*-- BEGIN : BANNERS CAMCAR ---------------------------*/
        //$app->get('/get/banners', /*'mw1',*/ 'getBanners');
    /*-- END : BANNERS CAMCAR ---------------------------*/
    /*-- BEGIN : INVENTARIOS SEMINUEVOS ---------------------------*/
        // Seminuevos
        $app->get('/get/seminuevos', /*'mw1',*/ 'getSeminuevos');
        $app->get('/get/seminuevos/:mrc_nombre_short/:mdo_nombre_short/:senId', /*'mw1',*/ 'getSeminuevosById');

        // Filtros
        $app->get('/get/seminuevos/filtros/:category/:marca/:modelo', /*'mw1',*/ 'getSeminuevosByFilter');

        // Pictures
        $app->get('/get/pictures/seminuevo', /*'mw1',*/ 'getPictures');
        $app->get('/get/pictures/seminuevo/:picId', /*'mw1',*/ 'getPicturesById');

        // Mapa
        $app->get('/get/mapa/seminuevo', /*'mw1',*/ 'getMapa');
        $app->get('/get/mapa/seminuevo/:senId', /*'mw1',*/ 'getMapaById');

        // Categoria
        $app->get('/get/categoria', /*'mw1',*/ 'getCategory');
        //$app->get('/get/categoria/:catId', /*'mw1',*/ 'getCategoryById');

        // Marca
        $app->get('/get/categoria/marcas/:idMrc', /*'mw1',*/ 'getCategoryByMarc');

        // Modelo
        $app->get('/get/categoria/modelos/:idCategory/:idMarc', /*'mw1',*/ 'getCategoryModelsByCategoryByMarc');

        // CAROUSEL
        $app->get('/get/catalogo/marcas/:marId', /*'mw1',*/ 'getCatalogoByMarc');
    /*-- END   : INVENTARIOS SEMINUEVOS ---------------------------*/
    /*-- BEGIN : AGENCIES PRE-OWNED ---------------------------*/
        // AGENCIES PRE-OWNED
        $app->get('/get/agencia/seminuevos', /*'mw1',*/ 'getAgenciesPreOwned');
        $app->get('/get/agencia/seminuevos/mapas/:agn_id', /*'mw1',*/ 'getAgenciesPreOwnedByMap');
        $app->get('/get/agencia/seminuevos/:agn_nombre/:agn_id', /*'mw1',*/ 'getAgenciesPreOwnedByAgencie');
    /*-- END   : AGENCIES PRE-OWNED ---------------------------*/
    /*-- BEGIN : AGENCIES WORKSHOP ---------------------------*/
        // TALLERES
        $app->get('/get/talleres', /*'mw1',*/ 'getWorkshop');
        $app->get('/get/talleres/logos', /*'mw1',*/ 'getWorkshopBrands');
    /*-- END   : AGENCIES WORKSHOP ---------------------------*/
    /*-- BEGIN : AGENCIES RENTAL ---------------------------*/
        // RENTAS
        $app->get('/get/rentas', /*'mw1',*/ 'getRental');
    /*-- END   : AGENCIES RENTAL ---------------------------*/

    /*-- BEGIN : AGENCIES NEWS ---------------------------*/
        // HOME -> BRANDS AGENCIES
        $app->get('/get/agencia/nuevos/marcas/logotipos', /*'mw1',*/ 'getBrandsLogos');
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
    /*-- END   : AGENCIES NEWS ---------------------------*/
// DELETE
//$app->get('/del/table/:idTable', /*'mw1',*/ 'delTable');
$app->run();

//Functions
    // GET BANNERS
    function getBanners() {
        $json = file_get_contents('../json/camBanners.json');
        echo $json;
    }
    // Bolsa de Trabajp
    function addFileUpload() {
        $property = requestBody();
        $structure = array();
        $var_name_img = $property->job_board_upload_file;

        $var_img_dir = '../resources/public/cv/files/';

        $obj_simpleimage->load($var_img_dir . $var_name_img);

        //Obtener sólo el type
        $type = $img_elements[count($img_elements) - 1];
        //$type = strtolower($type);
        //$type = 'files/' . $type;

        $result = restructureQuery($structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);

        //unlink($var_img_dir . $var_name_img);
        echo changeArrayIntoJSON('campa', array('process'=>'ok'));
    }
    function senMailJobBoard() {
        $property = requestBody();
        $send_job_board_first_name = $property->job_board_first_name;
        $send_job_board_last_name = $property->job_board_last_name;
        $send_job_board_email = $property->job_board_email;
        $send_job_board_phone = $property->job_board_phone;
        $send_job_board_interest_area = $property->job_board_interest_area;
        $send_job_board_message = $property->job_board_message;
        //$send_job_board_upload_file = $property->job_board_upload_file;
        $send_job_board_concessionary = $property->job_board_concessionary;
        $send_job_board_logo = $property->job_board_logo;
        $send_job_board_date_time = date("Y-m-d H:i:s");

        $file_name = $property->job_board_upload_file;
        $file_url = '../../resources/public/cv/files/'. $file_name;
        $file_content = file_get_contents($file_url);
        $file_content = base64_encode($file_content);
        $file_elements = explode('.', $file_name);
        $file_count = count($file_elements);
        $file_extension = strtolower($file_elements[$file_count -1]);

        switch ($file_extension) {
            case 'pdf':
                $file_mime_type = 'application/pdf';
                break;
            case 'doc':
                $file_mime_type = 'application/msword';
                break;
        }

        if ($send_job_board_interest_area == "mercadotecnia") {
            $send_job_board_department = "Mercadotecnia";
        } else if ($send_job_board_interest_area == "ventas") {
            $send_job_board_department = "Ventas";
        } else if ($send_job_board_interest_area == "administrativo") {
            $send_job_board_department = "Administrativo";
        } else if ($send_job_board_interest_area == "seminuevos") {
            $send_job_board_department = "Seminuevos";
        } else if ($send_job_board_interest_area == "taller") {
            $send_job_board_department = "Taller";
        } else if ($send_job_board_interest_area == "otros") {
            $send_job_board_department = "Otros";
        }

        $attachments = array(
            array(
                'type' => $file_mime_type,
                'name' => $file_name,
                'content' => $file_content
            )
        );
        unlink($file_url);
        send_mail_job_board($send_job_board_date_time, $send_job_board_first_name, $send_job_board_last_name, $send_job_board_email, $send_job_board_phone, $send_job_board_department, $send_job_board_message, $file_name, $send_job_board_concessionary, $send_job_board_logo);

        echo changeArrayIntoJSON("campa", array('process'=>'ok'));
    }
    // Contacto SEMINUEVOS PREMIUM
    function sendContactoSEMPREM() {
        $property = requestBody();
        $sem_con_sp_name = $property->sem_premium_contact_name;
        $sem_con_sp_email = $property->sem_premium_contact_email;
        $sem_con_sp_message = $property->sem_premium_contact_message;
        $sem_con_sp_concesionarie = $property->sem_premium_contact_concessionary;
        $sem_con_sp_logo = $property->sem_premium_contact_logo;

        sem_premium_contacto($sem_con_sp_name, $sem_con_sp_email, $sem_con_sp_message, $sem_con_sp_concesionarie, $sem_con_sp_logo);

        echo changeArrayIntoJSON("campa", array('process'=>'ok'));
    }
    // Contacto SEMINUEVOS PREMIUM BY MODEL
    function sendContactoSEMPREMByModel() {
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

        sem_premium_bymodel_contacto($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_sen_email, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture);

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
    /*-- STRUCTURE PRE-OWNED ---------------------------*/
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
        // STRUCTURE MAP JSON
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
    /*----------------------------------------------------------------------------*/
    /*-- STRUCTURE AGENCIES PRE-OWNED ---------------------------*/
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
                'agnlongitud' => 'AGN_MLongitud',
                'agngmapurl' => 'AGN_MUrl'
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
            ($agn_nombre !== '') ? $params['agn_nombre'] = $agn_nombre : $params = $params;
            ($agn_id !== '') ? $params['agn_id'] = $agn_id : $params = $params;
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
    /*----------------------------------------------------------------------------*/
    /*-- STRUCTURE AGENCIES NEWS ---------------------------*/
        // Get Agencies News
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
    /*----------------------------------------------------------------------------*/
    /*-- STRUCTURE BRANDS HOME ---------------------------*/
        // GET BRANDS HOME
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
                'agnPrincipal' => 'BRD_AGP_Id',
                'logo' => 'BRD_Logo'
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
        function getAgenciasLogosJSON ($sql) {
            $structure = array(
                'agpid' => 'AGN_AGP_Id',
                'principal' => 'AGP_Logo',
                'brand' => 'BRD_Logo',
            );
            $params = array();
            echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        }
    /*----------------------------------------------------------------------------*/
    // CONSULTAS
    /*-- CONSULTAS PRE-OWNED ---------------------------*/
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
        // MAP
        function getMapa() {
            $sql = "SELECT *
                    FROM (
                        SELECT *
                        FROM camSeminuevos
                    ) sen
                    INNER JOIN (
                        SELECT *
                        FROM camAgencias
                        WHERE AGN_Tipo = 1
                        AND AGN_Status = 1
                        AND AGN_IsMap_Agencia = 1
                    ) agn
                    GROUP BY AGN_Id";
            getMapaJSON($sql, '');
        }
        // MAP BY ID
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
    /*----------------------------------------------------------------------------*/
    /*-- CONSULTAS BY AGENCIES PRE-OWNED ---------------------------*/
        // AGENCIES PRE-OWNED
        function getAgenciesPreOwned() {
            $sql = "SELECT *
                    FROM (
                        SELECT *
                        FROM camAgencias
                        WHERE AGN_Tipo = 0
                    ) agn";
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
                    WHERE AGN_Id = :agnid";
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
                    ORDER BY AGN_Id";
            getAgenciesPreOwnedByAgencieJSON($sql, $agn_nombre, $agn_id);
        }
    /*----------------------------------------------------------------------------*/
    /*-- CONSULTAS BY AGENCIES NEWS ---------------------------*/
        // AGENCIES NEWS
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
    /*----------------------------------------------------------------------------*/

    // GET BRANDS HOME
    function getBrandsLogos() {
        $sql = "SELECT *
                FROM (
                    SELECT *
                    FROM camBrandsLogos
                ) brd
                LEFT JOIN (
                    SELECT *
                    FROM camAgencias
                ) agn
                ON agn.AGN_AGP_Id = brd.BRD_AGP_Id
                LEFT JOIN (
                    SELECT *
                    FROM camAgenciasPrincipales
                ) agp
                ON agn.AGN_AGP_Id = agp.AGP_Id
                GROUP BY BRD_Id
                ORDER BY BRD_Index
                ";
        getBrandsLogosJSON($sql);
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
    function getAgenciesNewsByTypeAgencie($agn_name_agencia/*, $agn_type*/) {
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

    // TALLERES
    function getWorkshop() {
        $sql_agencias = "SELECT *
                        FROM (
                            SELECT *
                            FROM camAgencias
                            WHERE AGN_Tipo = 2
                        ) agn
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

            $result_agencias[$idx]['columns'] = ($idx % 2 === 0) ? 'col-md-offset-7 col-sm-offset-5' : '';
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
                ";
        $params = array();
        $structure = array(
            'agnId' => 'AGN_Id',
            'agnTipo' => 'AGN_Tipo',
            'agnlogo1' => 'AGN_Logo1'
        );
        echo changeQueryIntoJSON('campa', $structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
    }

    // RENTALS
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
            'agnDireccion' => 'AGN_Direccion',
            'agnSmall' => 'AGN_Small'
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

            $result_agencias[$idx]['columns'] = ($idx % 2 === 0) ? 'col-md-offset-7 col-sm-offset-5' : '';
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
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
*/
/*
  ----------------------------------------------------------------------------
  General Get Mandril
  ----------------------------------------------------------------------------
*/
    // SEND MAIL CONTACT
    function sem_premium_contacto($sem_con_sp_name, $sem_con_sp_email, $sem_con_sp_message, $sem_con_sp_concesionarie, $sem_con_sp_logo) {
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
                                background: rgba(225, 222, 223, 1) !important;
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
                                            <td style="background-color: rgba(255, 255, 255, 1); border: 1px solid rgba(255, 255, 255, 1); border-bottom: 0px" width="600">
                                                <table style="padding: 13px 17px 17px" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="15" width="100">
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    <img src="http://camcar.mx/resources/public/img/'.$sem_con_sp_logo.'" alt="Modelo" width="150">
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
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Nombre(s):
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_name.'
                                                                </span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Correo Electrónico:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'
                                                                    .$sem_con_sp_email.'
                                                                </span><br>
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
                                                                <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'
                                                                    .$sem_con_sp_message.
                                                                '</span>
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
                                            <td height="11" valign="top" width="11"></td>
                                        </tr>
                                        <tr>
                                            <td width="11"></td>
                                            <td width="11"></td>
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
                        'email' => 'marina.reyes@camcar.mx',
                        //'email' => 'hevelmo060683@gmail.com',
                        'name' => $sem_con_sp_concesionarie,
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

                'tags' => array('orden-new-notificacion'),
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
    function sem_premium_bymodel_contacto($sem_con_sp_bm_name, $sem_con_sp_bm_email, $sem_con_sp_bm_phone, $sem_con_sp_bm_message, $sem_con_sp_bm_sen_email, $sem_con_sp_bm_concessionary, $sem_con_sp_bm_logo_seminuevos, $sem_con_sp_bm_logo_agencia, $sem_con_sp_bm_marc, $sem_con_sp_bm_model, $sem_con_sp_bm_picture) {
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
                'from_email' => $sem_con_sp_bm_email,
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

                'tags' => array('orden-new-notificacion'),
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
    // SEND MAIL JOB BOARD
    function send_mail_job_board($send_job_board_date_time, $send_job_board_first_name, $send_job_board_last_name, $send_job_board_email, $send_job_board_phone, $send_job_board_department, $send_job_board_message, $file_name, $send_job_board_concessionary, $send_job_board_logo) {
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
                                                                    <img src="http://camcar.mx/resources/public/img/'.$send_job_board_logo.'" alt="CAMCAR" width="150">
                                                                </p>
                                                                <p style="display: inline-block; color:#ffffff;font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;font-size:24px;text-align:center;padding:0;text-transform: uppercase; margin-left: 0px; float: left;">
                                                                    BOLSA DE TRABAJO
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
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Fecha:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'. $send_job_board_date_time .'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Nombre(s):
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'. $send_job_board_first_name . ' ' . $send_job_board_last_name .'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="150">
                                                                <strong style="color: #0059a9; font-family: ProximaNovaSemibold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Correo Electrónico:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$send_job_board_email.'</span><br>
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
                                                                <span style="margin-left: 15px; font-family: ProximaNovaRegular,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">'.$send_job_board_phone.'</span><br>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="20" valign="top" width="250">
                                                                <strong style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; text-align: right; padding: 0">
                                                                    Departamento:
                                                                </strong>
                                                            </td>
                                                            <td height="20" valign="top">
                                                                <span style="margin-left: 15px; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 400; text-align: right; padding: 0">
                                                                    Dirigido al departamento de <div style="color: #0059a9; font-family: Lato, Arial, sans-serif; font-size: 12px; font-weight: 900; display: inline-block;">'. $send_job_board_department .'</div>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td height="20" width="600" valign="top">
                                                                <span style="font-family: ProximaNovaRegular,Montserrat,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; padding: 15px; text-align: justify; display: block; word-break: break-all;">'.$send_job_board_message.'</span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table style="padding:20px 15px 20px 15px;border-top:1px solid #ccc" align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p style="color: #000000; font-family: jaguarbold,Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 11px; text-align: right; padding: 0">
                                                                    &nbsp;© 2015 / '.$send_job_board_concessionary.' BOLSA DE TRABAJO
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
                'subject' => $send_job_board_concessionary,
                'from_email' => $send_job_board_email,
                'from_name' => $send_job_board_first_name . ' ' . $send_job_board_last_name,
                'to' => array(
                    array(
                        'email' => 'hevelmo060683@gmail.com',
                        //'email' => 'reclutamiento@camcar.mx',
                        'name' => $send_job_board_concessionary . ' - Bolsa de Trabajo',
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

                'tags' => array('orden-new-notificacion'),
                'google_analytics_domains' => array('http://camcar.mx/sitio/'),
                'google_analytics_campaign' => 'reclutamiento@camcar.mx',
                'metadata' => array('website' => 'http://camcar.mx/sitio/'),

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
