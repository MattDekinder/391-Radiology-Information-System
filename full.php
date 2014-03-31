<?php
/*
Simple script that takes an image id using the GET protocol and returns the full size image. For
use in <img> tags in html.
*/
include("database.php");

if(isset($_GET['id'])){

	$conn = connect();
	$sql = "select full_size as F from pacs_images where image_id='".$_GET['id']."'";
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