<?php 
namespace Liguanh\JdySms\Gateways;

use Liguanh\JdySms\Traits\HttpRequest;
use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Interfaces\MessageInterface;

class JianzhouGateway extends Gateway
{
    use HttpRequest;

    const ENDPOINT_URL = '';

    /**
     * @desc 短信发送方法
     * @param $to
     * @param MessageInterface $message
     * @param Config $config
     * @return array|mixed|string
     * @throws GatewayErrorException
     */
    public function send($to, MessageInterface $message, Config $config)
    {
        //TO DO send a simple sms
    }
}
