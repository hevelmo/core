<?php

//namespace Medigraf;

class Router {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $request;
    private $response;
    private $args;
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- CONSTRUCT ------------------------------------------
    //---------------------------------------------------------------------------------------------

    function __construct() {
        $this->resultArray = array();
        //Get an array arguments to the method
        $args              = func_get_args();
        //Get number of arguments
        $numArgs           = func_num_args();
        //Make a method name
        $methodName        = "construct" . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            call_user_func_array(array($this, $methodName), $args);
        //Otherwise
        } else {
        }
    }
    
    function construct0() {
    }
    
    function construct3($request, $response, $args) {
        $this->request  = $request;
        $this->response = $response;
        $this->args     = $args;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getRequest() {
        return $this->request;
    }
    
    public function getResponse() {
        return $this->response;
    }
    
    public function getArgs() {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            return call_user_func_array(array($this, $methodName), $args);
        //Otherwise
        } else {
        }
    }
    
    private function getArgs1($keys) {
        return (gettype($keys) === "array") 
            ? $this->getArgsArray($keys) 
            : $this->getArgsValue($keys);
    }
    
    private function getArgs0() {
        return $this->args;
    }
    
    private function getArgsValue($key) {
        return (array_key_exists($key, $this->args)) ? $this->args[$key] : false;
    }
    
    private function getArgsArray($keys) {
        $foundArgs = array();
        foreach ($keys as $key) {
            $foundArgs[$key] = $this->getArgsValue($key);
        }
        return $foundArgs;
    }
    
    public function getProperty() {
        return (object) $this->request->getParsedBody();
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- SETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function setRouteParams($request, $response, $args) {
        $this->setRequest($request);
        $this->setResponse($response);
        $this->setArgs($args);
    }
    
    public function setRequest($request) {
        $this->request = $request;
    }
    
    public function setResponse($response) {
        $this->response = $response;
    }
    
    public function setArgs($args) {
        foreach ($args as $key => $value) {
            $args[$key] = (gettype($value) === "string") ? trim($value) : $value;
            if ($args[$key] === "") {
                unset($args[$key]);
            }
        }
        $this->args = $args;
    }
    
}
