<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

include_once "../../../../incorporate/db_connect.php";
include_once "../../../../incorporate/functions.php";
include_once "../../../../incorporate/queryintojson.php";
include_once '../Mandrill.php';

/**
 *
 * [Initial V 1.0]
 *
 */

require_once "../../core/vendor/autoload.php";
include_once "../../core/environment/WaxConfigSet.php";

//Medigraf

include_once "../../core/Medigraf/Bases.php";
//include_once "../../core/Medigraf/Invoker.php";
include_once "../../core/Medigraf/Router.php";
include_once "../../core/Medigraf/Consult.php";
include_once "../../core/Medigraf/Sender.php";
include_once "../../core/Medigraf/Template.php";

$container = new \Slim\Container();

$container["notFoundHandler"] = function($c) {
    return function($request, $response) use ($c) {
        return $c["response"]
            ->withStatus(404)
            ->withHeader("Content-Type", "text/html")
            ->write("No encontrado Handler");
    };
};

$app = new \Slim\App($container);



/*
      ___           ___           ___           ___     
     /\  \         /\  \         /\  \         /\  \    
    /::\  \       /::\  \       /::\  \       |::\  \   
   /:/\:\__\     /:/\:\  \     /:/\:\  \      |:|:\  \  
  /:/ /:/  /    /:/  \:\  \   /:/  \:\  \   __|:|\:\  \ 
 /:/_/:/__/___ /:/__/ \:\__\ /:/__/ \:\__\ /::::|_\:\__\
 \:\/:::::/  / \:\  \ /:/  / \:\  \ /:/  / \:\~~\  \/__/
  \::/~~/~~~~   \:\  /:/  /   \:\  /:/  /   \:\  \      
   \:\~~\        \:\/:/  /     \:\/:/  /     \:\  \     
    \:\__\        \::/  /       \::/  /       \:\__\    
     \/__/         \/__/         \/__/         \/__/    


Url Principales
Cuerpo de la API

*/

//---------------------------------------------------------------------------------------------
//---------------------------------------- GET ROUTES -----------------------------------------
//---------------------------------------------------------------------------------------------

//HOME
$app->get("/", "ConsultHome:__invoke");

//SELECT
$app->get("/get/marcas", "SelectMarcas:__invoke");
$app->get("/get/modelos[/{marca}]", "SelectModelos:__invoke");
$app->get("/get/seminuevos[/{marca}[/{modelo}[/{sen_id}[/{mystery}]]]]", "SelectSeminuevos:__invoke");
$app->get("/get/relacionados/{marca}[/{modelo}]", "SelectRelacionados:__invoke");
$app->get("/get/imagenes/{sen_id}", "SelectImagenes:__invoke");
$app->get("/get/mapas/{sen_id}", "SelectMapas:__invoke");

//---------------------------------------------------------------------------------------------
//---------------------------------------- POST ROUTES ----------------------------------------
//---------------------------------------------------------------------------------------------

//INSERT
$app->post("/add/visitas/{sen_id}", "InsertVisitas:__invoke");
$app->post("/add/contactos/{sen_id}", "InsertContactos:__invoke");

//SEND
$app->post("/send/contactos", "SendContactos:__invoke");

$app->run();



