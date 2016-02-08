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
        self::doInstall($event);
    }

    public static function postUpdate($event)
    {
        self::doInstall($event);
    }

    protected static function doInstall($event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();

        if (!empty($extra['HttpStub']['data-root'])) {

            $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
            $root = dirname($vendorDir);
            $dataRoot = $root . DIRECTORY_SEPARATOR . $extra['HttpStub']['data-root'];

            if (($path = realpath($dataRoot)) === false) {
                if (!@mkdir($dataRoot)) {
                    throw new Exception('Could not create data directory ' . $path);
                }
                echo "$dataRoot created", PHP_EOL;
            } else {
                echo "$dataRoot exists", PHP_EOL;
            }
        }


    }
}