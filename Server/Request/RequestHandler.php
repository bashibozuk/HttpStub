<?php
/**
 * Created by PhpStorm.
 * User: vasil
 * Date: 1/23/16
 * Time: 9:15 PM
 */

namespace HttpStub\Server\Request;


use HttpStub\Exception;
use HttpStub\Server\Response\AbstractResponse;
use HttpStub\Server\Response\JsonResponse;
use HttpStub\Server\Response\PlainResponse;
use HttpStub\Storage\AbsractStorage;
use HttpStub\Storage\FileStorage;

class RequestHandler
{
    protected static $config;

    public static function init($config = [])
    {
        static::$config['request_type'] = isset($config['request_type']) ? $config['request_type'] : Request::TYPE_REST;
        static::$config['response_type'] = isset($config['response_type']) ? $config['response_type'] : AbstractResponse::TYPE_JSON;
        static::$config['storage_class'] = isset($config['storage_class']) ? $config['storage_class'] : FileStorage::class;
    }

    public static function handleRequest()
    {
        $response = static::createResponse();

        try {
            $request = static::createRequest();
            $storage = static::createStorage($request->getStorageName());
            static::doCommand($request, $storage, $response);
        } catch (Exception $e) {
            $response->setData($e);
        }

        $response->send();
    }

    protected static function doCommand(Request $request, AbsractStorage $storage, AbstractResponse $response)
    {
        $result = $storage->command($request->getCommandName(), $request->getCommandParams());
        $response->setData($result);
    }


    /**
     * @return Request
     */
    protected static function createRequest()
    {
        return static::$config['request_type'] == Request::TYPE_REST ? new RestRequest() : new HttpRequest();
    }

    /**
     * @return AbstractResponse
     */
    protected static function createResponse()
    {
        if (isset(static::$config['response_type'])) {
            return static::$config['response_type'] == AbstractResponse::TYPE_JSON ? new JsonResponse() : new PlainResponse();
        }
        $headers = [];
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        }


        if (isset($headers['Accept']) && stripos('json', $headers['Accept']) !== false) {
            return new JsonResponse();
        }

        return new PlainResponse();
    }

    protected static function createStorage($name)
    {
        if (static::$config['storage_class'] == FileStorage::class) {
            return new FileStorage($name);
        }

        throw new Exception('Not supported storage class ' . self::$config['storage_class']);
    }
}