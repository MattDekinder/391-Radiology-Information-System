<?php
include("database.php");
if(isset($_POST['create'])){
	make_record(7, $_POST["patient"], $_POST["doctor"], $_POST["rad"], $_POST["test_type"], $_POST["pers_date"], $_POST["test_date"], $_POST["diag"], $_POST["desc"]);
}
?>
<html>
<body>
</body>
</html>