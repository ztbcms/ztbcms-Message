<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Messages;


use Message\Libs\Message;
use Message\Model\MessageModel;
use Message\Senders\SimpleSender;
use Message\Senders\SimpleWxSender;

/**
 * 简单的消息实现,模拟用户A给会员B发私信
 */
class SimpleMessage extends Message {


    /**
     * SimpleMessage constructor.
     *
     * @param string $sender
     * @param string $receiver 接收人ID
     * @param string $title  消息标题
     * @param string $content  消息内容
     */
    public function __construct($sender, $receiver, $title='', $content = '') {
        $this->setTitle($title);
        $this->setContent($content);
        $this->setType(MessageModel::TYPE_MESSAGE);

        $this->setSender($sender);
        $this->setSenderType('member');//默认自定义的类型

        $this->setReceiver($receiver);
        $this->setReceiverType('member');

        $this->setTarget('1');
        $this->setTargetType('11');

    }

    /**
     * 消息分发渠道
     *
     * @return array Senders数组
     */
    function createSender() {
        return [
            new SimpleSender(),
            new SimpleWxSender()
        ];
    }
}