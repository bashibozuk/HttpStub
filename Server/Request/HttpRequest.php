<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 10:00 PM
 */

namespace HttpStub\Server\Request;


use HttpStub\Exception;

class HttpRequest extends Request
{
    public function __construct()
    {
        parent::__construct();
        $route = empty($_GET['route']) ? '' : $_GET['route'];
        $route = explode('/', $route);

        if (count($route) < 2) {
            throw new Exception('Invalid route');
        }

        $this->storage = $route[0];
        $this->command = $route[1];
    }

    public function getData()
    {
        return (array) rawurldecode(file_get_contents('php://input'));
    }

    public function getStorageName()
    {
        return $this->storage;
    }

    public function getCommandName()
    {
        $this->command;
    }

    public function getCommandParams()
    {
        // TODO: Implement getCommandParams() method.
    }
}