<?php
include("database.php");

if(isset($_GET['id'])){

	$conn = connect();
	$sql = "select thumbnail as F from pacs_images where image_id='".$_GET['id']."'";
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
		echo $err['message'];
		oci_close($conn);
		return FALSE;
	}

	$row = oci_fetch_array($statement);
	$blob = $row['F'];

	$data = $blob->load();
	echo $data;
}
?>