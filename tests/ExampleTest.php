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
                    'jianzhou', 'chuanglan',
                ],
            ],
            // 可用的网关配置
            'gateways' => [
                'errorlog' => [
                    'file' => '/tmp/jdy-sms.log',
                ],
                'jianzhou' => [
                    'username' => 'sdk_notify',
                    'password' => '20150818',
                ],
                'chuanglan' => [
                    'username'=> 'M3653525',
                    'password'=>'gHLwj2hmZy4b40',
                ],
            ],
        ];

        $jdySms = new JdySms($config);

        $return = $jdySms->send(15501191752, [
            'gateways' => ['jianzhou'],
            'content' => '你的验证码是：344908, 找回密码成功，【九斗鱼】',
            'template' => 'SK_TEMDKSK',
            'data' => [
                'code' => '112342'
            ],
        ]);

        print_r($return);exit;
    }

}
