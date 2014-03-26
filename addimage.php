<?php

//Comment back in to re-enable uploading of records
include("database.php");

session_start();


$retval = rows_count("radiology_record");
if(isset($_POST['create'])){

	$rid = $retval;
	make_record($retval, $_POST["patient"], $_POST["doctor"], $_POST["rad"], $_POST["test_type"], $_POST["pers_date"], $_POST["test_date"], $_POST["diag"], $_POST["desc"]);

}

/*else*/if($_POST['upload']){

	if($_FILES['file']['error'][0] > 0){
		echo "Error: ".$_FILES["file"]["error"][0]."<br>";
	} else{
		$file = $_FILES['file'];

		// if(!$source_image = imagecreatefromjpeg($file['tmp_name'][0])){
		// 	echo "failed";
		// }

		// $width = imagesx($source_image);
		// $height = imagesy($source_image);

		// $desired_width = 100;

		// $desired_height = floor($height * ($desired_width / $width));

		// $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

		// imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
		// header("Content-Type:image/jpeg");
		// imagejpeg($virtual_image);

		add_image($file, 0);
	
	}
} else{

?>
<html>
<head>
	<LINK rel="stylesheet" type="text/css" href="style.css">
	</head>
</head>
<body>
	<div class="center">
		<form name="addimage" method="post" action="addimage.php" enctype="multipart/form-data">
			<input type="file" name="file[]"/>
			<input type="submit" name="upload"/>
		</form>
	</div>
</body>
</html>

<?php } ?>