<h1 align="center">九斗鱼短信微服务</h1>
<p align="center">九斗鱼平台短信通道微服务，实现满足平台不同的短信类型[验证码、通知、营销类］及短信通道的发送。</p>

<p align="center">
<a href="https://travis-ci.org/overtrue/easy-sms"><img src="https://travis-ci.org/overtrue/easy-sms.svg?branch=master" alt="Build Status"></a>
<a href="https://packagist.org/packages/overtrue/easy-sms"><img src="https://poser.pugx.org/overtrue/easy-sms/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/overtrue/easy-sms"><img src="https://poser.pugx.org/overtrue/easy-sms/v/unstable.svg" alt="Latest Unstable Version"></a>
<a href="https://scrutinizer-ci.com/g/overtrue/easy-sms/?branch=master"><img src="https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a>
<a href="https://scrutinizer-ci.com/g/overtrue/easy-sms/?branch=master"><img src="https://scrutinizer-ci.com/g/overtrue/easy-sms/badges/coverage.png?b=master" alt="Code Coverage"></a>
<a href="https://packagist.org/packages/overtrue/easy-sms"><img src="https://poser.pugx.org/overtrue/easy-sms/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/overtrue/easy-sms"><img src="https://poser.pugx.org/overtrue/easy-sms/license" alt="License"></a>
</p>

## 特点

- 参考的git_hub上overtrue的easy-sms  [https://github.com/overtrue/easy-sms.git]
- 支持目前多家服务商不同短信类型[验证码类，通知类，营销类]
- 配置简单，简单的配置可以增减切换服务商
- 内置多个服务商发送排序策略，还可以自定义轮询策略
- 统一的接口返回格式，便于实时跟进和日至监控
- 发送接口兼容各种平台，灵活增减服务商对应的类
- 其他功能还待改进，共勉........

## 短信平台通道支持

- 建周[通知类，验证码类]
- 漫道[营销类]
- 沃动[营销类]
- 美联[验证码类，营销类]
- 创蓝[营销类]
- 大汉三通[验证码类，营销类]


## 环境要求
 
- PHP >= 5.6

## 安装

```shell

$ composer require "Liguanh/jdy-sms-service"
```

## 网关文件创建方法[shell]

- 文档根目录manager.sh 是shell执行的主要文件
- 执行sh mananer.sh 或者 sh manager.sh help 查看当前可用的命令列表
- 创建自定义的网关文档：`sh manager.sh make_gateway gateway_name`
- 每个网关都会自动在类名后追加Gateway, 网关的类名尽量符合网关的定义规则
- 删除网站类: `sh manager.sh rm_gateway gateway_name`
- 其他功能还在继续跟进中......

## 使用步骤

