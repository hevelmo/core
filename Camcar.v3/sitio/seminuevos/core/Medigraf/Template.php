<?php

//namespace Medigraf;

class Template {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $loader;
    private $twig;
    
    private $path;
    private $name;
    private $twigConfig;
    private $masterConfigArray;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    function __construct($path, $name, $twigConfig, $masterConfigArray) {
        $this->path              = $path;
        $this->name              = $name;
        $this->twigConfig        = $twigConfig;
        $this->masterConfigArray = $masterConfigArray;
        $this->startTwig();
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getPath() {
        return $this->path;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getMasterConfigArray() {
        return $this->masterConfigArray;
    }
    
    public function getTwigConfig() {
        return $this->twigConfig;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- SETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function setPath($path) {
        $this->path = $path;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function setMasterConfigArray($masterConfigArray) {
        $this->masterConfigArray = $masterConfigArray;
    }
    
    public function setTwigConfig($twigConfig) {
        $this->twigConfig = $twigConfig;
    }
    
    //---------------------------------------------------------------------------------------------
    //------------------------------------------ ADDERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function addToMasterConfigArray() {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            call_user_func_array(array(
                $this,
                $methodName
            ), $args);
            ksort($this->masterConfigArray);
        //Otherwise
        } else {
        }
    }
    
    private function addToMasterConfigArray1($masterConfigArray) {
        $this->masterConfigArray = array_merge($this->masterConfigArray, $masterConfigArray);
    }
    
    private function addToMasterConfigArray2($key, $value) {
        $this->masterConfigArray[$key] = $value;
    }
    
    //---------------------------------------------------------------------------------------------
    //------------------------------------ TWIG PERFORMANCE ---------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function display() {
        $this->twig->display($this->name, $this->masterConfigArray);
    }
    
    public function render() {
        return $this->twig->render($this->name, $this->masterConfigArray);
    }
    
    private function startTwig() {
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($this->path);
        $this->twig   = new Twig_Environment($this->loader, $this->twigConfig);
    }
    
}
