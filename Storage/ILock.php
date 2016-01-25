<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 7:15 PM
 */

namespace HttpStub\Storage;


interface ILock
{
    public function lock();

    public function unlock();

    public function isLocked();
}