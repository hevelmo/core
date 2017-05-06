<?php
//namespace Medigraf;

/**
 * CONSULT
 * 
 * This class 
 * 
 * @author Francisco Javier Corona Sánchez <javier@medigraf.com.mx>
 * @copyright 2017
 */
class Consult 
{
    /**
     * @var     string      $resultArray     Result of the query.
     * @var     string      $packName        The main name of the final JSON.
     * @var     PDO         $connection      A PDO Reference with connection data.
     * @var     string      $sql             The query's code to be executed.
     * @var     array       $params          To replace in $sql prepared statements.
     * @var     array       $structure       The way $resultArray will be structured. Could be multilevel.
     * @var     int         $typeQuery       0 = Select, 1 = Insert, 2 = Update, 3 = Delete.
     * @var     bool        $multilevel      Decides if the final "SELECT "$resultArray will have nested Levels.
     */
    private $resultArray, $packName, $connection, $sql, $params, $structure, $typeQuery, $multilevel;
    
    /**
     * Constructor
     * 
     * This method initializes result array and besides along with the other 'construct' methods
     * emulates the POO's overload characteristic to initialize the rest of the internal class properties
     * Depending on the number of received args.
     * 
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
        if (method_exists($this, $methodName)) 
        {
            call_user_func_array(array($this, $methodName), $args);
        //Otherwise
        } else {
        }
    }
    
    /**
     * Constructor (Overload)
     * 
     * This is the construct method which is called when there are not args.
     * Construct7 method is called with default empty properties.
     * 
     */
    private function construct0() 
    {
        $this->construct7("", array(), "", array(), array(), 0, false);
    }
    
    /**
     * Constructor (Overload)
     * 
     * This is the construct method which is called when the properties
     * (packName, connection, sql, params, structure, typeQuery, multilevel)
     * Are sent together in an associative array.
     * Once received, the properties are individually sent to construct7 method.
     * 
     * @param   array     $properties     Must have the exact properties
     */
    private function construct1($properties) 
    {
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
    
    /**
     * Constructor (Overload)
     * 
     * This is the construct method which is called when the all the properties are received individually. 
     * Here is where the class properties are finally intialized.
     * 
     * @param   string    $packName 
     * @param   array     $connection 
     * @param   string    $sql 
     * @param   array     $params 
     * @param   array     $structure 
     * @param   type      $typeQuery 
     * @param   bool      $multilevel 
     */
    private function construct7($packName = "", $connection = array(), $sql = "", $params = array(), $structure = array(), $typeQuery = 0, $multilevel = false) 
    {
        $this->packName   = $packName;
        $this->connection = $connection;
        $this->sql        = $sql;
        $this->params     = $params;
        $this->structure  = $structure;
        $this->typeQuery  = $typeQuery;
        $this->multilevel = $multilevel;
    }
    
    /**
     * @return  string
     */
    public function getSql() 
    {
        return $this->sql;
    }
    
    /**
     * @return  array
     */
    public function getParams() 
    {
        return $this->params;
    }
    
    /**
     * Returns the result of the executed query no matter the current content.
     * That content could be the original result, or the restructured result, 
     * in case it is a SELECT query.
     * If there is not an executed query, result will be an empty array.
     * 
     * @return  array
     */
    public function getResultArray() 
    {
        return $this->resultArray;
    }
    
    /**
     * @return  array
     */
    public function getStructure() 
    {
        return $this->structure;
    }
    
    /**
     * @return  int
     */
    public function getTypeQuery() 
    {
        return $this->typeQuery;
    }
    
    /**
     * @return  bool
     */
    public function getMultilevel() 
    {
        return $this->multilevel;
    }
    
    /**
     * Change current $sql with a new one.
     * 
     * @param   string  $sql 
     */
    public function setSql($sql) 
    {
        $this->sql = $sql;
    }
    
    /**
     * Change current $resultArray with new ones.
     * 
     * @param   array  $resultArray 
     */
    public function setResultArray($resultArray) 
    {
        $this->resultArray = $resultArray;
    }
    
    /**
     * Change current $params with new ones.
     * 
     * @param   array  $params 
     */
    public function setParams($params) 
    {
        $this->params = $params;
    }
    
    /**
     * Change current $structure with a new one.
     * 
     * @param   array  $structure 
     */
    public function setStructure($structure) 
    {
        $this->structure = $structure;
    }
    
    /**
     * Change current $typeQuery with a new one.
     * 
     * @param   int  $typeQuery 
     */
    public function setTypeQuery($typeQuery) 
    {
        $this->typeQuery = $typeQuery;
    }
    
    /**
     * Change current $multilevel with a new one.
     * 
     * @param   bool  $multilevel 
     */
    public function setMultilevel($multilevel) 
    {
        $this->multilevel = $multilevel;
    }
    
    /**
     * From received $params this method dynamically makes the parameters that will be used in the $sql prepared statement.
     * Parameters with '0' or empty value are rejected.
     * "mystery" keys they are treated differently, they are used to searched values. 
     * The keys of this array must coincide with the used in the prepare statement created by makeWhere or makeWhereSearch methods.
     * Otherwise executeQuery method will fail.
     * 
     * @param   array  $params 
     */
    public function makeParams($params) 
    {
        foreach ($params as $key => $value) 
        {
            //Value is included only if it is in the array and it isn,t empty
            if (array_key_exists($key, $params) && $params[$key] != "0") 
            {
                $this->params[$key] = ($key !== "mystery") 
                    //Is a normal param
                    ? $params[$key]
                    //Is a param which have to be prepared to be executen in LIKE sql operator
                    : "%" . $params[$key] . "%";
            }
        }
    }
    
    /**
     * From received $params this method dynamically makes a where condition to be used in an $sql query.
     * This condition could be a prepared statement, thats the reason it must concide with the $params created
     * by makeParams method.
     * 
     * @param   string  $baseCondition      Default condition to be evaluated by WHERE clause
     * @param   array   $paramsConditions   Structure with the DB fields structure to create WHERE conditions.
     * @param   array   $params             With keys to be used
     * @return  string
     */
    public function makeWhere($baseCondition = "1=1", $paramsConditions, $params) 
    {
        $where = $baseCondition;
        foreach ($paramsConditions as $key => $value) 
        {
            if (array_key_exists($key, $params) && $params[$key] != "0" && $params[$key] != "") 
            {
                foreach ($value as $condition) 
                {
                    $where .= " {$condition[0]} {$condition[1]} {$condition[2]} :$key";
                }
            }
        }
        return $where;
    }
    
    /**
     * This method is used when is desired to make WHERE conditions focused in an specific parameter
     * To be searched in different BD fields, that is, when the query is a search. 
     * This method acts as an intermediary, by preparing properties to be sent to this class makeWhere method 
     * which will do the final work.
     * 
     * @param   string  $key            Specific parameter.
     * @param   array   $conditions     Structure with the DB fields structure to create WHERE conditions.
     * @param   array   $params         With keys to be used
     * @return  string
     */
    public function makeWhereSearch($key = "mystery", $conditions, $params) 
    {
        $where = "1=1";
        if (count($conditions) > 0 && array_key_exists($key, $params) && $params[$key] != "0" && $params[$key] != "") 
        {
            $baseCondition = "{$conditions[0]} LIKE :$key";
            unset($conditions[0]);
            $paramsConditions = array();
            if (count($conditions) > 0) 
            {
                $paramsConditions[$key] = array();
                foreach ($conditions as $key => $value) 
                {
                    $paramsConditions[$key][] = array(
                        "OR",
                        $value,
                        "LIKE"
                    );
                }
            }
            $where = $this->makeWhere($baseCondition, $paramsConditions, $params);
        }
        return $where;
    }
    
    /**
     * addToParams
     * 
     * This method adds more elemnts to the current class property $params.
     * emulates the POO's overload characteristic to add an key => value element or a complete associative array.
     * Depending on the number of received args.
     * 
     */
    public function addToParams() 
    {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) 
        {
            call_user_func_array(array($this, $methodName), $args);
            ksort($this->params);
        //Otherwise
        } else {
        }
    }
    
