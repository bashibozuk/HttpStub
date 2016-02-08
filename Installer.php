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
    public static function postInstall($event)
    {
        var_dump($event->getComposer()->getPackage());
    }

    public static function postUpdate()
    {
        var_dump('test');
    }
}