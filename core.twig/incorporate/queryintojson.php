<?php
/*
 * Copyright (C) 2015
 * fjcorona
 * 
 */

function changeArrayIntoJSON($nameJSON, $array) {
    return (trim($nameJSON) !== '') 
            ? '{"' . $nameJSON . '": ' . json_encode($array) . '}' 
            : json_encode($array);
}

function changeQueryIntoJSON($nameJSON, $structure, $connection, $sql, $params, $operation, $pdo) {
    $result = restructureQuery($structure, $connection, $sql, $params, $operation, $pdo);
    return changeArrayIntoJSON($nameJSON, $result);
}

function changeObjectIntoArrayAssoc($object) {
    $array = array();
    foreach($object as $key => $element) {
        if(is_object($element)) {
            $array[$key] = changeObjectIntoArrayAssoc($element);
        } else if(is_array($element)) {
            $subArray = array();
            foreach($element as $subKey => $subElement) {
                $subArray[] = changeObjectIntoArrayAssoc($subElement);
            }
            $array[$key] = $subArray;
        } else {
            $array[$key] = $element;
        }
    }
    return $array;
}

function generalQuery($connection, $sql, $params, $operation, $pdo) {
    try {
        $result = array();
        $stmt = $connection->prepare($sql);
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
    foreach($array as $row) {
        $restructuredArray[] = restructureRow($row, $structure);
    }
    return $restructuredArray;
}

function restructureRow($row, $structure) {
    $restructuredRow = array();
    foreach($structure as $name => $field) {
        if(!is_array($field)) {
            $restructuredRow[$name] = $row[$field];
        } else {
            $restructuredRow[$name] = restructureRow($row, $field);
        }
    }
    return $restructuredRow;
}

function restructureQuery($structure, $connection, $sql, $params, $operation, $pdo) {
    $result = generalQuery($connection, $sql, $params, $operation, $pdo);
    $restructured = ($operation === 0 && rightResult($result)) 
                        ? restructureArray($result, $structure) 
                        : $result;
    return $restructured;
}

function rightResult($result) {
    return !array_key_exists('error', $result) && !array_key_exists('process', $result);
}

function sortArrayByKeys($array, $keys, $sort = 'ASC') {
    $sort = trim($sort);
    $sort = strtoupper($sort);
    $sort = ($sort !== 'DESC') ? 'ASC' : $sort;
    $orderCriteria = array();
    for($i = 0; $i < count($keys); $i++) {
        $orderCriteria[] = array();
    }
    foreach($array as $auxiliar => $keyOrder) {
        for($i = 0; $i < count($orderCriteria); $i++) {
            $orderCriteria[$i][] = $keyOrder[$keys[$i]];
        }
    }
    $eval = 'array_multisort(';
    for($i = 0; $i < count($orderCriteria); $i++) {
        $eval .= '$orderCriteria[' . $i . '], SORT_' . $sort . ', ';
    }
    $eval .= '$array);';
    eval($eval);
    return $array;
}

function multiLevelJSON($array, $structure, $orderBy) {
    
    //Internal function: Build Lines
    $buildLines = function($numLev) {
        $codeLines = array();
        if($numLev) {
            for($cLevel = 0; $cLevel < $numLev; $cLevel++) {
                $line;
                if($cLevel) {
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
    };

    $restructuredJSON = array();
    $levels = array();
    $fields = array();
    $keys = array();
    $keysTemp = array();
    $idx = array();
    $numLev = count($structure);
    $codeLines = $buildLines($numLev);
    foreach($structure as $level => $value) {
        $levels[] = $level;
        $fields[] = $value;
        $idx[] = -1;
        $keys_fields = array_values($structure[$level]);
        $keys[] = array_shift($keys_fields);
        $keysTemp[] = '';
    }
    if(count($orderBy)) {
        $array = sortArrayByKeys($array, $orderBy);
    }
    foreach($array as $row) {
        for($cLevel = 0; $cLevel < $numLev; $cLevel++) {
            if($keysTemp[$cLevel] !== $row[$keys[$cLevel]]) {
                $idx[$cLevel] ++;
                for($i = $cLevel; $i < $numLev - 1; $i++) {
                    $idx[$i + 1] = -1;
                    $keysTemp[$i + 1] = '';
                }
                foreach($fields[$cLevel] as $newName => $name) {
                    eval($codeLines[$cLevel]);
                }
            }
        }
        for($i = 0; $i < $numLev; $i++) {
            $keysTemp[$i] = $row[$keys[$i]];
        }
    }
    return $restructuredJSON;
}

function changeCSVIntoArray($namefile, $spl) { 

    //This array will save the final clean content of the file
    $content = array();

    //Get the file
    $file = file_get_contents($namefile);
    //$encode = mb_detect_encoding($file);
    //$file = mb_convert_encoding($file, 'auto', $encode);

    //$file = utf8_decode($file);

    $myflie = explode("\n", $file);

    //Get line by line in the file
    for($idx = 0; $idx < count($myflie); $idx++) {

        //Get the current line
        $line = $myflie[$idx];
        //encode line
        //$line = utf8_decode($line);
        $line = mb_convert_encoding($line,'UTF-8','auto');

        //Trim the blanck spaces at the begining and at the end of the line
        $trimLine = ($spl === " ") ? trim($line) : $line;
        
        //Only ff it its not a blank line it is going to be used
        if($trimLine !== '') {
            
            //The line is separatend in individual elements to make a row
            $row = explode($spl, $trimLine);

            //The row is joined by a space, and after trimmed in order to be sure
            //One more time there is not a blank line
            $implodeRow = implode(" ", $row);
            $implodeRowTrim = trim($implodeRow);
            
            //It will work only with the rows that generate not empty info
            if($implodeRowTrim !== '') {

                //The row is traveled element by element in order to give it a last treatment
                for($i = 0; $i < count($row); $i++) {
                    //The spaces at the beginning and at the end are trimmed
                    $row[$i] = trim($row[$i]);
                    //After trim the spaces all the " ocurrences are deleted
                    $row[$i] = str_replace('"', '', $row[$i]);
                    //Finally the spaces at the beginning and at the end are trimmed one more time
                    $row[$i] = trim($row[$i]);
                }

                $content[] = $row;

            }
        }
    }
    
    return $content;
}

function changeLineIntoArray($line, $spl, $structure) {
    $splArray = array();
    $trimLine = trim($line);
    if($trimLine !== '') {
        $row = explode($spl, $trimLine);
        $count = 1;
        for($idx = 0; $idx < count($row); $idx++) {
            $element = trim($row[$idx]);
            if($element !== '') {    
                $splArray[] = array(
                    $count++,
                    $element
                );
            }
        }
    }
    if(count($splArray) && count($structure)) {
        $splArray = restructureArray($splArray, $structure);
    }
    return $splArray;
}

/*
 * Function taken from:
 * http://php.net/manual/es/function.array-filter.php
 * Adapted and customized by Javier Corona, Medigraf, 2015-10-27
 */

function filterByValue($array, $index, $value, $equal) {
    $newArray = array();
    if(is_array($array) && count($array) > 0) {
        foreach(array_keys($array) as $key) {
            $temp[$key] = $array[$key][$index];
            if($equal) {
                if($temp[$key] == $value) {
                    $newArray[$key] = $array[$key];
                }
            } else {
                if($temp[$key] != $value) {
                    $newArray[$key] = $array[$key];
                }
            }
        }
    }
    return $newArray;
}

function ownArrayColumn($array, $column) {
    $myFunction = function($interlnalArray, $internalColumn) {
        $internalValues = array();
        foreach($interlnalArray as $current) {
            $internalValues[] = $current[$internalColumn];
        }
        $internalValues = array_values($internalValues);
        return $internalValues;
    };
    $version = phpversion();
    $elements = explode('.', $version);
    $first = (integer)($elements[0]);
    if($first === 5) {
        $count = count($elements);
        switch($count) {
            case 1:
                $proyectos_values = $myFunction($array, $column);
                break;
            case 2:
                $second = (integer)($elements[1]);
                if($second === 5) {
                    $proyectos_values = $myFunction($array, $column);
                } else if($second > 5) {
                    $proyectos_values = array_column($array, $column);
                } else {
                    $proyectos_values = $myFunction($array, $column);
                }
                break;
            case 3:
            default:
                $second = (integer)($elements[1]);
                $third = (integer)($elements[2]);
                if($second === 5) {
                    if($third >= 0) {
                        $proyectos_values = array_column($array, $column);
                    } else {
                        $proyectos_values = $myFunction($array, $column);
                    }
                } else if($second > 5) {
                    $proyectos_values = array_column($array, $column);
                } else {
                    $proyectos_values = $myFunction($array, $column);
                }

        }
    } else if($first > 5) {
        $proyectos_values = array_column($array, $column);
    } else {
        $proyectos_values = $myFunction($array, $column);
    }
    $proyectos_values = array_values($proyectos_values);
    return $proyectos_values;
}

function searchMultiArrayKeyValueLike($array, $keys, $mystery, $strict = false) {

    //Internal function: noCaseString
    $noCaseString = function($valueString) {
        $valueString = str_replace(array('A', 'á', 'Á', 'ä', 'Ä', 'à', 'À', 'â', 'Â', 'ã', 'Ã'), 'a', $valueString);
        $valueString = str_replace(array('E', 'é', 'É', 'ë', 'Ë', 'è', 'È', 'ê', 'Ê'), 'e', $valueString);
        $valueString = str_replace(array('I', 'í', 'Í', 'ï', 'Ï', 'ì', 'Ì', 'î', 'Î'), 'i', $valueString);
        $valueString = str_replace(array('O', 'ó', 'Ó', 'ö', 'Ö', 'ò', 'Ò', 'ô', 'Ô', 'õ', 'Õ'), 'o', $valueString);
        $valueString = str_replace(array('U', 'ú', 'Ú', 'ü', 'Ü', 'ù', 'Ù', 'û', 'Û'), 'u', $valueString);
        $valueString = strtolower($valueString);
        return $valueString;
    };

    $newArray = array();
    if(is_array($array) && count($array) > 0) {
        $newKeys = array();
        $keysType = gettype($keys);
        switch($keysType) {
            case 'array':
                $newKeys = $keys;
                break;
            case 'string':
            case 'integer':
                $newKeys = array($keys);
                break;
            default:
                $newKeys = array();
        }
        $indexes = array();
        foreach($newKeys as $keyCurrent) {
            $acKeyCurrent = ownArrayColumn($array, $keyCurrent);
            foreach($acKeyCurrent as $idx => $value) {
                $value = (!$strict) ? $noCaseString($value) : $value;
                $mystery = (!$strict) ? $noCaseString($mystery) : $mystery;
                $pos = strpos($value, $mystery);
                (gettype($pos) !== 'boolean') ? $indexes[] = $idx : $indexes = $indexes;
            }
        }
        $indexes = array_unique($indexes);
        sort($indexes);
        $indexes = array_values($indexes);
        foreach($indexes as $idx) {
            $newArray[] = $array[$idx];
        }
        $newArray = array_values($newArray);
    }
    return $newArray;
}

function readXML($url, $limit, $count = 1) {
    if($count > $limit || $limit <= 0 || $count <= 0) {
        return false;
    }
    libxml_use_internal_errors(true);
    $xml = simplexml_load_string(file_get_contents($url), 'SimpleXMLElement', LIBXML_COMPACT|LIBXML_PARSEHUGE);
    if($xml !== false) {
        return $xml;
    }
    return readXML($url, $limit, $count + 1);
}

?>