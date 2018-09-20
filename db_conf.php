<?php
/*********************************************************************************
Script Name: Database Configuration
Author: Andrea Gallotta, Website: http://andlink.net/
Script Source URI: http://andlink.net/downloads/db_auth.php
Version: 1.0.0
Date: 2018-09-01

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

Get the full text of the GPL here: http://www.gnu.org/licenses/gpl.txt
*********************************************************************************/

/** MySQL Database 

DATABASE `andlink_db`

TABLE `session`
  `uid` char(32)
  `iduser` int(11)
  `creation_date` datetime 

TABLE `user` (
  `iduser` int(11)
  `username` varchar(45)
  `password` varchar(32)

**/

/** DB hostname **/
$_CONFIG['host'] = "hostname";
/** DB name **/
$_CONFIG['dbname'] = "andlink_db"; 
/** DB username **/
$_CONFIG['user'] = "username";
/** DB password **/
$_CONFIG['pass'] = "password";

/** DB tables **/
$_CONFIG['session_table'] = "session";
$_CONFIG['user_table'] = "user";

/** DB columns **/
$_CONFIG['uid_column'] = "uid";
$_CONFIG['iduser_column'] = "iduser";
$_CONFIG['date_column'] = "creation_date";
$_CONFIG['username_column'] = "username";
$_CONFIG['password_column'] = "password";

/** Session length in minutes **/
$_CONFIG['expire'] = 120; // after 2 hours the session will expire

/** Cookie to store the session - it's specific  for each database **/
$_CONFIG['uid_cookie'] = "uid".$_CONFIG['dbname']; 

/** START CONNECTION TO DATABASE **/
$conn = mysql_connect($_CONFIG['host'], $_CONFIG['user'], $_CONFIG['pass']) or die('Unable to make a connection');
mysql_select_db($_CONFIG['dbname']);


?>
