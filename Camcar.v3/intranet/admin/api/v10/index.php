<?php
include_once '../../../../incorporate/db_connect.php';
include_once '../../../../incorporate/functions.php';
include_once '../../../../incorporate/queryintojson.php';
include_once '../Mandrill.php';
include_once '../SimpleImage.class.php';

/**
 *
 * [Initial V 10.0]
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
$app->post('/set/thumbnail', /*'mws',*/ 'setThumbnail');

//DELETE
$app->post('/del/seminuevos/:senId', /*'mws',*/ 'delSeminuevos');
$app->post('/del/pictures', /*'mws',*/ 'delPictures');

//GET route

//SELECT

$app->get('/get/test', /*'mws',*/ 'getTest');

$app->get('/get/pictures/:senId', /*'mws',*/ 'getPictures');
$app->get('/get/seminuevos', /*'mws',*/ 'getSeminuevos');
$app->get('/get/seminuevos/:senId', /*'mws',*/ 'getSeminuevosById');
$app->get('/get/seminuevos/agencias/:agnId', /*'mws',*/ 'getSeminuevosByAgenciaId');
$app->get('/get/seminuevos/filters/:sorter/:sort/:agnId/:catId/:marId/:mdoId', /*'mws',*/ 'getSeminuevosByFilters');
$app->get('/get/seminuevos/filters/:sorter/:sort/:agnId/:catId/:marId/:mdoId/:mystery', /*'mws',*/ 'getSeminuevosByFiltersSearch');
$app->get('/get/agencias', /*'mws',*/ 'getAgencias');
$app->get('/get/agencias/:agnId', /*'mws',*/ 'getAgenciasById');
$app->get('/get/agenciass/seminuevos', /*'mws',*/ 'getAgenciasFromSeminuevos');
$app->get('/get/categorias', /*'mws',*/ 'getCategorias');
$app->get('/get/categorias/:agnId', /*'mws',*/ 'getCategoriasById');
$app->get('/get/categoriass/seminuevos', /*'mws',*/ 'getCategoriasFromSeminuevos');
$app->get('/get/categorias/seminuevos/agencias/:agnId', /*'mws',*/ 'getCategoriasFromSeminuevosByAgenciaId');
$app->get('/get/header/agencias/:agn_id', /*'mws',*/ 'getHeaderAgencia');
$app->get('/get/header/agencias', /*'mws',*/ 'getHeaderAgencias');
$app->get('/get/marcas', /*'mws',*/ 'getMarcas');
$app->get('/get/marcas/:marId', /*'mws',*/ 'getMarcasById');
$app->get('/get/marcas/seminuevos/agencias/:agnId', /*'mws',*/ 'getMarcasFromSeminuevosByAgenciaId');
$app->get('/get/modelos', /*'mws',*/ 'getModelos');
$app->get('/get/modelos/:mdoId', /*'mws',*/ 'getModelosById');
$app->get('/get/modelos/seminuevos/agencias/:agnId', /*'mws',*/ 'getModelosFromSeminuevosByAgenciaId');
$app->get('/get/modelos/seminuevos/marcas/:marId/:agnId', /*'mws',*/ 'getModelosFromSeminuevosByMarcaId');
$app->get('/get/modelos/marcas/:marId', /*'mws',*/ 'getModelosByMarcaId');

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

    mkdir($base, 0755);
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
        PIC_Status
    ) VALUES (
        :senId,
        :nombre,
        :status
    )";
    $structure = array();

    $ids_inserted = array();

    foreach($property as $object) {

        //variable que comprueba si tendrá efecto o no el redimensionamiento (1 para sí, 0 para no)
        $var_usar_thumb = 1;
        //variable que recibe el ancho que va a tener la imagen
        $var_thumb_ancho = 800;
        //variable que recibe el alto que va a tener la imagen
        $var_thumb_alto = 600;

        //recibimos la imagen, y tomamos su nombre
        $var_name_img = $object->name;
        //obtenemos el directorio actual con el cual se está trabajando
        $var_img_dir = '../../cdn/img/seminuevos/' . $senId . '/';

        //creamos un objeto de la clase SimpleImage
        $obj_simpleimage = new SimpleImage();
        
        //leemos la imagen 
        $obj_simpleimage->load($var_img_dir . $var_name_img);

        //Nombre y extensión de la imagen
        $img_elements = explode('.', $var_name_img);

        //Obtener sólo el type
        $type = $img_elements[count($img_elements) - 1];
        $type = strtolower($type);
        $type = 'image/' . $type;

        //Si la imagen no es de tipo gif, y marcamos en el formulario como thumbnail
        if(($type) != 'image/gif' && $var_usar_thumb == 1){
            //asignamos un nombre aleatorio al nuevo archivo, para evitar sobreescritura
            $var_nuevo_archivo = time() . rand() . ".jpg";
            //redimensionamos la imagen, con los valores de ancho y alto que hemos especificado
            $obj_simpleimage->resize($var_thumb_ancho, $var_thumb_alto);
        //Si no
        }else{
            //se agregará al nombre original de la imagen una serie de números aleatorios
            $var_nuevo_archivo = time() . rand() . $var_name_img;
        }
        //Reemplazamos los espacios en blanco con sub-guiones, para hacer más compatible el nombre del archivo
        $var_nuevo_archivo = strtolower(str_replace(' ', '_', $var_nuevo_archivo));
        //guardamos los cambios efectuados en la imagen
        $obj_simpleimage->save($var_img_dir . $var_nuevo_archivo);
        //eliminamos del temporal la imagen que estabamos subiendo
        unlink($var_img_dir . $var_name_img);
            
        
        $params = array(
            'senId' => $senId,
            'nombre' => $var_nuevo_archivo,
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

function setThumbnail() {
    $property = requestBody();
    $picId = trim($property->picId);
    $senId = trim($property->senId);

    $sql_u_o = "UPDATE camPictures
                SET PIC_Thum = :new_thum
                WHERE PIC_SEN_Id = :senId
                AND PIC_Thum = :old_thum";
    $structure_u_o = array();
    $params_u_o = array(
        'senId' => $senId,
        'new_thum' => 0,
        'old_thum' => 1
    );

    $result_u_o = restructureQuery($structure_u_o, getConnection(), $sql_u_o, $params_u_o, 2, PDO::FETCH_ASSOC);

    $sql_u_n = "UPDATE camPictures
                SET PIC_Thum = :thum
                WHERE PIC_SEN_Id = :senId
                AND PIC_Id = :picId";
    $structure_u_n = array();
    $params_u_n = array(
        'senId' => $senId,
        'picId' => $picId,
        'thum' => 1
    );

    $result_u_n = restructureQuery($structure_u_n, getConnection(), $sql_u_n, $params_u_n, 2, PDO::FETCH_ASSOC);

    echo changeArrayIntoJSON('camadpa', array('process' => 'ok'));
}

function delSeminuevos($senId) {
    $property = requestBody();

    //Disable Seminuevo from database
    $sql_u_s = "UPDATE camSeminuevos
                SET SEN_Status = :new_status
                WHERE SEN_Id = :senId
                AND SEN_Status <> :old_status";
    $structure_u_s = array();
    $params_u_s = array(
        'senId' => $senId,
        'new_status' => 0,
        'old_status' => 0
    );
    $result_u_s = restructureQuery($structure_u_s, getConnection(), $sql_u_s, $params_u_s, 2, PDO::FETCH_ASSOC);

    //Delete pictures from database
    $sql_d_p = "DELETE
                FROM camPictures
                WHERE PIC_SEN_Id = :senId";
    $structure_d_p = array();
    $params_d_p = array(
        'senId' => $senId,
    );
    $result_d_p = restructureQuery($structure_d_p, getConnection(), $sql_d_p, $params_d_p, 3, PDO::FETCH_ASSOC);

    //Delete files and directory
    $path = '../../cdn/img/seminuevos/' . $senId;
    $dir = dir($path);
    while (( $file = $dir->read() ) !== false) {
        $picture = $path . '/' . $file;
        if (is_file($picture) && file_exists($picture)) {
            unlink($picture);
        }
    }
    $dir->close();

    rmdir($path);

    echo changeArrayIntoJSON('camadpa', array('process' => 'ok'));
}

function delPictures() {
    $property = requestBody();

    $picId = trim($property->picId);
    $senId = trim($property->senId);
    $nombre = $property->picNombre;

    $sql = "DELETE
            FROM camPictures
            WHERE PIC_Id = :picId
            AND PIC_SEN_Id = :senId";
    $structure = array();
    $params = array(
        'picId' => $picId,
        'senId' => $senId
    );

    $result = restructureQuery($structure, getConnection(), $sql, $params, 3, PDO::FETCH_ASSOC);

    $base = '../../cdn/img/seminuevos/' . $senId;
    $picture = $base . '/' . $nombre;

    if (file_exists($picture)) {
        unlink($picture);
    }

    echo changeArrayIntoJSON('camadpa', $result);
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
        'thm' => 'PIC_Thum'
    );
    $params = array();
    ($senId !== '') ? $params['senId'] = $senId : $params = $params;
    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

    for($idx = 0; $idx < count($result); $idx++) {
        $result[$idx]['thm_possible'] = ($result[$idx]['thm']) ? '' : '1';
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
        ),
        'thm_nombre' => 'THM_Nombre',
        'thm_folder' => 'THM_Folder'
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
    $sql = "SELECT sen.*, thm.PIC_Id,
                   COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') THM_Nombre,
                   COALESCE(thm.PIC_SEN_Id, 'default') THM_Folder
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0
                ORDER BY SEN_Id ASC
            ) sen
            LEFT JOIN (
                SELECT *
                FROM camPictures
                WHERE PIC_Thum = 1
            ) thm
            ON sen.SEN_Id = thm.PIC_SEN_Id";
    getSeminuevosJSON($sql, '', '', '', '', '', '');
}

