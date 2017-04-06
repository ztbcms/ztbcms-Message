<?php
namespace Message\Controller;

use Common\Controller\AdminBase;

class MessageController extends AdminBase {
    public function index() {
        if (IS_AJAX) {
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
                'lists' => $lists ? $lists : [],
                'limit' => $limit,
                'page' => $page,
                'total' => $total,
                'page_count' => ceil($total / $limit),
            ];

            return $this->success($data);
        }

        return $this->display();
    }
}