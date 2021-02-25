<?php

/**
 *  Class UserModel
 *
 * @author Martin Maly
 * @package app\core
 */

namespace app\core;

use app\core\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}
