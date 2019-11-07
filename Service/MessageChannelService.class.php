<?php
/**
 * User: jayinton
 * Date: 2019-11-07
 * Time: 14:12
 */

namespace Message\Service;


use System\Service\BaseService;

class MessageChannelService extends BaseService
{
    function generateChannelId()
    {
        return uniqid('chat');
    }

    function createChannel($channel_data)
    {
        $channel_id = isset($channel_data['channel_id']) ? $channel_data['channel_id'] : $this->generateChannelId();
        $data = [
            'channel_id' => $channel_id,
            'channel_type' => $channel_data['channel_type'],
            'name' => $channel_data['name'],
            'target_type' => $channel_data['target_type'],
            'target' => $channel_data['target'],
            'create_time' => time(),
            'update_time' => time(),
        ];
        $res = M('message_channel')->add($data);
        if ($res) {
            return self::createReturn(true, [''], '创建成功');
        }
        return self::createReturn(false, null, '创建失败');
    }

    /**
     * 获取用户频道消息列表
     * @param $channel_id
     * @param $user_id
     * @param $user_type
     * @param int $page
     * @param int $limit
     * @return array
     */
    function getUserChannelMessage($channel_id, $user_id, $user_type, $page = 1, $limit = 10)
    {
        $db = M('MessageUserMsg');
        $where = [
            'channel_id' => $channel_id,
            'user_id' => $user_id,
            'user_type' => $user_type,
            'delete_time' => ['GT', 0],
        ];
        $lists = $db->where($where)->page($page)->limit($limit)->select();

        $total = $db->where($where)->count();
        $total_page = ceil($total / $limit);
        if (empty($lists)) {
            $lists = [];
        }

        return self::createReturnList(false, $lists, $page, $limit, $total, $total_page);
    }

    /**
     * 阅读全部用户消息
     * @param $channel_id
     * @param $user_id
     * @param $user_type
     * @return array
     */
    function readAllUserChannelMessage($channel_id, $user_id, $user_type){
        $db = M('MessageUserMsg');
        $where = [
            'channel_id' => $channel_id,
            'user_id' => $user_id,
            'user_type' => $user_type,
            'read_time' => 0,
        ];
        $db->where($where)->save([
            'read_time' => time()
        ]);
        return self::createReturn(true, null, '操作完成');
    }
}