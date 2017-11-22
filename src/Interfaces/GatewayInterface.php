<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 3:07 PM
 */

namespace Liguanh\JdySms\Interfaces;


use Liguanh\JdySms\Configs\Config;

interface GatewayInterface
{

    /**
     * send a short message
     * @param $to
     * @param MessageInterface $message
     * @param Config $config
     * @return mixed
     */
    public function send($to, MessageInterface $message,  Config $config);
}