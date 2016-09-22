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
        $this->construct7("", array(), "", array(), array(), 0, false);
    }
    
    private function construct1($properties) {
        $this->construct7(
            $properties["packName"], 
            $properties["connection"], 
            $properties["sql"], 
            $properties["params"], 
            $properties["structure"], 
            $properties["typeQuery"], 
            $properties["multilevel"]
        );
    }
    
    private function construct7($packName = "", $connection = array(), $sql = "", $params = array(), $structure = array(), $typeQuery = 0, $multilevel = false) {
        $this->packName   = $packName;
        $this->connection = $connection;
        $this->sql        = $sql;
        $this->params     = $params;
        $this->structure  = $structure;
        $this->typeQuery  = $typeQuery;
        $this->multilevel = $multilevel;
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
    
    public function getMultilevel() {
        return $this->multilevel;
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
    
    public function setStructure($structure) {
        $this->structure = $structure;
    }
    
    public function setTypeQuery($typeQuery) {
        $this->typeQuery = $typeQuery;
    }
    
    public function setMultilevel($multilevel) {
        $this->multilevel = $multilevel;
    }
    
    //---------------------------------------------------------------------------------------------
    //----------------------------------------- MAKERS --------------------------------------------
    //---------------------------------------------------------------------------------------------
    
    public function makeParams($params) {
        foreach ($params as $key => $value) {
            if (array_key_exists($key, $params) && $params[$key] != "0") {
                $this->params[$key] = ($key !== "mystery") ? $params[$key] : "%" . $params[$key] . "%";
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

    public function makeWhereSearch($field = "mystery", $conditions, $params) {
        $where = "1=1";
        if(count($conditions) > 0 && array_key_exists($field, $params) && $params[$field] != "0" && $params[$field] != "") {
            $baseCondition = "{$conditions[0]} LIKE :$field";
            unset($conditions[0]);
            $paramsConditions = array();
            if(count($conditions) > 0) {
                $paramsConditions[$field] = array();
                foreach($conditions as $key => $value) {
                    $paramsConditions[$field][] = array("OR", $value, "LIKE");
                }
            }
            $where = $this->makeWhere($baseCondition, $paramsConditions, $params);
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
    
    private function executeQuery() {
        $this->resultArray = generalQuery($this->connection, $this->sql, $this->params, $this->typeQuery, PDO::FETCH_ASSOC);
    }
    
    public function selectQuery() {
        $this->typeQuery = 0;
        $this->executeQuery();
        $this->resultArray = ($this->multilevel === false) 
            ? restructureArray($this->resultArray, $this->structure) 
            : multiLevelJSON($this->resultArray, $this->structure, array());
    }
    
    public function insertQuery() {
        $this->typeQuery = 1;
        $this->executeQuery();
    }
    
    public function getResultJSON() {
        return trim(changeArrayIntoJSON($this->packName, $this->resultArray));
    }
    
    public function echoResultJSON() {
        echo trim(changeArrayIntoJSON($this->packName, $this->resultArray));
    }
    
}
