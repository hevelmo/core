<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

/**
 *
 * [Initial V 1.0]
 *
 */

require_once "core/vendor/autoload.php";
include_once "core/environment/WaxConfigSet.php";

//Medigraf

include_once "core/Medigraf/Bases.php";
//include_once "core/Medigraf/Invoker.php";
include_once "core/Medigraf/Router.php";
include_once "core/Medigraf/Curl.php";
include_once "core/Medigraf/Template.php";

$container = new \Slim\Container();

$container["notFoundHandler"] = function($c) {
    return function($request, $response) use ($c) {
        return $c["response"]
            ->withStatus(404)
            ->withHeader("Content-Type", "text/html")
            ->write((new Control404())->getTemplate()->render());
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
Cuerpo del sitio web principal

*/



$app->get("/", function($request, $response, $args) {
    return $response->withRedirect(substr(_INVENTARIOS, 0, -1));
});
$app->get("/inventarios[/{marca}[/{modelo}[/{mystery}]]]", "ControlInventarios:__invoke");
$app->get("/detalles/{marca}/{modelo}/{sen_id}", "ControlDetalles:__invoke");
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
      ___           ___           ___                         ___           ___                   
     /\__\         /\  \         /\  \                       /\  \         /\  \                  
    /:/  /        /::\  \        \:\  \         ___         /::\  \       /::\  \                 
   /:/  /        /:/\:\  \        \:\  \       /\__\       /:/\:\__\     /:/\:\  \                
  /:/  /  ___   /:/  \:\  \   _____\:\  \     /:/  /      /:/ /:/  /    /:/  \:\  \   ___     ___ 
 /:/__/  /\__\ /:/__/ \:\__\ /::::::::\__\   /:/__/      /:/_/:/__/___ /:/__/ \:\__\ /\  \   /\__\
 \:\  \ /:/  / \:\  \ /:/  / \:\~~\~~\/__/  /::\  \      \:\/:::::/  / \:\  \ /:/  / \:\  \ /:/  /
  \:\  /:/  /   \:\  /:/  /   \:\  \       /:/\:\  \      \::/~~/~~~~   \:\  /:/  /   \:\  /:/  / 
   \:\/:/  /     \:\/:/  /     \:\  \      \/__\:\  \      \:\~~\        \:\/:/  /     \:\/:/  /  
    \::/  /       \::/  /       \:\__\          \:\__\      \:\__\        \::/  /       \::/  /   
     \/__/         \/__/         \/__/           \/__/       \/__/         \/__/         \/__/    


Control Parent Class.
Ésta es la clase padre para el manejo general de las rutas de Slim.
Dicha clase provee los métodos necesarios para interactuar con la API
Y para mostrar los templates crados vía Twig.
Esta clase jamás se usará directamente por una ruta Slim,
Sino que cada ruta Slim será manejada por una clase hija de ControlMaster.

*/



abstract class ControlMaster {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $bases;
    private $router;
    private $curl;
    private $template;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    function __construct($masterConfigArray, $twigConfig, $name) {
        //BASES
        $this->bases   = new Bases();
        //ROUTER
        $this->router   = new Router();
        //CURL
        $this->curl     = new Curl(_HOST . "sitio/seminuevos/api/v1/");
        //TEMPLATE
        $this->template = new Template(
            "templates/twig/interfaz",
            $name,
            array_merge(
                array(
                    "cache" => "cache",
                    "debug" => "true"
                ), 
                $twigConfig
            ), 
            array_merge(
                $this->bases->getConstants(),
                $masterConfigArray
            )
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
    
    public function getCurl() {
        return $this->curl;
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
      ___           ___           ___                         ___           ___                   
     /\__\         /\  \         /\  \                       /\  \         /\  \                  
    /:/  /        /::\  \        \:\  \         ___         /::\  \       /::\  \                 
   /:/  /        /:/\:\  \        \:\  \       /\__\       /:/\:\__\     /:/\:\  \                
  /:/  /  ___   /:/  \:\  \   _____\:\  \     /:/  /      /:/ /:/  /    /:/  \:\  \   ___     ___ 
 /:/__/  /\__\ /:/__/ \:\__\ /::::::::\__\   /:/__/      /:/_/:/__/___ /:/__/ \:\__\ /\  \   /\__\
 \:\  \ /:/  / \:\  \ /:/  / \:\~~\~~\/__/  /::\  \      \:\/:::::/  / \:\  \ /:/  / \:\  \ /:/  /
  \:\  /:/  /   \:\  /:/  /   \:\  \       /:/\:\  \      \::/~~/~~~~   \:\  /:/  /   \:\  /:/  / 
   \:\/:/  /     \:\/:/  /     \:\  \      \/__\:\  \      \:\~~\        \:\/:/  /     \:\/:/  /  
    \::/  /       \::/  /       \:\__\          \:\__\      \:\__\        \::/  /       \::/  /   
     \/__/         \/__/         \/__/           \/__/       \/__/         \/__/         \/__/    


Control Child Classes.
En esta sección se declaran todas las clases hijas de ControlMaster.
Cada clase hijo corresponde a una ruta de Slim declarada en la parte del Room.
Toda respuesta final será en formato JSON.
Así mismo cada clase hijo puede agregar funcionalidad extra a la proporcionada
por el padre, según sea necesaria en cada una de ellas.

*/



//CONTROL 404

class Control404 extends ControlMaster {
    
    function __construct() {
        parent::__construct(array("title" => "Página no encontrada"), array(), "404/_main.twig");
    }
    
    public function __invoke($request, $response, $args) {
    }
    
}

//CONTROL SEMINUEVOS

class ControlSeminuevos extends ControlMaster {
    
    function __construct($masterConfigArray, $twigConfig, $name, $title) {
        parent::__construct(
            array_merge(
                array(
                    "title" => $title
                ), 
                $masterConfigArray
            ), 
            array_merge(
                array(), 
                $twigConfig
            ), 
            $name
        );
        parent::getTemplate()->addToMasterConfigArray("marcas", parent::getCurl()->routeGet("get/marcas")->campa);
    }
    
    public function __invoke($request, $response, $args) {
        foreach($args as $key => $value) {
            $args[$key] = trim((string)$value);
            if($args[$key] == "0" || $args[$key] == "") {
                unset($args[$key]);
            }
        }
        parent::getRouter()->setRouteParams($request, $response, $args);
        parent::getTemplate()->addToMasterConfigArray(parent::getRouter()->getArgs());
        parent::getTemplate()->addToMasterConfigArray("modelos", $this->getAPIModelos());
        parent::getTemplate()->addToMasterConfigArray("seminuevos", $this->getAPISeminuevos());
    }
    
    private function getAPIModelos() {
        $marca = parent::getRouter()->getArgs("marca");
        return ($marca !== false) 
            ? parent::getCurl()->routeGet("get/modelos" . "/" . $marca)->campa 
            : array();
    }
    
    private function getAPISeminuevos() {
        $args = parent::getRouter()->getArgs(array("marca", "modelo", "sen_id", "mystery"));
        $url  = "get/seminuevos";
        if($args["mystery"] !== false) {
            $url .= ($args["marca"] !== false) ? "/" . $args["marca"] : "/0";
            $url .= ($args["modelo"] !== false) ? "/" . $args["modelo"] : "/0";
            $url .= ($args["sen_id"] !== false) ? "/" . $args["sen_id"] : "/0";
            $url .= "/" . $args["mystery"];
        } else {
            $url .= ($args["marca"] !== false) ? "/" . $args["marca"] : "";
            $url .= ($args["modelo"] !== false) ? "/" . $args["modelo"] : "";
            $url .= ($args["sen_id"] !== false) ? "/" . $args["sen_id"] : "";
        }
        return parent::getCurl()->routeGet($url)->campa;
    }
    
}

//CONTROL INVENTARIOS

class ControlInventarios extends ControlSeminuevos {
    
    function __construct() {
        parent::__construct(array(), array(), "seminuevos/inventarios/_main.twig", "CAMCAR Seminuevos|Inventarios");
    }
    
    public function __invoke($request, $response, $args) {
        parent::__invoke($request, $response, $args);
        parent::getTemplate()->display();
    }
    
}

//CONTROL DETALLE

class ControlDetalles extends ControlSeminuevos {
    
    function __construct() {
        parent::__construct(array(), array(), "seminuevos/detalles/_main.twig", "CAMCAR Seminuevos|Detalles");
    }
    
    public function __invoke($request, $response, $args) {
        parent::__invoke($request, $response, $args);
        parent::getTemplate()->addToMasterConfigArray("imagenes", $this->getAPIImagenes());
        parent::getTemplate()->addToMasterConfigArray("mapas", $this->getAPIMapas());
        parent::getTemplate()->display();
        $post = $this->addAPIVisitas();
    }

    private function getAPIImagenes() {
        $senId = parent::getRouter()->getArgs("sen_id");
        return ($senId !== false) 
            ? parent::getCurl()->routeGet("get/imagenes" . "/" . $senId)->campa 
            : array();
    }
    
    private function getAPIRelacionados() {
        $marca = parent::getRouter()->getArgs("marca");
        return ($marca !== false) 
            ? parent::getCurl()->routeGet("get/relacionados" . "/" . $marca)->campa 
            : array();
    }
    
    private function getAPIMapas() {
        $senId = parent::getRouter()->getArgs("sen_id");
        return ($senId !== false) 
            ? parent::getCurl()->routeGet("get/mapas" . "/" . $senId)->campa 
            : array();
    }
    
    private function addAPIVisitas() {
        $senId = parent::getRouter()->getArgs("sen_id");
        return ($senId !== false) 
            ? parent::getCurl()->routePost("add/visitas" . "/" . $senId, array("vis_ip" => $_SERVER["REMOTE_ADDR"])) 
            : array();
    }
    
}
