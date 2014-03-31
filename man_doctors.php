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
		<label>search Doctor ID:</label> 
			<form action="man_doctors.php" method="post">
				<input type="text" name="doctor_id">
				<input type="submit" name="search" value="Search"><br>
			</form>
		<label>Add new Family Doctor:</label><br>
		<form method="post" action="man_doctors.php">
			<label>Doctor ID </label>
			<input type="text" name="doctor_id"><br>
			<label>Patient ID</label>
			<input type="text" name="patient_id"><br>
			<input type="submit" name="makenew" value="Create">
		</form>
		<form action="manage.php">
			<input type="submit" name="back" value="Back" >
		</form>
		</div>
		<?php
if ($_POST['search']){
	if(!empty($_POST['doctor_id'])) {
	$sql = "select DOCTOR_ID, PERSON_ID from FAMILY_DOCTOR where DOCTOR_ID ='".$_POST['doctor_id']."'";
	$ret = query_search_exec($sql);
	if (!empty($ret)){
	foreach($ret as $row){
		echo '<form action="man_people.php" method="post">';
		echo '<input type="text" name="doctor_id" value="'.$row['DOCTOR_ID'].'">';
		echo '<input type="text" name="patient_id" value="'.$row['PATIENT_ID'].'">';
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
	$sql = "insert into FAMILY_DOCTOR values('".$_POST['doctor_id']."','".$_POST['patient_id']."')";
	insert_update_exec($sql);
	insert_update_exec('commit');
	}	
	
if ($_POST['delete_table']){
	$sql = "DELETE FROM FAMILY_DOCTOR WHERE DOCTOR_ID='".$_POST['doctor_id']."'";
	insert_update_exec($sql);
	insert_update_exec('commit');
	}
?>
	</body>
</html>
