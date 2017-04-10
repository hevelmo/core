<?php
/*
 * Copyright (C) 2015 Virbac México
 * 
 */

$devserverlist = array('127.0.0.1','::1','192.168.0.102','localhost');

if(!in_array($_SERVER['SERVER_NAME'], $devserverlist)){
    define("HOST", "localhost");     
	define("USER", "medigraf_prouser");    
	define("PASSWORD", "@irBus2013-Lop2014");    
	define("DATABASE", "medigraf_prodb"); 
} else {
	define("HOST", "localhost");     
	define("USER", "master");    
	define("PASSWORD", "12345");    
	define("DATABASE", "prodb");    
}
define("SECURE", FALSE);    // FOR DEVELOPMENT ONLY!!!!

