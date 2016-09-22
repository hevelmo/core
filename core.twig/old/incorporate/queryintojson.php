<?php
/*
 * Copyright (C) 2015 Virbac México
 * fjcorona
 * 
 */

function changeArrayIntoJSON($nameJSON, $array) {
    return ($nameJSON !== '') 
            ? '{"' . $nameJSON . '": ' . json_encode($array) . '}' 
            : json_encode($array);
}

function changeQueryIntoJSON($nameJSON, $structure, $connection, $sql, $params, $operation, $pdo) {
    $result = generalQuery($connection, $sql, $params, $operation, $pdo);
    $restructured = ($operation === 0 && rightResult($result)) 
                        ? restructureArray($result, $structure) 
                        : $result;
    return changeArrayIntoJSON($nameJSON, $restructured);
}

function generalQuery($connection, $query, $params, $operation, $pdo) {
    try {
        $result = array();
        $stmt = $connection->prepare($query);
        $stmt->execute($params);
        switch ($operation) {
            //SELECT
            case 0: $result = $stmt->fetchAll($pdo);
                break;
            //INSERT
            case 1: $result = array('id_inserted' => $connection->lastInsertId());
                break;
            //UPDATE
            case 2:
            //DELETE
            case 3: $result = array('process' => 'ok');
                break;
        }
        $connection = null;
        return $result;
    } catch (PDOException $e) {
        return array('error' => $e->getMessage());
    }
}

function restructureArray($array, $structure) {
    $restructuredArray = array();
    foreach ($array as $row) {
        $restructuredArray[] = restructureRow($row, $structure);
    }
    return $restructuredArray;
}

function restructureRow($row, $structure) {
    $restructuredRow = array();
    foreach ($structure as $name => $field) {
        if (!is_array($field)) {
            $restructuredRow[$name] = $row[$field];
        } else {
            $restructuredRowy[$name] = restructureRow($row, $field);
        }
    }
    return $restructuredRow;
}

function rightResult($result) {
    return !array_key_exists('error', $result) && !array_key_exists('process', $result);
}

function orderArrayByKeys($array, $keys) {
    $orderCriteria = array();
    for ($i = 0; $i < count($keys); $i++) {
        $orderCriteria[] = array();
    }
    foreach ($array as $auxiliar => $keyOrder) {
        for ($i = 0; $i < count($orderCriteria); $i++) {
            $orderCriteria[$i][] = $keyOrder[$keys[$i]];
        }
    }
    $eval = 'array_multisort(';
    for ($i = 0; $i < count($orderCriteria); $i++) {
        $eval .= '$orderCriteria[' . $i . '], SORT_ASC, ';
    }
    $eval .= '$array);';
    eval($eval);
    return $array;
}

function buildLines($numLev) {
    $codeLines = array();
    if ($numLev) {
        for ($cLevel = 0; $cLevel < $numLev; $cLevel++) {
            $line;
            if ($cLevel) {
                $line = $codeLines[$cLevel - 1] . '[$levels[' . $cLevel . ']][$idx[' . $cLevel . ']]';
                $codeLines[$cLevel - 1] .= '[$newName] = $row[$name];';
            } else {
                $line = '$restructuredJSON[$idx[' . $cLevel . ']]';
            }
            $codeLines[$cLevel] = $line;
        }
        $codeLines[$cLevel - 1] .= '[$newName] = $row[$name];';
    }
    return $codeLines;
}

function multiLevelJSON($array, $structure, $orderBy) {
    $restructuredJSON = array();
    $levels = array();
    $fields = array();
    $keys = array();
    $keysTemp = array();
    $idx = array();
    $numLev = count($structure);
    $codeLines = buildLines($numLev);
    foreach ($structure as $level => $value) {
        $levels[] = $level;
        $fields[] = $value;
        $idx[] = -1;
        $keys_fields = array_values($structure[$level]);
        $keys[] = array_shift($keys_fields);
        $keysTemp[] = '';
    }
    if (count($orderBy)) {
        $array = orderArrayByKeys($array, $orderBy);
    }
    foreach ($array as $row) {
        for ($cLevel = 0; $cLevel < $numLev; $cLevel++) {
            if ($keysTemp[$cLevel] !== $row[$keys[$cLevel]]) {
                $idx[$cLevel] ++;
                for ($i = $cLevel; $i < $numLev - 1; $i++) {
                    $idx[$i + 1] = -1;
                    $keysTemp[$i + 1] = '';
                }
                foreach ($fields[$cLevel] as $newName => $name) {
                    eval($codeLines[$cLevel]);
                }
            }
        }
        for ($i = 0; $i < $numLev; $i++) {
            $keysTemp[$i] = $row[$keys[$i]];
        }
    }
    return $restructuredJSON;
}
