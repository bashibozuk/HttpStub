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
        parse_str(file_get_contents('php://input'), $data);
        return $data ?: [];
    }

    public function getStorageName()
    {
        return $this->storage;
    }

    public function getCommandName()
    {
        return $this->command;
    }

    public function getCommandParams()
    {
        $key = isset($_GET['key']) ? $_GET['key'] : 0;
        $key = isset($_POST['key']) ? $_POST['key'] : $key;
        return $key ? [$key, $this->getData()] : [$this->getData()];
    }
}