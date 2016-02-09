<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 10:33 PM
 */

namespace HttpStub\Server\Request;


class RestRequest extends Request
{
    protected $key;

    public function __construct()
    {
        parent::__construct();
        $this->storage = $this->determinateStorageName();
        $this->command = $this->determinateCommand();
    }

    public function getData()
    {
        return json_decode(file_get_contents('php://input'), true);
    }

    public function getStorageName()
    {
        return $this->storage;
    }

    public function getCommandName()
    {
        return $this->command;
    }

    protected function determinateStorageName()
    {
        $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        return array_shift($uri);
    }

    public function getParams()
    {
        $uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

        array_shift($uri);

        return $uri;
    }

    public function getCommandParams()
    {
        $params = $this->getParams();
        $body = $this->getData();
        if ($this->method == 'DELETE') {
            $body = isset($body['key']) ? $body['key'] : 0;
        }

        return array_filter([array_pop($params), $body]);
    }

    protected function determinateCommand()
    {
        switch ($this->method) {
            case 'GET':
                return $this->getParams() ? 'read' : 'readAll';
            case 'POST':
                return 'insert';
            case 'PUT':
                return 'update';
            case 'DELETE':
                return 'delete';
        }

        return 'readAll';
    }
}