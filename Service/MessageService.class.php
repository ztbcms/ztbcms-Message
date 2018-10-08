<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Service;

use Message\Libs\Message;
use Message\Libs\Sender;
use Message\Model\MessageModel;
use System\Service\BaseService;

/**
 * 消息服务
 */
class MessageService extends BaseService {

    /**
     * 创建消息
     *
     * @param Message $message
     * @return array
     */
    static function createMessage(Message $message) {
        $class = get_class($message);

        $now = time();
        $data = [
            'title' => $message->getTitle(),
            'content' => $message->getContent(),
            'target' => $message->getTarget(),
            'target_type' => $message->getTargetType(),
            'sender' => $message->getSender(),
            'sender_type' => $message->getSenderType(),
            'receiver' => $message->getReceiver(),
            'receiver_type' => $message->getReceiverType(),
            'read_status' => MessageModel::READ_STATUS_UNREAD,
            'process_status' => MessageModel::PROCESS_STATUS_UNPROCESS,
            'create_time' => $now,
            'send_time' => 0,
            'type' => $message->getType(),
            'class' => $class,
            'url' => $message->getUrl()
        ];

        $result = D('Message/Message')->add($data);

        if ($result) {
            return self::createReturn(true, $result);
        }

        return self::createReturn(false, null, '操作失败');

    }

    /**
     * 处理消息
     *
     * @param $message_id
     * @return array
     * @internal message $message
     */
    static function handleMessage($message_id) {
        $db = D('Message/Message');
        $msg = $db->where(['id' => $message_id])->find();

        if ($msg && !empty($msg['class'])) {
            $message = self::instance($msg);
            $senders = $message->createSender();
            //标识发送时间
            self::updateMessage($message_id,
                ['process_status' => MessageModel::PROCESS_STATUS_PROCESSING, 'send_time' => time()]);
            //每个Sender都发送
            foreach ($senders as $index => $sender) {
                self::sendMessage($sender, $message);
            }
            //标识为已处理
            self::updateMessage($message_id, ['process_status' => MessageModel::PROCESS_STATUS_PROCESSED]);
            //处理次数+1，用于debug消息确认是否手动重复执行正确;高并发下会不会同一消息处理两次
            $db->where(['id' => $message_id])->setInc('process_num', 1);
        }

        return self::createReturn(true, '');
    }

    /**
     * 阅读消息
     *
     * @param $message_id
     * @return array
     */
    static function readMessage($message_id) {
        return self::updateMessage($message_id,
            ['read_time' => time(), 'read_status' => MessageModel::READ_STATUS_READ]);
    }

    /**
     * 发送消息
     *
     * @param Sender $sender
     * @param Message $message
     * @return bool
     */
    private static function sendMessage(Sender $sender, Message $message) {
        return $sender->doSend($message);
    }

    /**
     * 更新消息
     *
     * @param       $message_id
     * @param array $data
     * @return array
     */
    private static function updateMessage($message_id, array $data) {
        $db = D('Message/Message');
        $result = $db->where(['id' => $message_id])->save($data);

        if ($result) {
            return self::createReturn(true, $result);
        }

        return self::createReturn(false, null);

    }


    /**
     * 实例化消息并初始化
     *
     * @param $msg_data
     * @return Message
     */
    private static function instance($msg_data) {
        $message = self::instanceMessage($msg_data['class']);

        return self::initData($message, $msg_data);
    }

    /**
     * 创建消息实例
     *
     * @param $class
     * @return Message
     */
    private static function instanceMessage($class) {
        return new $class;
    }

    /**
     * 初始化数据
     *
     * @param Message $message
     * @param array   $msg_data
     * @return Message
     */
    private static function initData(Message $message, $msg_data) {
        $message->setId($msg_data['id']);
        $message->setTitle($msg_data['title']);
        $message->setContent($msg_data['content']);

        $message->setTarget($msg_data['target']);
        $message->setTargetType($msg_data['target_type']);
        $message->setSender($msg_data['sender']);
        $message->setSenderType($msg_data['sender_type']);
        $message->setReceiver($msg_data['receiver']);
        $message->setReceiverType($msg_data['receiver_type']);
        $message->setReadStatus($msg_data['read_status']);
        $message->setProcessStatus($msg_data['process_status']);

        $message->setCreateTime($msg_data['create_time']);
        $message->setType($msg_data['type']);
        $message->setClass($msg_data['class']);
        $message->setUrl($msg_data['url']);

        return $message;
    }

    /**
     * 取出一条未处理的消息记录
     *
     * @return array
     */
    static function popMessage() {
        $db = D('Message/Message');
        $result = false;
        $db->startTrans();
        $msg_record = $db->where(['process_status' => MessageModel::PROCESS_STATUS_UNPROCESS])->find();
        if($msg_record){
            $save_result = $db->where([
                'id' => $msg_record['id'],
                'process_status' => MessageModel::PROCESS_STATUS_UNPROCESS
            ])->save(['process_status' => MessageModel::PROCESS_STATUS_PROCESSING]);
            if($save_result){
                $result = $db->commit();
            }
        }

        if ($result) {
            return self::createReturn(true, $msg_record);
        } else {
            $db->rollback();
            return self::createReturn(false, null);
        }
    }

    /**
     * 获取队列中未处理的数
     *
     * @return array
     */
    static function getUnhandleCount(){
        $db = D('Message/Message');
        $count =  $db->where(['process_status' => MessageModel::PROCESS_STATUS_UNPROCESS])->count();

        return self::createReturn(true, ['count' => $count]);
    }
}