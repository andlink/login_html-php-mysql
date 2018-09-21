<!-- ---------------------------------------------------------------------------------
Author: Andrea Gallotta
Website: http://andlink.net/
Version: 1.0.0
Date: 2018-09-01

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

Get the full text of the GPL here: http://www.gnu.org/licenses/gpl.txt
--------------------------------------------------------------------------------- -->
<?php
include_once('./db_conf.php'); 	
include_once('./db_auth.php'); 
?>

<!doctype html>
<html>
<body>

<h1>PHP LOGIN - session stored in MySQL database</h1>
<h2>Status: <?php echo get_auth_status_str(); ?></h2>

<?php 
if (get_auth_status() != 2) {
	echo '<form action="login.php" method="post">
			<label for="uname">Username</label>
			<input type="text" placeholder="Enter Username" name="uname" required>			
			<label for="passw">Password</label>
			<input type="password" placeholder="Enter Password" name="passw" required>

			<button type="submit">Login</button>
		</form>';
} else {
	echo '<form action="logout.php">			
			<button type="submit">Logout</button>
		</form>';
}
?>

</body>
</html>
