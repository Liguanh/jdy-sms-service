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
                    'file' => '/tmp/jdy-sms.log',
                ],
                'jianzhou' => [
                    'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
                ],
                'chuanglan' => [
                    'username'=> 'M3653525',
                    'password'=>'gHLwj2hmZy4b40',
                ],
            ],
        ];

        $jdySms = new JdySms($config);

        $return = $jdySms->send('15501191752,18234475430', [
            'gateways' => ['chuanglan'],
            'content' => '亲爱的鱼客，您的“老用户回馈红包”还有三天就要到期了，请尽早使用，祝周末愉快, 回复TD退订',
            'template' => 'SK_TEMDKSK',
            'data' => [
                'code' => '112342'
            ],
        ]);

        print_r($return);exit;
    }

}