<?php
if(isset($_GET['username']){
	$username = $_GET['username'];
	$userinfo = get_user_info($username);
} elseif($_POST['makeedit']){

} else {
 //Header to man_users.php
}
?>
<html>
<body>
	<form method="post" action="new_user.php">
		<label><?php echo $username ?></label><br>
		<label>Password: </label>
		<input type="password" name="password" value="<?php echo $username['PASSWORD']?>"><br>
		<label>User Type: </label>
		<select name="utype">
			<?php if($username['CLASS']=='p') {?>
			<option value="p">Patient</option>
			<option value="r">Radiologist</option>
			<option value="d">Doctor</option>
			<option value="a">Administrator</option>
			<?php } elseif($username['CLASS']=='r'){ ?>
			<option value="r">Radiologist</option>
			<option value="d">Doctor</option>
			<option value="a">Administrator</option>
			<option value="p">Patient</option>
			<?php } elseif($username['CLASS']=='d'){ ?>
			<option value="d">Doctor</option>
			<option value="a">Administrator</option>
			<option value="p">Patient</option>
			<option value="r">Radiologist</option>
			<?php } elseif($username['CLASS']=='a'){ ?>
			<option value="a">Administrator</option>
			<option value="p">Patient</option>
			<option value="r">Radiologist</option>
			<option value="d">Doctor</option>
			<?php } ?>
		</select><br>
		<input type="submit" name="makeedit" value="Commit Edit">
	</form>
	<form action="man_users.php">
		<input type="submit" name=back>
	</form>
</body>
</html>
