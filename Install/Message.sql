DROP TABLE IF EXISTS `cms_message_msg`;
CREATE TABLE `cms_message_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '消息标题',
  `content` varchar(512) NOT NULL DEFAULT '' COMMENT '消息内容',
  `target` varchar(128) NOT NULL DEFAULT '' COMMENT '消息源',
  `target_type` varchar(11) NOT NULL DEFAULT '' COMMENT '消息源类型',
  `sender` varchar(128) NOT NULL DEFAULT '' COMMENT '发送者',
  `sender_type` varchar(11) NOT NULL DEFAULT '' COMMENT '发送者类型',
  `receiver` varchar(128) NOT NULL DEFAULT '' COMMENT '接收者',
  `receiver_type` varchar(11) NOT NULL DEFAULT '' COMMENT '接收者类型',
  `read_status` int(11) NOT NULL DEFAULT '0' COMMENT '阅读状态: 0未阅读 1已阅读',
  `process_status` int(11) NOT NULL DEFAULT '0' COMMENT '处理状态：0未处理 1已处理, 2处理中',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `send_time` int(11) NOT NULL COMMENT '发送时间',
  `type` varchar(32) NOT NULL DEFAULT 'message' COMMENT '消息类型：message私信 remind提醒 announce公告',
  `category` varchar(32) NOT NULL DEFAULT '' COMMENT '分类',
  `class` varchar(128) NOT NULL DEFAULT '' COMMENT '实例化的类名',
  `read_time` int(11) NOT NULL COMMENT '阅读时间',
  `process_num` int(11) NOT NULL DEFAULT '0' COMMENT '处理次数',
  `url` text NOT NULL COMMENT '关联链接',
  PRIMARY KEY (`id`),
  KEY `create_time` (`create_time`),
  KEY `sender` (`sender`),
  KEY `sender_type` (`sender_type`),
  KEY `receiver` (`receiver`),
  KEY `receiver_type` (`receiver_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `cms_message_channel` (
  `channel_id` varchar(32) NOT NULL DEFAULT '',
  `channel_type` varchar(16) NOT NULL DEFAULT '' COMMENT '频道类型',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '频道名称',
  `target_type` varchar(16) NOT NULL DEFAULT '',
  `target` varchar(11) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `update_time` int(11) NOT NULL COMMENT '更新时间',
  UNIQUE KEY `channel_id` (`channel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='频道';

CREATE TABLE `cms_message_channel_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `channel_id` varchar(32) NOT NULL DEFAULT '' COMMENT '频道ID',
  `channel_type` varchar(16) NOT NULL DEFAULT '' COMMENT '频道类型',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_type` varchar(32) NOT NULL DEFAULT '' COMMENT '用户类型',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `lastest_msg_time` int(11) NOT NULL COMMENT '最近的消息时间',
  `unread_amount` int(11) NOT NULL COMMENT '未读数量',
  PRIMARY KEY (`id`),
  KEY `channel_id` (`channel_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户频道';

CREATE TABLE `cms_message_user_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `user_type` varchar(16) NOT NULL DEFAULT '',
  `channel_id` varchar(32) NOT NULL DEFAULT '' COMMENT '频道ID',
  `channel_type` varchar(16) NOT NULL DEFAULT '',
  `msg_id` int(11) NOT NULL COMMENT '消息ID',
  `read_time` int(11) NOT NULL COMMENT '已读时间',
  `create_time` int(11) NOT NULL COMMENT '创建时间',
  `delete_time` int(11) NOT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `channel_id` (`channel_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;