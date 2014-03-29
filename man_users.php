<?php
$user_names; //Assign to array of rows of user names. only query for names.
?>
<html>
	<body>
		<div class="center">
			<form action="edit_user.php">
				<select name="username">

				<?php foreach($user_names as $user) { ?>
					<option value="<?php echo $user ?>"><?php echo $user ?></option>
				<?php } ?>

				</select>
				<input type="submit" name="edit" value="Edit User">
			</form>
			<form action="new_user.php">
				<input type="submit" name="new" value="New User">
			</form>
		</div>
	</body>
</html>
