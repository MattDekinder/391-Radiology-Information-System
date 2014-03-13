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
	$conn=connect();
	$sql = 'SELECT COUNT(*) count FROM users u WHERE u.user_name=\''.$user.'\' AND u.password=\''.$pass.'\'';

	if(($statement = oci_parse($conn, $sql)) == FALSE){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
	}

	$exec = oci_execute($statement);

	if(!$exec){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
	} else{

		//Fetches all 
		$row = array();
		$row = oci_fetch_row($statement);

		$count = $row[0];

		if($count==0){
			$ret =  0;
		} elseif($count > 0){
			$ret = 1;
		}
	}

	oci_close($conn);
	return $ret;
}
function query_register($user, $pass){
	$conn=connect();
	$sql = 'SELECT COUNT(*) count FROM users u WHERE u.user_name=\''.$user.'\' AND u.password=\''.$pass.'\'';
	INSERT INTO users VALUES ($user, $pass, NULL, )

	if(($statement = oci_parse($conn, $sql)) == FALSE){
		$err = oci_error($statement);
		echo htmlentities($err['message']);
	}

}
?>