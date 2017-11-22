<?php
/**
 * Created by PhpStorm.
 * User: linguanghui
 * Date: 11/21/17
 * Time: 11:46 AM
 * Desc: 短信内容处理的接口类
 */

namespace Liguanh\JdySms\Interfaces;


interface MessageInterface
{
    /**
     * @desc 短信发送的类型，文字or语音
     */
    const TEXT_MESSAGE = 'text';
    const VOICE_MESSAGE = 'voice';

    /**
     * @desc 返回短信的类型
     * @return string
     */
    public function getMessageType();


    public function getContent();


    public function getTemplate();

    public function getData();

    public function getGateways();

}