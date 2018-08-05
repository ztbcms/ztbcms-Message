<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Senders;

use Message\Libs\Message;
use Message\Libs\Sender;
use Think\Log;

class SimpleSender extends Sender {


    /**
     * 发送消息操作
     *
     * @param Message $message
     * @return boolean
     */
    function doSend(Message $message) {
        Log::write('simple send => msg_id=>' . $message->getId() . ' content=> ' . $message->getContent());

        return true;
    }
}