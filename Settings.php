<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 6:12 PM
 */

namespace HttpStub;


class Settings
{
    const PATH = 'path';

    protected static  $path;

    public static function set($k, $v)
    {
        self::${$k} = $v;
    }

    public static function get($k)
    {
        return self::${$k};
    }

}