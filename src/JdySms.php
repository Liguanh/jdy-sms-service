<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 10:19 AM
 * Desc: 九斗鱼短信通道微服务
 */

namespace Liguanh\JdySms;

use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Exceptions\Exception;
use Liguanh\JdySms\Exceptions\InvalidClassException;
use Liguanh\JdySms\Interfaces\GatewayInterface;
use Liguanh\JdySms\Interfaces\StrategyInterface;
use Liguanh\JdySms\Strategies\OrderStrategy;
use Closure;

class JdySms
{
    /**
     * @var JdySms的渠道配置信息
     */
    protected $config;

    /**
     * @var string 默认网关
     */
    protected $defaultGateway;

    /**
     * @var array 客户端信息
     */
    protected $customCreators = [];

    /**
     * @var array 网关配置数组
     */
    protected $gateways = [];

    /**
     * @var \Liguanh\JdySms\Messenger
     */
    protected $messenger;

    /**
     * @var array 配置的轮询策略信息
     */
    protected $strategies = [];

    /**
     * JdySms constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);

        //设置默认的网关信息
        if (!empty($config['default'])) {
            $this->setDefaultGateway($config['default']);
        }
    }


    /**
     * @desc 发送短信的入口send函数
     * @param string|array  $to  短信接受者手机号
     * @param \Liguanh\JdySms\Messenger|array  $message 短信内容
     * @param array $gateways  短信服务商网关配置信息
     * @return array
     */
    public function send($to, $message, array $gateways = [])
    {
        return $this->getMessenger()->send($to, $message, $gateways);
    }

    /**
     * @desc 获取短信网关的实例化
     * @param null $gateway
     * @return mixed
     */
    public function gateway($gateway = null)
    {
        $gateway = $gateway ? : $this->getDefaultGateway();

        if (!isset($this->gateways[$gateway])) {
            $this->gateways[$gateway] = $this->createGateway($gateway);
        }

        return $this->gateways[$gateway];
    }

    /**
     * @desc 返回创建且实例化的网关类实例
     * @param $gateway
     * @return mixed
     * @throws InvalidClassException
     */
    public function createGateway($gateway)
    {
        if (isset($this->customCreators[$gateway])) {

        } else {
            $className = $this->formatGatewayClassName($gateway);

            //获取对应网关的配置
            $gatewayConfig = $this->config->get("gateways.{$gateway}");

            $gateway = $this->makeGateway($className, $gatewayConfig);
        }

        if (!($gateway instanceof GatewayInterface)) {
            throw new InvalidClassException(sprintf("Gateway %s is not extens from %s", $gateway, GatewayInterface::class));
        }

        return $gateway;
    }

    /**
     * @desc 创建并实例化短信网关的类
     * @param $gateway
     * @param $config
     * @return mixed
     * @throws InvalidClassException
     */
    public function makeGateway($gateway, $config)
    {
        if (!class_exists($gateway)) {
            throw new InvalidClassException(sprintf('Gateway "%s" not exists.', $gateway));
        }

        return new $gateway($config);
    }

    /**
     * @desc 设置默认的短信网关名称
     * @param string $name
     * @return $this
     */
    public function setDefaultGateway($name)
    {
        $this->defaultGateway = $name;

        return $this;
    }

    /**
     * @desc 获取默认的网关配置
     * @return string
     * @throws if no default gateway configured
     */
    public function getDefaultGateway()
    {
        if(empty($this->defaultGateway)) {
            throw new \RuntimeException('No default gateway config');
        }

        return $this->defaultGateway;
    }

    /**
     * @desc 格式化短信网关的类名
     * @param $gateway
     * @return string
     */
    public function formatGatewayClassName($gateway)
    {
        if (class_exists($gateway)) {
            return $gateway;
        }

        $gateway = ucfirst(str_replace(['-', '_', ''], '', $gateway));

        return __NAMESPACE__.'\Gateways\\'.$gateway.'Gateway';
    }

    /**
     * @desc 实例化Messenger的类，并把当前类属性作为初始化值。
     * @return \Liguanh\JdySms\Messenger
     */
    public function getMessenger()
    {
        return $this->messenger ? $this->messenger : new Messenger($this);
    }

    /**
     * @desc 获取配置的实例化信息
     * @return array | \Liguanh\JdySms\Configs\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * 自定义实例化配置的策略类
     * @param null $strategy
     * @return mixed
     * @throws InvalidClassException
     */
    public function strategy($strategy = null)
    {
        //参数为空，取配置中默认的策略信息
        if (is_null($strategy)) {
            $strategy = $this->config->get('default.strategy', OrderStrategy::class);
        }

        //配置中的策略类不存在，设置默认的策略类
        if (!class_exists($strategy)) {
            $strategy = __NAMESPACE__.'Strategoies\\'.ucfirst($strategy);
        }

        //设置默认的策略类不存在，抛异常。
        if (!class_exists($strategy)) {
            throw new InvalidClassException("Unsupported strategy \"{$strategy}\"");
        }
        //实例化短信发送测策略类
        if (empty($this->strategies[$strategy]) || !($this->strategies[$strategy] instanceof  StrategyInterface)) {
            $this->strategies[$strategy] = new $strategy($this);
        }

        return$this->strategies[$strategy];
    }


    /**
     * Register a custom driver creator Closure.
     *
     * @param string   $name
     * @param \Closure $callback
     *
     * @return $this
     */
    public function extend($name, Closure $callback)
    {
        $this->customCreators[$name] = $callback;

        return $this;
    }


    /**
     * Call a custom gateway creator.
     *
     * @param string $gateway
     *
     * @return mixed
     */
    protected function callCustomCreator($gateway)
    {
        return call_user_func($this->customCreators[$gateway], $this->config->get($gateway, []));
    }

}