function getSeminuevosById($senId) {
    $sql = "SELECT sen.*, thm.PIC_Id,
                   COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') THM_Nombre,
                   COALESCE(thm.PIC_SEN_Id, 'default') THM_Folder
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0
                AND SEN_Id = :senId
                ORDER BY SEN_Id ASC
            ) sen
            LEFT JOIN (
                SELECT *
                FROM camPictures
                WHERE PIC_Thum = 1
            ) thm
            ON sen.SEN_Id = thm.PIC_SEN_Id";
    getSeminuevosJSON($sql, $senId, '', '', '', '', '');
}

function getSeminuevosByAgenciaId($agnId) {
    $sql = "SELECT sen.*, thm.PIC_Id,
                   COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') THM_Nombre,
                   COALESCE(thm.PIC_SEN_Id, 'default') THM_Folder
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0
                AND AGN_Id = :agnId
                ORDER BY SEN_Id ASC
            ) sen
            LEFT JOIN (
                SELECT *
                FROM camPictures
                WHERE PIC_Thum = 1
            ) thm
            ON sen.SEN_Id = thm.PIC_SEN_Id";
    getSeminuevosJSON($sql, '', $agnId, '', '', '', '');
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

    $sql_sem  = "SELECT sen.*, thm.PIC_Id,
                   COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') THM_Nombre,
                   COALESCE(thm.PIC_SEN_Id, 'default') THM_Folder
            FROM (
                SELECT *
                FROM v_camSeminuevos
                WHERE SEN_Status <> 0
                $where
                ORDER BY $sortingField $sort
            ) sen
            LEFT JOIN (
                SELECT *
                FROM camPictures
                WHERE PIC_Thum = 1
            ) thm
            ON sen.SEN_Id = thm.PIC_SEN_Id";

    $sql = "SELECT *
            FROM (
                $sql_sem
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

function getHeaderAgenciaJSON($sql, $agn_id) {
    $structure = array(
        'agn_id' => 'AGN_Id',
        'agn_header' => 'AGN_Header'
    );
    $params = array();
    ($agn_id !== '') ? $params['agn_id'] = $agn_id : $params = $params;
    $result = restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);

    echo changeArrayIntoJSON('camadpa', $result);
}

