<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 5:47 PM
 * Desc: 类不存在抛异常
 */

namespace Liguanh\JdySms\Exceptions;


use Throwable;

class InvalidClassException extends Exception
{
    protected $results = [];

    /**
     * 自定义类不存在抛出异常。
     * InvalidClassException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}