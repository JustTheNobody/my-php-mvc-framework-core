<?php

/**
 *  Class Application
 *
 * @author Martin Maly
 * @package app\core
 */

namespace app\core;

class Request
{
    public function getPath()
    {
        //no request_uri, assume that it's root
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        //search for the ? in URI
        $position  = strpos($path, '?');

        if ($position === false) {
            return $path;
        }

        //get all b4 ? & return it
        return substr($path, 0, $position);
    }

    public function method()
    {
        //retur get/post
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet()
    {
        //retur get/post
        return $this->method() === 'get';
    }

    public function isPost()
    {
        //retur get/post
        return $this->method() === 'post';
    }

    public function getBody()
    {
        $body = [];
        //sanitize the data from user
        if ($this->method() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
       
        return $body;
    }
}