/*
      ___         ___           ___           ___           ___                                   
     /\  \       /\  \         /\  \         /\__\         /\  \                                  
    /::\  \     /::\  \       /::\  \       /:/ _/_        \:\  \         ___                     
   /:/\:\__\   /:/\:\  \     /:/\:\__\     /:/ /\__\        \:\  \       /\__\                    
  /:/ /:/  /  /:/ /::\  \   /:/ /:/  /    /:/ /:/ _/_   _____\:\  \     /:/  /                    
 /:/_/:/  /  /:/_/:/\:\__\ /:/_/:/__/___ /:/_/:/ /\__\ /::::::::\__\   /:/__/                     
 \:\/:/  /   \:\/:/  \/__/ \:\/:::::/  / \:\/:/ /:/  / \:\~~\~~\/__/  /::\  \                     
  \::/__/     \::/__/       \::/~~/~~~~   \::/_/:/  /   \:\  \       /:/\:\  \                    
   \:\  \      \:\  \        \:\~~\        \:\/:/  /     \:\  \      \/__\:\  \                   
    \:\__\      \:\__\        \:\__\        \::/  /       \:\__\          \:\__\                  
     \/__/       \/__/         \/__/         \/__/         \/__/           \/__/                  
      ___           ___           ___           ___           ___                                 
     /\__\         /\  \         /\  \         /\__\         /\  \                                
    /:/  /        /::\  \        \:\  \       /:/ _/_        \:\  \                       ___     
   /:/  /        /:/\:\  \        \:\  \     /:/ /\  \        \:\  \                     /\__\    
  /:/  /  ___   /:/  \:\  \   _____\:\  \   /:/ /::\  \   ___  \:\  \   ___     ___     /:/  /    
 /:/__/  /\__\ /:/__/ \:\__\ /::::::::\__\ /:/_/:/\:\__\ /\  \  \:\__\ /\  \   /\__\   /:/__/     
 \:\  \ /:/  / \:\  \ /:/  / \:\~~\~~\/__/ \:\/:/ /:/  / \:\  \ /:/  / \:\  \ /:/  /  /::\  \     
  \:\  /:/  /   \:\  /:/  /   \:\  \        \::/ /:/  /   \:\  /:/  /   \:\  /:/  /  /:/\:\  \    
   \:\/:/  /     \:\/:/  /     \:\  \        \/_/:/  /     \:\/:/  /     \:\/:/  /   \/__\:\  \   
    \::/  /       \::/  /       \:\__\         /:/  /       \::/  /       \::/  /         \:\__\  
     \/__/         \/__/         \/__/         \/__/         \/__/         \/__/           \/__/  


Consult Parent Class.
Ésta es la clase padre para el manejo general de las rutas de Slim.
Dicha clase provee los métodos necesarios para interactuar con la base de datos
Que se se haya configurado en el proyecto principal, para así poder hacer consultas
sobre ella y obtener, agregar, modificar y eliminar información.
Esta clase jamás se usará directamente por una ruta Slim,
Sino que cada ruta Slim será manejada por una clase hija de ConsultlMaster.

*/



