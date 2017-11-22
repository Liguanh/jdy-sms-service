<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 5:16 PM
 * Desc: 网关策略，顺序轮询
 */

namespace Liguanh\JdySms\Strategies;


use Liguanh\JdySms\Interfaces\StrategyInterface;

class OrderStrategy implements StrategyInterface
{

    /**
     * @desc 轮询方案处理函数
     * @param array $gateways
     * @return array
     */
    public function apply(array $gateways)
    {
        if (empty($gateways)) {
            //TODO ........
        }

        return array_keys($gateways);
    }
}