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
use Liguanh\JdySms\Exceptions\GatewayErrorException;
use Liguanh\JdySms\Interfaces\MessageInterface;
use Liguanh\JdySms\Traits\HttpRequest;

class ChuanglanGateway extends Gateway
{
    use HttpRequest;

    const ENDPOINT_URL = 'http://smssh1.253.com/msg/HttpBatchSendSM?';
    const SUCCESS_CODE = 0;

    protected static $sendSmsStatus  = [
        '101'  => '无此用户',
        '102'  => '密码错误',
        '103'  => '提交过快(提交速度超过流量限制)',
        '104'  => '系统忙(因平台原因，暂时无法处理提交的短信)',
        '105'  => '敏感短信(关心内容包含敏感词)',
        '106'  => '消息长度错误(>536 or <=0)',
        '107'  => '包含错误的手机号码',
        '108'  => '手机号码个数错（群发>50000或<=0;单发>200或<=0）',
        '109'  => '无发送额度（该用户可用短信数已使用完）',
        '110'  => '不在发送时间内',
        '111'  => '超出该账户当月发送额度限制',
        '112'  => '无此产品，用户没有订购该产品',
        '113'  => 'extno格式错（非数字或者长度不对）',
        '115'  => '自动审核驳回',
        '116'  => '签名不合法，未带签名（用户必须带签名的前提下）',
        '117'  => 'IP地址认证错,请求调用的IP地址不是系统登记的IP地址',
        '118'  => '用户没有相应的发送权限',
        '119'  => '用户已过期',
        '120'  => '测试内容不是白名单',
        '123'  => '发送类型错误',
        '124'  => '白模版匹配错误',
        '125'  => '匹配驳回模版,提交失败',
        '127'  => '定时发送时间格式错误',
        '128'  => '内容编码失败',
        '129'  => 'json格式错误',
        '130'  => '请求参数错误(却少必要的参数)',
    ];

    /**
     * @desc 格式化信息
     * @param $to
     * @param MessageInterface $message
     * @param Config $config
     * @return array|mixed|string
     * @throws GatewayErrorException
     */
    public function send($to, MessageInterface $message, Config $config)
    {
        $params = [
            'account' => $config->get('username'),
            'pswd' => $config->get('password'),
            'mobile' => $to,
            'msg' => $message->getContent(),
        ];

        $result = $this->get(self::ENDPOINT_URL, $params);

        $formatResult = $this->formatResult($result);

        if (!empty($formatResult[1]) && $formatResult[1] != self::SUCCESS_CODE) {

            throw new GatewayErrorException(self::$sendSmsStatus[$formatResult[1]], $formatResult[1]);
        }

        $formatResult = [
            'message' => '发送成功',
            'code'  => $formatResult[1],
            'send_time' => $formatResult[0]
        ];

        return $formatResult;
    }

    /**
     * @desc 格式化创蓝接口返回的结果
     * @param $result string
     * @return array
     */
    public function formatResult($result)
    {
        $result = str_replace("\n", ',', $result);

        return explode(',', $result);
    }
}