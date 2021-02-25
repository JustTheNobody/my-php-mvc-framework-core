<?php

/**
 *  Class BaseMiddleware
 *
 * @author Martin Maly
 * @package app\core\Middlewares
 *
 */

namespace app\core\Middlewares;

abstract class BaseMiddleware
{
    //the function depends on the child class
    abstract public function execute();
}
