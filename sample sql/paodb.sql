/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : paodb

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-08-14 09:43:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `email_verification`
-- ----------------------------
DROP TABLE IF EXISTS `email_verification`;
CREATE TABLE `email_verification` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `verification_string` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of email_verification
-- ----------------------------

-- ----------------------------
-- Table structure for `log`
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `notes` text,
  `timestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES ('1', null, 'activity', 'site', 'index', null, '2017-08-11 08:50:09');
INSERT INTO `log` VALUES ('2', null, 'activity', 'site', 'error', null, '2017-08-11 09:02:44');
INSERT INTO `log` VALUES ('3', null, 'activity', 'site', 'error', null, '2017-08-11 09:02:56');
INSERT INTO `log` VALUES ('4', null, 'activity', 'site', 'error', null, '2017-08-11 09:03:01');
INSERT INTO `log` VALUES ('5', null, 'activity', 'site', 'error', null, '2017-08-11 09:03:44');
INSERT INTO `log` VALUES ('6', null, 'activity', 'site', 'login', null, '2017-08-11 09:56:42');
INSERT INTO `log` VALUES ('7', null, 'activity', 'site', 'signup', null, '2017-08-11 09:56:45');
INSERT INTO `log` VALUES ('8', null, 'activity', 'site', 'signup', null, '2017-08-11 09:56:56');
INSERT INTO `log` VALUES ('9', null, 'activity', 'site', 'index', null, '2017-08-11 09:56:57');
INSERT INTO `log` VALUES ('10', null, 'activity', 'site', 'login', null, '2017-08-11 09:57:44');
INSERT INTO `log` VALUES ('11', null, 'activity', 'site', 'login', null, '2017-08-11 09:57:54');
INSERT INTO `log` VALUES ('12', '1', 'activity', 'site', 'index', null, '2017-08-11 09:57:55');
INSERT INTO `log` VALUES ('13', '1', 'activity', 'site', 'index', null, '2017-08-11 09:58:41');
INSERT INTO `log` VALUES ('14', '1', 'activity', 'site', 'error', null, '2017-08-11 10:00:45');
INSERT INTO `log` VALUES ('15', '1', 'activity', 'site', 'error', null, '2017-08-11 10:01:15');
INSERT INTO `log` VALUES ('16', '1', 'activity', 'profile', 'test', null, '2017-08-11 10:02:18');
INSERT INTO `log` VALUES ('17', '1', 'activity', 'site', 'index', null, '2017-08-11 10:02:25');
INSERT INTO `log` VALUES ('18', '1', 'activity', 'site', 'login', null, '2017-08-11 10:03:24');
INSERT INTO `log` VALUES ('19', '1', 'activity', 'site', 'index', null, '2017-08-11 10:03:24');
INSERT INTO `log` VALUES ('20', '1', 'activity', 'site', 'error', null, '2017-08-11 10:03:38');
INSERT INTO `log` VALUES ('21', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:03:45');
INSERT INTO `log` VALUES ('22', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:05:04');
INSERT INTO `log` VALUES ('23', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:05:28');
INSERT INTO `log` VALUES ('24', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:13:02');
INSERT INTO `log` VALUES ('25', '1', 'activity', 'site', 'error', null, '2017-08-11 10:13:24');
INSERT INTO `log` VALUES ('26', '1', 'activity', 'profile', 'test', null, '2017-08-11 10:13:38');
INSERT INTO `log` VALUES ('27', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:13:42');
INSERT INTO `log` VALUES ('28', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:18:00');
INSERT INTO `log` VALUES ('29', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:19:20');
INSERT INTO `log` VALUES ('30', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:20:28');
INSERT INTO `log` VALUES ('31', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:21:37');
INSERT INTO `log` VALUES ('32', '1', 'activity', 'profile', 'index', null, '2017-08-11 10:39:12');
INSERT INTO `log` VALUES ('33', '1', 'activity', 'site', 'error', null, '2017-08-11 10:42:02');
INSERT INTO `log` VALUES ('34', '1', 'activity', 'site', 'error', null, '2017-08-11 10:53:12');
INSERT INTO `log` VALUES ('35', '1', 'activity', 'site', 'error', null, '2017-08-11 10:54:59');
INSERT INTO `log` VALUES ('36', '1', 'activity', 'site', 'index', null, '2017-08-11 10:55:03');
INSERT INTO `log` VALUES ('37', '1', 'activity', 'site', 'login', null, '2017-08-11 10:55:16');
INSERT INTO `log` VALUES ('38', '1', 'activity', 'site', 'index', null, '2017-08-11 10:55:17');
INSERT INTO `log` VALUES ('39', '1', 'activity', 'site', 'index', null, '2017-08-11 10:55:31');
INSERT INTO `log` VALUES ('40', '1', 'activity', 'site', 'error', null, '2017-08-11 11:11:00');
INSERT INTO `log` VALUES ('41', '1', 'activity', 'site', 'error', null, '2017-08-11 18:31:47');
INSERT INTO `log` VALUES ('42', '1', 'activity', 'site', 'debug', null, '2017-08-12 07:50:26');
INSERT INTO `log` VALUES ('43', '1', 'activity', 'site', 'debug', null, '2017-08-12 07:50:32');
INSERT INTO `log` VALUES ('44', '1', 'activity', 'site', 'debug', null, '2017-08-12 07:50:45');
INSERT INTO `log` VALUES ('45', '1', 'activity', 'site', 'debug', null, '2017-08-12 07:54:23');
INSERT INTO `log` VALUES ('46', '1', 'activity', 'site', 'debug', null, '2017-08-12 08:18:25');
INSERT INTO `log` VALUES ('47', '1', 'activity', 'site', 'debug', null, '2017-08-12 08:18:54');
INSERT INTO `log` VALUES ('48', '1', 'activity', 'site', 'debug', null, '2017-08-12 08:19:39');
INSERT INTO `log` VALUES ('49', '1', 'activity', 'site', 'debug', null, '2017-08-12 08:23:20');
INSERT INTO `log` VALUES ('50', '1', 'activity', 'site', 'debug', null, '2017-08-12 08:23:46');
INSERT INTO `log` VALUES ('51', '1', 'activity', 'site', 'debug', null, '2017-08-12 08:24:01');
INSERT INTO `log` VALUES ('52', '1', 'activity', 'site', 'error', null, '2017-08-12 08:49:22');
INSERT INTO `log` VALUES ('53', '1', 'activity', 'site', 'error', null, '2017-08-12 08:49:27');
INSERT INTO `log` VALUES ('54', '1', 'activity', 'site', 'error', null, '2017-08-12 14:14:58');
INSERT INTO `log` VALUES ('55', '1', 'activity', 'site', 'error', null, '2017-08-12 14:15:14');
INSERT INTO `log` VALUES ('56', '1', 'activity', 'site', 'error', null, '2017-08-12 14:16:17');
INSERT INTO `log` VALUES ('57', '1', 'activity', 'site', 'error', null, '2017-08-12 14:17:29');
INSERT INTO `log` VALUES ('58', '1', 'activity', 'site', 'error', null, '2017-08-12 17:09:33');
INSERT INTO `log` VALUES ('59', '1', 'activity', 'site', 'error', null, '2017-08-12 17:09:41');
INSERT INTO `log` VALUES ('60', '1', 'activity', 'site', 'error', null, '2017-08-12 17:10:30');
INSERT INTO `log` VALUES ('61', '1', 'activity', 'site', 'error', null, '2017-08-12 17:18:22');
INSERT INTO `log` VALUES ('62', '1', 'activity', 'site', 'error', null, '2017-08-12 18:05:54');
INSERT INTO `log` VALUES ('63', '1', 'activity', 'site', 'error', null, '2017-08-12 18:06:18');
INSERT INTO `log` VALUES ('64', '1', 'activity', 'site', 'index', null, '2017-08-12 18:13:00');
INSERT INTO `log` VALUES ('65', '1', 'activity', 'site', 'error', null, '2017-08-12 18:13:05');
INSERT INTO `log` VALUES ('66', '1', 'activity', 'site', 'error', null, '2017-08-12 18:13:08');
INSERT INTO `log` VALUES ('67', '1', 'activity', 'site', 'logout', null, '2017-08-13 14:53:38');
INSERT INTO `log` VALUES ('68', null, 'activity', 'site', 'index', null, '2017-08-13 14:53:38');
INSERT INTO `log` VALUES ('69', null, 'activity', 'site', 'login', null, '2017-08-13 14:53:40');
INSERT INTO `log` VALUES ('70', null, 'activity', 'site', 'login', null, '2017-08-13 14:53:42');
INSERT INTO `log` VALUES ('71', '1', 'activity', 'site', 'index', null, '2017-08-13 14:53:43');
INSERT INTO `log` VALUES ('72', '1', 'activity', 'site', 'index', null, '2017-08-13 19:05:43');
INSERT INTO `log` VALUES ('73', '1', 'activity', 'site', 'logout', null, '2017-08-13 19:05:49');
INSERT INTO `log` VALUES ('74', null, 'activity', 'site', 'index', null, '2017-08-13 19:05:49');
INSERT INTO `log` VALUES ('75', null, 'activity', 'site', 'login', null, '2017-08-13 19:07:47');
INSERT INTO `log` VALUES ('76', null, 'activity', 'site', 'login', null, '2017-08-13 19:07:53');
INSERT INTO `log` VALUES ('77', '1', 'activity', 'site', 'index', null, '2017-08-13 19:07:55');
INSERT INTO `log` VALUES ('78', '1', 'activity', 'site', 'error', null, '2017-08-13 19:11:00');
INSERT INTO `log` VALUES ('79', '1', 'activity', 'site', 'index', null, '2017-08-13 19:11:37');
INSERT INTO `log` VALUES ('80', '1', 'activity', 'site', 'index', null, '2017-08-13 19:14:27');
INSERT INTO `log` VALUES ('81', '1', 'activity', 'site', 'index', null, '2017-08-13 19:14:49');
INSERT INTO `log` VALUES ('82', '1', 'activity', 'site', 'error', null, '2017-08-13 19:14:51');
INSERT INTO `log` VALUES ('83', '1', 'activity', 'site', 'index', null, '2017-08-13 19:15:01');
INSERT INTO `log` VALUES ('84', '1', 'activity', 'site', 'index', null, '2017-08-13 19:15:03');
INSERT INTO `log` VALUES ('85', '1', 'activity', 'site', 'index', null, '2017-08-13 19:15:10');
INSERT INTO `log` VALUES ('86', '1', 'activity', 'site', 'index', null, '2017-08-13 21:03:00');

-- ----------------------------
-- Table structure for `message`
-- ----------------------------
DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `message` text,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of message
-- ----------------------------

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of migration
-- ----------------------------

-- ----------------------------
-- Table structure for `notification`
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `key_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of notification
-- ----------------------------