abstract class ConsultMaster {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $bases;
    private $router;
    private $consult;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    function __construct() {
        //BASES
        $this->bases   = new Bases();
        //ROUTER
        $this->router   = new Router();
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = "construct" . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            call_user_func_array(array($this, $methodName), $args);
        //Otherwise
        } else {
        }
    }
    
    function construct0() {
        $this->construct5("", array(), array(), 0, false);
    }
    
    function construct1($properties) {
        $this->construct5(
            $properties["sql"], 
            $properties["params"], 
            $properties["structure"], 
            $properties["typeQuery"], 
            $properties["multilevel"]
        );
    }
    
    function construct5($sql = "", $params = array(), $structure = array(), $typeQuery = 0, $multilevel = false) {
        $this->sql        = $sql;
        $this->params     = $params;
        $this->structure  = $structure;
        $this->typeQuery  = $typeQuery;
        $this->multilevel = $multilevel;
        //CONSULT
        $this->consult   = new Consult(
            "campa",
            getConnection(),
            $this->sql,
            $this->params,
            $this->structure,
            $this->typeQuery,
            $this->multilevel
        );
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getBases() {
        return $this->bases;
    }
    
    public function getRouter() {
        return $this->router;
    }
    
    public function getConsult() {
        return $this->consult;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- ABSTRACTS -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    abstract public function __invoke($request, $response, $args);
    
}



/*
      ___           ___                                                   ___                     
     /\__\         /\  \                                   _____         /\__\                    
    /:/  /         \:\  \       ___                       /::\  \       /:/ _/_                   
   /:/  /           \:\  \     /\__\                     /:/\:\  \     /:/ /\  \                  
  /:/  /  ___   ___ /::\  \   /:/__/      ___     ___   /:/  \:\__\   /:/ /::\  \                 
 /:/__/  /\__\ /\  /:/\:\__\ /::\  \     /\  \   /\__\ /:/__/ \:|__| /:/_/:/\:\__\                
 \:\  \ /:/  / \:\/:/  \/__/ \/\:\  \__  \:\  \ /:/  / \:\  \ /:/  / \:\/:/ /:/  /                
  \:\  /:/  /   \::/__/       ~~\:\/\__\  \:\  /:/  /   \:\  /:/  /   \::/ /:/  /                 
   \:\/:/  /     \:\  \          \::/  /   \:\/:/  /     \:\/:/  /     \/_/:/  /                  
    \::/  /       \:\__\         /:/  /     \::/  /       \::/  /        /:/  /                   
     \/__/         \/__/         \/__/       \/__/         \/__/         \/__/                    
      ___           ___           ___           ___           ___                                 
     /\__\         /\  \         /\  \         /\__\         /\  \                                
    /:/  /        /::\  \        \:\  \       /:/ _/_        \:\  \                       ___     
   /:/  /        /:/\:\  \        \:\  \     /:/ /\  \        \:\  \                     /\__\    
  /:/  /  ___   /:/  \:\  \   _____\:\  \   /:/ /::\  \   ___  \:\  \   ___     ___     /:/  /    
 /:/__/  /\__\ /:/__/ \:\__\ /::::::::\__\ /:/_/:/\:\__\ /\  \  \:\__\ /\  \   /\__\   /:/__/     
 \:\  \ /:/  / \:\  \ /:/  / \:\~~\~~\/__/ \:\/:/ /:/  / \:\  \ /:/  / \:\  \ /:/  /  /::\  \     
  \:\  /:/  /   \:\  /:/  /   \:\  \        \::/ /:/  /   \:\  /:/  /   \:\  /:/  /  /:/\:\  \    
   \:\/:/  /     \:\/:/  /     \:\  \        \/_/:/  /     \:\/:/  /     \:\/:/  /   \/__\:\  \   
    \::/  /       \::/  /       \:\__\         /:/  /       \::/  /       \::/  /         \:\__\  
     \/__/         \/__/         \/__/         \/__/         \/__/         \/__/           \/__/  


Consult Child Classes.
En esta sección se declaran todas las clases hijas de ConsultlMaster.
Cada clase hijo corresponde a una ruta de Slim declarada en la parte del Room.
Así mismo cada clase hijo puede agregar funcionalidad extra a la proporcionada
por el padre, según sea necesaria en cada una de ellas.

*/



//---------------------------------------------------------------------------------------------
//---------------------------------------- GET METHODS ----------------------------------------
//---------------------------------------------------------------------------------------------

//CONSULT SELECT HOME

class ConsultHome extends ConsultMaster {
    
    function __construct() {
    }
    
    public function __invoke($request, $response, $args) {
    }
    
}

//CONSULT SELECT MARCAS

class SelectMarcas extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(
                "id" => "MAR_Id",
                "nombre" => "MAR_Nombre",
                "nombre_short" => "MAR_NombreShort"
            ),
            "typeQuery" => 0,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        //PARAMS
        parent::getConsult()->makeParams($args);
        //WHERE
        $where = parent::getConsult()->makeWhere(
            "SEN_Status <> 0", 
            array(), 
            $args
        );
        //SQL
        parent::getConsult()->setSql(
            "SELECT *
             FROM v_camSeminuevos
             WHERE $where
             GROUP BY MAR_Id
             ORDER BY MAR_Nombre ASC"
        );
        //EXECUT
        parent::getConsult()->selectQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}

//CONSULT SELECT MODELOS

class SelectModelos extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(
                "id" => "MDO_Id",
                "nombre" => "MDO_Nombre",
                "nombre_short" => "MDO_NombreShort"
            ),
            "typeQuery" => 0,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        //PARAMS
        parent::getConsult()->makeParams($args);
        //WHERE
        $where = parent::getConsult()->makeWhere(
            "SEN_Status <> 0", 
            array(
                "marca" => array(
                    array("AND", "MAR_NombreShort", "=")
                )
            ), 
            $args
        );
        //SQL
        parent::getConsult()->setSql(
            "SELECT *
             FROM v_camSeminuevos
             WHERE $where
             GROUP BY MDO_Id
             ORDER BY MDO_Nombre ASC"
        );
        //EXECUT
        parent::getConsult()->selectQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}

