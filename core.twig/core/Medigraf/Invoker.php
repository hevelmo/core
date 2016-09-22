<?php

//namespace Medigraf;

abstract class Invoker {

    abstract public function __invoke($request, $response, $args);

}
