<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Senders;

use Message\Libs\Message;
use Message\Libs\Sender;

class SimpleWxSender extends Sender {

    /**
     * 发送消息操作
     *
     * @param Message $message
     * @return boolean
     */
    function doSend(Message $message) {
        echo '微信端发送 send => ' . $message->getContent() . '<br>';

        return true;
    }
}