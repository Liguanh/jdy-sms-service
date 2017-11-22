<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 4:06 PM
 * Desc: 处理短信发送配置信息的类
 */

namespace Liguanh\JdySms\Configs;


class Config
{
    /**
     * @var $config
     */
    protected $config;

    /**
     * Config constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @desc get an item from an define array using the 'dot' notation.
     * @param $key string
     * @param null $default
     *
     * @return array|mixed|null
     */
    public function get($key, $default = null)
    {
        $config = $this->config;

        if (is_null($key)) {
            return null;
        }

        //如果key值在数组顶级，直接返回
        if (isset($config[$key])) {
            return $config[$key];
        }
        //以dot分割传入的key值循环处理配置信息
        foreach (explode('.', $key) as $segment) {

            if (!is_array($config) || !array_key_exists($segment, $config)) {
                return $default;
            }
            $config = $config[$segment];
        }

        return $config;
    }
}