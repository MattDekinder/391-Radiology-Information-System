<?php
include("database.php");
if(isset($_POST['back'])){
	header('http://localhost/391-Radiology-Information-System/login.php');
}
?>
<html>
<head>
	<title>Change Password</title>
	<LINK rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="user_login">
			<form name="changep" method="post" action="change.php">
				<input class="uinfo"  type="text" name="username" placeholder="Old Password"/> <br>
				<Input class="uinfo" type="text" name="opassword" placeholder="New Password"/> <br>
				<input class="uinfo" ype="text" name="c_opassword" placeholder="Confirm New Password"> <br>
				<input type="submit" name="change_go" value="Change Password" >
			</form>
			<form name="back" method="post" action="login.php">
				<input type="submit" name="back" value="Back" >
			</form>
		</div>
	</body>
	</html>