<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Message\Libs;

class Utils {

    /**
     * 获取毫秒级别的时间戳
     *
     * @return float
     */
    static function now() {

        return round(microtime(true) * 1000);

    }

    static function log($msg){
        echo $msg . "\r\n";
    }

}