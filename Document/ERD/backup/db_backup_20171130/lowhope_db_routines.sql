-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 35.185.45.47    Database: lowhope_db
-- ------------------------------------------------------
-- Server version	5.6.38

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping routines for database 'lowhope_db'
--
/*!50003 DROP PROCEDURE IF EXISTS `GET_MULTI_GAME_PLAYERS` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`lowhope`@`%` PROCEDURE `GET_MULTI_GAME_PLAYERS`(IN timeToLoad datetime, IN gameID int)
BEGIN
    -- load the result
    select @real_price := round(price,2) as game_result from CURRENCY_DETAILS
    where UPDATE_AT = timeToLoad;
    -- load the question point
	select @price_below := PRICE_BELOW, @price_above := PRICE_ABOVE
		from MULTI_CHOICE_GAMES
		where ACTIVE=1 AND GAME_ID=gameID;
	-- find who's winner or looser
	if @real_price < @price_below then
		set @result_game = 1;
        -- winners
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BELOW=@result_game;
        -- loosers
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BELOW!=@result_game;
	elseif @real_price > @price_above then
        set @result_game = 1;
        -- winners
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_ABOVE=@result_game;
        -- loosers
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_ABOVE!=@result_game;
	else
        set @result_game = 1;
        -- winners
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BETWEEN=@result_game;
        -- loosers
        select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANS_TIME
		from MULTI_CHOICE_GAME_LOGS log
        join USERS usr on log.USER_ID=usr.USER_ID
        join MULTI_CHOICE_GAMES game on game.GAME_ID=log.GAME_ID
        where game.ACTIVE=1 AND game.GAME_ID=gameID
        AND log.PRICE_BETWEEN!=@result_game;
	end if;
    -- select owner of game
    select OWNER_ID as USER_ID, USER_POINT from MULTI_CHOICE_GAMES join USERS on OWNER_ID = USER_ID 
    where GAME_ID=gameID;

	set @real_price = null;
	set @price_below = null;
	set @price_above = null;
    set @result_game = null;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GET_SYS_GAME_PLAYERS` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`lowhope`@`%` PROCEDURE `GET_SYS_GAME_PLAYERS`(IN timeToLoad datetime)
BEGIN
   set @real_price = null;
   SELECT @real_price := round(price,2) as game_result FROM CURRENCY_DETAILS
   where UPDATE_AT = timeToLoad;
   SELECT usr.USER_ID, usr.USER_NAME, log.GAME_ID, log.PRICE_GUESS,
        abs(log.PRICE_GUESS - @real_price) as distance, log.DATE_GUESS
  from USERS usr  
  inner join SYSTEM_GAME_LOGS log on usr.USER_ID = log.USER_ID
  inner join SYSTEM_GAMES sgame  on log.GAME_ID = sgame.GAME_ID
  where sgame.ACTIVE = 1 AND @real_price is not null
  order by distance , log.DATE_GUESS; 
    set @real_price = null;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GET_YN_GAME_PLAYERS` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`lowhope`@`%` PROCEDURE `GET_YN_GAME_PLAYERS`(IN timeToLoad datetime, IN gameID int)
BEGIN
    -- game result
    select @real_price := round(price,2) as game_result from CURRENCY_DETAILS
    where UPDATE_AT = timeToLoad;
    -- game winners
    select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANSWER, log.ANS_TIME
    from YN_GAME_LOGS log 
    inner join USERS usr on usr.USER_ID = log.USER_ID
    inner join YN_GAMES yngame on yngame.GAME_ID = log.GAME_ID
    where yngame.ACTIVE = 1 AND yngame.GAME_ID = gameID
    AND log.ANSWER = (@real_price-yngame.PRICE_BET >= 0);
    -- game loosers
	select usr.USER_ID, usr.USER_NAME, usr.USER_POINT, log.GAME_ID, log.ANSWER, log.ANS_TIME
    from YN_GAME_LOGS log 
    inner join USERS usr on usr.USER_ID = log.USER_ID
    inner join YN_GAMES yngame on yngame.GAME_ID = log.GAME_ID
    where yngame.ACTIVE = 1 AND yngame.GAME_ID = gameID
    AND log.ANSWER != (@real_price-yngame.PRICE_BET >= 0);
    -- game owner
    select OWNER_ID as USER_ID, USER_POINT from YN_GAMES join USERS on OWNER_ID = USER_ID 
    where GAME_ID=gameID;
    set @real_price = null;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-30 23:58:54
