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
		<label>search Person ID:</label> 
			<form action="man_people.php" method="post">
				<input type="text" name="Person_ID">
				<input type="submit" name="search" value="Search"><br>
			</form>
		<label>Add new Person:</label><br>
		<form method="post" action="man_people.php">
			<label>Person ID </label>
			<input type="text" name="P_ID"><br>
			<label>First Name</label>
			<input type="text" name="first_name"><br>
			<label>Last Name</label>
			<input type="text" name="last_name"><br>
			<label>Address</label>
			<input type="text" name="address"><br>
			<label>Email</label>
			<input type="text" name="email"><br>
			<label>Phone</label>
			<input type="text" name="phone"><br>
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
		echo '<form action="man_people.php" method="post">';
		echo '<input type="text" name="user_name" value="'.$row['USER_NAME'].'">';
		echo '<input type="text" name="password" value="'.$row['PASSWORD'].'">';
		echo '<input type="submit" name="update_table" value="Update" ><br>';
		echo '<br><br>';
		echo '<input type="submit" name="delete_table" value="Delete" >';
		echo '</form>';
		echo '<br><br><br>';
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
