/*
Navicat MySQL Data Transfer

Source Server         : lab.schematical.com
Source Server Version : 50162
Source Host           : localhost:3306
Source Database       : likeignite

Target Server Type    : MYSQL
Target Server Version : 50162
File Encoding         : 65001

Date: 2013-01-26 10:19:50
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `Account`
-- ----------------------------
DROP TABLE IF EXISTS `AuthAccount`;
CREATE TABLE `AuthAccount` (
  `idAccount` int(11) NOT NULL AUTO_INCREMENT,
  `idAccountTypeCd` int(11) DEFAULT NULL,
  PRIMARY KEY (`idAccount`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of Account
-- ----------------------------
INSERT INTO `AuthAccount` VALUES ('1', '1');

-- ----------------------------
-- Table structure for `AuthAccountTypeCd_tpcd`
-- ----------------------------
DROP TABLE IF EXISTS `AuthAccountTypeCd_tpcd`;
CREATE TABLE `AuthAccountTypeCd_tpcd` (
  `idAccountTypeCd` int(11) NOT NULL AUTO_INCREMENT,
  `shortDesc` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`idAccountTypeCd`),
  UNIQUE KEY `shortDesc` (`shortDesc`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of AccountTypeCd_tpcd
-- ----------------------------
INSERT INTO `AuthAccountTypeCd_tpcd` VALUES ('1', 'Admin');

-- ----------------------------
-- Table structure for `AuthSession`
-- ----------------------------
DROP TABLE IF EXISTS `AuthSession`;
CREATE TABLE `AuthSession` (
  `idSession` int(11) NOT NULL AUTO_INCREMENT,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `sessionKey` varchar(64) DEFAULT NULL,
  `ipAddress` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`idSession`),
  KEY `fkSession_userId` (`idUser`),
  CONSTRAINT `fkSession_userId` FOREIGN KEY (`idUser`) REFERENCES `AuthUser` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of AuthSession
-- ----------------------------

-- ----------------------------
-- Table structure for `AuthUser`
-- ----------------------------
DROP TABLE IF EXISTS `AuthUser`;
CREATE TABLE `AuthUser` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `idAccount` int(11) DEFAULT NULL,
  `idUserTypeCd` int(11) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `passResetCode` varchar(128) DEFAULT NULL,
  `fbuid` varchar(128) DEFAULT NULL,
  `fbAccessToken` varchar(256) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `friendsIds` longtext,
  `friendsUpdated` datetime DEFAULT NULL,
  `fbAccessTokenExpires` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  KEY `fkUser` (`idAccount`),
  KEY `fkUserTypeCd` (`idUserTypeCd`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of User
-- ----------------------------
INSERT INTO `AuthUser` VALUES ('2', 'matt@mattleaconsulting.com', null, null, '3', 'Matt Lea', null, '100001842107744', 'AAAFoEL87A6QBAAiDMDIRD8Ki2Ieo5yKCPgJEUfQnJX2bsm4mvN4t8wF3iNbFXFlFRCBNvuJLuOJAGe6p8ZC7rNPJUUjTQZAfiszOiaEh7FOLpc6AFc', '1', null, null, null);

-- ----------------------------
-- Table structure for `AuthUserSetting`
-- ----------------------------
DROP TABLE IF EXISTS `AuthUserSetting`;
CREATE TABLE `AuthUserSetting` (
  `idUserSetting` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `idUserSettingTypeCd` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`idUserSetting`),
  KEY `fk_UserSetting_idUser` (`idUser`),
  KEY `fk_UserSetting_idUserSettingTypeCd` (`idUserSettingTypeCd`),
  CONSTRAINT `fk_UserSetting_idUser` FOREIGN KEY (`idUser`) REFERENCES `AuthUser` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_UserSetting_idUserSettingTypeCd` FOREIGN KEY (`idUserSettingTypeCd`) REFERENCES `AuthUserSettingTypeCd_tpcd` (`idUserSettingType`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of AuthUserSetting
-- ----------------------------

-- ----------------------------
-- Table structure for `AuthUserSettingTypeCd_tpcd`
-- ----------------------------
DROP TABLE IF EXISTS `AuthUserSettingTypeCd_tpcd`;
CREATE TABLE `AuthUserSettingTypeCd_tpcd` (
  `idUserSettingType` int(11) NOT NULL AUTO_INCREMENT,
  `shortDesc` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`idUserSettingType`),
  UNIQUE KEY `id_UserSetting_shortDesc` (`shortDesc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of AuthUserSettingTypeCd_tpcd
-- ----------------------------
INSERT INTO `AuthUserSettingTypeCd_tpcd` VALUES ('1', 'Admin');
INSERT INTO `AuthUserSettingTypeCd_tpcd` VALUES ('2', 'Reguar');

-- ----------------------------
-- Table structure for `AuthUserTypeCd_tpcd`
-- ----------------------------
DROP TABLE IF EXISTS `AuthUserTypeCd_tpcd`;
CREATE TABLE `AuthUserTypeCd_tpcd` (
  `idUserTypeCd` int(11) NOT NULL DEFAULT '0',
  `shortDesc` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`idUserTypeCd`),
  UNIQUE KEY `key_index` (`shortDesc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of AuthUserTypeCd_tpcd
-- ----------------------------
