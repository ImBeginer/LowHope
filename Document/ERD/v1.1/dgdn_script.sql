DROP DATABASE IF EXISTS dgdn;

CREATE DATABASE dgdn;

use dgdn;

-- ROLE

CREATE TABLE ROLE(
  ROLE_ID int(11) NOT NULL auto_increment,
  ROLE_NAME varchar(30) NOT NULL,
  primary key(ROLE_ID)
) ENGINE=InnoDB;

INSERT INTO `ROLE` (`ROLE_ID`, `ROLE_NAME`) VALUES
(1, 'Admin'),
(2, 'Manager'),
(3, 'User');

-- USERS

CREATE TABLE USERS (
  USER_ID int(11) NOT NULL AUTO_INCREMENT,
  ROLE_ID int(11),
  USER_CIF varchar(50) NOT NULL,
  USER_NAME nvarchar(100) NOT NULL,
  USER_POINT int(11) NOT NULL,
  EMAIL varchar(100) NOT NULL,
  PHONE_NUMBER varchar(30) NOT NULL,
  ADDRESS nvarchar(255) NOT NULL,
  ATTENDANCE tinyint(1) NOT NULL,
  ACTIVE tinyint(1) NOT NULL,
  PRIMARY KEY (USER_ID),
  FOREIGN KEY (ROLE_ID) REFERENCES ROLE(ROLE_ID)
) ENGINE=InnoDB;


INSERT INTO `USERS` (`ROLE_ID`, `USER_CIF`, `USER_NAME`, `USER_POINT`, `EMAIL`, `PHONE_NUMBER`, `ADDRESS`, `ATTENDANCE`, `ACTIVE`) VALUES
(1, '114359317688861576124', 'CongLDSE03929', 500, 'congldse03929@fpt.edu.vn', '0986966861', 'Hải Dương', 1, 0),
(2, '1591830150906934', 'Quách Tương', 100, 'congld2509@gmail.com', '0986966861', 'Cầu Giấy, Hà Nội', 1, 1),
(3,'1098039550331795', 'hotaru', 500, 'tranhongquan.94@gmail.com', '1234', 'Hai Duong', 1, 0),
(3,'108396582926044150378', 'Công Công', 500, 'duycong2509@gmail.com', '123123123', 'Hà Nội', 1, 0);


CREATE TABLE  NOTIFICATION(
  NOTICE_ID int(11) NOT NULL auto_increment,
  TITLE nvarchar(255) NOT NULL,
  CONTENT text NOT NULL,
  CREATE_DATE datetime,
  primary key(NOTICE_ID)
) ENGINE=InnoDB;

