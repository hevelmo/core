<?php

//Array for save file names that will be used throughout the process
$names = array();

//DYNAMIC INCLUSION OF THE DIRECTORY
$count = 0; //Control
$path = 'to_object'; //Path that will be included
$dir = dir($path);
while (( $file = $dir->read() ) !== false) {
    //All the names of the files in the path are gotten
    if (++$count > 2) {
        $file_new = str_replace('.php', '', $file);
        //Only php files will be included
        if($file_new !== $file) {
            $names[] = str_replace('.php', '', $file);
        }
    }
    //All the files in the path are included
    if (is_file($path . '/' . $file) and preg_match('/^(.+)\.php$/i', $file)) {
        include $path . '/' . $file;
    }
}
$dir->close();

/* CONSTRUCTION OF THE FILE CONTENTS
  It is composed of two parts:
  1. Declaration of variables
  2. Allocation of the objects in variables
*/

$count = 0; //Control
$declaration = 'var ';
$allocation = '';

asort($names);

foreach ($names as $name) {
    //1. DECLARATION OF VARIABLES
    $declaration.= (!$count) ? $name : ', ' . $name;
    $count++;

    //2. ALLOCATIONS OF THE OBJECTS IN VARIABLES
    $array = $name();
    ksort($array);
    if (count($array)) {
        //a) Getting the object
        $object = $name . ' = ' . json_encode($array) . ';';
        //b) Parsing: all the '\' are deleted
        $object = str_replace('\\', '', $object);
    } else {
        //The empty objects won't be written in the final file
        //$object = '';
        $object = $name . ' = ' . '{};';
    }
    //c) Indentation: each element of the object is written in a new line and with tabulation
    $object = str_replace(',', ',' . PHP_EOL . "\t", $object);
    //d) The object is now ready to be allocated
    $allocation.=$object;
}
$declaration .=';';
$content = $declaration . $allocation;
//Content indentation
$content = str_replace(';', ';' . PHP_EOL, $content);
$content = str_replace('{', '{' . PHP_EOL . "\t", $content);
$content = str_replace('}', PHP_EOL . '}', $content);

//FILE WRITING
$name = 'objects';
$urlObject = '../js/';
$file = $urlObject . $name . '.js';
if (file_exists($file)) {
    unlink($file);
}
$names = fopen($file, 'a');
fwrite($names, $content);
fclose($names);
