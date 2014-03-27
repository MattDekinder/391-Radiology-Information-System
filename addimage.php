<?php

//Comment back in to re-enable uploading of records
include("database.php");

session_start();


$retval = rows_count("radiology_record") + 1;
if(isset($_POST['create'])){

	$rid = $retval;
	make_record($retval, $_POST["patient"], $_POST["doctor"], $_POST["rad"], $_POST["test_type"], $_POST["pers_date"], $_POST["test_date"], $_POST["diag"], $_POST["desc"]);

}

if($second = isset($_POST['upload'])){
	$rid = $_POST['record'];
	if($_FILES['file']['error'][0] > 0){
		echo "Error: ".$_FILES["file"]["error"][0]."<br>";
	} else{
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
			<input type="hidden" name="record" value=<?php echo '"'.$rid.'"' ?>>
			<input type="submit" name="upload"/>
			<input type="submit" name="done" value="Done"/>
		</form>
	</div>
</body>
</html>