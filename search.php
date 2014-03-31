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

if(!empty($_POST['StartDate'])){
	$sql_string_good = $sql_string_good."(PRESCRIBING_DATE>="."TO_DATE('".$_POST['StartDate']."', 'YYYY-MM-DD' )"." or TEST_DATE>="."TO_DATE('".$_POST['StartDate']."', 'YYYY-MM-DD' )".") and ";
}

if(!empty($_POST['EndDate'])){
	$sql_string_good = $sql_string_good."(PRESCRIBING_DATE<="."TO_DATE('".$_POST['EndDate']."', 'YYYY-MM-DD' )"." or TEST_DATE<="."TO_DATE('".$_POST['EndDate']."', 'YYYY-MM-DD' )".") and ";
}

$sql_string_good = $sql_string_good."(";
	
	if ($_POST['sorting'] == "relevant"){ $sql_string_good2 = $sql_string_good2.") order by SCORE desc";}
else if ($_POST['sorting'] == "td_desc"){ $sql_string_good2 = $sql_string_good2.") order by TEST_DATE desc";}
else if ($_POST['sorting'] == "td_asc"){ $sql_string_good2 = $sql_string_good2.") order by TEST_DATE asc";}
else if ($_POST['sorting'] == "pd_desc"){ $sql_string_good2 = $sql_string_good2.") order by PRESCRIBING_DATE desc";}
else if ($_POST['sorting'] == "pd_asc"){ $sql_string_good2 = $sql_string_good2.") order by PRESCRIBING_DATE asc";}

$sql = $sql_string_good.$sql_string_good2;
return $sql;
}

function query_images ($id){
	$conn = connect();
	$ret_img;
	$sql = "select IMAGE_ID from PACS_IMAGES where RECORD_ID='".$id."'";
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
		oci_fetch_all($statement,$ret_img);	
	}
	oci_free_statement($statement);
	oci_close($conn);
	return $ret_img;
}


//ini_set('display_errors',1);
include('database.php');
session_start();

// Security is defined in the following code: first, an sql query is generated. Then the query is wrapped in a security query and executed

if(isset($_POST['search'])){
	$search_string = (explode('and',strtolower(trim($_POST['keywords']))));
	$SQL_String = query_search($search_string);
					 //echo $_SESSION['CLASS']."<br>";
               // echo $_SESSION['PERSON_ID']."<br>";

	if($_SESSION['CLASS']=='a') {
					//administrators have no security on searches
		$ret = query_search_exec($SQL_String);

	}

	if($_SESSION['CLASS']=='p') {
		$SQL_String = "select SCORE,RECORD_ID,PATIENT_ID,DOCTOR_ID,RADIOLOGIST_ID,TEST_TYPE,PRESCRIBING_DATE,TEST_DATE,DIAGNOSIS,DESCRIPTION from (".$SQL_String.") where PATIENT_ID ='".$_SESSION['PERSON_ID']."'";
		$ret = query_search_exec($SQL_String);
	}

	if($_SESSION['CLASS']=='r') {
		$SQL_String = "select SCORE,RECORD_ID,PATIENT_ID,DOCTOR_ID,RADIOLOGIST_ID,TEST_TYPE,PRESCRIBING_DATE,TEST_DATE,DIAGNOSIS,DESCRIPTION from (".$SQL_String.") where RADIOLOGIST_ID ='".$_SESSION['PERSON_ID']."'";
		$ret = query_search_exec($SQL_String);
	}

	if($_SESSION['CLASS']=='d') {
		$SQL_String = "select SCORE,RECORD_ID,s.PATIENT_ID,s.DOCTOR_ID,RADIOLOGIST_ID,TEST_TYPE,PRESCRIBING_DATE,TEST_DATE,DIAGNOSIS,DESCRIPTION from (".$SQL_String.") s join FAMILY_DOCTOR d on s.PATIENT_ID=d.PATIENT_ID where d.DOCTOR_ID ='".$_SESSION['PERSON_ID']."'";
		$ret = query_search_exec($SQL_String);
	}

} 

else{  }

	?>

<html>
<head>
	<title>Radiology Search</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <a href="search.html"target="_blank">Help</a>
	<div id="topbar">
		<label><?php echo $_SESSION['FIRST_NAME']." "; echo $_SESSION['LAST_NAME']; ?></label>
		<label id="uname">(<?php echo $_SESSION['USER_NAME'] ?>)</label>
	</div>
	<div id="space"></div>
	<div class="center">
		<form name="logout" method="post" action="login.php" id="logout">
			<input type="submit" name="logout" value="Logout">
		</form>
<!--             	<?php if($_SESSION['CLASS'] == 'r') { ?>
            		<form action="http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/upload.php">
            			<input type="submit" value="Upload">
            		</form>
            	<?php }?>
            	<?php if($_SESSION['CLASS'] == 'a') { ?>
            		<form action="http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/manage.php">
            			<input type="submit" value="User Management">
            		</form>
            		<form action="http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/data.php">
            			<input type="submit" value="Data Analysis">
            		</form>
            		<form action="http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/report.php">
            			<input type="submit" value="Report Generate">
            		</form>
            		<?php }?> -->
            		<?php if($_SESSION['CLASS'] == 'r') { ?>
            		<form action="upload.php">
            			<input type="submit" value="Upload">
            		</form>
            		<?php }?>
            		<?php if($_SESSION['CLASS'] == 'a') { ?>
            		<form action="manage.php">
            			<input type="submit" value="User Management">
            		</form>
            		<form action="data.php">
            			<input type="submit" value="Data Analysis">
            		</form>
            		<form action="report.php">
            			<input type="submit" value="Report Generate">
            		</form>
            		<?php }?>
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
            		Start Date: <input type="date" name="StartDate"><br>
            		End Date: <input type="date" name="EndDate"><br>

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
        		<th>Description</th>
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
        		$images = query_images($row['RECORD_ID']);
        		if(!empty($images)){
        			echo "<tr>";
        			foreach ($images as $col){
        				foreach ($col as $img){
        					echo "<th>";
        					echo '<p> <a href="image_reg.php?id='.$img.'"target="_blank">';
        					echo '<img src="thumb.php?id='.$img.'">';
        					echo "</a> </p> </th>";

        				}
        			}
        			echo "</tr>";

        		}
        	}
        	?>
        </table>
        <?php } ?>
        </html>














