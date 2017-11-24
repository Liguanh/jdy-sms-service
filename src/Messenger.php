<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 11:13 AM
 * Desc: 九斗鱼平台通道出入口类
 */

namespace Liguanh\JdySms;

use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Exceptions\GatewayErrorException;
use Liguanh\JdySms\Exceptions\NoGatewayAvailableException;
use Liguanh\JdySms\Interfaces\MessageInterface;


class Messenger
{

    /**
     * @var 设置短信通道调用的返回状态值
     */
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR   = 'error';

    /**
     * @var \Liguanh\JdySms\JdySms;
     */
    protected $jdySms;

    /**
     * Messenger constructor.
     * @param \Liguanh\JdySms\JdySms $jdySms
     */
    public function __construct(JdySms $jdySms)
    {
        $this->jdySms = $jdySms;
    }

    /**
     * @param array|string  $to
     * @param string|array|\Liguanh\JdySms\Messenger   $message
     * @param array $gateways
     * @throws
     * @return array
     */
    public function send($to, $message, array $gateways = [])
    {
        //格式化要发送的短信渠道的短信内容，格式化为Message的实例类
        $message = $this->formatMessage($message);


        //如果没有传要发送短信的网关，那么取Message类实例化的网关属性的值
        if (empty($gateways)) {
            $gateways = $message->getGateways();
        }

        //如果Message类的属性中没有网关信息，那么获取配置中默认网关信息
        if (empty($gateways)) {
            $gateways = $this->jdySms->getConfig()->get('default.gateways', []);
        }

        //格式化要设置的网关信息
        $gateways = $this->formatGateways($gateways);

        //获取自定义的网关策略信息
        $strategyApplyGateways = $this->jdySms->strategy()->apply($gateways);

        $results = [];

        $hasSuccess = false;

        foreach ($strategyApplyGateways as $gateway) {

            try {
                $results[$gateway] = [
                    'status' => self::STATUS_SUCCESS,
                    'result' => $this->jdySms->gateway($gateway)->send($to, $message, new Config($gateways[$gateway])),
                ];
                $hasSuccess = true;

                break;

            } catch (GatewayErrorException $e) {

                $results[$gateway] = [
                    'status' => self::STATUS_ERROR,
                    'msg' => $e->getMessage(),
                ];

                continue;
            }
        }

       /* if (!$hasSuccess) {
            throw new NoGatewayAvailableException($results);
       }*/

        return $results;
    }

    /**
     * @desc 格式化短信内容，实例化为Message的对象
     * @param $message array|\Liguanh\JdySms\Interfaces\MessageInterface
     * @return array|\Liguanh\JdySms\Message
     */
    public function formatMessage($message)
    {

        //判断$message 是否被实例化且继成接口类信息
        if (!($message instanceof MessageInterface)) {

            if (!is_array($message)) {
                $message = [
                    'message' => strval($message),
                    'template' => strval($message),
                ];
            }

            $message = new Message($message);
        }

        return $message;
    }

    /**
     * @desc 格式化网关信息
     * @param array $gateways
     * @return array@
     */
    public function formatGateways(array $gateways)
    {
        $formatted = [];
        //返回JdySms渲染的config实例...
        $config = $this->jdySms->getConfig();

        if (empty($gateways)) {
            return $formatted;
        }

        foreach ($gateways as $gateway=>$setting) {

            if (is_int($gateway) || is_string($setting)) {
                $gateway = $setting;
                $setting = [];
            }

            $formatted[$gateway] = $setting;

            //获取全局配置信息
            $globalSettings = $config->get("gateways.{$gateway}", []);

            if (is_string($gateway) && !empty($globalSettings) && is_array($setting)) {
                $formatted[$gateway] = array_merge($globalSettings, $setting);
            }
        }
        return $formatted;
    }
}
