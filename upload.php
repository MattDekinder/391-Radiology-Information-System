<?php
include('database.php'); 
$patients = get_patients();
$doctors = get_doctors();
$rads = get_radiolog();
?>

<html>
<head>
	<LINK rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="center">
		<form name="new_record" method="post" action="addimage.php">
			<label>Patient: </label>
			<select name="patient">
				<?php
				foreach ($patients as $patient) {
					echo '<option value="'.$patient['PERSON_ID'].'" >'.$patient['LAST_NAME'].", ".$patient["FIRST_NAME"].'</option>';
				}?>
			</select> 
			<br>
			<label>Doctor: </label>
			<select name="doctor">
				<?php
				foreach ($doctors as $doc) {
					echo '<option value="'.$doc['PERSON_ID'].'" >'.$doc['LAST_NAME'].", ".$doc["FIRST_NAME"].'</option>';
				}?>
			</select>
			<br>
			<label>Radiologist: </label>
			<select name="rad">
				<?php
				foreach ($rads as $rad) {
					echo '<option value="'.$rad['PERSON_ID'].'" >'.$rad['LAST_NAME'].", ".$rad["FIRST_NAME"].'</option>';
				}?>
			</select>
			<br>
			<label>Test Type: </label>
			<input type="text" name="test_type" maxlength="23"> <br>
			<label>Prescribing Date: </label>
			<input type="date" name="pers_date"> <br>
			<label>Test Date: </label>
			<input type="date" name="test_date"> <br>
			<label>Diagnosis: </label>
			<input type="text" name="diag" maxlength="127"> <br>
			<label>Description: </label> <br>
			<textarea name="desc" rows="4" cols="50" maxlength="1023"></textarea> <br>
			<input type="submit" name="create" value="Create Record">
		</form>
	</div>
</body>
</html>