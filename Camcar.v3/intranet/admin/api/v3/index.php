<?php
include_once '../../../../incorporate/db_connect.php';
include_once '../../../../incorporate/functions.php';
include_once '../../../../incorporate/queryintojson.php';
include_once '../Mandrill.php';

/**
 * 
 * [Initial V 3.0]
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
$app->post('/new/seminuevos', /*'mws',*/ 'addSeminuevos');
$app->post('/new/pictures/:senId', /*'mws',*/ 'addPictures');

//UPDATE
$app->post('/set/seminuevos/:senId', /*'mws',*/ 'setSeminuevos');

//DELETE
$app->post('/del/seminuevos/:senId', /*'mws',*/ 'delSeminuevos');

//GET route

//SELECT

$app->get('/get/test', /*'mws',*/ 'getTest');

$app->get('/get/pictures/:senId', /*'mws',*/ 'getPictures');
$app->get('/get/seminuevos', /*'mws',*/ 'getSeminuevos');
$app->get('/get/seminuevos/:senId', /*'mws',*/ 'getSeminuevosById');
$app->get('/get/seminuevos/filters/:sorter/:sort/:agnId/:catId/:marId/:mdoId', /*'mws',*/ 'getSeminuevosByFilters');
$app->get('/get/seminuevos/filters/:sorter/:sort/:agnId/:catId/:marId/:mdoId/:mystery', /*'mws',*/ 'getSeminuevosByFiltersSearch');
$app->get('/get/agencias', /*'mws',*/ 'getAgencias');
$app->get('/get/agencias/:agnId', /*'mws',*/ 'getAgenciasById');
$app->get('/get/categorias', /*'mws',*/ 'getCategorias');
$app->get('/get/categorias/:agnId', /*'mws',*/ 'getCategoriasById');
$app->get('/get/marcas', /*'mws',*/ 'getMarcas');
$app->get('/get/marcas/:agnId', /*'mws',*/ 'getMarcasById');
$app->get('/get/modelos', /*'mws',*/ 'getModelos');
$app->get('/get/modelos/:mdoId', /*'mws',*/ 'getModelosById');


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
}

/*
----------------------------------------------------------------------------
    General Post Methods
----------------------------------------------------------------------------
*/

function addSeminuevos() {
    $property = requestBody();
    $sql = "INSERT INTO camSeminuevos(
        SEN_AGN_Id,
        SEN_CAT_Id,
        SEN_MAR_Id,
        SEN_MDO_Id,
        SEN_Year,
        SEN_Precio,
        SEN_Cilindros,
        SEN_Transmision,
        SEN_Color,
        SEN_Interior,
        SEN_Descripcion,
        SEN_Status
    ) VALUES (
        :agnId,
        :catId,
        :marId,
        :mdoId,
        :year,
        :price,
        :cylinders,
        :transmission,
        :color,
        :interior,
        :description,
        :status
    )";
    $structure = array();
    $params = array(
        'agnId' => trim($property->sen_agency),
        'catId' => trim($property->sen_category),
        'marId' => trim($property->sen_brand),
        'mdoId' => trim($property->sen_model),
        'year' => trim($property->sen_year),
        'price' => trim($property->sen_price),
        'cylinders' => trim($property->sen_cylinders),
        'transmission' => trim($property->sen_transmission),
        'color' => trim($property->sen_color),
        'interior' => trim($property->sen_interior),
        'description' => trim($property->sen_description),
        'status' => 1
    );
    $result = restructureQuery($structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);
    $id_inserted = $result['id_inserted'];

    $base = '../../cdn/img/seminuevos/' . $id_inserted;
    $thumbnail = 'thumbnail';

    mkdir($base, 0700);
    $file = fopen($base . '/_empty_', 'a');
    fwrite($file, '');
    fclose($file);

    echo changeArrayIntoJSON('camadpa', $result);
}

