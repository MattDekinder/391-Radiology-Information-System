<?php 
include('database.php');
session_start();
?>


<http>
	<head>
		<title>Radiology Search</title>
		</head>
		<body>
			<h1 class="header">Radiology Search</h1>
			<form name="user_login" method="post" action="search.php">
				Search : <input type="text" name="search"> <br> 
<!-- insert some kind of date picker here-->
				<input type="submit" name="search" value="Search">
				<input type="submit" name="change" value="Change Password">
			</form>
			<?php if($search){ ?>
			<h2>Search Failed!(what does that even mean!! hoq does a search fail.)</h2>
			<?php } ?>
		</body>
</http>