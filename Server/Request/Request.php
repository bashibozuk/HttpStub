<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 9:28 PM
 */

namespace HttpStub\Server\Request;


abstract class Request
{

    const TYPE_HTTP = 1;

    const TYPE_REST = 2;

    protected $method;

    protected $storage;

    protected $command;

    public function __construct()
    {
        $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
    }

    public function getParams()
    {
       return $_GET;
    }

    abstract public function getData();

    abstract public function getStorageName();

    abstract public function getCommandName();

    abstract public function getCommandParams();
}