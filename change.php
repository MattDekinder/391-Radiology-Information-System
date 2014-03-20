<?php
include('database.php');
if(isset($_GET['uname'])){
	$username = $_GET['uname'];
} elseif(isset($_POST['change_go'])){
	$username = $_POST['username'];
	$status = query_password_change($_POST['username'], $_POST['opassword'], $_POST['npassword']);
	if($status){
		header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/login.php");
	}
}
?>
<html>
<head>
	<title>Change Password</title>
	<LINK rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class ="center">
			<form name="changep" method="post" action="change.php">
				<label>Username :</label> <input type="text" name="username" value=<?php echo '"'.$username.'"'?>/> <br>
				<label>Old Password :</label> <Input type="password" name="opassword"/> <br>
				<label>New Password :</label> <Input type="password" name="npassword"/> <br>
				<label>Confirm New Password :</label> <input type="password" name="c_opassword"> <br>
				<input type="submit" name="change_go" value="Change Password" >
			</form>
			<?php if(!$status){ ?>
			<h2>Password Change Failed!</h2>
			<?php } ?>
		</div>
	</body>
	</html>