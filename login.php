<html>
<body>
	<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
		//Is set if there was a login post sent.

	include("database.php");
	if(isset($_POST['login'])){
		$function='login';
		$user=$_POST['uname'];
		$pass=$_POST['upass'];

		$correct=query_login($user, $pass);
		echo $correct;

		//Is set if there was a register post sent.
	} elseif(isset($_POST['register'])){
		$function='register';
		$user=$_POST['uname_input'];
		$pass=$_POST['upass_input'];
		
		$correct=query_login($user, $pass);
		echo $correct;
	}
	?>

</body>
</html>