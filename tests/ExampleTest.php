<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 4:32 PM
 * 测试用力demo
 */

namespace Liguanh\JdySms\Tests;


use Liguanh\JdySms\JdySms;
use Liguanh\JdySms\Strategies\OrderStrategy;

class ExampleTest extends TestCase
{

    public function testJdySmsSteps()
    {
        $config = [
            // HTTP 请求的超时时间（秒）
            'timeout' => 5.0,

            // 默认发送配置
            'default' => [
                // 网关调用策略，默认：顺序调用
                'strategy' => \Liguanh\JdySms\Strategies\OrderStrategy::class,

                // 默认可用的发送网关
                'gateways' => [
                    'yunpian', 'aliyun', 'alidayu',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/easy-sms.log',
                ],
                'yunpian' => [
                    'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
                ],
                'aliyun' => [
                    'access_key_id' => '',
                    'access_key_secret' => '',
                    'sign_name' => '',
                ],
                'alidayu' => [
                    //...
                ],
            ],
        ];

        $jdySms = new JdySms($config);

        print_r('JdySms实例化类的属性列表:'.PHP_EOL);
        print_r($jdySms);

    }

}