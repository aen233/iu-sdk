<?php

namespace Aen233\IUSDK\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected $data;

    /**
     * Error constructor.
     *
     * @param string $message
     * @param int    $code
     * @param array  $data
     */
    public function __construct($message = "", $code = 500, $data = [])
    {
        $this->data = $data;
        parent::__construct($message, $code);
    }

    public function getStatusCode()
    {
        $objClass = new \ReflectionClass(\Symfony\Component\HttpFoundation\Response::class);
        // 此处获取类中定义的全部常量 返回的是 [key=>value,...] 的数组
        // key是常量名 value是常量值
        // dd($objClass->getConstants());
        $httpStatus = array_values($objClass->getConstants());

        return in_array($this->code, $httpStatus) ? $this->code : 500;
    }

    public function getData()
    {
        return $this->data;
    }
}