    /**
     *  addToParams(Overload)
     * 
     * This is the addToParams method which is called when there is only one arg.
     * This arg should be an array to be merged with the current class $params property.
     * 
     * @param   array    $params    New params to be merged
     */
    private function addToParams1($params) 
    {
        $this->params = array_merge($this->params, $params);
    }
    
    /**
     *  addToParams(Overload)
     * 
     * This is the addToParams method which is called when there are two args.
     * This method add a new key value to the current class $params property.
     * 
     * @param   type    $key 
     * @param   type    $value 
     */
    private function addToParams2($key, $value) 
    {
        $this->params[$key] = $value;
    }
    
    /**
     * This method executes a query no matter which type it is.
     * Result is saved in the class $resultArray property without be restructured.
     */
    private function executeQuery() 
    {
        $this->resultArray = generalQuery($this->connection, $this->sql, $this->params, $this->typeQuery, PDO::FETCH_ASSOC);
    }
    
    /**
     * This method executes a SELECT query. 
     * After executed, the SELECT query will be restructured simple or multilevel way, 
     * Depending on this class $multilevel property value.
     */
    public function selectQuery() 
    {
        $this->typeQuery = 0;
        $this->executeQuery();
        $this->resultArray = changeNullToEmpty($this->resultArray);
        $this->resultArray = ($this->multilevel === false) 
            //Simple structure case
            ? restructureArray($this->resultArray, $this->structure) 
            //Multilevel structure case
            : multiLevelJSON($this->resultArray, $this->structure, array());
    }
    
    /**
     * This method executes an INSERT query. An insert query will never be restructured.
     */
    public function insertQuery() 
    {
        $this->typeQuery = 1;
        $this->executeQuery();
    }
    
    /**
     * From this class $packname and $resultArray and changeArrayIntoJSON function.
     * A string with JSON structure is returned.
     * This method is used when it's desired to get the result.
     * 
     * @return  string   In a JSON structure
     */
    public function getResultJSON() 
    {
        return trim(changeArrayIntoJSON($this->packName, $this->resultArray));
    }
    
    /**
     * From this class $packname and $resultArray and changeArrayIntoJSON function.
     * A string with JSON structure is printed.
     * This method is used when whe just want to print the result.
     * 
     * @return  string   In a JSON structure
     */
    public function echoResultJSON() 
    {
        echo trim(changeArrayIntoJSON($this->packName, $this->resultArray));
    }
}