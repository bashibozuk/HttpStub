<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 5:46 PM
 */

namespace HttpStub;


class Autoloader
{
    const BASE_NAMESPACE_NAME = 'HttpStubOld';

    public static function load($className)
    {
        $nameParts = explode('\\', $className);
        if ($nameParts <= 1) {
            return;
        }

        $root = array_shift($nameParts);

        if ($root != self::BASE_NAMESPACE_NAME) {
            return;
        }

        require_once __DIR__ . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $nameParts) . '.php';
    }

    public static function init()
    {
        spl_autoload_register([get_called_class(), 'load']);
    }
}