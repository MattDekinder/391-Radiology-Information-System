<?php

//Include database functions
include('database.php');

if(isset($_POST['logout'])){
	$logout = FALSE;
	session_start();
	$logout = session_destroy();
	if($logout){
		echo "logout successfull";
		}
	}     
	
//The user clicked the 'login' button
if($login = isset($_POST['login'])){

//Will not execute a query on an empty password or username field
	if(empty($_POST['uname']) || empty($_POST['upass'])){
		// Do nothing at the moment
	} else{
		$result = query_login($_POST['uname'], $_POST['upass']);

		//Is only valid if user entered correct uname and pass
		if($result['valid']){
			session_start();

			// Assigns all session data
			$_SESSION['USER_NAME'] = $result['info']['USER_NAME'];
			$_SESSION['CLASS'] = $result['info']['CLASS'];
			$_SESSION['PERSON_ID'] = $result['info']['PERSON_ID'];
			$_SESSION['FIRST_NAME'] = $result['info']['FIRST_NAME'];
			$_SESSION['LAST_NAME'] = $result['info']['LAST_NAME'];
			$_SESSION['ADDRESS'] = $result['info']['ADDRESS'];
			$_SESSION['EMAIL'] = $result['info']['EMAIL'];
			$_SESSION['PHONE'] = $result['info']['PHONE'];

			// Moves on to search
			//header("Location: http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/search.php");
			header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/search.php");
		}
	}

//The user clicked the 'change password' button
} elseif(isset($_POST['change'])) {

	// Go to change script with username as url field (GET)
	//header("Location: http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/change.php?uname=".$_POST['uname']);
	header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/change.php?uname=".$_POST['uname']);
}
?>
<http>
	<head>
		<title>Login</title>
		<LINK rel="stylesheet" type="text/css" href="style.css">
		</head>
		<body>
			<a href="loginchange.html"target="_blank">Help</a>
			<div class="center">
				<h1 class="header">Login</h1>
				<form name="user_login" method="post" action="login.php">
					Username : <input type="text" name="uname"> <br>
					Password : <input type="password" name="upass"> <br>
					<input type="submit" name="login" value="Login">
					<input type="submit" name="change" value="Change Password">
				</form>
				<?php if($login){ ?>
				<h2>Login Failed!</h2>
				<?php } ?>
			</div>
		</body>
	</http>