//CONSULT SELECT SEMINUEVOS

class SelectSeminuevos extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(
                "id" => "SEN_Id",
                "anio" => "SEN_Year",
                "precio" => "SEN_Precio",
                "cilindros" => "SEN_Cilindros",
                "transmision" => "SEN_Transmision",
                "color" => "SEN_Color",
                "interior" => "SEN_Interior",
                "kilometraje" => "SEN_Kilometraje",
                "descripcion" => "SEN_Descripcion",
                "agencia" => array(
                    "id" => "AGN_Id",
                    "nombre" => "AGN_Nombre",
                    "pseudonimo" => "AGN_Seudonimo",
                    "direccion" => "AGN_Direccion",
                    "correo" => "AGN_Mail",
                    "folder" => "AGN_Folder",
                    "logo" => "AGN_Logo1"
                ),
                "telefonos" => array(
                    //VENTAS
                    "ventas_tel_1" => "TEL_Telefono_Ventas_linea1",
                    "ventas_tel_2" => "TEL_Telefono_Ventas_linea2",
                    "ventas_call_1" => "TEL_Call_Ventas_linea1",
                    "ventas_call_2" => "TEL_Call_Ventas_linea2",
                    //SERVICIO
                    "servicio_tel_1" => "TEL_Telefono_Servicio_linea1",
                    "servicio_tel_2" => "TEL_Telefono_Servicio_linea2",
                    "servicio_call_1" => "TEL_Call_Servicio_linea1",
                    "servicio_call_2" => "TEL_Call_Servicio_linea2"
                ),
                "categoria" => array(
                    "id" => "CAT_Id",
                    "nombre" => "CAT_Nombre",
                    "nombre_short" => "CAT_NombreShort"
                ),
                "marca" => array(
                    "id" => "MAR_Id",
                    "nombre" => "MAR_Nombre",
                    "nombre_short" => "MAR_NombreShort"
                ),
                "modelo" => array(
                    "id" => "MDO_Id",
                    "nombre" => "MDO_Nombre",
                    "nombre_short" => "MDO_NombreShort"
                ),
                "thm_nombre" => "THM_Nombre",
                "thm_folder" => "THM_Folder"
            ),
            "typeQuery" => 0,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        //PARAMS
        parent::getConsult()->makeParams($args);
        //WHERE
        $where = parent::getConsult()->makeWhere(
            "sen.SEN_Status <> 0", 
            array(
                "marca" => array(
                    array("AND", "sen.MAR_NombreShort", "=")
                ),
                "modelo" => array(
                    array("AND", "sen.MDO_NombreShort", "=")
                ),
                "sen_id" => array(
                    array("AND", "sen.SEN_Id", "=")
                )
            ), 
            $args
        );
        //WHERE SERACH
        $whereSearch = parent::getConsult()->makeWhereSearch(
            "mystery", 
            array(
                "sen.SEN_Descripcion",
                "sen.AGN_Nombre",
                "sen.CAT_Nombre",
                "sen.MAR_Nombre",
                "sen.MDO_Nombre",
                "sen.SEN_Transmision",
                "sen.SEN_Color",
                "sen.SEN_Interior"
            ),
            $args
        );
        //SQL
        parent::getConsult()->setSql(
            "SELECT * 
             FROM(
                SELECT sen.*, thm.PIC_Id,
                    COALESCE(thm.PIC_Nombre, 'default_camcar.jpg') THM_Nombre,
                    COALESCE(thm.PIC_SEN_Id, 'default') THM_Folder
                FROM (
                    SELECT *
                    FROM v_camSeminuevos
                    ORDER BY SEN_Id ASC
                ) sen
                LEFT JOIN (
                    SELECT *
                    FROM camPictures
                    WHERE PIC_Thum = 1
                ) thm
                ON sen.SEN_Id = thm.PIC_SEN_Id
                WHERE $where
             ) sen
             WHERE $whereSearch"
        );
        //EXECUT
        parent::getConsult()->selectQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}

