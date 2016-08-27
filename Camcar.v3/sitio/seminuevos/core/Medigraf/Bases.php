<?php

//namespace Medigraf;

class Bases {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $constants;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    function __construct() {
        $this->constants = array(
            "_host" => _HOST,
            "_intranet" => _INTRANET,
            "_admin" => _ADMIN,
            "_sitio" => _SITIO,
            "_seminuevos" => _SEMINUEVOS,
            "_inventarios" => _INVENTARIOS,
            "_detalles" => _DETALLES,
            "_anio" => date("o")
        );
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getConstants() {
        return $this->constants;
    }
    
}
