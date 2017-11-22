<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 6:00 PM
 * Desc: 网关错误抛异常
 */

namespace Liguanh\JdySms\Exceptions;


use Throwable;

class GatewayErrorException extends Exception
{

    /**
     * GatewayErrorException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}