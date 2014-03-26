<?php
include("database.php");

ini_set('display_errors',1); 
error_reporting(E_ALL);

$conn = connect();
$sql = "select record_id, regular_size as f from pacs_images where image_id='0'";


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
header("Content-Type: image/jpeg");
echo $data;
?>

<html>
<body>
</body>
</html>