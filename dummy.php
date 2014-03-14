<html>
<body>
	<?php 
	session_start();
	if(isset($_SESSION['USER_NAME'])){
		echo $_SESSION['USER_NAME']."<br>";
		echo $_SESSION['CLASS']."<br>";
		echo $_SESSION['PERSON_ID']."<br>";
		echo $_SESSION['FIRST_NAME']."<br>";
		echo $_SESSION['LAST_NAME']."<br>";
		echo $_SESSION['ADDRESS']."<br>";
		echo $_SESSION['EMAIL']."<br>";
		echo $_SESSION['PHONE']."<br>";
	}
	?>
</body>
</html>
