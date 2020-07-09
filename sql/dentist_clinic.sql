/*
 Navicat Premium Data Transfer

 Source Server         : localhost_3306
 Source Server Type    : MySQL
 Source Server Version : 80020
 Source Host           : localhost:3306
 Source Schema         : dentist_clinic

 Target Server Type    : MySQL
 Target Server Version : 80020
 File Encoding         : 65001

 Date: 06/07/2020 20:38:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '管理员账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '管理员密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES (1, 'hzc', 'hzchzc');

-- ----------------------------
-- Table structure for illness_case
-- ----------------------------
DROP TABLE IF EXISTS `illness_case`;
CREATE TABLE `illness_case`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '患者名字',
  `sex` varchar(255) NULL DEFAULT NULL COMMENT '患者性别',
  `born_year` int(0) NULL DEFAULT NULL COMMENT '出生年',
  `note` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '备注',
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '案例状态',
  `image_id` int(0) NULL DEFAULT NULL COMMENT '影像资料',
  `doctor_id` int(0) NULL DEFAULT NULL COMMENT '所属医生',
  `expert_id` int(0) NULL DEFAULT NULL COMMENT '所属专家',
  `treatment_plan` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '治疗方案',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of illness_case
-- ----------------------------
INSERT INTO `illness_case` VALUES (1, '黄志聪', '男', 1998, 'PE：B4（牙合）面畸形中央尖，已完全磨损，露髓，探痛（++），冷痛（++），松动（-）。行全口常规检查发现E3E4滞留；A3弓外牙，腭侧完全萌出；A4未见，E4颊侧牙龈可见隆起明显，触之较硬，无压痛。 A3A4区牙片及全口CT示：E3牙根短小，E4牙根吸收至颈部，A4完全埋藏于骨内，根尖紧贴于上颌窦底。', '3D方案设计中', 1, 1, 1, 1);
INSERT INTO `illness_case` VALUES (2, '陈港升', '女', 1998, 'PE：B4（牙合）面畸形中央尖，已完全磨损，露髓，探痛（++），冷痛（++），松动（-）。行全口常规检查发现E3E4滞留；A3弓外牙，腭侧完全萌出；A4未见，E4颊侧牙龈可见隆起明显，触之较硬，无压痛。 A3A4区牙片及全口CT示：E3牙根短小，E4牙根吸收至颈部，A4完全埋藏于骨内，根尖紧贴于上颌窦底。', '3D方案设计中', 2, 1, 1, 2);

-- ----------------------------
-- Table structure for clinic
-- ----------------------------
DROP TABLE IF EXISTS `clinic`;
CREATE TABLE `clinic`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '诊所名字',
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '诊所地理位置',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of clinic
-- ----------------------------
INSERT INTO `clinic` VALUES (1, '心悦口腔', '广州市从化区街口街青云路18号');

-- ----------------------------
-- Table structure for doctor
-- ----------------------------
DROP TABLE IF EXISTS `doctor`;
CREATE TABLE `doctor`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '医生姓名',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '密码',
  `sex` varchar(255) NULL DEFAULT NULL COMMENT '性别',
  `profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '简介',
  `clinic_id` int(0) NULL DEFAULT NULL COMMENT '所属诊所',
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '所属诊所',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of doctor
-- ----------------------------
INSERT INTO `doctor` VALUES (1, '何梓涛', 'hzt', 'hzthzt', 0, '十年老口医,值得信赖.', 1, '广东省深圳市第一诊所');

-- ----------------------------
-- Table structure for expert
-- ----------------------------
DROP TABLE IF EXISTS `expert`;
CREATE TABLE `expert`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '专家名',
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '专家账号',
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '专家密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of expert
-- ----------------------------
INSERT INTO `expert` VALUES (1, '专家A', 'zja', 'zjazja');

-- ----------------------------
-- Table structure for image_data
-- ----------------------------
DROP TABLE IF EXISTS `image_data`;
CREATE TABLE `image_data`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `front` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '正面像',
  `front_smile` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '正面微笑像',
  `side` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '侧面像',
  `intraoral_side` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '口内右(左)侧位像',
  `intraoral_front` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '口内正位像',
  `lower_dentition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '下牙列像',
  `upper_dentition` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '上牙列像',
  `qhqmdcp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '全颌曲面断层片',
  `qlcwdwp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '全颅侧位定位片',
  `digital_model` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '数字模型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of image_data
-- ----------------------------
INSERT INTO `image_data` VALUES (1, 'http://www.kupan123.com/upload/1594038629x1822619041.png', 'http://www.kupan123.com/upload/1594038690x1822618901.png', 'http://www.kupan123.com/upload/1594038718x1822619041.png', 'http://www.kupan123.com/upload/1594038750x1822619041.png', 'http://www.kupan123.com/upload/1594038787x-1566676391.png', 'http://www.kupan123.com/upload/1594038813x-1566676391.png', 'http://www.kupan123.com/upload/1594038831x-1566676391.png', 'http://www.kupan123.com/upload/1594038870x-1566676002.png', 'http://www.kupan123.com/upload/1594038916x-1566676002.png', 'http://www.kupan123.com/upload/1594038936x1822619344.png');
INSERT INTO `image_data` VALUES (2, 'http://www.kupan123.com/upload/1594038629x1822619041.png', 'http://www.kupan123.com/upload/1594038690x1822618901.png', 'http://www.kupan123.com/upload/1594038718x1822619041.png', 'http://www.kupan123.com/upload/1594038750x1822619041.png', 'http://www.kupan123.com/upload/1594038787x-1566676391.png', 'http://www.kupan123.com/upload/1594038813x-1566676391.png', 'http://www.kupan123.com/upload/1594038831x-1566676391.png', 'http://www.kupan123.com/upload/1594038870x-1566676002.png', 'http://www.kupan123.com/upload/1594038916x-1566676002.png', 'http://www.kupan123.com/upload/1594038936x1822619344.png');

-- ----------------------------
-- Table structure for plan
-- ----------------------------
DROP TABLE IF EXISTS `plan`;
CREATE TABLE `plan`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `treatment_plan` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT '治疗方案',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of plan
-- ----------------------------
INSERT INTO `plan` VALUES (1, '1、先拔除右下8 2、上下颌粘MBT直丝弓托槽 3、三类牵引后退右侧磨牙调整中线 4、再拔除左下8，继续三类牵引 5、调整覆颌覆盖至正常 6、保持');
INSERT INTO `plan` VALUES (2, '1、先拔除右下8 2、上下颌粘MBT直丝弓托槽 3、三类牵引后退右侧磨牙调整中线 4、再拔除左下8，继续三类牵引 5、调整覆颌覆盖至正常 6、保持');

SET FOREIGN_KEY_CHECKS = 1;
