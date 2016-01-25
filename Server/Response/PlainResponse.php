<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/24/16
 * Time: 4:36 PM
 */

namespace HttpStub\Server\Response;


class PlainResponse extends AbstractResponse
{
    protected function processData()
    {
        if ($this->data instanceof \Exception) {
            return sprintf(
                    static::ERROR_MSG_TEMPLATE,
                    $this->data->getMessage(),
                    $this->data->getFile(),
                    $this->data->getLine()
            );
        }

        if (is_scalar($this->data)) {
            return $this->data;
        }

        if (is_object($this->data) && method_exists($this->data, '__toString')) {
            return $this->data;
        }

        return serialize($this->data);
    }
}