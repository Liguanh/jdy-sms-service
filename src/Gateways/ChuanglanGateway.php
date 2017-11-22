<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/22/17
 * Time: 2:40 PM
 * Desc: 创蓝短信通道网关信息
 */

namespace Liguanh\JdySms\Gateways;


use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Interfaces\MessageInterface;
use Liguanh\JdySms\Traits\HttpRequest;

class ChuanglanGateway extends Gateway
{
    use HttpRequest;

    public function send($to, MessageInterface $message, Config $config)
    {
        // TODO: Implement send() method.
    }
}