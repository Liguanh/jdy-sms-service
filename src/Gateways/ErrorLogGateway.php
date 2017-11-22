<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/22/17
 * Time: 2:14 PM
 * Desc: 网关错误日志的类......
 */

namespace Liguanh\JdySms\Gateways;


use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Interfaces\MessageInterface;

class ErrorLogGateway extends Gateway
{
    public function send($to, MessageInterface $message, Config $config)
    {
        // TODO: Implement send() method.
        if (is_array($to)) {
            $to = implode(',', $to);
        }

        $message = sprintf(
            "[%s] to: %s | message: \"%s\"  | template: \"%s\" | data: %s\n",
            date('Y-m-d H:i:s'),
            $to,
            $message->getContent(),
            $message->getTemplate($this),
            json_encode($message->getData($this))
        );

        $file = $this->config->get('file', ini_get('error_log'));

        $status = error_log($message, 3, $file);

        return compact('file', 'status');
    }

}