-- ----------------------------
-- Table structure for `organization`
-- ----------------------------
DROP TABLE IF EXISTS `organization`;
CREATE TABLE `organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of organization
-- ----------------------------
INSERT INTO `organization` VALUES ('1', 'kemenkes', 'active');

-- ----------------------------
-- Table structure for `organization_meta`
-- ----------------------------
DROP TABLE IF EXISTS `organization_meta`;
CREATE TABLE `organization_meta` (
  `organization_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`organization_id`,`type`,`key`,`value`),
  CONSTRAINT `fk_organization_meta_organization_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of organization_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `profile`
-- ----------------------------
DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_profile_user_1` (`user_id`),
  CONSTRAINT `fk_profile_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of profile
-- ----------------------------
INSERT INTO `profile` VALUES ('1', '1', 'user 1', 'reno', '0000-00-00', '12');
INSERT INTO `profile` VALUES ('2', null, 'assessee 2', null, null, null);
INSERT INTO `profile` VALUES ('3', null, 'assessor 2', null, null, null);

-- ----------------------------
-- Table structure for `profile_meta`
-- ----------------------------
DROP TABLE IF EXISTS `profile_meta`;
CREATE TABLE `profile_meta` (
  `profile_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`profile_id`,`type`,`key`,`value`),
  CONSTRAINT `fk_profile_meta_profile_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='types: address, contact, work, education';

-- ----------------------------
-- Records of profile_meta
-- ----------------------------
INSERT INTO `profile_meta` VALUES ('1', 'project', 'role', 'assessor', '1', null, null);

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_project_organization_1` (`organization_id`),
  CONSTRAINT `fk_project_organization_1` FOREIGN KEY (`organization_id`) REFERENCES `organization` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES ('1', '1', 'assessment kemenkes', 'active');

