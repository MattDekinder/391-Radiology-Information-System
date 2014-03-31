<?php
//ini_set('display_errors',1); 
//error_reporting(E_ALL);

include('database.php');

if(isset($_POST['sub'])){
	if (isset($_POST['diagnosis'])){
	$sql = "select first_name,last_name,address,email,phone,diagnosis,max(test_date) from  persons,radiology_record where diagnosis like '".$_POST['diagnosis']."' and person_id = patient_id";
		
	if(!empty($_POST['s_date'])){
		$sql = $sql." and test_date >= TO_DATE('".$_POST['s_date']."','YYYY-MM-DD')";
	}
	
	if(!empty($_POST['e_date'])){
		$sql = $sql." and test_date <= TO_DATE('".$_POST['e_date']."','YYYY-MM-DD')";
	}
	$sql = $sql." group by (first_name,last_name,address,email,phone,diagnosis)";
	
	$ret = query_search_exec($sql);
	
	}
	else {
		echo 'please fill in a search parameter'; 
	}	
}

if(isset($_POST['back'])){
	//header("Location: http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/search.php");
	header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/search.php");
}
?>

<html>
<head>
	<LINK rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="center">
			<form action="report.php" method="post">
				<label>Start Date: </label>
				<input type="date" name="s_date"> 
				<label>End Date: </label>
				<input type="date" name="e_date"> 
				<label>Diagnosis </label>
				<input type="text" name="diagnosis"> 
				<input type="submit" name="sub">
				<input type="submit" name="back" value="Back">
			</form>
		</div>
		<div id="space"></div>
		</body>
		
<?php if(isset($_POST['diagnosis'])){ ?>
<table width="100%">
	<tr>
		<th>First Name</th>
		<th>Last Name</th>
		<th>Address</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Diagnosis</th>
		<th>Date First Diagnosed</th>
	</tr>
	<?php 
	foreach ($ret as $row){
		echo "<tr>";
		foreach ($row as $key => $item){
			echo "<th> ".$item." </th>";
		}
		echo "</tr>";
	}
	?>
</table>
<?php } ?>
</html>
		