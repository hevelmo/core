<?php

class QueryGenerator {
    private $queryString;

    private $select;
    private $from;
    private $join;
    private $where;
    private $orderBy;
    private $groupBy;

    function construct6($select, $from, $join, $where, $orderBy, $groupBy) {
        $this->select = $select;
        $this->from = $from;
        $this->join = $join;
        $this->where = $where;
        $this->orderBy = $orderBy;
        $this->groupBy = $groupBy;
    }

    function construct1($elements) {
        $this->construct6(
            $elements["select"],
            $elements["from"],
            $elements["join"],
            $elements["where"],
            $elements["orderBy"],
            $elements["groupBy"]
        );
    }

    function construct0() {
        $this->construct6(
            array(),
            array(),
            array(),
            array(),
            array(),
            array()
        );
    }

    function __construct() {
        $this->queryString = "";
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = "construct" . $numArgs;
        //If the method exists called it 
        if(method_exists($this, $methodName)) {
            call_user_func_array(array($this, $methodName), $args);
            //Otherwise
        } else {
        }

    }

    //GETTERS

    public function getSelect() {
        return $this->select;
    }
    public function getFrom() {
        return $this->from;
    }
    public function getJoin() {
        return $this->join;
    }
    public function getWhere() {
        return $this->where;
    }
    public function getOrderBy() {
        return $this->orderBy;
    }
    public function getGroupBy() {
        return $this->groupBy;
    }

    //SETTERS

    public function setSelect($select) {
        $this->select = $select;
    }

    public function setFrom($from) {
        $this->from = $from;
    }

    public function setJoin($join) {
        $this->join = $join;
    }

    public function setWhere($where) {
        $this->where = $where;
    }

    public function setOrderBy($orderBy) {
        $this->orderBy = $orderBy;
    }

    public function setGroupBy($groupBy) {
        $this->groupBy = $groupBy;
    }

    //ADDERS

    public function addToSelect($element) {
        $this->select[] = $element;
    }

    public function addToFrom($element) {
        $this->from[] = $element;
    }

    public function addToJoin($element) {
        $this->join[] = $element;
    }

    public function addToWhere($element) {
        $this->where[] = $element;
    }

    public function addToOrderBy($element) {
        $this->orderBy[] = $element;
    }

    public function addToGroupBy($element) {
        $this->groupBy[] = $element;
    }

    //STRINGS

    private function stringSelect() {
        return "";
    }

    private function stringFrom() {
        return "";
    }

    private function stringJoin() {
        return "";
    }

    private function stringWhere() {
        return "";
    }

    private function stringOrderBy() {
        return "";
    }

    private function stringGroupBy() {
        return "";
    }

    //QUERY

    private function buildQuery() {
        $this->queryString =
            $this->stringSelect() .
            $this->stringFrom() .
            $this->stringJoin() .
            $this->stringWhere() .
            $this->stringOrderBy() .
            $this->stringGroupBy();
    }

    public function queryString() {
        $this->buildQuery();
        return $this->queryString;
    }

}