-- ----------------------------
-- Table structure for `project_activity`
-- ----------------------------
DROP TABLE IF EXISTS `project_activity`;
CREATE TABLE `project_activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_activity_project_1` (`project_id`),
  CONSTRAINT `fk_activity_project_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_activity
-- ----------------------------

-- ----------------------------
-- Table structure for `project_activity_meta`
-- ----------------------------
DROP TABLE IF EXISTS `project_activity_meta`;
CREATE TABLE `project_activity_meta` (
  `project_activity_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`project_activity_id`,`type`,`key`,`value`),
  CONSTRAINT `fk_activity_meta_activity_1` FOREIGN KEY (`project_activity_id`) REFERENCES `project_activity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='types : assessment';

-- ----------------------------
-- Records of project_activity_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `project_assessment`
-- ----------------------------
DROP TABLE IF EXISTS `project_assessment`;
CREATE TABLE `project_assessment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_assessment_profile_1` (`profile_id`),
  KEY `fk_assessment_project_1` (`project_id`),
  CONSTRAINT `fk_assessment_profile_1` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`),
  CONSTRAINT `fk_assessment_project_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_assessment
-- ----------------------------

-- ----------------------------
-- Table structure for `project_assessment_meta`
-- ----------------------------
DROP TABLE IF EXISTS `project_assessment_meta`;
CREATE TABLE `project_assessment_meta` (
  `project_assessment_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`project_assessment_id`,`type`,`key`,`value`),
  CONSTRAINT `fk_assessment_meta_assessment_1` FOREIGN KEY (`project_assessment_id`) REFERENCES `project_assessment` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_assessment_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `project_meta`
