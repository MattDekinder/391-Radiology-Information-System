<?php 
include('database.php');
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
//TODO: create security for classes and add dates to search.
if(isset($_POST['search'])){
	
	} else{
		
	}
?>

<http>
	<head>
		<title>Radiology Search</title>
		</head>
		<body>
			<h1 class="header">Radiology Search</h1>
			<form name="search" method="post" action="search.php">
				Search : <input type="text" name="keywords"> <br>
				Start Date: <input type="date" name="date"> <br>
				End Date: <input type="date" name="date"> <br>
				<input type="submit" name="search" value="Search"> <br>
			</form>

</body>
</http>
