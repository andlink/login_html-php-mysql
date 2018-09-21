## HTML / PHP LOGIN - session stored in MySQL database

Easy script for HTML login 

### HTML
Form for login
```html
<form action="login.php" method="post">
			<label for="uname">Username</label>
			<input type="text" placeholder="Enter Username" name="uname" required>			
			<label for="passw">Password</label>
			<input type="password" placeholder="Enter Password" name="passw" required>

			<button type="submit">Login</button>
</form>
```
### PHP

```php
```

### MySQL database
# TABLE `session`
  `uid` char(32)
  `iduser` int(11)
  `creation_date` datetime 

# TABLE `user` 
  `iduser` int(11)
  `username` varchar(45)
  `password` varchar(32)

