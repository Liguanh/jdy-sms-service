<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 11:37 AM
 * Desc: 短信内容处理类
 */

namespace Liguanh\JdySms;

use Liguanh\JdySms\Interfaces\MessageInterface;


class Message implements MessageInterface
{

    /**
     * @var array
     */
    protected $gateways = [];

    /**
     * @var string
     */
    protected $signature;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $content;

    /**
     * @var string
     */
    protected $template;

    /**
     * @var array
     */
    protected $data = [];


    /**
     * Message constructor.
     * @param array $attributes
     * @param string $type
     */
    public function __construct(array $attributes = [], $type = MessageInterface::TEXT_MESSAGE)
    {
        $this->type = $type;

        foreach ($attributes as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }
    }

    /**
     * @desc 获取短信类型
     * @return string
     */
    public function getMessageType()
    {
        return $this->type;
    }

    /**
     * @desc Get the message Content
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @desc Return the template of message
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @desc Return the Message Data
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @desc 返回短信平台网关
     * @return array
     */
    public function getGateways()
    {
        return $this->gateways;
    }

    /**
     * @desc 返回短信内容的签名
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

}