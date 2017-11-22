<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 5:16 PM
 * Desc: 网关策略的接口类
 */

namespace Liguanh\JdySms\Interfaces;


interface StrategyInterface
{
    public function apply(array $gateways);
}