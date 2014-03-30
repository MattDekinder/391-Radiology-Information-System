<html>
	<body>
		<form method="post" action="new_user.php">
			<label>Username: </label>
			<input type="text" name="username"><br>
			<label>Password: </label>
			<input type="text" name="password"><br>
			<label>User Type: </label>
			<select name="utype">
				<option value="p">Patient</option>
				<option value="r">Radiologist</option>
				<option value="d">Doctor</option>
				<option value="a">Administrator</option>
			</select><br>
			<input type="submit" name="makenew" value="Create">
		</form>
		<form action="man_users.php">
			<input type="submit" name=back>
		</form>
	</body>
</html>
