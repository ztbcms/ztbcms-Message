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
        $messages = D('Message/Message')->where(['process_status' => MessageModel::PROCESS_STATUS_UNPROCESS])->field('id')->select();
        foreach ($messages as $index => $message) {
            MessageService::handleMessage($message['id']);
        }
    }
}