function addPictures($senId) {
    $property = requestBody();

    $sql = "INSERT INTO camPictures(
        PIC_SEN_Id,
        PIC_Nombre,
        PIC_MDO_Folder,
        PIC_Status
    ) VALUES (
        :senId,
        :nombre,
        :mdoFolder,
        :status
    )";
    $structure = array();

    $ids_inserted = array();

    foreach($property as $object) {
        $params = array(
            'senId' => $senId,
            'nombre' => $object->name,
            'mdoFolder' => 'folder',
            'status' => 1
        );
        $result = restructureQuery($structure, getConnection(), $sql, $params, 1, PDO::FETCH_ASSOC);
        $ids_inserted[] = $result['id_inserted'];
    }

    echo changeArrayIntoJSON('camadpa', $ids_inserted);
}

function setSeminuevos($senId) {
    $property = requestBody();
    $sql = "UPDATE camSeminuevos
            SET SEN_AGN_Id = :agnId,
                SEN_CAT_Id = :catId,
                SEN_MAR_Id = :marId,
                SEN_MDO_Id = :mdoId,
                SEN_Year = :year,
                SEN_Precio = :price,
                SEN_Cilindros = :cylinders,
                SEN_Transmision = :transmission,
                SEN_Color = :color,
                SEN_Interior = :interior,
                SEN_Descripcion = :description
            WHERE SEN_Status = :status 
            AND SEN_Id = :senId";
    $structure = array();
    $params = array(
        'senId' => $senId,
        'agnId' => trim($property->sen_agency),
        'catId' => trim($property->sen_category),
        'marId' => trim($property->sen_brand),
        'mdoId' => trim($property->sen_model),
        'year' => trim($property->sen_year),
        'price' => trim($property->sen_price),
        'cylinders' => trim($property->sen_cylinders),
        'transmission' => trim($property->sen_transmission),
        'color' => trim($property->sen_color),
        'interior' => trim($property->sen_interior),
        'description' => trim($property->sen_description),
        'status' => 1
    );
    echo changeQueryIntoJSON('camadpa', $structure, getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
}

function delSeminuevos($senId) {
    $property = requestBody();
    $sql = "UPDATE camSeminuevos
            SET SEN_Status = :new_status
            WHERE SEN_Id = :senId 
            AND SEN_Status <> :old_status";
    $structure = array();
    $params = array(
        'senId' => $senId,
        'new_status' => 0,
        'old_status' => 0
    );
    echo changeQueryIntoJSON('camadpa', $structure, getConnection(), $sql, $params, 2, PDO::FETCH_ASSOC);
}

/*
----------------------------------------------------------------------------
    General Get Methods
----------------------------------------------------------------------------
*/

function getPicturesArray($sql, $senId) {
    $structure = array(
        'id' => 'PIC_Id',
        'sen_id' => 'PIC_SEN_Id',
        'nombre' => 'PIC_Nombre',
        'pic_mdo_folder' => 'PIC_MDO_Folder'
    );
    $params = array();
    ($senId !== '') ? $params['senId'] = $senId : $params = $params;

    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
        
    for($idx = 0; $idx < count($result); $idx++) {
        $result[$idx]['si_pic'] = ($result[$idx]['pic_mdo_folder'] == 'default') ? '' : '1';
    }
   return $result;
}

function getPicturesJSON($sql, $senId) {
    $result = getPicturesArray($sql, $senId);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getPictures($senId) {
    $sql = "SELECT *
            FROM camPictures
            WHERE PIC_SEN_Id = :senId
            ORDER BY PIC_Id ASC";
    getPicturesJSON($sql, $senId);
}

function getSeminuevosArray($sql, $senId, $agnId, $catId, $marId, $mdoId, $mystery) {
    $structure = array(
        'id' => 'SEN_Id',
        'anio' => 'SEN_Year',
        'precio' => 'SEN_Precio',
        'cilindros' => 'SEN_Cilindros',
        'transmision' => 'SEN_Transmision',
        'color' => 'SEN_Color',
        'interior' => 'SEN_Interior',
        'descripcion' => 'SEN_Descripcion',
        'agencia' => array(
            'id' => 'AGN_Id',
            'nombre' => 'AGN_Nombre'
        ),
        'categoria' => array(
            'id' => 'CAT_Id',
            'nombre' => 'CAT_Nombre'
        ),
        'marca' => array(
            'id' => 'MAR_Id',
            'nombre' => 'MAR_Nombre',
            'nombre_short' => 'MAR_NombreShort'
        ),
        'modelo' => array(
            'id' => 'MDO_Id',
            'nombre' => 'MDO_Nombre',
            'nombre_short' => 'MDO_NombreShort'
        )
    );
    $params = array();
    ($senId !== '') ? $params['senId'] = $senId : $params = $params;
    ($agnId !== '') ? $params['agnId'] = $agnId : $params = $params;
    ($catId !== '') ? $params['catId'] = $catId : $params = $params;
    ($marId !== '') ? $params['marId'] = $marId : $params = $params;
    ($mdoId !== '') ? $params['mdoId'] = $mdoId : $params = $params;
    ($mystery !== '') ? $params['mystery'] = '%' . $mystery . '%' : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getSeminuevosJSON($sql, $senId, $agnId, $catId, $marId, $mdoId, $mystery) {
    $result = getSeminuevosArray($sql, $senId, $agnId, $catId, $marId, $mdoId, $mystery);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getSeminuevos() {
    $sql = "SELECT * 
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0
                ORDER BY SEN_Id ASC
            ) sen";
    getSeminuevosJSON($sql, '', '', '', '', '', '');
}

function getSeminuevosById($senId) {
    $sql = "SELECT * 
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0
                AND SEN_Id = :senId
                ORDER BY SEN_Id ASC
            ) sen";
    getSeminuevosJSON($sql, $senId, '', '', '', '', '');
}

function getSeminuevosByFiltersMaster($sorter, $sort, $agnId, $catId, $marId, $mdoId, $mystery) {

    $agnId = ($agnId === '0') ? '' : $agnId;
    $catId = ($catId === '0') ? '' : $catId;
    $marId = ($marId === '0') ? '' : $marId;
    $mdoId = ($mdoId === '0') ? '' : $mdoId;

    $where = '';

    $where .= ($agnId !== '') ? ' AND AGN_Id = :agnId' : '';
    $where .= ($catId !== '') ? ' AND CAT_Id = :catId' : '';
    $where .= ($marId !== '') ? ' AND MAR_Id = :marId' : '';
    $where .= ($mdoId !== '') ? ' AND MDO_Id = :mdoId' : '';

    $where_search = ($mystery !== '')
        ? ' sen.SEN_Descripcion LIKE :mystery' .
          ' OR sen.AGN_Nombre LIKE :mystery' .
          ' OR sen.CAT_Nombre LIKE :mystery' .
          ' OR sen.MAR_Nombre LIKE :mystery' .
          ' OR sen.MDO_Nombre LIKE :mystery' .
          ' OR sen.SEN_Transmision LIKE :mystery' .
          ' OR sen.SEN_Color LIKE :mystery' .
          ' OR sen.SEN_Interior LIKE :mystery'
        : ' 1=1';

    $sortingField = 'SEN_Descripcion';

    switch($sorter) {
        case 'des':
            $sortingField = 'SEN_Descripcion';
            break;
        case 'agn':
            $sortingField = 'AGN_Nombre';
            break;
        case 'cat':
            $sortingField = 'CAT_Nombre';
            break;
        case 'mar':
            $sortingField = 'MAR_Nombre';
            break;
        case 'mdo':
            $sortingField = 'MDO_Nombre';
            break;
        case 'anio':
            $sortingField = 'SEN_Year';
            break;
        case 'pri':
            $sortingField = 'SEN_Precio';
            break;
        case 'cil':
            $sortingField = 'SEN_Cilindros';
            break;
        case 'tra':
            $sortingField = 'SEN_Transmision';
            break;
        case 'col':
            $sortingField = 'SEN_Color';
            break;
        case 'int':
            $sortingField = 'SEN_Interior';
            break;
    }

    $sql = "SELECT * 
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0 
                $where
                ORDER BY $sortingField $sort
            ) sen
            WHERE $where_search";
    getSeminuevosJSON($sql, '', $agnId, $catId, $marId, $mdoId, $mystery);
}

function getSeminuevosByFilters($sorter, $sort, $agnId, $catId, $marId, $mdoId) {
    getSeminuevosByFiltersMaster($sorter, $sort, $agnId, $catId, $marId, $mdoId, '');
}

function getSeminuevosByFiltersSearch($sorter, $sort, $agnId, $catId, $marId, $mdoId, $mystery) {
    $mystery = str_replace('**47**', '/', $mystery);
    getSeminuevosByFiltersMaster($sorter, $sort, $agnId, $catId, $marId, $mdoId, $mystery);
}

function getAgenciasArray($sql, $agnId) {
    $structure = array(
        'id' => 'AGN_Id',
        'nombre' => 'AGN_Nombre'
    );
    $params = array();
    ($agnId !== '') ? $params['agnId'] = $agnId : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getAgenciasJSON($sql, $agnId) {
    $result = getAgenciasArray($sql, $agnId);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getAgencias() {
    $sql = "SELECT *
            FROM camAgencias
            ORDER BY AGN_Nombre ASC";
    getAgenciasJSON($sql, '');
}

function getAgenciasById($agnId) {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Id = :agnId
            ORDER BY AGN_Nombre ASC";
    getAgenciasJSON($sql, $agnId);
}

function getCategoriasArray($sql, $cat) {
    $structure = array(
        'id' => 'CAT_Id',
        'nombre' => 'CAT_Nombre'
    );
    $params = array();
    ($cat !== '') ? $params['cat'] = $cat : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getCategoriasJSON($sql, $cat) {
    $result = getCategoriasArray($sql, $cat);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getCategorias() {
    $sql = "SELECT *
            FROM camCategorias
            ORDER BY CAT_Nombre ASC";
    getCategoriasJSON($sql, '');
}

function getCategoriasById($cat) {
    $sql = "SELECT *
            FROM camCategorias
            WHERE CAT_Id = :cat
            ORDER BY CAT_Nombre ASC";
    getCategoriasJSON($sql, $cat);
}

function getMarcasArray($sql, $mar) {
    $structure = array(
        'id' => 'MAR_Id',
        'nombre' => 'MAR_Nombre'
    );
    $params = array();
    ($mar !== '') ? $params['mar'] = $mar : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getMarcasJSON($sql, $mar) {
    $result = getMarcasArray($sql, $mar);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getMarcas() {
    $sql = "SELECT *
            FROM camMarcas
            ORDER BY MAR_Nombre ASC";
    getMarcasJSON($sql, '');
}

function getMarcasById($mar) {
    $sql = "SELECT *
            FROM camMarcas
            WHERE MAR_Id = :mar
            ORDER BY MAR_Nombre ASC";
    getMarcasJSON($sql, $mar);
}

function getModelosArray($sql, $mdo) {
    $structure = array(
        'id' => 'MDO_Id',
        'nombre' => 'MDO_Nombre'
    );
    $params = array();
    ($mdo !== '') ? $params['mdo'] = $mdo : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getModelosJSON($sql, $mdo) {
    $result = getModelosArray($sql, $mdo);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getModelos() {
    $sql = "SELECT *
            FROM camModelos
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, '');
}

function getModelosById($mdo) {
    $sql = "SELECT *
            FROM camModelos
            WHERE MDO_Id = :mdo
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, $mdo);
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

