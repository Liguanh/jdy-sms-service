<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 6:41 PM
 */

namespace Liguanh\JdySms\Gateways;


use Liguanh\JdySms\Configs\Config;
use Liguanh\JdySms\Interfaces\GatewayInterface;

abstract class Gateway implements GatewayInterface
{

    const DEFAULT_TIMEOUT = 5.0;

    /**
     * @var \Liguanh\JdySms\Configs\Config;
     */
    protected $config;

    /**
     * @var float
     */
    protected $timeout;

    /**
     * Gateway constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = new Config($config);
    }

    /**
     * return the timeout
     *
     * @return array|mixed|null
     */
    public function getTimeout()
    {
        return $this->timeout ? : $this->config->get('timeout', self::DEFAULT_TIMEOUT);
    }


    /**
     * @desc Set the timeout
     * @param $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = floatval($timeout);

        return $this;
    }

    /**
     * @return \Liguanh\JdySms\Configs\Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Liguanh\JdySms\Configs\Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }
}