<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/24/16
 * Time: 4:33 PM
 */

namespace HttpStub\Server\Response;


class JsonResponse extends AbstractResponse
{
    protected function preSend()
    {
        parent::preSend();
        header('Content-Type: application/json');
    }

    protected function processData()
    {
        if ($this->data instanceof \Exception) {
            return json_encode([
                'message' => sprintf(
                    static::ERROR_MSG_TEMPLATE,
                    $this->data->getMessage(),
                    $this->data->getFile(),
                    $this->data->getLine())
            ]);
        }

        return json_encode($this->data);
    }
}