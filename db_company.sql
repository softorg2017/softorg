

SET FOREIGN_KEY_CHECKS=0;


DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0.未启用 1.启用 9. 禁用',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `start_time` int(11) DEFAULT '0',
  `end_time` int(11) DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='活动表';


INSERT INTO `activity` VALUES ('1', '0', '1', '1', '1', '活动1', '活动1', '描述1', '<p>活动详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p><p>7</p>', '1509501600', '1509793200', '1506169971', '1509948301');
INSERT INTO `activity` VALUES ('2', '0', '2', '2', '0', '活动1', '活动1', '描述1', '<p>活动1详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '0', '0', '1506340200', '1508390889');
INSERT INTO `activity` VALUES ('3', '0', '1', '1', '0', '活动2', '活动2', '描述2', '<p>活动详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p><p>7</p>', '0', '0', '1507742102', '1508227896');


DROP TABLE IF EXISTS `administrator`;
CREATE TABLE `administrator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `org_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员类型 0 超级管理员',
  `role_id` int(11) NOT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(155) DEFAULT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `truename` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `administrator_email_unique` (`email`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';


INSERT INTO `administrator` VALUES ('1', '1', '0', '1', '15800689433', 'longyun.cui88@gmail.com', '$2y$10$Aqu.dd890ZVA0CasV1Zk0OmWjlyqhFVg3pE1jc5XxMLskq2EIIEM2', 'longyun', '崔龙云', null, null, 'yihL5oJ6KwvYr8Ad3sG3beIR8QOhpgn5gnvVw4MuCWSqZjfYNJ5gxfs19EVo');
INSERT INTO `administrator` VALUES ('2', '2', '0', '2', '15800689433', 'longyun-cui@163.com', '$2y$10$Aqu.dd890ZVA0CasV1Zk0OmWjlyqhFVg3pE1jc5XxMLskq2EIIEM2', 'longyun163', '龙云', null, null, '8GGTpjMyhOoBRY5Oz8Ki2V1rlaW52c4ghhsSOh96kdGHGTGdsNY6PUzsIDkH');


DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1.survey 2.slide',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `survey_id` int(11) NOT NULL,
  `slide_id` int(11) NOT NULL DEFAULT '0',
  `page_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='调研-提交表';


INSERT INTO `answer` VALUES ('39', '1', '0', '2', '0', '0', '1509028590', '1509028590');
INSERT INTO `answer` VALUES ('40', '1', '0', '2', '0', '0', '1509064888', '1509064888');
INSERT INTO `answer` VALUES ('41', '1', '0', '2', '0', '0', '1509081968', '1509081968');
INSERT INTO `answer` VALUES ('42', '1', '0', '2', '0', '0', '1509435560', '1509435560');
INSERT INTO `answer` VALUES ('43', '1', '0', '2', '0', '0', '1509435592', '1509435592');
INSERT INTO `answer` VALUES ('44', '1', '0', '2', '0', '0', '1509435603', '1509435603');


DROP TABLE IF EXISTS `apply`;
CREATE TABLE `apply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `activity_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='活动报名表';


DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0.未启用 1.启用 9. 禁用',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='活动表';


INSERT INTO `article` VALUES ('1', '0', '1', '1', '0', '中华医学会第十四次全国白血病·淋巴瘤学术会议', '中华医学会第十四次全国白血病·淋巴瘤学术会议', '描述1111', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1506243480', '1509939107');
INSERT INTO `article` VALUES ('2', '0', '1', '1', '0', '2017天津How I Treat和淋巴瘤转化医学国际研讨会', '2017天津How I Treat和淋巴瘤转化医学国际研讨会', '描述2', '<p style=\"white-space: normal; text-align: center; line-height: 1.75em;\"><br/></p><p style=\"white-space: normal; line-height: 1.75em;\"><img src=\"http://image.135editor.com/files/users/162/1625396/201708/GbPeBZPf_xSp9.png\" alt=\"15018096601201.png\"/></p><p style=\"white-space: normal; line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;</p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 2em;\">2017年8月19~20日，由天津市抗癌协会淋巴瘤专业委员会、天津市抗衰老学会主办，天津医科大学肿瘤医院、中美淋巴血液肿瘤诊治中心和《中国肿瘤临床》与《Cancer Biology &amp; Medicine》杂志社共同承办的2017天津How I Treat和淋巴瘤转化医学国际研讨会将在天津凯悦酒店隆重举行。</p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 2em;\">刚刚结束不久的Lugano国际淋巴瘤大会(ICML)，美国临床肿瘤学大会（ASCO），欧洲血液学协会年会(EHA)等国际著名学术会议上淋巴瘤的研究成果层出不穷，本届会议以“为淋巴瘤医师提供兼具专业性和实用性的基础及临床科研前沿”为宗旨，围绕淋巴瘤的&quot;How I Treat&quot;和转化医学两个主题进行学术报告和讨论，分享国内外淋巴瘤诊治的新进展、新理念、新方法。</p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong style=\"text-indent: 2em;\"><br/></strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>大会主席：张会来教授，孟斌教授</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>会议时间：8月19~20日</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>会议地点：天津凯悦酒店</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>会议日程：</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503059029858553.jpeg\" title=\"1503059029858553.jpeg\" alt=\"天津11.jpg\"/><br/></p><p style=\"font-size: 13px; line-height: normal;\"><strong><span style=\"color: rgb(85, 85, 85);\"></span></strong></p><p style=\"font-size: 14px; line-height: normal;\"><span style=\"font-size: 16px;\"><strong><br/></strong></span></p><p style=\"font-size: 14px; line-height: normal;\"><span style=\"font-size: 16px;\"><strong><br/></strong></span></p><p style=\"font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\"> </span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p style=\"white-space: normal; line-height: 1.75em;\"><br/></p>', '1506243626', '1509939124');
INSERT INTO `article` VALUES ('3', '0', '1', '1', '0', '文章3', '文章3的标题', '描述3', '<p><img src=\"http://res.cdn.bioon.com/application/live/cover_picture/2017/09/21/c5785df23d91993bf40486ba55710ca4.jpg\"/></p>', '1506243697', '1506526136');
INSERT INTO `article` VALUES ('4', '0', '2', '2', '0', '文章1', '文章1', '描述1', '<p>文章1详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1506340164', '1508390971');
INSERT INTO `article` VALUES ('5', '0', '1', '1', '9', '文章4', '文章4', '描述4', '<p>这是内容详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1507745817', '1509946212');


DROP TABLE IF EXISTS `choice`;
CREATE TABLE `choice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `answer_id` int(11) NOT NULL DEFAULT '0',
  `question_id` int(11) NOT NULL DEFAULT '0',
  `option_id` int(11) NOT NULL,
  `text` varchar(256) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='调研-回答选项表';


INSERT INTO `choice` VALUES ('126', '0', '37', '1016', '0', '1', '1508991356', '1508991356');
INSERT INTO `choice` VALUES ('127', '0', '37', '1017', '0', '2', '1508991356', '1508991356');
INSERT INTO `choice` VALUES ('128', '0', '37', '1018', '35', '', '1508991356', '1508991356');
INSERT INTO `choice` VALUES ('129', '0', '37', '1019', '38', '', '1508991356', '1508991356');
INSERT INTO `choice` VALUES ('130', '0', '37', '1020', '42', '', '1508991356', '1508991356');
INSERT INTO `choice` VALUES ('131', '0', '38', '1016', '0', '3', '1508991365', '1508991365');
INSERT INTO `choice` VALUES ('132', '0', '38', '1017', '0', '4', '1508991365', '1508991365');
INSERT INTO `choice` VALUES ('133', '0', '38', '1018', '36', '', '1508991365', '1508991365');
INSERT INTO `choice` VALUES ('134', '0', '38', '1019', '39', '', '1508991365', '1508991365');
INSERT INTO `choice` VALUES ('135', '0', '38', '1020', '42', '', '1508991365', '1508991365');
INSERT INTO `choice` VALUES ('136', '0', '38', '1020', '43', '', '1508991365', '1508991365');
INSERT INTO `choice` VALUES ('137', '0', '39', '1016', '0', '1', '1509028590', '1509028590');
INSERT INTO `choice` VALUES ('138', '0', '39', '1017', '0', '2', '1509028590', '1509028590');
INSERT INTO `choice` VALUES ('139', '0', '39', '1018', '35', '', '1509028590', '1509028590');
INSERT INTO `choice` VALUES ('140', '0', '39', '1019', '38', '', '1509028590', '1509028590');
INSERT INTO `choice` VALUES ('141', '0', '39', '1020', '42', '', '1509028590', '1509028590');
INSERT INTO `choice` VALUES ('142', '0', '40', '1016', '0', '3', '1509064888', '1509064888');
INSERT INTO `choice` VALUES ('143', '0', '40', '1017', '0', '4', '1509064888', '1509064888');
INSERT INTO `choice` VALUES ('144', '0', '40', '1018', '36', '', '1509064888', '1509064888');
INSERT INTO `choice` VALUES ('145', '0', '40', '1019', '40', '', '1509064888', '1509064888');
INSERT INTO `choice` VALUES ('146', '0', '40', '1020', '44', '', '1509064888', '1509064888');
INSERT INTO `choice` VALUES ('147', '0', '41', '1016', '0', '123', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('148', '0', '41', '1017', '0', '123', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('149', '0', '41', '1018', '35', '', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('150', '0', '41', '1019', '40', '', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('151', '0', '41', '1020', '42', '', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('152', '0', '41', '1020', '43', '', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('153', '0', '41', '1020', '44', '', '1509081968', '1509081968');
INSERT INTO `choice` VALUES ('154', '0', '42', '1016', '0', '你好', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('155', '0', '42', '1017', '0', '我很好', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('156', '0', '42', '1018', '37', '', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('157', '0', '42', '1019', '41', '', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('158', '0', '42', '1020', '42', '', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('159', '0', '42', '1020', '43', '', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('160', '0', '42', '1020', '44', '', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('161', '0', '42', '1020', '45', '', '1509435560', '1509435560');
INSERT INTO `choice` VALUES ('162', '0', '43', '1016', '0', '123123123', '1509435592', '1509435592');
INSERT INTO `choice` VALUES ('163', '0', '43', '1017', '0', '123', '1509435592', '1509435592');
INSERT INTO `choice` VALUES ('164', '0', '43', '1018', '36', '', '1509435592', '1509435592');
INSERT INTO `choice` VALUES ('165', '0', '43', '1019', '39', '', '1509435592', '1509435592');
INSERT INTO `choice` VALUES ('166', '0', '43', '1020', '42', '', '1509435592', '1509435592');
INSERT INTO `choice` VALUES ('167', '0', '43', '1020', '43', '', '1509435592', '1509435592');
INSERT INTO `choice` VALUES ('168', '0', '44', '1016', '0', '1', '1509435603', '1509435603');
INSERT INTO `choice` VALUES ('169', '0', '44', '1017', '0', '1', '1509435603', '1509435603');
INSERT INTO `choice` VALUES ('170', '0', '44', '1018', '35', '', '1509435603', '1509435603');
INSERT INTO `choice` VALUES ('171', '0', '44', '1019', '39', '', '1509435603', '1509435603');
INSERT INTO `choice` VALUES ('172', '0', '44', '1020', '42', '', '1509435603', '1509435603');
INSERT INTO `choice` VALUES ('173', '0', '44', '1020', '43', '', '1509435603', '1509435603');


DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='产品目录表';


INSERT INTO `menu` VALUES ('1', '0', '1', '1', '目录1', '目录1', '描述1', '内容1', '1506149860', '1506150122');
INSERT INTO `menu` VALUES ('2', '0', '1', '1', '目录2', '目录2', '描述2', '内容2', '1506150151', '1506150446');
INSERT INTO `menu` VALUES ('3', '0', '1', '1', '目录3', '目录3', '描述3', '内容3', '1506151005', '1506151005');
INSERT INTO `menu` VALUES ('4', '0', '1', '1', '产品目录4', '产品目录4', '描述4', null, '1506151078', '1506151839');
INSERT INTO `menu` VALUES ('5', '0', '1', '1', '产品目录5', '产品目录5', '描述5', null, '1506151823', '1507560612');
INSERT INTO `menu` VALUES ('6', '0', '1', '1', '产品目录6', '产品目录6', '描述6', null, '1506168455', '1506226471');
INSERT INTO `menu` VALUES ('7', '0', '2', '2', '产品目录1', '产品目录1', null, null, '1506339322', '1506339322');
INSERT INTO `menu` VALUES ('8', '0', '1', '1', '产品目录7', null, '描述7', null, '1507742073', '1507742083');


DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');


DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `question_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='调研问题选项表';


INSERT INTO `option` VALUES ('1', '1', '1003', '1', '选项 1', '1', '1', '1');
INSERT INTO `option` VALUES ('2', '1', '1003', '2', '选项 2', '2', '1', '2');
INSERT INTO `option` VALUES ('3', '0', '1003', '3', '选项 3', null, null, null);
INSERT INTO `option` VALUES ('4', '0', '1004', null, '选项 4', null, null, null);
INSERT INTO `option` VALUES ('5', '0', '1004', null, '选项 5', null, null, null);
INSERT INTO `option` VALUES ('6', '0', '1004', null, '选项 6', null, null, null);
INSERT INTO `option` VALUES ('7', '0', '1005', null, '选项 7', null, null, null);
INSERT INTO `option` VALUES ('8', '0', '1005', null, '选项 8', null, null, null);
INSERT INTO `option` VALUES ('9', '0', '1005', null, '选项 9', null, null, null);
INSERT INTO `option` VALUES ('11', '0', '1009', null, '选项1', null, '1508049543', '1508049543');
INSERT INTO `option` VALUES ('12', '0', '1009', null, '选项2', null, '1508049543', '1508049543');
INSERT INTO `option` VALUES ('13', '0', '1009', null, '选项3', null, '1508049543', '1508049543');
INSERT INTO `option` VALUES ('14', '0', '1010', null, '选项1', null, '1508050550', '1508050550');
INSERT INTO `option` VALUES ('15', '0', '1010', null, '选项2', null, '1508050550', '1508050550');
INSERT INTO `option` VALUES ('16', '0', '1010', null, '选项3', null, '1508050550', '1508050550');
INSERT INTO `option` VALUES ('17', '0', '1011', null, '选项1', null, '1508050577', '1508050577');
INSERT INTO `option` VALUES ('18', '0', '1011', null, '选项2', null, '1508050577', '1508050577');
INSERT INTO `option` VALUES ('19', '0', '1011', null, '选项3', null, '1508050577', '1508050577');
INSERT INTO `option` VALUES ('20', '0', '1012', null, '选项1', null, '1508050595', '1508050595');
INSERT INTO `option` VALUES ('21', '0', '1012', null, '选项2', null, '1508050595', '1508050595');
INSERT INTO `option` VALUES ('22', '0', '1012', null, '选项3', null, '1508050595', '1508050595');
INSERT INTO `option` VALUES ('23', '0', '1013', null, '选项1', null, '1508050626', '1508050626');
INSERT INTO `option` VALUES ('24', '0', '1013', null, '选项2', null, '1508050626', '1508050626');
INSERT INTO `option` VALUES ('25', '0', '1013', null, '选项3', null, '1508050626', '1508050626');
INSERT INTO `option` VALUES ('26', '0', '1014', null, '选项1', null, '1508050648', '1508050648');
INSERT INTO `option` VALUES ('27', '0', '1014', null, '选项2', null, '1508050648', '1508050648');
INSERT INTO `option` VALUES ('28', '0', '1014', null, '选项3', null, '1508050648', '1508050648');
INSERT INTO `option` VALUES ('29', '0', '1014', null, '选项4', null, '1508050648', '1508050648');
INSERT INTO `option` VALUES ('30', '0', '1015', null, '选项1', null, '1508050677', '1508050677');
INSERT INTO `option` VALUES ('31', '0', '1015', null, '选项2', null, '1508050677', '1508050677');
INSERT INTO `option` VALUES ('32', '0', '1015', null, '选项3', null, '1508050677', '1508050677');
INSERT INTO `option` VALUES ('33', '0', '1015', null, '选项4', null, '1508050677', '1508050677');
INSERT INTO `option` VALUES ('34', '0', '1015', null, '选项5', null, '1508050677', '1508050677');
INSERT INTO `option` VALUES ('35', '0', '1018', null, '选项1', null, '1508057493', '1508057493');
INSERT INTO `option` VALUES ('36', '0', '1018', null, '选项2', null, '1508057493', '1508057493');
INSERT INTO `option` VALUES ('37', '0', '1018', null, '选项3', null, '1508057493', '1508057493');
INSERT INTO `option` VALUES ('38', '0', '1019', null, '选项1', null, '1508057532', '1508057532');
INSERT INTO `option` VALUES ('39', '0', '1019', null, '选项2', null, '1508057532', '1508057532');
INSERT INTO `option` VALUES ('40', '0', '1019', null, '选项3', null, '1508057532', '1508057532');
INSERT INTO `option` VALUES ('41', '0', '1019', null, '选项4', null, '1508057532', '1508057532');
INSERT INTO `option` VALUES ('42', '0', '1020', null, '选项1', null, '1508057565', '1508057565');
INSERT INTO `option` VALUES ('43', '0', '1020', null, '选项2', null, '1508057565', '1508057565');
INSERT INTO `option` VALUES ('44', '0', '1020', null, '选项3', null, '1508057565', '1508057565');
INSERT INTO `option` VALUES ('45', '0', '1020', null, '选项4', null, '1508057565', '1508057565');
INSERT INTO `option` VALUES ('46', '0', '1021', null, '选项', null, '1509552288', '1509552288');
INSERT INTO `option` VALUES ('47', '0', '1021', null, '选项', null, '1509552288', '1509552288');
INSERT INTO `option` VALUES ('48', '0', '1021', null, '选项', null, '1509552288', '1509552288');


DROP TABLE IF EXISTS `page`;
CREATE TABLE `page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `company_id` int(11) NOT NULL DEFAULT '0',
  `admin_id` int(11) NOT NULL,
  `slide_id` int(11) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL COMMENT '说明',
  `content` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='幻灯页表';


INSERT INTO `page` VALUES ('10', '0', '1', '1', '17', '1', '第一页名称', '第一页', '第一页描述', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1505809788', '1509812703');
INSERT INTO `page` VALUES ('11', '0', '1', '1', '17', '3', '第二页名称', '第二页标题', '第二页描述', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1505809788', '1509812703');
INSERT INTO `page` VALUES ('12', '0', '1', '1', '17', '2', '第三页名称', '第三页', '第三页描述', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1505819156', '1509812703');
INSERT INTO `page` VALUES ('13', '0', '1', '1', '16', '0', '第一页', '第一页', '第一页', '<p>1<br/></p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505828387', '1509674036');
INSERT INTO `page` VALUES ('14', '0', '1', '1', '16', '1', '第二页', '第二页', '第二页', '<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505828387', '1509674158');
INSERT INTO `page` VALUES ('15', '0', '1', '1', '18', '2', '首页', '这是第一页', '第一页说明', '<p>首页内容</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505999440', '1509679673');
INSERT INTO `page` VALUES ('16', '0', '1', '1', '18', '1', '第三页', '第三页', '第三页', '<p>第三页内容</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505999440', '1509679673');
INSERT INTO `page` VALUES ('17', '0', '1', '1', '18', '3', '尾页', '尾页', '尾页', '<p>尾页内容</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505999440', '1509675190');
INSERT INTO `page` VALUES ('18', '0', '1', '1', '18', '0', '第二页', '第二页', '第二页', '<p>第二页内容</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505999514', '1509679673');
INSERT INTO `page` VALUES ('19', '0', '2', '2', '23', '0', '首页', '这是第一个幻灯片', '描述1', null, '1506348585', '1506348803');
INSERT INTO `page` VALUES ('20', '0', '2', '2', '23', '1', '第二页', null, null, null, '1506348585', '1506348585');
INSERT INTO `page` VALUES ('21', '0', '2', '2', '23', '2', '第三页', null, null, null, '1506348585', '1506348585');
INSERT INTO `page` VALUES ('22', '0', '0', '1', '17', '0', '111', '111', '111', '<p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1509807530', '1509812703');
INSERT INTO `page` VALUES ('23', '0', '0', '0', '17', '5', '123', '123', '123', null, '1509807645', '1509807889');
INSERT INTO `page` VALUES ('24', '0', '0', '0', '17', '6', '321', '321', '321', null, '1509807646', '1509807889');
INSERT INTO `page` VALUES ('25', '0', '0', '0', '17', '4', '333', '333', '333', null, '1509807889', '1509807889');


DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pivot_activity_slide`;
CREATE TABLE `pivot_activity_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL COMMENT '活动 id',
  `slide_id` int(11) NOT NULL COMMENT '幻灯片 id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pivot_slide_page`;
CREATE TABLE `pivot_slide_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) NOT NULL COMMENT '幻灯片 id',
  `page_id` int(11) NOT NULL COMMENT '幻灯页 id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `pivot_survey_question`;
CREATE TABLE `pivot_survey_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='调研-问题表 多对多表';


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0.未启用 1.启用 9. 禁用',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属目录',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='企业产品表';


INSERT INTO `product` VALUES ('3', '0', '1', '1', '0', '3', '产品3', '产品3', '说明3', '<p>产品3</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505919537', '1509637106');
INSERT INTO `product` VALUES ('8', '0', '1', '1', '9', '3', '伊布替尼', '伊布替尼', '描述8', '<h3 style=\"margin: 20px 0px 0px; padding: 0px; font-weight: 400; font-size: 16px; max-width: 100%; font-family: &#39;Helvetica Neue&#39;, Helvetica, &#39;Hiragino Sans GB&#39;, &#39;Microsoft YaHei&#39;, Arial, sans-serif; white-space: normal; line-height: 30px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); box-sizing: border-box !important; word-wrap: break-word !important;\"></h3><p style=\"margin-top: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; margin-bottom: 5px; box-sizing: border-box !important; word-wrap: break-word !important;\">2017年8月24日，全球首个口服BTK抑制剂亿珂®（伊布替尼）正式获得中国食品药品监督管理总局（CFDA）批准，用于治疗慢性淋巴细胞白血病及套细胞淋巴瘤患者。亿珂®（伊布替尼）曾四次被FDA授予突破性药物认定，获得国际奖项“盖伦奖”，截止目前全球85个国家获批超过65000名患者受益，未来将开启中国B细胞淋巴瘤治疗的新纪元！&nbsp;<br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170901/1504236204664320.jpeg\" title=\"1504236204664320.jpeg\" alt=\"WechatIMG1165.jpeg\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; color: rgb(0, 0, 255);\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold;\">BTK抑制剂的发现发展之旅-新型靶向药物的诞生</span>&nbsp;</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">据报道，1999年合成了首个BTK抑制剂LFM-A13，但是遗憾的是，随后LFM-A13并未开展临床研究，不过在了解BTK抑制作用的机理下，美国塞莱拉基因公司药物化学教研室学者继续展开研究，最终合成了compound 4，并用两种方法证实了这类药物与BTK结合的不可逆性，ibrutinib就此诞生。&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">而后动物及人体外研究均提示PCI-32765与BTK活化位点不可逆结合，可获得满意疗效。2013年《J Clin Oncol》杂志公布了一项令人激动人心的结果，56例RR B细胞淋巴瘤或CLL患者接受口服ibrutinib升阶梯治疗，ibrutinib与BTK的cys481不可逆结合至少24h。患者OR率为60%，CR为16%4。因此，2013年开始获得FDA加速审批：2013.11MCL，2014.7CLL，2015.1WM,同时欧洲药物机构也批准了这些B细胞恶性肿瘤的药物治疗。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">2012年发表于Blood的一项研究阐释了伊布替尼的作用机制：PCI-32765通过抑制BTK，抑制肿瘤细胞生存和增殖，抑制BCR调控的粘附，调节趋化因子调控的粘附和迁移。同时合理阐释了CLL患者接受伊布替尼治疗后出现的临床应答：可获得快速且持续的淋巴结病变缓解，伴随暂时停药后可逆的一过性淋巴细胞增多。&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold; color: rgb(0, 0, 255);\">CLL/SLL和MCL疗效上历史性的突破</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold;\">PCYC-1102/03研究</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">2013年首次发布在新英格兰医学杂志，纳入了101例R/R CLL患者，研究共随访5年发现，伊布替尼单药治疗患者ORR为89%，中位PFS为52个月，中位OS未达到，5年OS为57%。突破现有免疫化疗方案治疗RR CLL后PFS不到2年的局限。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161387631525.png\" title=\"1504161387631525.png\" alt=\"图片 1.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold;\">MCL-3001&nbsp;RAY研究</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">发表Lancet杂志的一项伊布替尼研究，纳入了280例R/R&nbsp;MCL患者，随访3年，结果显示，伊布替尼单药治疗ORR为72%，中位PFS为15.6个月，中位OS为30.3个月。并且首次复发后使用，PFS可延长至25.4个月, OS 延长至42.1个月;&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">&nbsp;<img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161397949063.png\" title=\"1504161397949063.png\" alt=\"图片 2.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161406723950.png\" title=\"1504161406723950.png\" alt=\"图片 3png.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161414739757.png\" title=\"1504161414739757.png\" alt=\"图片 4.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold; color: rgb(0, 0, 255);\">可靠的安全性</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">在中国发起的以CLL/SLL亚洲患者为主的CLL 3002国际多中心Ⅲ期研究报告显示：伊布替尼对比利妥昔单抗显著提高ORR,中位随访18个月，伊布替尼PFS 74% vs 利妥昔单抗&nbsp;PFS 11.9%,OS 伊布替尼&nbsp;vs 利妥昔单抗79.8% vs57.6%，在显著提高PFS与OS的同时，伊布替尼治疗不良事件多为1或2级，3，4级非常罕见，无剂量相关性，每日一次的口服治疗也给患者带来了更好的生活质量。&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">相信亿珂®（伊布替尼）在中国获批定会为淋巴瘤患者带来全新的治疗选择与更高的生活质量，推动中国淋巴瘤治疗领域水平的提高。</p><p style=\"margin-top: 15px; margin-bottom: 15px; color: rgb(85, 85, 85); font-size: 14px; line-height: normal; white-space: normal;\"><span style=\"font-size: 16px;\"><strong><br/></strong></span></p><p style=\"margin-top: 15px; margin-bottom: 15px; color: rgb(85, 85, 85); font-size: 14px; line-height: normal; white-space: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"text-align: center;\"><span style=\"font-size: 16px;\"><strong><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170915/1505452618242518.png\" title=\"1505452618242518.png\" alt=\"淋巴瘤亿刻二维码.png\"/></strong></span></p>', '1506225562', '1509945869');
INSERT INTO `product` VALUES ('9', '0', '2', '2', '0', '7', '产品1', '产品1', '描述1', '<p>产品1详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1506339300', '1508390839');


DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `survey_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属调研',
  `page_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属幻灯片页',
  `order` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `correct_option` varchar(32) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1022 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='调研问题表';


INSERT INTO `question` VALUES ('1001', '1', '1', '1', '4', '0', '0', '2', '问题题目 1', null, null, null, null, null);
INSERT INTO `question` VALUES ('1002', '2', '1', '1', '4', '0', '0', '1', '问题题目 2', '说明 2', '内容 4', null, null, null);
INSERT INTO `question` VALUES ('1003', '3', '1', '1', '4', '0', '0', '3', '问题题目 选择题 单选题', '单选题 说明3', null, null, null, null);
INSERT INTO `question` VALUES ('1004', '4', '1', '1', '4', '0', '0', '4', '问题题目 选择题 下拉题', '下拉题 说明4', null, null, null, null);
INSERT INTO `question` VALUES ('1005', '5', '1', '1', '4', '0', '0', '5', '问题题目 选择题 多选题', '多选题 说明5', null, null, null, null);
INSERT INTO `question` VALUES ('1006', '1', '1', '1', '4', '0', '0', null, '123', null, null, null, '1508035717', '1508035717');
INSERT INTO `question` VALUES ('1009', '3', '1', '1', '4', '0', '0', null, '3', '4', null, null, '1508049543', '1508049543');
INSERT INTO `question` VALUES ('1010', '3', '1', '1', '4', '0', '0', null, '3', '4', null, null, '1508050550', '1508050550');
INSERT INTO `question` VALUES ('1011', '3', '1', '1', '4', '0', '0', null, '单选题3', '单选题4', null, null, '1508050577', '1508050577');
INSERT INTO `question` VALUES ('1012', '3', '1', '1', '4', '0', '0', null, '单选题3', '单选题4', null, null, '1508050595', '1508050595');
INSERT INTO `question` VALUES ('1013', '3', '1', '1', '4', '0', '0', null, '单选题34', '单选题44', null, null, '1508050626', '1508050626');
INSERT INTO `question` VALUES ('1014', '4', '1', '1', '4', '0', '0', null, '下拉题2', null, null, null, '1508050648', '1508050648');
INSERT INTO `question` VALUES ('1015', '5', '1', '1', '4', '0', '0', null, '多选题4', null, null, null, '1508050677', '1508050677');
INSERT INTO `question` VALUES ('1016', '1', '1', '1', '2', '0', '4', null, '单行文本题', '备注1', null, null, '1508057450', '1509939281');
INSERT INTO `question` VALUES ('1017', '2', '1', '1', '2', '0', '1', null, '多行文本题', '备注2', null, null, '1508057468', '1509643260');
INSERT INTO `question` VALUES ('1018', '3', '1', '1', '2', '0', '2', null, '单选题1', '备注3', null, null, '1508057493', '1509939281');
INSERT INTO `question` VALUES ('1019', '4', '1', '1', '2', '0', '5', null, '下拉题', '备注4', null, null, '1508057532', '1509939281');
INSERT INTO `question` VALUES ('1020', '5', '1', '1', '2', '0', '0', null, '多选题1', '备注5', null, null, '1508057565', '1509643260');
INSERT INTO `question` VALUES ('1021', '4', '1', '1', '2', '0', '3', null, '132', '123', null, null, '1509552288', '1509939281');


DROP TABLE IF EXISTS `records`;
CREATE TABLE `records` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1.主页 2.录目 3.详情页',
  `sort` varchar(64) NOT NULL DEFAULT '0',
  `form` int(11) NOT NULL DEFAULT '0',
  `org_id` int(11) NOT NULL DEFAULT '0',
  `page_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '0.游客',
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0.未启用 1.启用 9. 禁用',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `description` varchar(255) DEFAULT NULL COMMENT '说明',
  `content` text COMMENT '内容',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='幻灯片表';


INSERT INTO `slide` VALUES ('16', '0', '1', '1', '0', '幻灯片16', '幻灯片16的标题', '说明16', '<p>内容16</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p><p>7</p>', '1505664625', '1508227982');
INSERT INTO `slide` VALUES ('17', '1', '1', '1', '0', '幻灯片测试', '测试幻灯片17的标题', '说明17', '<p>内容17</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505664705', '1509672212');
INSERT INTO `slide` VALUES ('18', '0', '1', '1', '1', '幻灯片18', '幻灯片18的标题', '说明18', '<p>内容18</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1505998982', '1509945573');
INSERT INTO `slide` VALUES ('23', '0', '2', '0', '0', '幻灯片1', '幻灯片1', '描述1', '<p>幻灯片1详情</p><p>1</p><p>2</p><p>3</p><p>4</p><p>5</p><p>6</p>', '1506340279', '1508390917');


DROP TABLE IF EXISTS `softorg`;
CREATE TABLE `softorg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `website_name` varchar(64) NOT NULL DEFAULT '' COMMENT '企业网站域名地址名称',
  `name` varchar(255) DEFAULT NULL COMMENT '企业名称',
  `short` varchar(255) DEFAULT NULL COMMENT '企业简称',
  `description` varchar(255) DEFAULT NULL COMMENT '企业描述',
  `slogan` varchar(255) DEFAULT NULL COMMENT '企业标语',
  `logo` varchar(255) DEFAULT NULL COMMENT '业企logo图片url',
  `telephone` varchar(32) DEFAULT NULL COMMENT '企业电话（座机）',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机',
  `email` varchar(64) DEFAULT NULL COMMENT '业企邮箱',
  `qq` varchar(16) DEFAULT NULL COMMENT '企业QQ',
  `wechat` varchar(64) DEFAULT NULL COMMENT '企业微信',
  `title` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL COMMENT '创建时间',
  `updated_at` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `website_name` (`website_name`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8 COMMENT='企业表';


INSERT INTO `softorg` VALUES ('1', '1', 'lotus', '莲花树互联网科技有限公司', '莲花树', '这是一家创造未来de企业', '让企业更出众', null, '021-88886668', '15800689433', 'admin@softorg.cn', '123456789', 'qing_qiyes', null, null, '1508844360');
INSERT INTO `softorg` VALUES ('2', '1', 'qingbo', '轻博吧', '轻博吧', '说你想说的话', '轻轻的我来了', null, '021-88668866', null, 'longyun-cui@163.com', '1234567890', 'qingbo8', null, null, '1508391609');
INSERT INTO `softorg` VALUES ('1001', '0', 'softsocial', '轻社交', '轻社交', null, null, null, null, null, null, null, null, null, null, null);
INSERT INTO `softorg` VALUES ('1010', '0', 'sinsung', '上海信圣投资咨询有限公司', '上海信圣', null, null, null, null, null, null, null, null, null, null, null);


DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态 0.未启用 1.启用 9. 禁用',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `answer_num` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='调研表';


INSERT INTO `survey` VALUES ('1', '0', '1', '1', '0', '调研问卷1', '问卷1', '描述1', '内容1', '0', '1506173760', '1506442144');
INSERT INTO `survey` VALUES ('2', '0', '1', '1', '9', '调研问卷2', '这是一个问卷测试', '描述2', '<p>内容2</p>', '6', '1506175708', '1509945071');
INSERT INTO `survey` VALUES ('3', '0', '2', '2', '0', '问卷1', '标题1', '描述1', null, '0', '1506335012', '1508390930');
INSERT INTO `survey` VALUES ('4', '0', '1', '1', '0', '问卷3 - 问卷测试', '问卷测试', '描述3', null, '0', '1507746192', '1508687928');


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `truename` varchar(64) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='用户表';


DROP TABLE IF EXISTS `user_ext`;
CREATE TABLE `user_ext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO `user_ext` VALUES ('1', '1', 'longyun.cui', null, null);
INSERT INTO `user_ext` VALUES ('2', '2', 'longyun.c', '1506327015', '1506327015');
INSERT INTO `user_ext` VALUES ('3', '3', 'longyun', '1506327309', '1506327309');


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(64) DEFAULT NULL,
  `truename` varchar(64) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户表';


INSERT INTO `users` VALUES ('1', 'longyun.cui', null, 'longyun.cui88@gmail.com', '$2y$10$Aqu.dd890ZVA0CasV1Zk0OmWjlyqhFVg3pE1jc5XxMLskq2EIIEM2', null, null, 'MWDj7UIjf5lDytqHKL4yBS8fTkLL12HqKqwCzQ7pcTKtF3xEHRVuIhuYcSQ7', null, null);
INSERT INTO `users` VALUES ('2', 'longyun.c', null, 'longyun-cui@163.com', '$2y$10$y8vfB.L2kL..LjnB1ZpDpezEykyjKjAhG8zFF9PseET0D1nPJ2pk2', null, null, 't7F8kaxmhu8ITqUEYn7KgJRfha0IROYJmK8a3mhCHNvAhoniHdKQJrvVUElR', '1506327015', '1506327015');
INSERT INTO `users` VALUES ('3', 'longyun', null, 'longyun-cui@qq.com', '$2y$10$jWmmOxjfWj3wHLzm3iGZDOreJLl.QdDRrjA8sEM6jltCx.DVroAVK', null, null, null, '1506327309', '1506327309');


DROP TABLE IF EXISTS `website`;
CREATE TABLE `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


