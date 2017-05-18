<?php
namespace Message\Controller;

use Common\Controller\AdminBase;
use Message\Service\MessageService;

/**
 * 消息
 */
class MessageController extends AdminBase {
    /**
     * 消息列表页
     */
    public function index() {
        if (IS_AJAX) {

        }

        $this->display();
        return;
    }

    /**
     * 获取消息列表操作
     */
    public function getMessageList(){
        $where = [];
        if (I('where')) {
            $where = I('where');
            foreach ($where as $key => $item) {
                if ($item == '') {
                    unset($where[$key]);
                }
            }
        }

        $order = 'id desc';
        $page = I('page', 1);
        $limit = I('limit', 20);
        $lists = M('MessageMsg')->where($where)->order($order)->page($page, $limit)->select();
        $total = M('MessageMsg')->where($where)->count();
        $data = [
            'items' => $lists ? $lists : [],
            'limit' => $limit,
            'page' => $page,
            'total' => $total,
            'page_count' => ceil($total / $limit),
        ];

        $this->ajaxReturn(self::createReturn(true, $data));
    }

    /**
     * 触发消息处理
     */
    public function handleMessage(){
        $message_id = I('post.message_id');
        MessageService::handleMessage($message_id);
        $this->ajaxReturn(self::createReturn(true, null, '操作完成'));
    }
}