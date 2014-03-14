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
		header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/dummy.php");
	}
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
					Username : <input type="text" name="uname"/> <br/> 
					Password : <input type="text" name="upass"/> </br>
					<input type="submit" name="login" value="Login"/>
				</form>
				<?php 
				echo $result['info']['USER_NAME'];
				echo $result['info']['PASSWORD'];
				echo $result['info']['CLASS'];
				echo $result['info']['PERSON_ID'];
				echo $result['info']['FIRST_NAME'];
				echo $result['info']['LAST_NAME'];
				echo $result['info']['ADDRESS'];
				echo $result['info']['EMAIL'];
				echo $result['info']['PHONE'];
				?>
				<?php if($login){ ?>
				<h2>Login Failed!</h2>
				<?php } ?>
			</div>
		</body>
	</http>