//CONSULT SELECT RELACIONADOS

class SelectRelacionados extends SelectSeminuevos {
    
    function __construct() {
        parent::__construct();
    }
    
    public function __invoke($request, $response, $args) {
        parent::__invoke($request, $response, $args);
    }
    
}

//CONSULT SELECT IMAGENES

class SelectImagenes extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(
                "id" => "PIC_Id",
                "folder" => "PIC_SEN_Id",
                "nombre" => "PIC_Nombre",
                "thumb" => "PIC_Thum"
            ),
            "typeQuery" => 0,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        //PARAMS
        parent::getConsult()->makeParams($args);
        //WHERE
        $where = parent::getConsult()->makeWhere(
            "sen.SEN_Status <> 0 AND pic.PIC_Status <> 0", 
            array(
                "sen_id" => array(
                    array("AND", "sen.SEN_Id", "="),
                    array("AND", "pic.PIC_SEN_Id", "=")
                )
            ), 
            $args
        );
        //SQL
        parent::getConsult()->setSql(
            "SELECT *
             FROM camSeminuevos sen
             INNER JOIN camPictures pic
             ON sen.SEN_Id = pic.PIC_SEN_Id
             WHERE $where
             ORDER BY sen.SEN_Id ASC, pic.PIC_Id ASC"
        );
        //EXECUT
        parent::getConsult()->selectQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}

//CONSULT SELECT MAPAS

class SelectMapas extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(
                "latitud" => "AGN_MLatitud",
                "longitud" => "AGN_MLongitud",
                "url" => "AGN_MUrl",
                "direccion" => "AGN_Direccion"
            ),
            "typeQuery" => 0,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        //PARAMS
        parent::getConsult()->makeParams($args);
        //WHERE
        $where = parent::getConsult()->makeWhere(
            "SEN_Status <> 0", 
            array(
                "sen_id" => array(
                    array("AND", "SEN_Id", "=")
                )
            ), 
            $args
        );
        //SQL
        parent::getConsult()->setSql(
            "SELECT *
             FROM v_camSeminuevos
             WHERE $where
             ORDER BY SEN_Id ASC, AGN_Id ASC"
        );
        //EXECUT
        parent::getConsult()->selectQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}

//---------------------------------------------------------------------------------------------
//--------------------------------------- POST METHODS ----------------------------------------
//---------------------------------------------------------------------------------------------

//CONSULT INSERT VISITAS

class InsertVisitas extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(),
            "typeQuery" => 1,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        parent::getRouter()->setRouteParams($request, $response, $args);
        $property = parent::getRouter()->getProperty();
        //PARAMS
        parent::getConsult()->makeParams(array_merge(
            $args, 
            array(
                "vis_ip" => $property->vis_ip,
                "fecha" => date("o-m-d H:i:s")
            )
        ));
        //SQL
        parent::getConsult()->setSql(
            "INSERT INTO camVisitas(
                VIS_Ip,
                VIS_SEN_Id,
                VIS_Fecha
             ) VALUES (
                :vis_ip,
                :sen_id,
                :fecha
             )"
        );
        //EXECUT
        parent::getConsult()->insertQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}

//CONSULT INSERT CONTACTOS

class InsertContactos extends ConsultMaster {
    
    function __construct() {
        parent::__construct(array(
            "sql" => "",
            "params" => array(),
            "structure" => array(),
            "typeQuery" => 1,
            "multilevel" => false
        ));
    }
    