CREATE TABLE  NOTIFICATION_DETAILS(
  NOTICE_ID int(11),
  USER_ID int(11),
  foreign key(NOTICE_ID) references NOTIFICATION(NOTICE_ID),
  foreign key(USER_ID) references USERS(USER_ID),
  SEND_DATE datetime NOT NULL,
  SEEN tinyint(1) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE  CHAT_ROOMS(
  ROOM_ID int(11) NOT NULL auto_increment,
  ROOM_NAME varchar(100), 
  CREATE_DATE datetime NOT NULL,
  primary key(ROOM_ID)
) ENGINE=InnoDB;

CREATE TABLE  CHAT_MESSAGES(
  MESSAGE_ID INT(11) NOT NULL auto_increment,
  USER_ID int(11),
  ROOM_ID int(11),
  CONTENT nvarchar(255) NOT NULL,
  SEND_DATE datetime NOT NULL,
  primary key(MESSAGE_ID),
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(ROOM_ID) references CHAT_ROOMS(ROOM_ID)
) ENGINE=InnoDB;

CREATE TABLE CATEGORIES (
  CATEGORY_ID int(11) NOT NULL auto_increment,
  CATEGORY_NAME VARCHAR(30) NOT NULL,
  primary key(CATEGORY_ID)
) ENGINE=InnoDB;

CREATE TABLE CURRENCY_TYPE (
  TYPE_ID int(11) NOT NULL auto_increment,
  TYPE_NAME varchar(20) NOT NULL,
  CATEGORY_ID int(11),
  primary key(TYPE_ID),
  foreign key(CATEGORY_ID) references CATEGORIES(CATEGORY_ID)
) ENGINE=InnoDB;

CREATE TABLE CURRENCY_DETAILS (
  CURRENCY_ID int(11) NOT NULL auto_increment,
  PRICE double NOT NULL,
  UPDATE_AT datetime NOT NULL,
  TYPE_ID int(11),
  primary key(CURRENCY_ID),
  foreign key(TYPE_ID) references CURRENCY_TYPE(TYPE_ID)
) ENGINE=InnoDB;

CREATE TABLE SYSTEM_GAMES (
  GAME_ID int(11) NOT NULL auto_increment,
  TITLE nvarchar(255),
  CONTENT nvarchar(255),
  START_DATE datetime NOT NULL,
  END_DATE datetime NOT NULL, 
  ACTIVE tinyint(1) NOT NULL,
  PRICE_BET double NOT NULL, 
  RESULT double NOT NULL,
  CUR_TYPE_ID int(11),
  primary key(GAME_ID),
  foreign key(CUR_TYPE_ID) references CURRENCY_TYPE(TYPE_ID)
) ENGINE=InnoDB;


CREATE TABLE SYSTEM_GAME_LOGS (
  USER_ID int(11),
  GAME_ID int(11),
  PRICE_GUESS double NOT NULL,
  DATE_GUESS datetime NOT NULL,
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(GAME_ID) references SYSTEM_GAMES(GAME_ID)
) ENGINE=InnoDB;


CREATE TABLE AWARD (
  AWARD_ID int(11) NOT NULL auto_increment,
  AWARD_NAME nvarchar(100) NOT NULL, 
  PRICE double NOT NULL,
  IMAGE_URL varchar(255),
  ACTICE tinyint(1) NOT NULL,
  primary key(AWARD_ID)
) ENGINE=InnoDB;


CREATE TABLE ACHIEVEMENT (
  A_ID int(11) NOT NULL auto_increment,
  USER_ID int(11),
  AWARD_ID int(11),
  GAME_ID int(11),
  GET_AT datetime NOT NULL,
  primary key(A_ID),
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(AWARD_ID) references AWARD(AWARD_ID),
  foreign key(GAME_ID) references SYSTEM_GAMES(GAME_ID)
) ENGINE=InnoDB;


CREATE TABLE YN_GAMES (
  GAME_ID int(11) NOT NULL auto_increment,
  OWNER_ID int(11),
  CUR_TYPE_ID int(11),
  TITLE nvarchar(255),
  CONTENT nvarchar(255),
  START_DATE datetime NOT NULL,
  END_DATE datetime NOT NULL, 
  PRICE_BET double NOT NULL, 
  RESULT double,
  PLAYER_COUNT int(2) NOT NULL,
  ACTIVE tinyint(1) NOT NULL,
  TOTAL_AMOUNT double NOT NULL,
  primary key(GAME_ID), 
  foreign key(OWNER_ID) references USERS(USER_ID),
  foreign key(CUR_TYPE_ID) references CURRENCY_TYPE(TYPE_ID)
) ENGINE=InnoDB;

CREATE TABLE YN_GAME_LOGS (
  USER_ID int(11), 
  GAME_ID int(11), 
  ANSWER tinyint(1) NOT NULL,
  ANS_TIME datetime NOT NULL,
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(GAME_ID) references YN_GAMES(GAME_ID)
) ENGINE=InnoDB;

CREATE TABLE MULTI_CHOICE_GAMES (
  GAME_ID int(11) NOT NULL auto_increment,
  OWNER_ID int(11),
  CUR_TYPE_ID int(11),
  TITLE nvarchar(255),
  CONTENT nvarchar(255),
  START_DATE datetime NOT NULL, 
  END_DATE datetime NOT NULL,
  PRICE_BET double NOT NULL, 
  BETWEEN_DOWN double, 
  BETWEEN_UP double,
  RESULT double, 
  PLAYER_COUNT int(2) NOT NULL, 
  ACTIVE tinyint(1) NOT NULL, 
  TOTAL_AMOUNT double NOT NULL,
  primary key(GAME_ID),
  foreign key(OWNER_ID) references USERS(USER_ID),
  foreign key(CUR_TYPE_ID) references CURRENCY_TYPE(TYPE_ID)
) ENGINE=InnoDB;

CREATE TABLE MULTI_CHOICE_GAME_LOGS (
  USER_ID int(11), 
  GAME_ID int(11), 
  PRICE_BELOW double NOT NULL, 
  PRICE_BETWEEN double NOT NULL, 
  PRICE_ABOVE double NOT NULL,
  ANS_TIME datetime NOT NULL,
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(GAME_ID) references MULTI_CHOICE_GAMES(GAME_ID)
) ENGINE=InnoDB;

