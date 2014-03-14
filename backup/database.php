<?php
function connect(){

	//Connects to my Orricle username
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
?>