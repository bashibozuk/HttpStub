<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 30.01.16
 * Time: 19:22
 */

namespace HttpStub;


class Installer
{
    public static function postInstall()
    {
        var_dump(func_get_args());
    }

    public static function postUpdate()
    {
        var_dump(func_get_args());
    }
}