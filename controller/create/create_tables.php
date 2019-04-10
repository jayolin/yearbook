<?php
	//subAccountString
	//Name Email Password Phone DofB Sex Nickname
		$all_users = "CREATE TABLE IF NOT EXISTS `$db_name`.`All_Users` (
		`id` INT( 255 ) NOT NULL AUTO_INCREMENT,
		`Display_Pic` MEDIUMBLOB NOT NULL ,
		`Display_Pic_Thumb` MEDIUMBLOB NOT NULL ,
		`Name` VARCHAR( 100 ) NOT NULL ,
		`RegNo` VARCHAR( 100 ) NOT NULL ,
		`Password` VARCHAR( 150 ) NOT NULL ,
		`Phone` VARCHAR( 100 ) NOT NULL ,
		`Bio` VARCHAR( 200 ) NOT NULL ,
		`DofB` VARCHAR( 50 ) NOT NULL ,
		`Sex` VARCHAR( 50 ) NOT NULL ,
		`Nickname` VARCHAR( 100 ) NOT NULL ,
		`Likes` VARCHAR( 200 ) NOT NULL ,
		`Dislikes` VARCHAR( 200 ) NOT NULL ,
		`Favourite_Food` VARCHAR( 200 ) NOT NULL ,
		`Favourite_Colors` VARCHAR( 50 ) NOT NULL ,
		`Favourite_Quotes` VARCHAR( 200 ) NOT NULL ,
		`Date` VARCHAR( 50 ) NOT NULL ,
		PRIMARY KEY(`id`)
		) ENGINE = INNODB;";
		$all_users_run = mysql_query($all_users);


		$all_posts = "CREATE TABLE IF NOT EXISTS `$db_name`.`Posts` (
		`id` INT( 255 ) NOT NULL AUTO_INCREMENT,
		`user_id` INT( 255 ) NOT NULL,
		`Type` INT( 1 ) NOT NULL ,
		`mime_type` VARCHAR( 20 ) NOT NULL ,
		`Image_or_Vid` LONGBLOB NOT NULL ,
		`Image_or_Vid_Thumb` LONGBLOB NOT NULL ,
		`Description` VARCHAR( 10000 ) NOT NULL ,
		`seen` INT( 2 ) NOT NULL,
		`Date` VARCHAR( 50 ) NOT NULL ,
		PRIMARY KEY(`id`)
		) ENGINE = INNODB;";
		$all_posts = mysql_query($all_posts);


		$comments = "CREATE TABLE IF NOT EXISTS `$db_name`.`Comments` (
		`id` INT( 255 ) NOT NULL AUTO_INCREMENT,
		`post_id` INT( 255 ) NOT NULL ,
		`user_id` INT( 255 ) NOT NULL ,
		`seen` INT( 2 ) NOT NULL,
		`comment` VARCHAR( 1000 ) NOT NULL ,
		`Date` VARCHAR( 50 ) NOT NULL ,
		PRIMARY KEY(`id`)
		) ENGINE = INNODB;";
		$comments = mysql_query($comments);

		$mentions = "CREATE TABLE IF NOT EXISTS `$db_name`.`Mentions` (
		`id` INT( 255 ) NOT NULL AUTO_INCREMENT,
		`post_id` INT( 255 ) NOT NULL ,
		`mentioner_id` INT( 255 ) NOT NULL ,
		`mentionee_id` INT( 255 ) NOT NULL ,
		`seen` INT( 2 ) NOT NULL,
		`Date` VARCHAR( 50 ) NOT NULL ,
		PRIMARY KEY(`id`)
		) ENGINE = INNODB;";
		$mentions = mysql_query($mentions);


		$likes = "CREATE TABLE IF NOT EXISTS `$db_name`.`Likes` (
		`id` INT( 255 ) NOT NULL AUTO_INCREMENT,
		`post_id` INT( 255 ) NOT NULL ,
		`user_id` INT( 255 ) NOT NULL ,
		`seen` INT( 2 ) NOT NULL,
		`Date` VARCHAR( 50 ) NOT NULL ,
		PRIMARY KEY(`id`)
		) ENGINE = INNODB;";
		$likes = mysql_query($likes);


		
		
?>