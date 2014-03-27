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
	$sql_string_good = $sql_string_good.") SCORE,RECORD_ID,PATIENT_ID,DOCTOR_ID,RADIOLOGIST_ID,TEST_TYPE,PRESCRIBING_DATE,TEST_DATE,DIAGNOSIS,DESCRIPTION from persons, radiology_record where person_id=patient_id and ";	
	
	//if ($_POST['StartDate'])
	
	$sql_string_good = $sql_string_good."(";
	
	if ($_POST['sorting'] == "relevant"){ $sql_string_good2 = $sql_string_good2.") order by SCORE desc";}
	else if ($_POST['sorting'] == "td_desc"){ $sql_string_good2 = $sql_string_good2.") order by TEST_DATE desc";}
	else if ($_POST['sorting'] == "td_asc"){ $sql_string_good2 = $sql_string_good2.") order by TEST_DATE asc";}
	else if ($_POST['sorting'] == "pd_desc"){ $sql_string_good2 = $sql_string_good2.") order by PRESCRIBING_DATE desc";}
	else if ($_POST['sorting'] == "pd_asc"){ $sql_string_good2 = $sql_string_good2.") order by PRESCRIBING_DATE asc";}
	
	$sql = $sql_string_good.$sql_string_good2;

	$conn = connect();
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

		$count = 0;
		while ($row = oci_fetch_assoc($statement)) {
			$ret[$count] = $row;
			$count = $count+1;
			}
			return $ret;
	}
	oci_free_statement($statement);
	oci_close($conn);
}

function query_images (){
	$conn = connect();
	//$sql = 
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

		$count = 0;
		while ($row = oci_fetch_assoc($statement)) {
			$ret[$count] = $row;
			$count = $count+1;
			}
			return $ret;
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

if(!isset($_SESSION['date_ranges'])){
	$_SESSION['date_ranges']=1;
	}
	
if(isset($_POST['search'])){
	$search_string = (explode('and',strtolower(trim($_POST['keywords']))));
	$_SESSION['date_ranges']=1;
	
	//$s_date = "TO_DATE('".$_POST['StartDate']."', 'YYYY-MM-DD' )";
	//$e_date = "TO_DATE('".$_POST['EndDate']."', 'YYYY-MM-DD' )";
	$ret = query_search($search_string);
	
	
} 
if(isset($_POST['add_dates'])){
	$_SESSION['date_ranges'] =$_SESSION['date_ranges']+1;
}	
	
else{  }

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
      Sort By: <select name="sorting">
						<option value="relevant">Most Relevant</option>
      				<option value="td_desc">Test Date descending</option>
      				<option value="td_asc">Test Date ascending</option>
      				<option value="pd_desc">Prescribing Date descending</option>
      				<option value="pd_asc">Prescribing Date ascending</option>
      </select><br>
		<input type="submit" name="add_dates" value="Add Date Range"><br>
      <?php
      for ($i=0; $i<$_SESSION['date_ranges']; $i++){
			echo 'Start Date: <input type="date" name="StartDate'.$i.'"><br> End Date: <input type="date" name="EndDate'.$i.'"><br>';
      	}
      ?>
      <!--Start Date: <input type="date" name="StartDate"><br>
      End Date: <input type="date" name="EndDate"><br> -->
      
      <input type="submit" name="search" value="Search"><br>
      
    </form>
  </div>
</body>
<?php if(isset($_POST['search'])){ ?>
<table width="100%">
	<tr>
	<th>Record ID</th>
	<th>Patient ID</th>
	<th>Doctor ID</th>
	<th>Radiologist ID</th>
	<th>Test Type</th>
	<th>Prescribing Date</th>
	<th>Test Date</th>
	<th>Diagnosis</th>
	<th>Prescribing Date</th>
	</tr>
<?php 
foreach ($ret as $row){
	echo "<tr>";
	foreach ($row as $key => $item){
		if ($key != "SCORE"){
			echo "<th> ".$item." </th>";
		}
	}
	echo "</tr>";
}
	?>
</table>
<?php } ?>
</html>














