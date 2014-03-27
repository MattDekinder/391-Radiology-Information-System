<?php
function connect(){

	//Connects to my Oracle username
	$connection = oci_connect('dekinder', 'qwertyuiop1');
	if (!$connection) {

		//Gets last error array
		$e = oci_error();

		//Triggers error with HTML safe error message. 
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	return $connection;
}

function query_login($user, $pass){
	$conn = connect();
	$sql = "select * from users u join persons p on u.person_id=p.person_id where user_name='".$user."' and password='".$pass."'";
	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		return FALSE;
	} else{

		//Fetches all 
		$row = oci_fetch_assoc($statement);
		if (!$row){ //No results, user/pass pair invalid
			$ret['valid'] = FALSE;
			$ret['info'] = NULL;
		} else{
			$ret['valid'] = TRUE;
			$ret['info'] = $row;
		}
	} 

	oci_free_statement($statement);
	oci_close($conn);

	return $ret;
}

function query_password_change($user, $oldpass, $newpass){
	$conn = connect();
	$sql = "select * from users where user_name='".$user."' and password='".$oldpass."'";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	} else{

		$row = oci_fetch_assoc($statement);
		if (!$row){ //No results, user/pass pair invalid
			$valid = FALSE;
		} else{
			$valid = TRUE;
		}
	}

	oci_free_statement($statement);

	if($valid){
		$sql = "update users set password='".$newpass."' where user_name='".$user."'";
		if(($statement = oci_parse($conn, $sql)) == false){
			$err = oci_error($statement);
			echo htmlentities($err['message']);
			oci_close($conn);
			return FALSE;
		}

		$exec = oci_execute($statement);

		if(!$exec){
			$err = oci_error($statement);
			oci_free_statement($statement);
			echo htmlentities($err['message']);
			oci_close($conn);
			return FALSE;
		} 
		oci_free_statement($statement);
		oci_close($conn);
		return TRUE;
	} else{
		oci_close($conn);
		return FALSE;
	} 
}

function get_patients(){
	$conn = connect();
	$sql = "select u.person_id, first_name, last_name from persons p join users u on p.person_id=u.person_id where u.CLASS='p'";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$count = 0;

	while($row = oci_fetch_assoc($statement)){
		$ret[$count] = $row;
		$count = $count + 1; 
	}
	oci_free_statement($statement);
	oci_close($conn);
	return $ret;
}

function get_doctors(){
	$conn = connect();
	$sql = "select u.person_id, first_name, last_name from persons p join users u on p.person_id=u.person_id where u.CLASS='d'";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$count = 0;

	while($row = oci_fetch_assoc($statement)){
		$ret[$count] = $row;
		$count = $count + 1; 
	}
	oci_free_statement($statement);
	oci_close($conn);
	return $ret;
}

function get_radiolog(){
	$conn = connect();
	$sql = "select u.person_id, first_name, last_name from persons p join users u on p.person_id=u.person_id where u.CLASS='r'";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$count = 0;

	while($row = oci_fetch_assoc($statement)){
		$ret[$count] = $row;
		$count = $count + 1; 
	}
	oci_free_statement($statement);
	oci_close($conn);
	return $ret;
}

function make_record($id, $patient, $doctor, $rad, $type, $p_date, $t_date, $diag, $desc){
	$conn = connect();
	$sql = "insert into radiology_record values (".(string)$id.", ".(string)$patient.", ".(string)$doctor.", ".(string)$rad.", '".(string)$type."', TO_DATE('".(string)$p_date."', 'YYYY-MM-DD'), TO_DATE('".(string)$t_date."', 'YYYY-MM-DD'), '".(string)$diag."', '".(string)$desc."')";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	oci_free_statement($statement);
	oci_close($conn);
}

function rows_count($table){
	$conn = connect();
	$sql = "select count(*) as C from ".$table;//radiology_record

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$row = oci_fetch_assoc($statement);
	
	$ret = $row['C'];

	oci_free_statement($statement);
	oci_close($conn);

	return $ret;
}

function add_image($file, $rid){

	//Image id for the new image
	$iid = rows_count('pacs_images');

	$conn = connect();
	$sql = "insert into pacs_images (record_id, image_id, thumbnail, regular_size, full_size) VALUES(0, 0, empty_blob(), empty_blob(), empty_blob()) RETURNING thumbnail, regular_size, full_size into :tn, :rs, :fs";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		echo 'fail';
		return FALSE;
	}
	
	$full_size = oci_new_descriptor($conn, OCI_DTYPE_LOB);
	$regular_size = oci_new_descriptor($conn, OCI_DTYPE_LOB);
	$thumbnail = oci_new_descriptor($conn, OCI_DTYPE_LOB);

	if(!$full_size || !$regular_size || !$thumbnail){
		echo "FAILFAILFIAL <br>";
	}

	oci_bind_by_name($statement, ":fs", $full_size, -1, OCI_B_BLOB);
	oci_bind_by_name($statement, ":rs", $regular_size, -1, OCI_B_BLOB);
	oci_bind_by_name($statement, ":tn", $thumbnail, -1, OCI_B_BLOB);

	$exec = oci_execute($statement, OCI_DEFAULT);

	if(!$exec){
		$err = oci_error($statement);
		oci_free_statement($statement);
		echo $err['message'];
		oci_close($conn);
		return FALSE;
	}

	$file = fopen($file["tmp_name"][0], 'r');
	$image_binary = fread($file, 100000);

	$image = imagecreatefromstring($image_binary);

	//Thumbnail
	$width = imagesx($image);
	$height = imagesy($image);

	$thumb_width = 50;
	$thumb_height = floor($height * ($thumb_width / $width));

	$reg_width = ((400 < $width) ? 400 : $width);
	$reg_height = floor($height * ($reg_width / $width));

	$thumbnail = imagecreatetruecolor($thumb_width, $thumb_height);
	$regular = imagecreatetruecolor($reg_width, $reg_height);


	imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height);
	imagecopyresampled($regular, $image, 0, 0, 0, 0, $reg_width, $reg_height, $width, $height);

	ob_start();
	imagejpeg($thumbnail);
	$thumbnail_binary = ob_get_contents();
	ob_end_clean();

	ob_start();
	imagejpeg($regular);
	$reg_binary = ob_get_contents();
	ob_end_clean();

	

	if(!$full_size->save($image_binary)) {
		oci_rollback($conn);
	}
	else {
		oci_commit($conn);
	}

	oci_close($conn);
	oci_free_statement($statement);
	}
	?>