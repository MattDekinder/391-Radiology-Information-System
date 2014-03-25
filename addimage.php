<?php
include("database.php");

session_start();


$retval = rows_count();
if(isset($_POST['create'])){

	make_record($retval, $_POST["patient"], $_POST["doctor"], $_POST["rad"], $_POST["test_type"], $_POST["pers_date"], $_POST["test_date"], $_POST["diag"], $_POST["desc"]);

}
?>
<html>
<body>
<?php echo "Retval: ".$retval; ?>
</body>
</html>