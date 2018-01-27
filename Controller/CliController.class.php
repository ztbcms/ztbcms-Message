<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Controller;

use Common\Controller\Base;
use Message\Service\MessageService;

/**
 * Class CliController
 */
class CliController extends Base {

    protected function _initialize() {
        parent::_initialize();

        //如要开启以CLI 形式启动，请注释下面语句
        exit();

        set_time_limit(0);
        ignore_user_abort(true);
    }


    /**
     * CLI入口
     * php index.php /Message/Cli/start
     */
    function start(){
        $unhandle_amount = MessageService::getUnhandleCount()['data']['count'];
        while ($unhandle_amount) {
            $message = MessageService::popMessage()['data'];
            if($message){
                MessageService::handleMessage($message['id']);
            }
            $unhandle_amount = MessageService::getUnhandleCount()['data']['count'];
        }
    }

}