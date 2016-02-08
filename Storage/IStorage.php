<?php

namespace HttpStub\Storage;

/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 6:00 PM
 */
interface IStorage
{
    /**
     * @param mixed $value
     * @return mixed $key - the next key
     */
    public function insert($value);

    public function update($key, $value);

    public function read($key);

    public function delete($key);

    public function truncate();

    public function readAll();

    public function getNextKey();
}