-- ----------------------------
DROP TABLE IF EXISTS `project_meta`;
CREATE TABLE `project_meta` (
  `project_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`project_id`,`type`,`key`,`value`),
  CONSTRAINT `fk_project_meta_project_1` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `rawscan`
-- ----------------------------
DROP TABLE IF EXISTS `rawscan`;
CREATE TABLE `rawscan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `data` text,
  `create_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of rawscan
-- ----------------------------

-- ----------------------------
-- Table structure for `ref_config`
-- ----------------------------
DROP TABLE IF EXISTS `ref_config`;
CREATE TABLE `ref_config` (
  `type` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`type`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_config
-- ----------------------------

-- ----------------------------
-- Table structure for `ref_relation`
-- ----------------------------
DROP TABLE IF EXISTS `ref_relation`;
CREATE TABLE `ref_relation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `predicate` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_relation
-- ----------------------------

-- ----------------------------
-- Table structure for `ref_value`
-- ----------------------------
DROP TABLE IF EXISTS `ref_value`;
CREATE TABLE `ref_value` (
  `type` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`type`,`key`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of ref_value
-- ----------------------------

-- ----------------------------
-- Table structure for `requirement`
-- ----------------------------
DROP TABLE IF EXISTS `requirement`;
CREATE TABLE `requirement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_id` int(11) DEFAULT NULL,
  `requirement_type` varchar(255) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of requirement
-- ----------------------------

-- ----------------------------
-- Table structure for `token`
-- ----------------------------
DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `user_id` int(11) NOT NULL,
  `code` text,
  `type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of token
-- ----------------------------

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', 'ZNbZYriIG9iQOx6KASg_cPMnlY27GEsN', '$2y$13$fNEbWAvWtrjJq1eWxwZXduAvT.mayfGJq/cRrbZg.eFVqRHj8rYhy', null, 'admin@gamantha.com', '10', '1502420217', '1502420217');

-- ----------------------------
-- Table structure for `user_meta`
-- ----------------------------
DROP TABLE IF EXISTS `user_meta`;
CREATE TABLE `user_meta` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(255) NOT NULL DEFAULT '',
  `key` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL,
  `attribute_1` varchar(255) DEFAULT NULL,
  `attribute_2` varchar(255) DEFAULT NULL,
  `attribute_3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`type`,`key`,`value`),
  CONSTRAINT `fk_user_meta_user_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='types: role';

-- ----------------------------
-- Records of user_meta
-- ----------------------------
