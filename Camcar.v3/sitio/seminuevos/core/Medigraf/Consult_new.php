<?php

//namespace Medigraf;

class Consult {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $resultArray;
    
    private $packName;
    private $connection;
    private $sql;
    private $params;
    private $structure;
    private $typeQuery;
    
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
    
    private function construct0() {
        $this->construct6("", array(), "", array(), array(), 0);
    }
    
    private function construct1($properties) {
        $this->construct6(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"], 
            $properties["structure"], 
            $properties["typeQuery"]
        );
    }
    
    private function construct6($packName = "", $connection = array(), $sql = "", $params = array(), $structure = array(), $typeQuery = 0) {
        $this->packName   = $packName;
        $this->connection = $connection;
        $this->sql        = $sql;
        $this->params     = $params;
        $this->structure  = $structure;
        $this->typeQuery  = $typeQuery;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getSql() {
        return $this->sql;
    }
    
    public function getParams() {
        return $this->params;
    }
    
    public function getResultArray() {
        return $this->resultArray;
    }
    
    public function getStructure() {
        return $this->structure;
    }
    
    public function getTypeQuery() {
        return $this->typeQuery;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- SETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function setSql($sql) {
        $this->sql = $sql;
    }
    
    public function setParams($params) {
        $this->params = $params;
    }
    
    public function setResultArray($resultArray) {
        $this->resultArray = $resultArray;
    }
    
    public function setStructure($structure) {
        $this->structure = $structure;
    }
    
    public function setTypeQuery($typeQuery) {
        $this->typeQuery = $typeQuery;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- MAKERS --------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function makeParams($params) {
        foreach ($params as $key => $value) {
            if (array_key_exists($key, $params) && $params[$key] != "0") {
                $this->params[$key] = $params[$key];
            }
        }
    }
    
    public function makeWhere($baseCondition = "1=1", $paramsConditions, $params) {
        $where = $baseCondition;
        foreach ($paramsConditions as $key => $value) {
            if (array_key_exists($key, $params) && $params[$key] != "0" && $params[$key] != "") {
                foreach($value as $condition) {
                    $where .= " {$condition[0]} {$condition[1]} {$condition[2]} :$key";
                }
            }
        }
        return $where;
    }
    
    //---------------------------------------------------------------------------------------------
    //------------------------------------------ ADDERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function addToParams() {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            call_user_func_array(array($this, $methodName), $args);
            ksort($this->params);
            //Otherwise
        } else {
        }
    }
    
    private function addToParams1($params) {
        $this->params = array_merge($this->params, $params);
    }
    
    private function addToParams2($key, $value) {
        $this->params[$key] = $value;
    }
    
    //---------------------------------------------------------------------------------------------
    //------------------------------------------ QUERY --------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function executeQuery() {
        $this->resultArray = generalQuery($this->connection, $this->sql, $this->params, $this->typeQuery, PDO::FETCH_ASSOC);
    }
    
    public function getResultJSON() {
        return trim(changeArrayIntoJSON($this->packName, $this->resultArray));
    }
    
    public function echoResultJSON() {
        echo trim(changeArrayIntoJSON($this->packName, $this->resultArray));
    }
    
}

class UnstructuredConsult extends Consult {
    
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
    
    private function construct0() {
        $this->construct5("", array(), "", array(), 1);
    }
    
    private function construct1($properties) {
        $this->construct5(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"], 
            $properties["typeQuery"]
        );
    }
    
    private function construct5($packName = "", $connection = array(), $sql = "", $params = array(), $typeQuery = 1) {
        parent::__construct($packName, $connection, $sql, $params, array(), $typeQuery);
    }

}

class InsertConsult extends UnstructuredConsult {
    
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
    
    private function construct0() {
        $this->construct4("", array(), "", array());
    }
    
    private function construct1($properties) {
        $this->construct4(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"],
        );
    }
    
    private function construct4($packName = "", $connection = array(), $sql = "", $params = array()) {
        parent::__construct($packName, $connection, $sql, $params, array(), 1);
    }

}

class UpdateConsult extends UnstructuredConsult {
    
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
    
    private function construct0() {
        $this->construct4("", array(), "", array());
    }
    
    private function construct1($properties) {
        $this->construct4(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"],
        );
    }
    
    private function construct4($packName = "", $connection = array(), $sql = "", $params = array()) {
        parent::__construct($packName, $connection, $sql, $params, array(), 1);
    }

}

class DeleteConsult extends UnstructuredConsult {
    
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
    
    private function construct0() {
        $this->construct4("", array(), "", array());
    }
    
    private function construct1($properties) {
        $this->construct4(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"],
        );
    }
    
    private function construct4($packName = "", $connection = array(), $sql = "", $params = array()) {
        parent::__construct($packName, $connection, $sql, $params, array(), 1);
    }

}

class SelectConsult extends Consult {
    
    //---------------------------------------------------------------------------------------------
    //---------------------------------------- PROPERTIES -----------------------------------------
    //---------------------------------------------------------------------------------------------
    
    private $multilevel;
    
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
    
    private function construct0() {
        $this->construct6("", array(), "", array(), array(), false);
    }
    
    private function construct1($properties) {
        $this->construct6(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"], 
            $properties["structure"], 
            $properties["multilevel"]
        );
    }
    
    private function construct6($packName = "", $connection = array(), $sql = "", $params = array(), $structure = array(), $multilevel = false) {
        $this->multilevel = $multilevel;
        parent::__construct($packName, $connection, $sql, $params, $structure, 0);
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- GETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function getMultilevel() {
        return $this->multilevel;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- SETTERS -------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function setMultilevel($multilevel) {
        $this->multilevel = $multilevel;
    }
    
    //---------------------------------------------------------------------------------------------
    //------------------------------------------ QUERY --------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function executeQuery() {
        parent::executeQuery();
        $restructured = ($this->multilevel === false) 
            ? restructureArray(parent::getResultArray(), parent::getStructure()) 
            : multiLevelJSON(parent::getResultArray(), parent::getStructure(), array());
        parent::setResultArray($restructured);
    }

}
