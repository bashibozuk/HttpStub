<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/24/16
 * Time: 4:02 PM
 */

namespace HttpStub\Server\Response;

abstract class AbstractResponse
{
    const TYPE_JSON = 'json';

    const TYPE_PLAIN_TEXT = 'plain';

    const STATUS_OK = 200;

    const STATUS_ERROR = 500;

    const ERROR_MSG_TEMPLATE = 'Error %s , in file %s at line %s';

    protected $data;

    protected $status;

    public function __construct($data = null)
    {
        $this->data = $data;
        $this->status = 200;
    }

    public function setData($data)
    {
        $this->data = $data;
        if ($this->data instanceof \Exception) {
            $this->status = 500;
        }
    }

    protected function preSend()
    {
        $protocol = $_SERVER['SERVER_PROTOCOL'];
        header(sprintf('%s %s %s', $protocol, $this->status, $this->status == self::STATUS_OK ? 'OK' : 'Internal Server Error'));
    }

    public function send()
    {
        $this->preSend();
        $data = $this->processData();

        echo $data;
    }

    abstract protected function processData();

}