<?php
//namespace Medigraf;

/**
 * This class 
 * 
 * @author Francisco Javier Corona Sánchez <javier@medigraf.com.mx>
 * @copyright 2017
 */
abstract class Invoker
{
    /**
     * Description
     * @param type $request 
     * @param type $response 
     * @param type $args 
     * @return type
     */
    abstract public function __invoke($request, $response, $args);
}