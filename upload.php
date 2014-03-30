<?php
include('database.php'); 
session_start();
$patients = get_patients();
$doctors = get_doctors();
$rads = get_radiolog();

$rad_id = $_SESSION["PERSON_ID"];
echo "Radiologist ID: ".$rad_id;

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
			<input type="hidden" name="rad" value="<?php echo $rad_id ?>">
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
		<form name="back" method="post" action="search.php">
		<input type="submit" name="back" value="Back">
		</form>
	</div>
</body>
</html>