    public function __invoke($request, $response, $args) {
        parent::getRouter()->setRouteParams($request, $response, $args);
        $property = parent::getRouter()->getProperty();
        //PARAMS
        parent::getConsult()->makeParams(array_merge(
            $args, 
            array(
                "cnt_nombre" => $property->cnt_nombre,
                "cnt_apellido" => $property->cnt_apellido,
                "cnt_mail" => $property->cnt_mail,
                "cnt_mail_to" => $property->cnt_mail_to,
                "cnt_telefono" => $property->cnt_telefono,
                "cnt_comentario" => $property->cnt_comentario,
                "fecha" => date("o-m-d H:i:s")
            )
        ));

        //SQL
        parent::getConsult()->setSql(
            "INSERT INTO camContactos(
                CNT_SEN_Id,
                CNT_Nombre,
                CNT_Apellido,
                CNT_Mail,
                CNT_MailTo,
                CNT_Telefono,
                CNT_Comentario,
                CNT_Fecha
             ) VALUES (
                :sen_id,
                :cnt_nombre,
                :cnt_apellido,
                :cnt_mail,
                :cnt_mail_to,
                :cnt_telefono,
                :cnt_comentario,
                :fecha
             )"
        );
        //EXECUT
        parent::getConsult()->insertQuery();
        parent::getConsult()->echoResultJSON();
    }
    
}


/*
      ___         ___           ___           ___           ___                   
     /\  \       /\  \         /\  \         /\__\         /\  \                  
    /::\  \     /::\  \       /::\  \       /:/ _/_        \:\  \         ___     
   /:/\:\__\   /:/\:\  \     /:/\:\__\     /:/ /\__\        \:\  \       /\__\    
  /:/ /:/  /  /:/ /::\  \   /:/ /:/  /    /:/ /:/ _/_   _____\:\  \     /:/  /    
 /:/_/:/  /  /:/_/:/\:\__\ /:/_/:/__/___ /:/_/:/ /\__\ /::::::::\__\   /:/__/     
 \:\/:/  /   \:\/:/  \/__/ \:\/:::::/  / \:\/:/ /:/  / \:\~~\~~\/__/  /::\  \     
  \::/__/     \::/__/       \::/~~/~~~~   \::/_/:/  /   \:\  \       /:/\:\  \    
   \:\  \      \:\  \        \:\~~\        \:\/:/  /     \:\  \      \/__\:\  \   
    \:\__\      \:\__\        \:\__\        \::/  /       \:\__\          \:\__\  
     \/__/       \/__/         \/__/         \/__/         \/__/           \/__/  
      ___           ___           ___                                             
     /\__\         /\__\         /\  \         _____                              
    /:/ _/_       /:/ _/_        \:\  \       /::\  \                             
   /:/ /\  \     /:/ /\__\        \:\  \     /:/\:\  \                            
  /:/ /::\  \   /:/ /:/ _/_   _____\:\  \   /:/  \:\__\                           
 /:/_/:/\:\__\ /:/_/:/ /\__\ /::::::::\__\ /:/__/ \:|__|                          
 \:\/:/ /:/  / \:\/:/ /:/  / \:\~~\~~\/__/ \:\  \ /:/  /                          
  \::/ /:/  /   \::/_/:/  /   \:\  \        \:\  /:/  /                           
   \/_/:/  /     \:\/:/  /     \:\  \        \:\/:/  /                            
     /:/  /       \::/  /       \:\__\        \::/  /                             
     \/__/         \/__/         \/__/         \/__/                              


Send Parent Class.
Ésta es la clase padre para el manejo general de envío de correos.
Dicha clase provee los métodos necesarios para interactuar con Mandil.
Esta clase jamás se usará directamente por una ruta Slim,
Sino que cada ruta Slim será manejada por una clase hija de SendMaster.

*/



