<?php

namespace HttpStub\Storage;

use HttpStub\Settings;
use HttpStub\Exception;
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 5:59 PM
 */
class FileStorage extends AbsractStorage
{
    public function insert($value)
    {
        $key = $this->getNextKey();
        $this->setKey($key, $value);
        return $key;
    }

    public function update($key, $value)
    {
        if ($this->keyExists($key)) {
            return $this->setKey($key, $value);
        }
    }

    public function read($key)
    {
        $file = Settings::get(Settings::PATH) . '/' . $this->name . '/' . $key .'.file';
        if ($this->keyExists($key)) {
            return json_decode(file_get_contents($file), true);
        }
    }

    public function delete($key)
    {
        if ($this->keyExists($key)) {
            $file = Settings::get(Settings::PATH) . '/' . $this->name . '/' . $key .'.file';
            unlink($file);
            return true;
        }

        return false;
    }

    public function truncate()
    {
        $dir = Settings::get(Settings::PATH) . '/' . $this->name;
        foreach (scandir($dir) as $file) {
            if ($file !== '.' && $file !== '..') {
                unlink($file);
            }
        }
    }

    public function readAll()
    {
        $dir = Settings::get(Settings::PATH) . '/' . $this->name;
        $result = [];
        foreach (scandir($dir) as $file) {
            if ($file !== '.' && $file !== '..') {
                $result[] = json_decode(file_get_contents($dir . DIRECTORY_SEPARATOR . $file), true);
            }
        }

        return $result;
    }


    public function getNextKey()
    {

        $keyFile = Settings::get(Settings::PATH) . '/' . $this->name . '/key.file';
        if (!is_dir(Settings::get(Settings::PATH) . '/' . $this->name)) {
            mkdir(Settings::get(Settings::PATH) . '/' . $this->name);
        }
        $key = 1;
        if (!file_exists($keyFile)) {
            file_put_contents($keyFile, $key);
        } else {
            $key = file_get_contents($keyFile) + 1;
            file_put_contents($keyFile, $key);
        }


        return $key;
    }

    public function keyExists($key)
    {
        $file = Settings::get(Settings::PATH) . '/' . $this->name . '/' . $key .'.file';
        return file_exists($file);
    }

    public function isLocked()
    {
        $lockFile = Settings::get(Settings::PATH) . '/' . $this->name . '/lock.file';
        return file_exists($lockFile);
    }


    protected function setKey($key, $value)
    {
        $file = Settings::get(Settings::PATH) . '/' . $this->name . '/' . $key .'.file';
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file));
        }
        file_put_contents($file, json_encode($value));
    }

    public function lock()
    {
        $lockFile = Settings::get(Settings::PATH) . '/' . $this->name . '/lock.file';
        file_put_contents($lockFile, time());
    }

    public function unlock()
    {
        $lockFile = Settings::get(Settings::PATH) . '/' . $this->name . '/lock.file';
        unlink($lockFile);
    }

    public function beforeCommand($name, $params = null)
    {
        $storageDir = Settings::get(Settings::PATH);
        if (!is_dir($storageDir) || !is_readable($storageDir) || !is_writable($storageDir)) {
            throw new Exception(sprintf('Directory %s is not accessible', $storageDir));
        }
        $attempts = 3;

        while(--$attempts) {
            if (!$this->isLocked()) {
                return parent::beforeCommand($name, $params);
            }
            usleep(2);
        }

        throw new Exception('Could Not Attempt lock');
    }

    public function insertCommand($params)
    {
        return $this->insert($params);
    }

    public function updateCommand($key, $value)
    {
        return $this->update($key, $value);
    }

    public function deleteCommand($key)
    {
        return $this->delete($key);
    }

    public function readCommand($key)
    {
        return $this->read($key);
    }

    public function readAllCommand()
    {
        return $this->readAll();
    }
}