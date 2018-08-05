<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Libs;

/**
 * 消息
 */
abstract class Message {

    //消息ID
    protected $id = '';
    //标题
    protected $title = '';
    //消息内容
    protected $content = '';
    protected $target = '';
    protected $target_type = '';
    protected $sender = '';
    protected $sender_type = '';
    protected $receiver = '';
    protected $receiver_type = '';
    protected $create_time;
    protected $send_time;
    protected $class;
    //消息类型
    protected $type = 1;
    //处理状态 0未处理 1已处理, 2处理中
    protected $process_status = 0;
    //阅读状态 0未阅读 1已阅读
    protected $read_status = 0;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * 消息分发渠道
     *
     * @return array Senders数组
     */
    abstract function createSender();

    /**
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getTarget() {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget($target) {
        $this->target = $target;
    }

    /**
     * @return string
     */
    public function getTargetType() {
        return $this->target_type;
    }

    /**
     * @param string $target_type
     */
    public function setTargetType($target_type) {
        $this->target_type = $target_type;
    }

    /**
     * @return string
     */
    public function getSender() {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender($sender) {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getSenderType() {
        return $this->sender_type;
    }

    /**
     * @param string $sender_type
     */
    public function setSenderType($sender_type) {
        $this->sender_type = $sender_type;
    }

    /**
     * @return string
     */
    public function getReceiver() {
        return $this->receiver;
    }

    /**
     * @param string $receiver
     */
    public function setReceiver($receiver) {
        $this->receiver = $receiver;
    }

    /**
     * @return string
     */
    public function getReceiverType() {
        return $this->receiver_type;
    }

    /**
     * @param string $receiver_type
     */
    public function setReceiverType($receiver_type) {
        $this->receiver_type = $receiver_type;
    }

    /**
     * @return mixed
     */
    public function getCreateTime() {
        return $this->create_time;
    }

    /**
     * @param mixed $create_time
     */
    public function setCreateTime($create_time) {
        $this->create_time = $create_time;
    }

    /**
     * @return mixed
     */
    public function getSendTime() {
        return $this->send_time;
    }

    /**
     * @param mixed $send_time
     */
    public function setSendTime($send_time) {
        $this->send_time = $send_time;
    }

    /**
     * @return int
     */
    public function getProcessStatus() {
        return $this->process_status;
    }

    /**
     * @param int $process_status
     */
    public function setProcessStatus($process_status) {
        $this->process_status = $process_status;
    }

    /**
     * @return int
     */
    public function getReadStatus() {
        return $this->read_status;
    }

    /**
     * @param int $read_status
     */
    public function setReadStatus($read_status) {
        $this->read_status = $read_status;
    }

    /**
     * @return mixed
     */
    public function getClass() {
        return $this->class;
    }

    /**
     * @param mixed $class
     */
    public function setClass($class) {
        $this->class = $class;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type) {
        $this->type = $type;
    }


}