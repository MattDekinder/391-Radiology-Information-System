<?php
include('database.php');
session_start();
//ini_set('display_errors',1);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>User Management</title>
</head>
	<body>
		<div class="center">
		<label>search user:</label> 
			<form action="man_users.php" method="post">
				<input type="text" name="username">
				<input type="submit" name="search" value="Search User"><br>
			</form>
		<label>Create New User:</label>
		<form method="post" action="new_user.php">
			<label>Username: </label>
			<input type="text" name="username"><br>
			<label>Password: </label>
			<input type="text" name="password"><br>
			<label>User Type: </label>
			<select name="utype" value="a">
				<option value="p">Patient</option>
				<option value="r">Radiologist</option>
				<option value="d">Doctor</option>
				<option value="a">Administrator</option>
			</select><br>
			<input type="submit" name="makenew" value="Create">
		</form>
		<form action="manage.php">
			<input type="submit" name="back" value="Back" >
		</form>
		</div>
		<?php
if ($_POST['search']){
	if(!empty($_POST['username'])) {
	$sql = "select USER_NAME, PASSWORD, CLASS, PERSON_ID, TO_CHAR(DATE_REGISTERED, 'YYYY-MM-DD') as DATE_REG from USERS where USER_NAME ='".$_POST['username']."'";
	$ret = query_search_exec($sql);
	if (!empty($ret)){
	foreach($ret as $row){
		echo '<form action="man_users.php" method="post">';
		echo '<input type="text" name="user_name" value="'.$row['USER_NAME'].'">';
		echo '<input type="text" name="password" value="'.$row['PASSWORD'].'">';
		echo '<input type="text" name="class" value="'.$row['CLASS'].'">';
		echo '<input type="text" name="person_id" value="'.$row['PERSON_ID'].'">';
		echo '<input type="date" name="date_reg" value="'.$row['DATE_REG'].'">';
		echo '<input type="submit" name="update_table" value="Update" ><br>';
		echo '<br><br>';
		echo '<input type="submit" name="delete_table" value="Delete" >';
		echo '</form>';
			}
	}
	}
	else {
		echo "No username entered";
		}
	}
	
if ($_POST['update_table']){
	$sql = "update USERS set PASSWORD='".$_POST['password']."' , CLASS='".$_POST['class']."' ,PERSON_ID='".$_POST['person_id']."', DATE_REGISTERED='".$_POST['date_reg']."' where USER_NAME='".$_POST['user_name']."'";
	echo $sql;
	}
if ($_POST['delete_table']){
	$sql = "DELETE FROM USERS WHERE USER_NAME='".$_POST['user_name']."'";
	echo $sql;
	}
?>
	</body>
</html>
