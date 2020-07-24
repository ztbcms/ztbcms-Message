<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Controller;

use Common\Controller\Base;
use Message\Libs\Utils;
use Message\Service\MessageService;

/**
 * Class CliController
 */
class CliController extends Base {

    protected function _initialize() {
        parent::_initialize();

        //如要开启以CLI 形式启动，请注释下面语句
        if(!IS_CLI){
            echo '请用命令行运行！';
            exit;
        }
    }


    /**
     * CLI入口
     * php index.php /Message/Cli/start
     */
    function start(){
        cache('__message_loop_stop__', null);
        while (true) {
            $message = MessageService::popMessage()['data'];
            if($message){
                Utils::log('Process MsgId:'.$message['id']);
                MessageService::handleMessage($message['id']);
            }
            $unhandle_amount = MessageService::getUnhandleCount()['data']['count'];
            if($unhandle_amount == 0){
                sleep(C('MESSAGE_LOOP_SLEEP'));
            }
            if (cache('__message_loop_stop__')) {
                Utils::log('Process exit with stop signal');
                break;
            }
        }
    }

    /**
     * 停止
     */
    function stop(){
        cache('__message_loop_stop__', 1);
        Utils::log('Send STOP signal.');
        exit;
    }

}