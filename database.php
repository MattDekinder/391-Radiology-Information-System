<?php
function connect(){

	//Connects to my Oracle username
	$connection = oci_connect('esinglet', 'qwertyuiop1');
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
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
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
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
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
			$err = oci_error($stid);
			echo htmlentities($err['message']);
			oci_close($conn);
			return FALSE;
		}

		$exec = oci_execute($statement);

		if(!$exec){
			$err = oci_error($stid);
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
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
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
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
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
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
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
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
		oci_free_statement($statement);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	oci_free_statement($statement);
	oci_close($conn);
}

function rows_g(){
	$conn = connect();
	$sql = "select count(*) as C from radiology_record";

	if(($statement = oci_parse($conn, $sql)) == false){
		$err = oci_error($stid);
		echo htmlentities($err['message']);
		oci_close($conn);
		return FALSE;
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($stid);
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
?>
