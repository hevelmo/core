<?php
//namespace Medigraf;

/**
 * This class 
 * 
 * @author Francisco Javier Corona Sánchez <javier@medigraf.com.mx>
 * @copyright 2017
 */
class Router
{
    private $request;
    private $response;
    private $args;
    
    /**
     * Description
     * @return type
     */    
    function __construct()
    {
        $this->resultArray = array();
        //Get an array arguments to the method
        $args              = func_get_args();
        //Get number of arguments
        $numArgs           = func_num_args();
        //Make a method name
        $methodName        = "construct" . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            call_user_func_array(array(
                $this,
                $methodName
            ), $args);
            //Otherwise
        } else {
        }
    }
    
    /**
     * Description
     * @return type
     */
    function construct0()
    {
    }
    
    /**
     * Description
     * @param type $request 
     * @param type $response 
     * @param type $args 
     * @return type
     */
    function construct3($request, $response, $args)
    {
        $this->request  = $request;
        $this->response = $response;
        $this->args     = $args;
    }
    
    /**
     * Description
     * @return type
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Description
     * @return type
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * Description
     * @return type
     */
    public function getArgs()
    {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            return call_user_func_array(array(
                $this,
                $methodName
            ), $args);
            //Otherwise
        } else {
        }
    }
    
    /**
     * Description
     * @param type $keys 
     * @return type
     */
    private function getArgs1($keys)
    {
        return (gettype($keys) === "array") ? $this->getArgsArray($keys) : $this->getArgsValue($keys);
    }
    
    /**
     * Description
     * @return type
     */
    private function getArgs0()
    {
        return $this->args;
    }
    
    /**
     * Description
     * @param type $key 
     * @return type
     */
    private function getArgsValue($key)
    {
        return (array_key_exists($key, $this->args)) ? $this->args[$key] : false;
    }
    
    /**
     * Description
     * @param type $keys 
     * @return type
     */
    private function getArgsArray($keys)
    {
        $foundArgs = array();
        foreach ($keys as $key) {
            $foundArgs[$key] = $this->getArgsValue($key);
        }
        return $foundArgs;
    }
    
    /**
     * Description
     * @return type
     */
    public function getProperty()
    {
        return (object) $this->request->getParsedBody();
    }

    /**
     * Description
     * @return type
     */
    public function getCurrentUrl() {
        $currentUrl =  $this->request->getUri()->getBaseUrl();
        $currentUrl .= ($this->request->getUri()->getPath() !== "" && $this->request->getUri()->getPath() !== NULL) 
            ? "/" . $this->request->getUri()->getPath() 
            : "";
        return $currentUrl;
    }
    
    /**
     * Description
     * @param type $request 
     * @param type $response 
     * @param type $args 
     * @return type
     */
    public function setRouteParams($request, $response, $args)
    {
        $this->setRequest($request);
        $this->setResponse($response);
        $this->setArgs($args);
    }
    
    /**
     * Description
     * @param type $request 
     * @return type
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    /**
     * Description
     * @param type $response 
     * @return type
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
    
    /**
     * Description
     * @param type $args 
     * @return type
     */
    public function setArgs($args)
    {
        foreach ($args as $key => $value) {
            $args[$key] = (gettype($value) === "string") ? trim($value) : $value;
            if ($args[$key] === "") {
                unset($args[$key]);
            }
        }
        $this->args = $args;
    }
}