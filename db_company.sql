/*
Navicat MySQL Data Transfer
Source Host     : localhost:3306
Source Database : db_company
Target Host     : localhost:3306
Target Database : db_company
Date: 2017-10-14 03:38:25
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for activity
-- ----------------------------
DROP TABLE IF EXISTS `activity`;
CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
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

-- ----------------------------
-- Records of activity
-- ----------------------------
INSERT INTO `activity` VALUES ('1', '0', '1', '1', '活动1', '活动1', '描述1', null, null, null, '1506169971', '1506419867');
INSERT INTO `activity` VALUES ('2', '0', '2', '2', '活动1', null, null, null, null, null, '1506340200', '1506340200');
INSERT INTO `activity` VALUES ('3', '0', '1', '1', '活动2', null, '描述2', null, '0', '0', '1507742102', '1507742111');

-- ----------------------------
-- Table structure for activity_slide
-- ----------------------------
DROP TABLE IF EXISTS `activity_slide`;
CREATE TABLE `activity_slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_id` int(11) NOT NULL COMMENT '活动 id',
  `slide_id` int(11) NOT NULL COMMENT '幻灯片 id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of activity_slide
-- ----------------------------

-- ----------------------------
-- Table structure for administrator
-- ----------------------------
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

-- ----------------------------
-- Records of administrator
-- ----------------------------
INSERT INTO `administrator` VALUES ('1', '1', '0', '1', '15800689433', 'longyun.cui88@gmail.com', '$2y$10$Aqu.dd890ZVA0CasV1Zk0OmWjlyqhFVg3pE1jc5XxMLskq2EIIEM2', 'longyun', '崔龙云', null, null, 'BewW3UpXhVI9dAaUjC079C6YOZF6Gli0ogGwvG5DuY2NrvP1mdeySLqhSGRq');
INSERT INTO `administrator` VALUES ('2', '2', '0', '2', '15800689433', 'longyun-cui@163.com', '$2y$10$Aqu.dd890ZVA0CasV1Zk0OmWjlyqhFVg3pE1jc5XxMLskq2EIIEM2', 'longyun163', '龙云', null, null, 'K18l61KYWkFT5lGW6114rSc0HRcoOgQ3BpZhFgC73BVpmw7sekNV8hpFVSED');

-- ----------------------------
-- Table structure for apply
-- ----------------------------
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

-- ----------------------------
-- Records of apply
-- ----------------------------

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='活动表';

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', '0', '1', '1', '文章1', '中华医学会第十四次全国白血病·淋巴瘤学术会议', '描述1111', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1506243480', '1507741666');
INSERT INTO `article` VALUES ('2', '0', '1', '1', '文章2', '2017天津How I Treat和淋巴瘤转化医学国际研讨会', '描述2', '<p style=\"white-space: normal; text-align: center; line-height: 1.75em;\"><br/></p><p style=\"white-space: normal; line-height: 1.75em;\"><img src=\"http://image.135editor.com/files/users/162/1625396/201708/GbPeBZPf_xSp9.png\" alt=\"15018096601201.png\"/></p><p style=\"white-space: normal; line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;</p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 2em;\">2017年8月19~20日，由天津市抗癌协会淋巴瘤专业委员会、天津市抗衰老学会主办，天津医科大学肿瘤医院、中美淋巴血液肿瘤诊治中心和《中国肿瘤临床》与《Cancer Biology &amp; Medicine》杂志社共同承办的2017天津How I Treat和淋巴瘤转化医学国际研讨会将在天津凯悦酒店隆重举行。</p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 2em;\">刚刚结束不久的Lugano国际淋巴瘤大会(ICML)，美国临床肿瘤学大会（ASCO），欧洲血液学协会年会(EHA)等国际著名学术会议上淋巴瘤的研究成果层出不穷，本届会议以“为淋巴瘤医师提供兼具专业性和实用性的基础及临床科研前沿”为宗旨，围绕淋巴瘤的&quot;How I Treat&quot;和转化医学两个主题进行学术报告和讨论，分享国内外淋巴瘤诊治的新进展、新理念、新方法。</p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong style=\"text-indent: 2em;\"><br/></strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>大会主席：张会来教授，孟斌教授</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>会议时间：8月19~20日</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>会议地点：天津凯悦酒店</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-indent: 0em;\"><strong>会议日程：</strong></p><p style=\"white-space: normal; line-height: 1.75em; text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503059029858553.jpeg\" title=\"1503059029858553.jpeg\" alt=\"天津11.jpg\"/><br/></p><p style=\"font-size: 13px; line-height: normal;\"><strong><span style=\"color: rgb(85, 85, 85);\"></span></strong></p><p style=\"font-size: 14px; line-height: normal;\"><span style=\"font-size: 16px;\"><strong><br/></strong></span></p><p style=\"font-size: 14px; line-height: normal;\"><span style=\"font-size: 16px;\"><strong><br/></strong></span></p><p style=\"font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\"> </span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p style=\"white-space: normal; line-height: 1.75em;\"><br/></p>', '1506243626', '1506607914');
INSERT INTO `article` VALUES ('3', '0', '1', '1', '文章3', '文章3的标题', '描述3', '<p><img src=\"http://res.cdn.bioon.com/application/live/cover_picture/2017/09/21/c5785df23d91993bf40486ba55710ca4.jpg\"/></p>', '1506243697', '1506526136');
INSERT INTO `article` VALUES ('4', '0', '2', '2', '文章1', null, null, null, '1506340164', '1506340164');
INSERT INTO `article` VALUES ('5', '0', '1', '1', '文章4', null, null, null, '1507745817', '1507745817');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
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

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '0', '1', '1', '目录1', '目录1', '描述1', '内容1', '1506149860', '1506150122');
INSERT INTO `menu` VALUES ('2', '0', '1', '1', '目录2', '目录2', '描述2', '内容2', '1506150151', '1506150446');
INSERT INTO `menu` VALUES ('3', '0', '1', '1', '目录3', '目录3', '描述3', '内容3', '1506151005', '1506151005');
INSERT INTO `menu` VALUES ('4', '0', '1', '1', '产品目录4', '产品目录4', '描述4', null, '1506151078', '1506151839');
INSERT INTO `menu` VALUES ('5', '0', '1', '1', '产品目录5', '产品目录5', '描述5', null, '1506151823', '1507560612');
INSERT INTO `menu` VALUES ('6', '0', '1', '1', '产品目录6', '产品目录6', '描述6', null, '1506168455', '1506226471');
INSERT INTO `menu` VALUES ('7', '0', '2', '2', '产品目录1', '产品目录1', null, null, '1506339322', '1506339322');
INSERT INTO `menu` VALUES ('8', '0', '1', '1', '产品目录7', null, '描述7', null, '1507742073', '1507742083');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');

-- ----------------------------
-- Table structure for option
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='调研问题选项表';

-- ----------------------------
-- Records of option
-- ----------------------------
INSERT INTO `option` VALUES ('1', '1', '1003', '1', '选项 1', '1', '1', '1');
INSERT INTO `option` VALUES ('2', '1', '1003', '2', '选项 2', '2', '1', '2');
INSERT INTO `option` VALUES ('3', '0', '1003', '3', '选项 3', null, null, null);
INSERT INTO `option` VALUES ('4', '0', '1004', null, '选项 4', null, null, null);
INSERT INTO `option` VALUES ('5', '0', '1004', null, '选项 5', null, null, null);
INSERT INTO `option` VALUES ('6', '0', '1004', null, '选项 6', null, null, null);
INSERT INTO `option` VALUES ('7', '0', '1005', null, '选项 7', null, null, null);
INSERT INTO `option` VALUES ('8', '0', '1005', null, '选项 8', null, null, null);
INSERT INTO `option` VALUES ('9', '0', '1005', null, '选项 9', null, null, null);

-- ----------------------------
-- Table structure for page
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='幻灯页表';

-- ----------------------------
-- Records of page
-- ----------------------------
INSERT INTO `page` VALUES ('10', '0', '1', '1', '17', '0', '第一页名称', '第一页', '第一页描述', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1505809788', '1507508712');
INSERT INTO `page` VALUES ('11', '0', '1', '1', '17', '1', '第二页名称', '第二页标题', '第二页描述', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1505809788', '1507508819');
INSERT INTO `page` VALUES ('12', '0', '1', '1', '17', '2', '第三页名称', '第三页', '第三页描述', '<p style=\"text-align: center;\"><br/></p><p style=\"text-align: center;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170818/1503043458806450.png\" title=\"1503043458806450.png\" alt=\"image.png\" width=\"600\" height=\"130\"/></p><p><br/></p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp;中华医学会第十四次全国白血病·淋巴瘤学术会议于2017年7月13日-7月15日在哈尔滨市举办。会议由中华医学会、中华医学会血液学分会主办，哈尔滨血液病肿瘤研究所、中国医学科学院血液病医院、北京大学血液病研究所、苏州大学附属第一医院血研所、北京白求恩公益基金会协办。有来自国内外著名学者就白血病及淋巴瘤、骨髓瘤等领域相关基础及临床做专题报告；美国、欧洲、日本等学者对白血病、淋巴瘤、骨髓瘤、造血干细胞移植、MDS及MPN进行了专题研讨；分为白血病、淋巴瘤、骨髓瘤、恶性血液病的免疫治疗、造血干细胞移植、MDS及MPN等专场进行学术论文交流。</p><p style=\"line-height: 1.75em;\">&nbsp; &nbsp; &nbsp; &nbsp;中华医学会王大方副秘书长致辞时表示，此次会议将对白血病和淋巴瘤的临床热点及难点进行全方位、深层次和多角度讨论，为进一步提高我国血液病防治水平做出新的更大贡献，为改善全民健康水平发挥了极其重大的作用。</p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"line-height: 1.75em;\"><br/></p><p style=\"font-size: 14px; line-height: normal;\"><strong><span style=\"font-size: 16px;\"></span></strong></p><p style=\"white-space: normal; font-size: 14px; line-height: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"white-space: normal; text-align: center;\"><img src=\"http://image.135editor.com/files/users/286/2865052/201708/VzeRSUnA_kKgB.png\" alt=\"WechatIMG1466.png\"/></p><p><br/></p>', '1505819156', '1507508831');
INSERT INTO `page` VALUES ('13', '0', '1', '1', '16', '0', null, '第一页', null, null, '1505828387', '1505828387');
INSERT INTO `page` VALUES ('14', '0', '1', '1', '16', '1', null, '第二页', null, null, '1505828387', '1505828387');
INSERT INTO `page` VALUES ('15', '0', '1', '1', '18', '0', '首页', '这是第一页', '第一页说明', '内容', '1505999440', '1505999561');
INSERT INTO `page` VALUES ('16', '0', '1', '1', '18', '2', '第二页', '第二页', null, null, '1505999440', '1506008607');
INSERT INTO `page` VALUES ('17', '0', '1', '1', '18', '3', '尾页', '第三页', null, null, '1505999440', '1505999514');
INSERT INTO `page` VALUES ('18', '0', '1', '1', '18', '1', '第三页', '第三页', null, null, '1505999514', '1506008607');
INSERT INTO `page` VALUES ('19', '0', '2', '2', '23', '0', '首页', '这是第一个幻灯片', '描述1', null, '1506348585', '1506348803');
INSERT INTO `page` VALUES ('20', '0', '2', '2', '23', '1', '第二页', null, null, null, '1506348585', '1506348585');
INSERT INTO `page` VALUES ('21', '0', '2', '2', '23', '2', '第三页', null, null, null, '1506348585', '1506348585');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `menu_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属目录',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `content` text,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='企业产品表';

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', '0', '1', '1', '0', '产品1', '产品1', '说明1', '内容1', '1505919213', '1506419617');
INSERT INTO `product` VALUES ('2', '0', '1', '1', '2', '产品2', '产品2', '说明2', '<p>内容2</p>', '1505919424', '1507564802');
INSERT INTO `product` VALUES ('3', '0', '1', '1', '3', '产品3', '产品3', '说明3', '<p>产品3</p>', '1505919537', '1507564847');
INSERT INTO `product` VALUES ('4', '0', '1', '1', '2', '产品4', '产品4', '描述4', '<p>内容4</p>', '1505919820', '1507564839');
INSERT INTO `product` VALUES ('5', '0', '1', '1', '2', '产品5', '产品5', '描述5', '<p>内容5</p>', '1505920085', '1507564782');
INSERT INTO `product` VALUES ('6', '0', '1', '1', '6', '产品6', '产品6', '描述6', '<p>内容6</p>', '1506146529', '1507564830');
INSERT INTO `product` VALUES ('7', '0', '1', '1', '6', '产品7', '产品7', '描述7', null, '1506168426', '1507564792');
INSERT INTO `product` VALUES ('8', '0', '1', '1', '3', '产品8', '产品8', '描述8', '<h3 style=\"margin: 20px 0px 0px; padding: 0px; font-weight: 400; font-size: 16px; max-width: 100%; font-family: &#39;Helvetica Neue&#39;, Helvetica, &#39;Hiragino Sans GB&#39;, &#39;Microsoft YaHei&#39;, Arial, sans-serif; white-space: normal; line-height: 30px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); box-sizing: border-box !important; word-wrap: break-word !important;\"></h3><p style=\"margin-top: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; margin-bottom: 5px; box-sizing: border-box !important; word-wrap: break-word !important;\">2017年8月24日，全球首个口服BTK抑制剂亿珂®（伊布替尼）正式获得中国食品药品监督管理总局（CFDA）批准，用于治疗慢性淋巴细胞白血病及套细胞淋巴瘤患者。亿珂®（伊布替尼）曾四次被FDA授予突破性药物认定，获得国际奖项“盖伦奖”，截止目前全球85个国家获批超过65000名患者受益，未来将开启中国B细胞淋巴瘤治疗的新纪元！&nbsp;<br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170901/1504236204664320.jpeg\" title=\"1504236204664320.jpeg\" alt=\"WechatIMG1165.jpeg\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; color: rgb(0, 0, 255);\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold;\">BTK抑制剂的发现发展之旅-新型靶向药物的诞生</span>&nbsp;</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">据报道，1999年合成了首个BTK抑制剂LFM-A13，但是遗憾的是，随后LFM-A13并未开展临床研究，不过在了解BTK抑制作用的机理下，美国塞莱拉基因公司药物化学教研室学者继续展开研究，最终合成了compound 4，并用两种方法证实了这类药物与BTK结合的不可逆性，ibrutinib就此诞生。&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">而后动物及人体外研究均提示PCI-32765与BTK活化位点不可逆结合，可获得满意疗效。2013年《J Clin Oncol》杂志公布了一项令人激动人心的结果，56例RR B细胞淋巴瘤或CLL患者接受口服ibrutinib升阶梯治疗，ibrutinib与BTK的cys481不可逆结合至少24h。患者OR率为60%，CR为16%4。因此，2013年开始获得FDA加速审批：2013.11MCL，2014.7CLL，2015.1WM,同时欧洲药物机构也批准了这些B细胞恶性肿瘤的药物治疗。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">2012年发表于Blood的一项研究阐释了伊布替尼的作用机制：PCI-32765通过抑制BTK，抑制肿瘤细胞生存和增殖，抑制BCR调控的粘附，调节趋化因子调控的粘附和迁移。同时合理阐释了CLL患者接受伊布替尼治疗后出现的临床应答：可获得快速且持续的淋巴结病变缓解，伴随暂时停药后可逆的一过性淋巴细胞增多。&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold; color: rgb(0, 0, 255);\">CLL/SLL和MCL疗效上历史性的突破</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold;\">PCYC-1102/03研究</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">2013年首次发布在新英格兰医学杂志，纳入了101例R/R CLL患者，研究共随访5年发现，伊布替尼单药治疗患者ORR为89%，中位PFS为52个月，中位OS未达到，5年OS为57%。突破现有免疫化疗方案治疗RR CLL后PFS不到2年的局限。</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161387631525.png\" title=\"1504161387631525.png\" alt=\"图片 1.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold;\">MCL-3001&nbsp;RAY研究</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">发表Lancet杂志的一项伊布替尼研究，纳入了280例R/R&nbsp;MCL患者，随访3年，结果显示，伊布替尼单药治疗ORR为72%，中位PFS为15.6个月，中位OS为30.3个月。并且首次复发后使用，PFS可延长至25.4个月, OS 延长至42.1个月;&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">&nbsp;<img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161397949063.png\" title=\"1504161397949063.png\" alt=\"图片 2.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161406723950.png\" title=\"1504161406723950.png\" alt=\"图片 3png.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170831/1504161414739757.png\" title=\"1504161414739757.png\" alt=\"图片 4.png\"/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><br/></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\"><span style=\"margin: 0px; padding: 0px; max-width: 100%; box-sizing: border-box !important; word-wrap: break-word !important; font-weight: bold; color: rgb(0, 0, 255);\">可靠的安全性</span></p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">在中国发起的以CLL/SLL亚洲患者为主的CLL 3002国际多中心Ⅲ期研究报告显示：伊布替尼对比利妥昔单抗显著提高ORR,中位随访18个月，伊布替尼PFS 74% vs 利妥昔单抗&nbsp;PFS 11.9%,OS 伊布替尼&nbsp;vs 利妥昔单抗79.8% vs57.6%，在显著提高PFS与OS的同时，伊布替尼治疗不良事件多为1或2级，3，4级非常罕见，无剂量相关性，每日一次的口服治疗也给患者带来了更好的生活质量。&nbsp;</p><p style=\"margin-top: 0px; margin-bottom: 0px; padding: 0px 0px 20px; max-width: 100%; clear: both; min-height: 1em; box-sizing: border-box !important; word-wrap: break-word !important;\">相信亿珂®（伊布替尼）在中国获批定会为淋巴瘤患者带来全新的治疗选择与更高的生活质量，推动中国淋巴瘤治疗领域水平的提高。</p><p style=\"margin-top: 15px; margin-bottom: 15px; color: rgb(85, 85, 85); font-size: 14px; line-height: normal; white-space: normal;\"><span style=\"font-size: 16px;\"><strong><br/></strong></span></p><p style=\"margin-top: 15px; margin-bottom: 15px; color: rgb(85, 85, 85); font-size: 14px; line-height: normal; white-space: normal; text-align: center;\"><span style=\"font-size: 16px;\"><strong>如需了解更多淋巴瘤的前沿信息<span style=\"line-height: normal;\">&nbsp;</span>请扫描二维码访问<span style=\"line-height: normal;\">“</span>淋巴瘤亿刻<span style=\"line-height: normal;\">”</span>网站。</strong></span></p><p style=\"text-align: center;\"><span style=\"font-size: 16px;\"><strong><img src=\"http://7n.medsci.cn/uploads/ueditor/php/upload/image/20170915/1505452618242518.png\" title=\"1505452618242518.png\" alt=\"淋巴瘤亿刻二维码.png\"/></strong></span></p>', '1506225562', '1507564355');
INSERT INTO `product` VALUES ('9', '0', '2', '2', '0', '产品1', null, null, null, '1506339300', '1506339300');
INSERT INTO `product` VALUES ('10', '0', '1', '1', '2', '产品9', '产品9', '描述9', '<p>123</p>', '1507563556', '1507563556');

-- ----------------------------
-- Table structure for question
-- ----------------------------
DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
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
) ENGINE=InnoDB AUTO_INCREMENT=1006 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='调研问题表';

-- ----------------------------
-- Records of question
-- ----------------------------
INSERT INTO `question` VALUES ('1001', '1', '1', '4', '0', '0', '2', '问题题目 1', null, null, null, null, null);
INSERT INTO `question` VALUES ('1002', '2', '1', '4', '0', '0', '1', '问题题目 2', '说明 2', '内容 4', null, null, null);
INSERT INTO `question` VALUES ('1003', '3', '1', '4', '0', '0', '3', '问题题目 选择题 单选题', '单选题 说明3', null, null, null, null);
INSERT INTO `question` VALUES ('1004', '4', '1', '4', '0', '0', '4', '问题题目 选择题 下拉题', '下拉题 说明4', null, null, null, null);
INSERT INTO `question` VALUES ('1005', '5', '1', '4', '0', '0', '5', '问题题目 选择题 多选题', '多选题 说明5', null, null, null, null);

-- ----------------------------
-- Table structure for slide
-- ----------------------------
DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `admin_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '激活状态 0.未激活 1.激活启用',
  `name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT '标题',
  `description` varchar(255) DEFAULT NULL COMMENT '说明',
  `content` text COMMENT '内容',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='幻灯片表';

-- ----------------------------
-- Records of slide
-- ----------------------------
INSERT INTO `slide` VALUES ('1', '1', '1', '1', '0', '幻灯片1', '幻灯片1的标题', '说明1', '幻灯片1', '1505661159', '1505820219');
INSERT INTO `slide` VALUES ('2', '2', '1', '1', '0', '幻灯片2', '幻灯片2的标题', '说明2', null, '1505661211', '1505661211');
INSERT INTO `slide` VALUES ('3', '0', '1', '1', '0', '幻灯片3', '幻灯片3的标题', '说明3', '123', '1505661263', '1505661263');
INSERT INTO `slide` VALUES ('4', '0', '1', '1', '0', '幻灯片4', '幻灯片4的标题', '说明4', null, '1505661370', '1505661370');
INSERT INTO `slide` VALUES ('5', '0', '1', '1', '0', '幻灯片5', '幻灯片5的标题', '说明5', null, '1505661391', '1505661391');
INSERT INTO `slide` VALUES ('6', '0', '1', '1', '0', '幻灯片6', '幻灯片6的标题', '说明6', '123', '1505661418', '1505661418');
INSERT INTO `slide` VALUES ('7', '0', '1', '1', '0', '幻灯片7', '幻灯片7的标题', '说明7', '<p>幻灯片7</p>', '1505661488', '1506611069');
INSERT INTO `slide` VALUES ('8', '0', '1', '1', '0', '幻灯片8', '幻灯片8的标题', '说明8', null, '1505661511', '1505661511');
INSERT INTO `slide` VALUES ('9', '0', '1', '1', '0', '幻灯片9', '幻灯片9的标题', '说明9', '123', '1505661609', '1505661609');
INSERT INTO `slide` VALUES ('10', '0', '1', '1', '0', '幻灯片10', '幻灯片10的标题', '说明10', '123', '1505661620', '1505661620');
INSERT INTO `slide` VALUES ('11', '0', '1', '1', '0', '幻灯片11', '幻灯片11的标题', '说明11', '123', '1505661702', '1505661702');
INSERT INTO `slide` VALUES ('12', '0', '1', '1', '0', '幻灯片12', '幻灯片12的标题', '说明12', '123', '1505661808', '1505661808');
INSERT INTO `slide` VALUES ('13', '0', '1', '1', '0', '幻灯片13', '幻灯片13的标题', '说明13', '123', '1505663419', '1505663419');
INSERT INTO `slide` VALUES ('14', '0', '1', '1', '0', '幻灯片14', '幻灯片14的标题', '说明14141414', '<p>内容</p>', '1505663568', '1507742006');
INSERT INTO `slide` VALUES ('15', '0', '1', '1', '0', '幻灯片15', '幻灯片15的标题', '说明15', '内容15', '1505664520', '1505995195');
INSERT INTO `slide` VALUES ('16', '0', '1', '1', '0', '幻灯片16', '幻灯片16的标题', '说明16', '内容16', '1505664625', '1505828378');
INSERT INTO `slide` VALUES ('17', '1', '1', '1', '0', '幻灯片17', '幻灯片17的标题', '说明17', '内容17', '1505664705', '1506479783');
INSERT INTO `slide` VALUES ('18', '0', '1', '1', '0', '幻灯片18', '幻灯片18的标题', '说明18', '内容18', '1505998982', '1505999403');
INSERT INTO `slide` VALUES ('19', '0', '1', '1', '0', '幻灯片19', '幻灯片19的标题', '描述19', null, '1505999946', '1506610877');
INSERT INTO `slide` VALUES ('20', '0', '1', '1', '0', '幻灯片20', '幻灯片20的标题', '描述20', '<p>内容20</p>', '1506009787', '1506610838');
INSERT INTO `slide` VALUES ('21', '0', '1', '1', '0', '幻灯片21', '幻灯片21的标题', '描述21', '内容21', '1506009798', '1506094400');
INSERT INTO `slide` VALUES ('22', '0', '1', '1', '0', '幻灯片22', '幻灯片22的标题', '描述22', '幻灯片22的内容', '1506168494', '1506444550');
INSERT INTO `slide` VALUES ('23', '0', '2', '0', '0', '幻灯片1', null, null, null, '1506340279', '1506340279');
INSERT INTO `slide` VALUES ('24', '0', '1', '1', '0', '幻灯片23', '幻灯片23', '描述23', '<p>内容23</p>', '1507742052', '1507745861');
INSERT INTO `slide` VALUES ('25', '0', '1', '1', '0', '幻灯片24', null, null, null, '1507745943', '1507745943');

-- ----------------------------
-- Table structure for slide_page
-- ----------------------------
DROP TABLE IF EXISTS `slide_page`;
CREATE TABLE `slide_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slide_id` int(11) NOT NULL COMMENT '幻灯片 id',
  `page_id` int(11) NOT NULL COMMENT '幻灯页 id',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of slide_page
-- ----------------------------

-- ----------------------------
-- Table structure for softorg
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='企业表';

-- ----------------------------
-- Records of softorg
-- ----------------------------
INSERT INTO `softorg` VALUES ('1', '1', 'lotus', '莲花树互联网科技有限公司', '莲花树', '这是一家创造未来de企业', '让企业更出众', '', '021-88886668', '15800689433', 'admin@softorg.cn', '123456789', 'qing_qiye', null, null, '1507738160');
INSERT INTO `softorg` VALUES ('2', '1', 'qingbo', '轻博吧', null, null, null, null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for survey
-- ----------------------------
DROP TABLE IF EXISTS `survey`;
CREATE TABLE `survey` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='调研表';

-- ----------------------------
-- Records of survey
-- ----------------------------
INSERT INTO `survey` VALUES ('1', '0', '1', '1', '调研问卷1', '问卷1', '描述1', '内容1', '1506173760', '1506442144');
INSERT INTO `survey` VALUES ('2', '0', '1', '1', '调研问卷2', '标题2', '描述2222', '<p>内容2</p>', '1506175708', '1507741874');
INSERT INTO `survey` VALUES ('3', '0', '2', '2', '问卷1', '标题1', null, null, '1506335012', '1506335270');
INSERT INTO `survey` VALUES ('4', '0', '1', '1', '问卷3', '问卷测试', '描述3', null, '1507746192', '1507881650');

-- ----------------------------
-- Table structure for survey_question
-- ----------------------------
DROP TABLE IF EXISTS `survey_question`;
CREATE TABLE `survey_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='调研-问题表 多对多表';

-- ----------------------------
-- Records of survey_question
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
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

-- ----------------------------
-- Records of user
-- ----------------------------

-- ----------------------------
-- Table structure for user_ext
-- ----------------------------
DROP TABLE IF EXISTS `user_ext`;
CREATE TABLE `user_ext` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_ext
-- ----------------------------
INSERT INTO `user_ext` VALUES ('1', '1', 'longyun.cui', null, null);
INSERT INTO `user_ext` VALUES ('2', '2', 'longyun.c', '1506327015', '1506327015');
INSERT INTO `user_ext` VALUES ('3', '3', 'longyun', '1506327309', '1506327309');

-- ----------------------------
-- Table structure for users
-- ----------------------------
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

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'longyun.cui', null, 'longyun.cui88@gmail.com', '$2y$10$Aqu.dd890ZVA0CasV1Zk0OmWjlyqhFVg3pE1jc5XxMLskq2EIIEM2', null, null, 'MWDj7UIjf5lDytqHKL4yBS8fTkLL12HqKqwCzQ7pcTKtF3xEHRVuIhuYcSQ7', null, null);
INSERT INTO `users` VALUES ('2', 'longyun.c', null, 'longyun-cui@163.com', '$2y$10$y8vfB.L2kL..LjnB1ZpDpezEykyjKjAhG8zFF9PseET0D1nPJ2pk2', null, null, 't7F8kaxmhu8ITqUEYn7KgJRfha0IROYJmK8a3mhCHNvAhoniHdKQJrvVUElR', '1506327015', '1506327015');
INSERT INTO `users` VALUES ('3', 'longyun', null, 'longyun-cui@qq.com', '$2y$10$jWmmOxjfWj3wHLzm3iGZDOreJLl.QdDRrjA8sEM6jltCx.DVroAVK', null, null, null, '1506327309', '1506327309');

-- ----------------------------
-- Table structure for website
-- ----------------------------
DROP TABLE IF EXISTS `website`;
CREATE TABLE `website` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0',
  `org_id` int(11) NOT NULL DEFAULT '0' COMMENT '所属机构',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of website
-- ----------------------------
