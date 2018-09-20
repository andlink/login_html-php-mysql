<?php
/*********************************************************************************
Script Name: Database Authentication
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

/** *********************************************************** 
	** STATUS LIST **
		1: NOT LOGGED
		2: LOGGED
		3: INVALID PARAMS
		4: AUTH FAILED
*********************************************************** **/


/** *********************************************************** 
	DELETE sessions if expired	
**/
function auth_clean_expired() {
	global $_CONFIG;
	
	/* delete old auth */
	mysql_query("DELETE FROM ".$_CONFIG['session_table']." 
	             WHERE ".$_CONFIG['date_column']." + INTERVAL ".$_CONFIG['expire']." MINUTE <= NOW()" );	
	
	/* if UID does not exis in the database, delete the cookie */
	$result = mysql_query("SELECT * FROM ".$_CONFIG['session_table']." 
                           WHERE ".$_CONFIG['uid_column']."='".get_cookie_uid()."'");	
						   	
	if(mysql_num_rows($result) != 1) {		
		setcookie($_CONFIG['uid_cookie'], '', time()-3600); 
	}
}

/** *********************************************************** 
	GET uid stored in the cookie
	
	return $uid (String) - the uid stored
**/
function get_cookie_uid() {	
	global $_CONFIG;
	global $_COOKIE;
	
	$uid = $_COOKIE[$_CONFIG['uid_cookie']];

	return $uid ? $uid : NULL;	
}

/** *********************************************************** 
	GET the authentication status
		
	return (Integer) - The status (1 or 2)
**/
function get_auth_status() { 
	global $_CONFIG;	

	auth_clean_expired();
	$uid = get_cookie_uid();
	if(is_null($uid)) { 		
		return 1; 
	}
	
	$result = mysql_query("SELECT * FROM ".$_CONFIG['session_table']." 
	                       WHERE ".$_CONFIG['uid_column']."='".$uid."'"); 
						   
	if(mysql_num_rows($result) == 1) {
		return 2;
	} else {		
		return 1;
	}
}

/** *********************************************************** 
	LOGIN - insert UID in the database and create the cookie
	
	$uname (String) - The username
	$passw (String) - The password (not encrypted)
		
	return (Integer) - The status
**/
function auth_login($uname, $passw) {
	global $_CONFIG;
		
	// return INVALID PARAMS if username or password are empty
	if (empty($uname) | empty($passw)) {
		return 3;
	}
	
	// check if already logged
	if (get_auth_status() == 2 ) {
		return 2;		
	}		
	
	$result = mysql_query("SELECT *	FROM ".$_CONFIG['user_table']." 
                           WHERE ".$_CONFIG['username_column']."='".$uname."' 
						   AND ".$_CONFIG['password_column']."=MD5('".$passw."')"	);
	
	// check if username and password are correct
	if( mysql_num_rows($result) != 1 ) {
		return 3;
	} else {
		//LOGGIN
		$data = mysql_fetch_array($result);
		$uid = generate_uid();		
		
		$result = mysql_query("INSERT INTO ".$_CONFIG['session_table']." (".$_CONFIG['uid_column'].", ".$_CONFIG['iduser_column'].") VALUES
				    ('".$uid."', '".$data[$_CONFIG['iduser_column']]."')");				
		if($result){					
			setcookie($_CONFIG['uid_cookie'], $uid, time()+($_CONFIG['expire']*60), '/');			
			return 2;
		} else {
			return 4;
		}		
		
	}
}

/** *********************************************************** 
	LOGOUT - delete UID from the database and remove the cookie
		
	return (Boolean) - false if cookie uid does not exist
**/
function auth_logout() {
	global $_CONFIG;

	$uid = get_cookie_uid();
	
	if(is_null($uid)) {
		return false;
	} else {		
		mysql_query("DELETE FROM ".$_CONFIG['session_table']." 
                     WHERE ".$_CONFIG['uid_column']."='".$uid."'");
		setcookie($_CONFIG['uid_cookie'], '', time()-3600);
		return true;
	}
}

/** *********************************************************** 
	GENERATE a random String based on time
		
	return (String) - a random String of 32 chars
**/
function generate_uid() {
	list($usec, $sec) = explode(' ', microtime());
	mt_srand((float) $sec + ((float) $usec * 100000));
	return md5(uniqid(mt_rand(), true));
}


?>
