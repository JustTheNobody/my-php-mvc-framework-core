<?php

/**
 *  Class ForbiddenException
 *
 * @author Martin Maly
 * @package app\core
 *
 */

namespace app\core\exception;

class ForbiddenException extends \Exception
{
    //2 overide some in the php \Exception
    protected $message = 'You don\'t have permission to access this page';
    protected $code = 403;
}
