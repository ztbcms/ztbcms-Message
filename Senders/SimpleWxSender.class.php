<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Senders;

use Message\Libs\Message;
use Message\Libs\Sender;
use Think\Log;

class SimpleWxSender extends Sender {

    /**
     * 发送消息操作
     *
     * @param Message $message
     * @return boolean
     */
    function doSend(Message $message) {
        Log::write('微信端发送 send => ' . $message->getContent());

        return true;
    }
}