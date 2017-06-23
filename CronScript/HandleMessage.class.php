<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\CronScript;

use Cron\Base\Cron;
use Message\Model\MessageModel;
use Message\Service\MessageService;

/**
 * 处理(发送)消息
 *
 * 建议每隔1分钟处理一次
 */
class HandleMessage extends Cron {

    /**
     * 执行任务回调
     *
     * @param string $cronId
     */
    public function run($cronId) {

        $message = MessageService::popMessage()['data'];
        while (!empty($message)) {
            MessageService::handleMessage($message['id']);
            $message = MessageService::popMessage()['data'];
        }
    }
}