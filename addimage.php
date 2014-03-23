<?php
include("database.php");
if(isset($_POST['create'])){
	$id = count("radiology_record");
	make_record($id, $_POST["patient"], $_POST["doctor"], $_POST["rad"], $_POST["test_type"], $_POST["pers_date"], $_POST["test_date"], $_POST["diag"], $_POST["desc"]);
}
?>
<html>
<body>
</body>
</html>