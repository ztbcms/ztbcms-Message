DROP TABLE IF EXISTS `cms_message_msg`;
CREATE TABLE `cms_message_msg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
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
  `type` varchar(11) NOT NULL DEFAULT 'message' COMMENT '消息类型：message私信 remind提醒 announce公告',
  `class` varchar(128) NOT NULL DEFAULT '' COMMENT '实例化的类名',
  `read_time` int(11) NOT NULL COMMENT '阅读时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;