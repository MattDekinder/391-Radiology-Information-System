<?php

//Comment back in to re-enable uploading of records
include("database.php");

session_start();

//Creates an ID for a new record 
$retval = rows_count("radiology_record") + 1;

if(isset($_POST['create'])){

	// Save rid for adding images
	$rid = $retval;

	// Creates the record
	// Images rely on record foreign keys, so record must be commited before images are added
	make_record($retval, $_POST["patient"], $_POST["doctor"], $_POST["rad"], $_POST["test_type"], $_POST["pers_date"], $_POST["test_date"], $_POST["diag"], $_POST["desc"]);

}


if($second = isset($_POST['upload'])){

	// Reloads $rid from POST data
	$rid = $_POST['record'];

	//If there is not an error
	if($_FILES['file']['error'][0] > 0){
		echo "Error: ".$_FILES["file"]["error"][0]."<br>";
	} else{

		//Add the image indicated by file to the database (associated with record number '$rid')
		$file = $_FILES['file'];
		add_image($file, $rid);	
	}
} 

if(isset($_POST['done'])){
	header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/search.php");
}
?>
<html>
<head>
	<LINK rel="stylesheet" type="text/css" href="style.css">
	</head>
</head>
<body>
	<div class="center">
		<?php if($second){ ?> 
		<label>Add Another Image?</label> <br/> 
		<?php } ?>
		<form name="addimage" method="post" action="addimage.php" enctype="multipart/form-data">
			<input type="file" name="file[]"/>
			<!-- rid in hidden POST data-->
			<input type="hidden" name="record" value=<?php echo '"'.$rid.'"' ?>>
			<input type="submit" name="upload"/>
			<input type="submit" name="done" value="Done"/>
		</form>
	</div>
</body>
</html>