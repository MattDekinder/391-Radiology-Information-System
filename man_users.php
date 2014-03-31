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
	<a href="usermanigement.html"target="_blank">Help</a>
	<div class="center">
		<label>search user's person ID:</label> 
		<form action="man_users.php" method="post">
			<input type="text" name="person_id">
			<input type="submit" name="search" value="Search"><br>
		</form>
		<label>Create New User:</label><br>
		<form method="post" action="man_users.php">
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
			<label>Person ID: </label>
			<input type="text" name="person_id"><br>
			<label>Date Registered: </label>
			<input type="date" name="date_reg" value="<?php echo date('Y-m-d'); ?>" /><br>
			<input type="submit" name="makenew" value="Create">
		</form>
		<form action="manage.php">
			<input type="submit" name="back" value="Back" >
		</form>
	</div>
	
	<?php
	if ($_POST['search']){
		if(!empty($_POST['person_id'])) {
			$sql = "select USER_NAME, PASSWORD, CLASS, PERSON_ID, TO_CHAR(DATE_REGISTERED, 'YYYY-MM-DD') as DATE_REG from USERS where PERSON_ID ='".$_POST['person_id']."'";
			$ret = query_search_exec($sql);
			if (!empty($ret)){
				foreach($ret as $row){
					echo '<form action="man_users.php" method="post">';
					echo '<label>User Name: </label>';
					echo '<input readonly="readonly" name="user_name" value="'.$row['USER_NAME'].'">';
					echo '<label>Password: </label>';
					echo '<input type="text" name="password" value="'.$row['PASSWORD'].'">';
					echo '<label>Class: </label>';
					echo '<input type="text" name="class" value="'.$row['CLASS'].'">';
					echo '<label>Person ID: </label>';
					echo '<input type="text" name="person_id" value="'.$row['PERSON_ID'].'">';
					echo '<label>Date Registered: </label>';
					echo '<input type="date" name="date_reg" value="'.$row['DATE_REG'].'">';
					echo '<input type="submit" name="update_table" value="Update" ><br>';
					echo '<br><br>';
					echo '<input type="submit" name="delete_table" value="Delete" >';
					echo '</form>';
					echo '<br><br>';
				}
			}
		}
		else {
			echo "No user ID entered";
		}
	}

	if ($_POST['makenew']){
		$sql = "insert into USERS values('".$_POST['username']."', '".$_POST['password']."' , '".$_POST['utype']."' ,'".$_POST['person_id']."', to_date('".$_POST['date_reg']."','YYYY-MM-DD'))";
		insert_update_exec($sql);
	}	
	
	if ($_POST['update_table']){
		$sql = "update USERS set PASSWORD='".$_POST['password']."' , CLASS='".$_POST['class']."' ,PERSON_ID='".$_POST['person_id']."', DATE_REGISTERED=to_date('".$_POST['date_reg']."','YYYY-MM-DD') where USER_NAME='".$_POST['user_name']."'";
		insert_update_exec($sql);
	}
	
	if ($_POST['delete_table']){
		$sql = "DELETE FROM USERS WHERE USER_NAME='".$_POST['user_name']."'";
		insert_update_exec($sql);
	}
	?>
</body>
</html>
