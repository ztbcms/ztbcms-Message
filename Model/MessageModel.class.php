<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Model;

use Common\Model\Model;

class MessageModel extends Model {

    protected $tableName = 'message_msg';

    //=== 消息类型
    /**
     * 消息类型：私信
     */
    const TYPE_MESSAGE = 'message';
    /**
     * 消息类型：提醒
     */
    const TYPE_REMIND = 'remind';
    /**
     * 消息类型：公告
     */
    const TYPE_ANNOUNCE = 'announce';

    //=== 处理状态
    /**
     * 处理状态：未处理
     */
    const PROCESS_STATUS_UNPROCESS = 0;
    /**
     * 处理状态：已处理
     */
    const PROCESS_STATUS_PROCESSED = 1;
    /**
     * 处理状态：处理中
     */
    const PROCESS_STATUS_PROCESSING = 2;

    //=== 阅读状态
    /**
     * 阅读状态：未阅读
     */
    const READ_STATUS_UNREAD = 0;
    /**
     * 阅读状态：已阅读
     */
    const READ_STATUS_READ = 1;
}