<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 7:04 PM
 * Desc: 无可用的网关抛异常
 */

namespace Liguanh\JdySms\Exceptions;


class NoGatewayAvailableException extends Exception
{

    /**
     * @var array
     */
    public $results = [];

    /**
     * NoGatewayAvailableException constructor.
     *
     * @param array           $results
     * @param int             $code
     * @param \Throwable|null $previous
     */
    public function __construct(array $results = [], $code = 0, \Throwable $previous = null)
    {
        $this->results = $results;
        parent::__construct('All the gateways have failed.', $code, $previous);
    }
}