<?php

/**
 * 模块安装，基本配置
 */
return array(
    //模块名称
    'modulename' => '消息系统',
    //图标
    'icon' => 'https://dn-coding-net-production-pp.qbox.me/e57af720-f26c-4f3b-90b9-88241b680b7b.png',
    //模块简介
    'introduce' => '私信、提醒，站内信',
    //模块介绍地址
    'address' => 'http://doc.ztbcms.com/module/message/',
    //模块作者
    'author' => 'Jayin',
    //作者地址
    'authorsite' => 'http://www.jayinton.com',
    //作者邮箱
    'authoremail' => 'admin@ztbcms.com',
    //版本号，请不要带除数字外的其他字符
    'version' => '1.0.2.2',
    //适配最低版本，
    'adaptation' => '3.0.0.0',
    //签名
    'sign' => 'd78d201337cf9f6ea9ca8d73e8c8fefe',
    //依赖模块
    'depend' => array(
        'Cron'
    ),
    //注册缓存
    'cache' => array(),
);