abstract class SendMaster {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $router;
    private $sender;
    private $template;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    function __construct($masterConfigArray, $twigConfig, $name) {

        //ROUTER
        $this->router   = new Router();

        //SENDER
        $this->sender   = new Sender(new Mandrill("V6ypCDEnJAgL9FsOyyDxAw"));
        
        //TEMPLATE
        $this->template = new Template(
            "../../templates/twig/mensajes",
            $name,
            array_merge(
                array(
                    "cache" => "../../cache",
                    "debug" => "true"
                ), 
                $twigConfig
            ), 
            $masterConfigArray
        );
        
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getRouter() {
        return $this->router;
    }
    
    public function getSender() {
        return $this->sender;
    }
    
    public function getTemplate() {
        return $this->template;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- ABSTRACTS -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    abstract public function __invoke($request, $response, $args);
    
}



/*
      ___           ___                                                   ___     
     /\__\         /\  \                                   _____         /\__\    
    /:/  /         \:\  \       ___                       /::\  \       /:/ _/_   
   /:/  /           \:\  \     /\__\                     /:/\:\  \     /:/ /\  \  
  /:/  /  ___   ___ /::\  \   /:/__/      ___     ___   /:/  \:\__\   /:/ /::\  \ 
 /:/__/  /\__\ /\  /:/\:\__\ /::\  \     /\  \   /\__\ /:/__/ \:|__| /:/_/:/\:\__\
 \:\  \ /:/  / \:\/:/  \/__/ \/\:\  \__  \:\  \ /:/  / \:\  \ /:/  / \:\/:/ /:/  /
  \:\  /:/  /   \::/__/       ~~\:\/\__\  \:\  /:/  /   \:\  /:/  /   \::/ /:/  / 
   \:\/:/  /     \:\  \          \::/  /   \:\/:/  /     \:\/:/  /     \/_/:/  /  
    \::/  /       \:\__\         /:/  /     \::/  /       \::/  /        /:/  /   
     \/__/         \/__/         \/__/       \/__/         \/__/         \/__/    
      ___           ___           ___                                             
     /\__\         /\__\         /\  \         _____                              
    /:/ _/_       /:/ _/_        \:\  \       /::\  \                             
   /:/ /\  \     /:/ /\__\        \:\  \     /:/\:\  \                            
  /:/ /::\  \   /:/ /:/ _/_   _____\:\  \   /:/  \:\__\                           
 /:/_/:/\:\__\ /:/_/:/ /\__\ /::::::::\__\ /:/__/ \:|__|                          
 \:\/:/ /:/  / \:\/:/ /:/  / \:\~~\~~\/__/ \:\  \ /:/  /                          
  \::/ /:/  /   \::/_/:/  /   \:\  \        \:\  /:/  /                           
   \/_/:/  /     \:\/:/  /     \:\  \        \:\/:/  /                            
     /:/  /       \::/  /       \:\__\        \::/  /                             
     \/__/         \/__/         \/__/         \/__/                              


Send Child Classes.
En esta sección se declaran todas las clases hijas de SendMaster.
Cada clase hijo corresponde a una ruta de Slim declarada en la parte del Room.
Así mismo cada clase hijo puede agregar funcionalidad extra a la proporcionada
por el padre, según sea necesaria en cada una de ellas.

*/



//SEND CONTACTOS

class SendContactos extends SendMaster {
    
    function __construct() {
        parent::__construct(array(), array(), "contacto.twig");
    }
    
    public function __invoke($request, $response, $args) {
        parent::getRouter()->setRouteParams($request, $response, $args);
        $property = parent::getRouter()->getProperty();
        parent::getTemplate()->setMasterConfigArray((array) $property);
        parent::getSender()->__send(array(
            "html" => parent::getTemplate()->render(),
            "subject" => $property->sen_concessionary,
            "from_email" => "respuesta.segura@camcar.mx",
            "from_name" => $property->sen_name . " " . $property->sen_lastname,
            "to" => array(
                array(
                    //"email" => "javier@medigraf.com.mx",
                    "email" => $property->sen_email,
                    "name" => $property->sen_concessionary,
                    "type" => "to"
                )
            ),
            "headers" => array(
                //"Reply-To" => "javier@medigraf.com.mx"
                "Reply-To" => $property->sen_email
            ),
            "tags" => array(
                "orden-new-notificacion-camcar-sitio"
            ),
            "google_analytics_domains" => array(
                "http://camcar.mx/"
            ),
            "google_analytics_campaign" => "marina.reyes@camcar.mx",
            "metadata" => array(
                "website" => "http://camcar.mx/"
            )
        ));
        echo changeArrayIntoJSON("campa", array("process" => "ok"));
    }
    
}
