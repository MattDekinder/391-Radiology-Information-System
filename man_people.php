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
			<input type="text" name="person_id"><br>
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
	if(!empty($_POST['Person_ID'])) {
	$sql = "select PERSON_ID, FIRST_NAME, LAST_NAME, ADDRESS, EMAIL, PHONE from PERSONS where PERSON_ID ='".$_POST['Person_ID']."'";
	$ret = query_search_exec($sql);
	if (!empty($ret)){
	foreach($ret as $row){
		echo '<form action="man_people.php" method="post">';
		echo '<input type="text" readonly="readonly" name="person_id" value="'.$row['PERSON_ID'].'">';
		echo '<input type="text" name="first_name" value="'.$row['FIRST_NAME'].'">';
		echo '<input type="text" name="last_name" value="'.$row['LAST_NAME'].'">';
		echo '<input type="text" name="address" value="'.$row['ADDRESS'].'">';
		echo '<input type="text" name="email" value="'.$row['EMAIL'].'">';
		echo '<input type="text" name="phone" value="'.$row['PHONE'].'">';
		echo '<input type="submit" name="update_table" value="Update" ><br>';
		echo '<br><br>';
		echo '<input type="submit" name="delete_table" value="Delete" >';
		echo '</form>';
		echo '<br><br><br>';
			}
		}
		else{echo "No results";}
		}
	else {echo "No username entered";}
	}
if ($_POST['makenew']){
	$sql = "insert into PERSONS values('".$_POST['person_id']."','".$_POST['first_name']."', '".$_POST['last_name']."' , '".$_POST['address']."' ,'".$_POST['email']."', '".$_POST['phone']."')";
	insert_update_exec($sql);
	insert_update_exec('commit');
	}	
	
if ($_POST['update_table']){
	$sql = "update PERSONS set FIRST_NAME='".$_POST['first_name']."' , LAST_NAME='".$_POST['last_name']."' ,ADDRESS='".$_POST['address']."', EMAIL='".$_POST['email']."',PHONE='".$_POST['phone']."' where PERSON_ID='".$_POST['person_id']."'";
	insert_update_exec($sql);
	insert_update_exec('commit');
	}
if ($_POST['delete_table']){
	$sql = "DELETE FROM PERSONS WHERE PERSON_ID='".$_POST['person_id']."'";
	insert_update_exec($sql);
	insert_update_exec('commit');
	}
?>
	</body>
</html>
