<?php 

function query_search ( $search_string ){
	$c = 1;
	$sql_string_good = "select (";
	$sql_string_good2 = "";
	foreach ($search_string as $key){
		
		$sql_string1 = "(6*(score(".$c.")+score(".($c+1).")))+score(".($c+2).")+(3*score(".($c+3)."))";
		if ($sql_string_good == "select ("){
		$sql_string_good = $sql_string_good.$sql_string1;
		}
		else{$sql_string_good = $sql_string_good."+".$sql_string1;
		}
		
		$sql_string2 = "CONTAINS(FIRST_NAME,"."'".$key."'".",".$c.") > 0 or CONTAINS(LAST_NAME,"."'".$key."'".",".($c+1).") > 0 or CONTAINS(DESCRIPTION, "."'".$key."'".",".($c+2).") > 0 or CONTAINS(DIAGNOSIS, "."'".$key."'".",".($c+3).") >0";
		if ($sql_string_good2 == ""){
		$sql_string_good2 = $sql_string_good2.$sql_string2;
		}
		else{ $sql_string_good2 = $sql_string_good2." or ".$sql_string2;
		}
		$c = ($c+4);
	}
	$sql_string_good = $sql_string_good.") SCORE,RECORD_ID,PATIENT_ID,DOCTOR_ID,RADIOLOGIST_ID,TEST_TYPE,PRESCRIBING_DATE,TEST_DATE,DIAGNOSIS,DESCRIPTION from persons, radiology_record where person_id=patient_id and (";	
	$sql_string_good2 = $sql_string_good2.")";

	$sql = $sql_string_good.$sql_string_good2;

	$conn = connect();
//	$sql = "select (6*(score(1)+score(2)))+score(3)+(3*score(4)),RECORD_ID,PATIENT_ID,DOCTOR_ID,RADIOLOGIST_ID,TEST_TYPE,PRESCRIBING_DATE,TEST_DATE,DIAGNOSIS,DESCRIPTION from persons, radiology_record where person_id=patient_id and (CONTAINS(FIRST_NAME,"."'".$key."'".",1) > 0 or CONTAINS(LAST_NAME,"."'".$key."'".", 2) > 0 or CONTAINS(DESCRIPTION, "."'".$key."'".",3) > 0 or CONTAINS(DIAGNOSIS, "."'".$key."'".",4) >0 )";
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

		while ($row = oci_fetch_assoc($statement)) {
			echo $row['SCORE'];
			echo '<br>';
			}
	}
	oci_free_statement($statement);
	oci_close($conn);
}

ini_set('display_errors',1);
include('database.php');
session_start();
/*if(isset($_SESSION['USER_NAME'])){
                echo $_SESSION['USER_NAME']."<br>";
                echo $_SESSION['CLASS']."<br>";
                echo $_SESSION['PERSON_ID']."<br>";
                echo $_SESSION['FIRST_NAME']."<br>";
                echo $_SESSION['LAST_NAME']."<br>";
                echo $_SESSION['ADDRESS']."<br>";
                echo $_SESSION['EMAIL']."<br>";
                echo $_SESSION['PHONE']."<br>";
        }*/
//TODO: create security for classes and add dates to search. (for now administrator is assumed)


	
if(isset($_POST['search'])){
	$search_string = (explode('and',strtolower(trim($_POST['keywords']))));
	
	query_search($search_string);
	
	} else{
		
	}

?>

<html>
<head>

  <title>Radiology Search</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
  <div id="topbar">
    <label><?php echo $_SESSION['FIRST_NAME']." "; echo $_SESSION['LAST_NAME']; ?></label>
    <label id="uname">(<?php echo $_SESSION['USER_NAME'] ?>)</label>
  </div>
  
  <div id="space"></div>

  <div class="center">
    <h1 class="header">Radiology Search</h1>

    <form name="search" method="post" action="search.php" id="search">
      Search : <input type="text" name="keywords"><br>
      Start Date: <input type="date" name="date"><br>
      End Date: <input type="date" name="date"><br>
      <input type="submit" name="search" value="Search"><br>
    </form>
  </div>
</body>
</html>
