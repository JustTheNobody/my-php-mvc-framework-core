<?php

/**
 *  Class Response
 *
 * @author Martin Maly
 * @package app\core
 */

namespace app\core;

class Response
{
    public function setStatusCode(int $code)
    {
        //set web browser status code (404)
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location:'.$url);
    }
}
