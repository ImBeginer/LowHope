DROP DATABASE IF EXISTS lowhope_db;

CREATE DATABASE lowhope_db;

use lowhope_db;

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
  USER_CIF varchar(50),
  USER_NAME nvarchar(100) NOT NULL,
  PASSWORD varchar(100),
  USER_POINT int(11) NOT NULL,
  EMAIL varchar(100) NOT NULL,
  PHONE_NUMBER varchar(30),
  ADDRESS nvarchar(255),
  CREATE_DATE date NOT NULL,
  ATTENDANCE tinyint(1) NOT NULL,
  ACTIVE tinyint(1) NOT NULL ,
  DAILYGAME_CHECKOUT tinyint(1) NOT NULL default 0,
  PRIMARY KEY (USER_ID),
  FOREIGN KEY (ROLE_ID) REFERENCES ROLE(ROLE_ID)
) ENGINE=InnoDB;


INSERT INTO `USERS` (`ROLE_ID`, `USER_CIF`, `USER_NAME`, `USER_POINT`, `EMAIL`, `PHONE_NUMBER`, `ADDRESS`, `CREATE_DATE` ,`ATTENDANCE`, `ACTIVE`) VALUES
(1, '114359317688861576124', 'CongLDSE03929', 500, 'congldse03929@fpt.edu.vn', '0986966861', 'Hải Dương', now(), 1, 0),
(2, '1591830150906934', 'Quách Tương', 100, 'congld2509@gmail.com', '0986966861', 'Cầu Giấy, Hà Nội', now(), 1, 1),
(3,'1098039550331795', 'hotaru', 500, 'tranhongquan.94@gmail.com', '1234', 'Hai Duong', now(), 1, 0),
(3,'108396582926044150378', 'Công Công', 500, 'duycong2509@gmail.com', '123123123', 'Hà Nội', now(), 1, 0);


CREATE TABLE  NOTIFICATION(
  NOTICE_ID int(11) NOT NULL auto_increment,
  TITLE nvarchar(255) NOT NULL,
  CONTENT text CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NOT NULL,
  CREATE_DATE datetime,
  primary key(NOTICE_ID)
) ENGINE=InnoDB;

CREATE TABLE  NOTIFICATION_TYPE(
  TYPE_ID int(2) NOT NULL auto_increment,
  TYPE_NAME nvarchar(20) NOT NULL,
  primary key(TYPE_ID)
) ENGINE=InnoDB;

CREATE TABLE  NOTIFICATION_DETAILS(
  NOTICE_ID int(11),
  USER_ID int(11),
  TYPE_ID int(2),
  foreign key(NOTICE_ID) references NOTIFICATION(NOTICE_ID),
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(TYPE_ID) references NOTIFICATION_TYPE(TYPE_ID),
  GAME_ID int(11),
  SEND_DATE datetime NOT NULL,
  SEEN tinyint(1) NOT NULL default 0
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
  POINT_TO_BET double NOT NULL, 
  RESULT double,
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
  POINT_TO_BET double NOT NULL,
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
  IS_WINNER tinyint(1) NOT NULL,
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
  POINT_TO_BET double NOT NULL,
  PRICE_BELOW double, 
  PRICE_ABOVE double,
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
  PRICE_BELOW boolean NOT NULL, 
  PRICE_BETWEEN boolean NOT NULL, 
  PRICE_ABOVE boolean NOT NULL,
  ANS_TIME datetime NOT NULL,
  IS_WINNER tinyint(1) NOT NULL,
  foreign key(USER_ID) references USERS(USER_ID),
  foreign key(GAME_ID) references MULTI_CHOICE_GAMES(GAME_ID)
) ENGINE=InnoDB;



-- create stored procedure

DELIMITER $$
DROP PROCEDURE IF EXISTS `GET_SYS_GAME_PLAYERS`$$
CREATE PROCEDURE `GET_SYS_GAME_PLAYERS`(IN timeToLoad datetime)
BEGIN
   set @real_price = null;
   SELECT @real_price := round(price,2) FROM CURRENCY_DETAILS
   where UPDATE_AT = timeToLoad;
   SELECT usr.USER_ID, usr.USER_NAME, log.GAME_ID, log.PRICE_GUESS,
        abs(log.PRICE_GUESS - @real_price) as distance,
          @real_price as result,
          log.DATE_GUESS
  from USERS usr  
  inner join SYSTEM_GAME_LOGS log on usr.USER_ID = log.USER_ID
  inner join SYSTEM_GAMES sgame  on log.GAME_ID = sgame.GAME_ID
  where sgame.ACTIVE = 1 AND @real_price is not null
  order by distance , log.DATE_GUESS; 
    set @real_price = null;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `GET_YN_GAME_WINNERS`$$
CREATE PROCEDURE `GET_YN_GAME_WINNERS`(IN timeToLoad datetime, IN gameID int)
BEGIN
    select @real_price := round(price,2) from CURRENCY_DETAILS
    where UPDATE_AT = timeToLoad;
    select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANSWER, @real_price as RESULT,
       log.ANS_TIME
    from YN_GAME_LOGS log 
    inner join USERS usr on usr.USER_ID = log.USER_ID
    inner join YN_GAMES yngame on yngame.GAME_ID = log.GAME_ID
    where yngame.ACTIVE = 1 AND yngame.GAME_ID = gameID
    AND log.ANSWER = (@real_price-yngame.PRICE_BET >= 0);
    set @real_price = null;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS `GET_MULTI_GAME_PLAYERS`$$
CREATE PROCEDURE `GET_MULTI_GAME_PLAYERS`(IN timeToLoad datetime, IN gameID int)
BEGIN
    -- load the result
    select @real_price := round(price,2) from CURRENCY_DETAILS
    where UPDATE_AT = timeToLoad;
    -- load the question point
	select @price_below := PRICE_BELOW, @price_above := PRICE_ABOVE
		from MULTI_CHOICE_GAMES
		where ACTIVE=1 AND GAME_ID=gameID;
	-- find who's winner or looser
	if @real_price < @price_below then
		set @result_game = 1;
        -- winners
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, @real_price as RESULT,
               log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BELOW=@result_game;
        -- loosers
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, @real_price as RESULT,
               log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BELOW!=@result_game;
	elseif @real_price > @price_above then
        set @result_game = 1;
        -- winners
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, @real_price as RESULT,
               log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_ABOVE=@result_game;
        -- loosers
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, @real_price as RESULT,
               log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_ABOVE!=@result_game;
	else
        set @result_game = 1;
        -- winners
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, @real_price as RESULT,
               log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BETWEEN=@result_game;
        -- loosers
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, @real_price as RESULT,
               log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BETWEEN!=@result_game;
	end if;
    -- select owner of game
    select OWNER_ID, USER_POINT from MULTI_CHOICE_GAMES join USERS on OWNER_ID = USER_ID 
    where GAME_ID=gameID;

	set @real_price = null;
	set @price_below = null;
	set @price_above = null;
    set @result_game = null;
END$$
DELIMITER ;