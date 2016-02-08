<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 6:05 PM
 */

namespace HttpStub\Storage;


abstract class AbsractStorage implements IStorage, ILock
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function command($name, $params = null)
    {
        $n = ucfirst($name);
        if (method_exists($this, 'beforeCommand')) {
            $this->beforeCommand($name, $params);
        }

        if (method_exists($this, 'before' . $n)) {
            call_user_func_array([$this, 'before' . $n], $params);
        }
        $result = null;
        if (method_exists($this, $name . 'Command')) {
            $result = call_user_func_array([$this, $name . 'Command'], $params);
        } else {
            throw new \Exception('Unknown Command : ' . $name);
        }

        if (method_exists($this, 'after' . $n)) {
            call_user_func_array([$this, 'after' . $n], $params);
        }

        if (method_exists($this, 'afterCommand')) {
            $this->afterCommand($name, $params);
        }

        return $result;
    }

    public function beforeCommand($name, $params = null)
    {

        if (in_array($name, ['insert', 'update', 'delete']) && !$this->isLocked()) {
            $this->lock();
        }
    }

    public function afterCommand($name)
    {
        if (in_array($name, ['insert', 'update', 'delete']) && $this->isLocked()) {
            $this->unlock();
        }
    }
}