function getHeaderAgencias() {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Tipo = 0";
    getHeaderAgenciaJSON($sql, '');
}

function getHeaderAgencia($agn_id) {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Tipo = 0
            AND AGN_Id = :agn_id";
    getHeaderAgenciaJSON($sql, $agn_id);
}

function getAgencias() {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Tipo = 0
            ORDER BY AGN_Nombre ASC";
    getAgenciasJSON($sql, '');
}

function getAgenciasById($agnId) {
    $sql = "SELECT *
            FROM camAgencias
            WHERE AGN_Tipo = 0
            AND AGN_Id = :agnId
            ORDER BY AGN_Nombre ASC";
    getAgenciasJSON($sql, $agnId);
}

function getAgenciasFromSeminuevos() {
    $sql = "SELECT *
            FROM v_camSeminuevos
            WHERE AGN_Tipo = 0
            GROUP BY AGN_Id ASC
            ORDER BY AGN_Nombre ASC";
    getAgenciasJSON($sql, '');
}

function getCategoriasArray($sql, $catId, $agnId) {
    $structure = array(
        'id' => 'CAT_Id',
        'nombre' => 'CAT_Nombre'
    );
    $params = array();
    ($catId !== '') ? $params['catId'] = $catId : $params = $params;
    ($agnId !== '') ? $params['agnId'] = $agnId : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getCategoriasJSON($sql, $catId, $agnId) {
    $result = getCategoriasArray($sql, $catId, $agnId);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getCategorias() {
    $sql = "SELECT *
            FROM camCategorias
            ORDER BY CAT_Nombre ASC";
    getCategoriasJSON($sql, '', '');
}

function getCategoriasById($catId) {
    $sql = "SELECT *
            FROM camCategorias
            WHERE CAT_Id = :catId
            ORDER BY CAT_Nombre ASC";
    getCategoriasJSON($sql, $catId, '');
}

function getCategoriasFromSeminuevos() {
    $sql = "SELECT *
            FROM v_camSeminuevos
            GROUP BY CAT_Id
            ORDER BY CAT_Nombre ASC";
    getCategoriasJSON($sql, '', '');
}

function getCategoriasFromSeminuevosByAgenciaId($agnId) {
    $sql = "SELECT *
            FROM v_camSeminuevos
            WHERE AGN_Id = :agnId
            GROUP BY CAT_Id
            ORDER BY CAT_Nombre ASC";
    getCategoriasJSON($sql, '', $agnId);
}

function getMarcasArray($sql, $marId, $agnId) {
    $structure = array(
        'id' => 'MAR_Id',
        'nombre' => 'MAR_Nombre'
    );
    $params = array();
    ($marId !== '') ? $params['marId'] = $marId : $params = $params;
    ($agnId !== '') ? $params['agnId'] = $agnId : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getMarcasJSON($sql, $marId, $agnId) {
    $result = getMarcasArray($sql, $marId, $agnId);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getMarcas() {
    $sql = "SELECT *
            FROM camMarcas
            ORDER BY MAR_Nombre ASC";
    getMarcasJSON($sql, '', '');
}

function getMarcasById($marId) {
    $sql = "SELECT *
            FROM camMarcas
            WHERE MAR_Id = :marId
            ORDER BY MAR_Nombre ASC";
    getMarcasJSON($sql, $marId, '');
}

function getMarcasFromSeminuevosByAgenciaId($agnId) {
    $sql = "SELECT *
            FROM v_camSeminuevos
            WHERE AGN_Id = :agnId
            GROUP BY MAR_Id
            ORDER BY MAR_Nombre ASC";
    getMarcasJSON($sql, '', $agnId);
}

function getModelosArray($sql, $mdoId, $agnId, $marId) {
    $structure = array(
        'id' => 'MDO_Id',
        'nombre' => 'MDO_Nombre'
    );
    $params = array();
    ($mdoId !== '') ? $params['mdoId'] = $mdoId : $params = $params;
    ($agnId !== '') ? $params['agnId'] = $agnId : $params = $params;
    ($marId !== '') ? $params['marId'] = $marId : $params = $params;
    return restructureQuery($structure, getConnection(), $sql, $params, 0, PDO::FETCH_ASSOC);
}

function getModelosJSON($sql, $mdoId, $agnId, $marId) {
    $result = getModelosArray($sql, $mdoId, $agnId, $marId);
    echo changeArrayIntoJSON('camadpa', $result);
}

function getModelos() {
    $sql = "SELECT *
            FROM camModelos
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, '', '', '');
}

function getModelosById($mdoId) {
    $sql = "SELECT *
            FROM camModelos
            WHERE MDO_Id = :mdoId
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, $mdoId, '', '');
}

function getModelosFromSeminuevosByAgenciaId($agnId) {
    $sql = "SELECT *
            FROM v_camSeminuevos
            WHERE AGN_Id = :agnId
            GROUP BY MDO_Id
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, '', $agnId, '');
}

function getModelosFromSeminuevosByMarcaId($marId, $agnId) {
    $sql = "SELECT *
            FROM v_camSeminuevos
            WHERE MAR_Id = :marId
            AND AGN_Id = :agnId
            GROUP BY MDO_Id
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, '', $agnId, $marId);
}

function getModelosByMarcaId($marId) {
    $sql = "SELECT *
            FROM v_camModelosMarcas
            WHERE MAR_Id = :marId
            ORDER BY MDO_Nombre ASC";
    getModelosJSON($sql, '', '', $marId);
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

