<?php 
include('database.php');
if($login = isset($_POST['login'])){ 

	$result = query_login($_POST['uname'], $_POST['upass']);
	if($result['valid']){
		session_start();
		$_SESSION['USER_NAME'] = $result['info']['USER_NAME'];
		$_SESSION['CLASS'] = $result['info']['CLASS'];
		$_SESSION['PERSON_ID'] = $result['info']['PERSON_ID'];
		$_SESSION['FIRST_NAME'] = $result['info']['FIRST_NAME'];
		$_SESSION['LAST_NAME'] = $result['info']['LAST_NAME'];
		$_SESSION['ADDRESS'] = $result['info']['ADDRESS'];
		$_SESSION['EMAIL'] = $result['info']['EMAIL'];
		$_SESSION['PHONE'] = $result['info']['PHONE'];


		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/dummy.php");
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
		////////////////////////////////////////////////NEXT PAGE////////////////////////////////////////////////
	}
} elseif(isset($_POST['change'])) {
}
?>
<http>
	<head>
		<title>Login</title>
		<LINK rel="stylesheet" type="text/css" href="login.css">
		</head>
		<body>
			<div class="user_login">
				<h1 class="header">Login</h1>
				<form name="user_login" method="post" action="login.php">
					Username : <input type="text" name="uname"> <br> 
					Password : <input type="text" name="upass"> <br>
					<input type="submit" name="login" value="Login">
				</form>
				<form method="post" action="change.php">
					<input type="submit" name="change" value="Change Password">
				</form>
				<?php if($login){ ?>
				<h2>Login Failed!</h2>
				<?php } ?>
			</div>
		</body>
	</http>