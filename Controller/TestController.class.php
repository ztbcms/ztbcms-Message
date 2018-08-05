<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Controller;

use Common\Controller\AdminBase;
use Message\Messages\SimpleMessage;
use Message\Model\MessageModel;
use Message\Service\MessageService;

class TestController extends AdminBase {

    //发送信息
    function pushMessage() {
        $sender = 'jayin';
        $receiver = 'admin';
        $title = '消息';
        $content = '用户 ' . $sender . ' 对用户 ' . $receiver . ' 说:' . '你好，这是推送 at ' . date('Y-m-d H:i:s');
        $msg = new SimpleMessage($sender, $receiver, $title, $content);
        MessageService::createMessage($msg);
    }

    //处理信息
    function handleMessage() {
        $messages = D('Message/Message')->where(['process_status' => MessageModel::PROCESS_STATUS_UNPROCESS])->field('id')->select();
        foreach ($messages as $index => $message) {
            MessageService::handleMessage($message['id']);
        }
    }

    //阅读消息
    function readMessage(){
        $message_id = I('message_id');
        $res=  MessageService::readMessage($message_id);
        var_dump($res);
    }

    //批量创建消息
    function batchPushMessage(){
        $start = time();
        $total = 2000;
        for ($i = 0; $i < $total; $i++){
            $sender = 'jayin'.$i;
            $receiver = 'admin'.$i;
            $title = '消息'.$i;
            $content = '用户 ' . $sender . ' 对用户 ' . $receiver . ' 说:' . '你好，这是推送 at ' . date('Y-m-d H:i:s');
            $msg = new SimpleMessage($sender, $receiver, $title, $content);
            MessageService::createMessage($msg);
        }
        $end = time();
        echo ' start at ' . date('Y-m-d H:i:s', $start) ;
        echo ' end at' . date('Y-m-d H:i:s', $end);
        echo ' use time ' . ($end - $start) . 's';

    }
}