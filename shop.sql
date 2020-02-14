DROP TABLE IF EXISTS   `shop_user`;
CREATE TABLE IF NOT EXISTS `shop_user` (
  `userid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `username` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `userpass` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '密码',
  `useremail` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '邮箱',
  `createtime` INT UNSIGNED NOT NULL DEFAULT  '0',
  UNIQUE shop_user_username_userpass(`username` , `userpass`),
  UNIQUE shop_user_useremail_userpass(`useremail`, `userpass`),
  PRIMARY KEY (`userid`)
) ENGINE=InooDB DEFAULT CHARSET=utf8;

INSERT INTO `shop_user` (username,userpass,useremail) VALUES ('test',md5("123"),'1090094838@qq.com');

DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE IF NOT EXISTS `shop_profile` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `truename` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `age` TINYINT NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` ENUM('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别:0保密,1男,2女',
  `birthday` DATE NOT NULL DEFAULT '2020-01-01' ,
  `nickname` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `compony` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '公司',
  `createtime` INT NOT NULL DEFAULT '0' COMMENT '创建时间',
  `userid` BIGINT NOT NULL DEFAULT '0' COMMENT '关联用户表的用户id',
  PRIMARY KEY(`id`),
  UNIQUE shop_profile_userid(`userid`)
) ENGINE=InooDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_cateogy`(
  `cateid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键id',
   `title` VARCHAR(64) NOT NULL DEFAULT '' COMMENT '分类名称',
   `parentid` BIGINT NOT NULL DEFAULT '0' COMMENT '父类id',
   `createtime` INT NOT NULL DEFAULT '0' COMMENT '创建时间',
   PRIMARY KEY (`cateid`),
   KEY shop_category_parentid (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE IF NOT EXISTS `shop_product` (
  `productid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `cateid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id',
  `title` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `description` TEXT COMMENT '商品描述',
  `num` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品数量',
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0',
  `cover` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '封面图',
  `pics` TEXT,
  `issale` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '商品状态是否在售',
  `saleprice` DECIMAL(10,2) NOT NULL DEFAULT '0' COMMENT '销售价格',
  `ishot` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否热卖',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY(`productid`),
  KEY shop_product_cateid(`cateid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;