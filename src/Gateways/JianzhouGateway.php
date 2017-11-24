<?php
namespace Liguanh\JdySms\Gateways;

use Liguanh\JdySms\Traits\HttpRequest;
use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Interfaces\MessageInterface;
use Liguanh\JdySms\Exceptions\GatewayErrorException;

class JianzhouGateway extends Gateway
{
    use HttpRequest;

    const ENDPOINT_URL = 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage';
    const MAX_PHONE_NUMS = 3000;
    const SUCCESS_CODE = 0;

    //短信提交错误定义
    protected static $sendSmsReturn = [
        '-1'   => '余额不足',
        '-2'   => '帐号或密码错',
        '-3'   => '连接服务商失败',
        '-4'   => '超时',
        '-5'   => '其他错误，一般为网络问题，IP受限等',
        '-6'   => '短信内容为空',
        '-7'   => '目标号码为空',
        '-8'   => '用户通道设置不对，需要设置三个通道',
        '-9'   => '捕获未知异常',
        '-10'  => '超过最大定时时间限制',
        '-13'  => '没有权限使用该网关',
        '-17'  => '没有提交权限，客户端帐号无法使用接口提交。或非绑定IP提交',
        '-18'  => '提交参数名称不正确或确少参数',
        '-19'  => '必须为POST提交',
        '-20'  => '超速提交(非验证码类短信一般为每秒一次提交)',
        '-21'  => '扩展参数不正确',
        '-22'  => 'Ip 被封停',
        '-23'  => '国际短信号码必须“00”开头',
        '-24'  => 'userTaskID错误',
        ];

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
        $phoneArr = is_array($to) ? $to : explode(",",$to);

        if (count($phones) > self::MAX_PHONE_NUMS) {
            throw new Exceptions('超出最大的限制数');
        }

        $phones  = implode(",", $phoneArr);

        //TO DO send a simple sms
        $params = [
            'account' => $config->get('username'),
            'password' => $config->get('password'),
            'destmobile' => $phones,
            'msgText'  => $message->getContent(),
            ];

        $result = $this->post(self::ENDPOINT_URL, $params);

        //发送失败
        if ($result < self::SUCCESS_CODE) {
            throw new GatewayErrorException(self::$sendSmsReturn[$result], $result);
        }

        $return  = [
            'message' => '发送成功',
            'code'  => $result,
        ];

        return $return;
    }

    /**
     * @desc 查询短信余额的方法
     */
    public function queryBalance()
    {

    }
}
