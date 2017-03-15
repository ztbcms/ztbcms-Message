<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Libs;

/**
 * 发送者
 */
abstract class Sender {

    /**
     * 发送消息操作
     *
     * @param Message $message
     * @return boolean
     */
    abstract function doSend(Message $message);

}