<?php

/**
 *  Class NotFoundException
 *
 * @author Martin Maly
 * @package app\core\exception
 *
 */

namespace app\core\exception;

class NotFoundException extends \Exception
{
   protected $message = 'Requested page not found';
   protected $code = 404;
}
