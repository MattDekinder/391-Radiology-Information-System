<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

include('database.php');

if(isset($_POST['back'])){
	header("Location: http://consort.cs.ualberta.ca/~esinglet/website/391-Radiology-Information-System/search.php");
}

$return = false;
$nblank = false;
$reop = false;
$count = 0;

$start = '';
$end = '';

if(isset($_POST['sub'])){

	
	if($isdate = !empty($_POST['date'])){

		$d = $_POST['date'];

		$date_array = explode("-", $d);

		$date  = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);

	// Day of year (0-365)
		$day_of_year  = (int)date('z', $date);

	//4 digit year
		$year = (int)date('Y', $date);

	// Day of week (0-sunday to 6-saturday)
		$dayw = $day_of_year - (int)date('w', $date);

	// The last sunday to have occured
		$sunday1 = date_create_from_format('z Y', strval($dayw).' '.strval($year));

	//The sunday 7 days later
		$day = date_create_from_format('z Y', strval($dayw).' '.strval($year));
		$sunday2 = $day->add(date_interval_create_from_date_string('7 days'));


	//First and last day of week inclusive
		$weekd1 =  $sunday1->format('Y-m-d');
		$weekdL =  $sunday2->format('Y-m-d');


	// Month of year (01-12)
		$month_of_y = (int)date('m', $date);

	// Number of days in the month.
		$month_days = (int)date("t", $date);

	// First day of month
		$daym1 = date_create_from_format('d m Y', "01 ".strval($month_of_y).' '.strval($year));
		if($month_of_y == 12){
			$daymL = date_create_from_format('d m Y', "01 ".strval(1).' '.strval($year+1));
		} else{
			$daymL = date_create_from_format('d m Y', "01 ".strval($month_of_y+1).' '.strval($year));
		}


	//First and last day of month inclusive
		$monthd1 = $daym1->format('Y-m-d');
		$monthdL = $daymL->format('Y-m-d');



		$dayy1 = date_create_from_format('z Y', '00 '.strval($year));
		$dayyL = date_create_from_format('z Y', '00 '.strval($year+1));

	//First and last day of year inclusive
		$yeard1 = $dayy1->format('Y-m-d');
		$yeardL = $dayyL->format('Y-m-d');

	//Selected period 
		$period = $_POST['period'];

		$dtype = $_POST['date_type'];

	// Array to pass around
		// unsset($dates);

		$dates['weekd1'] = $weekd1;
		$dates['weekdL'] = $weekdL;
		$dates['monthd1'] = $monthd1;
		$dates['monthdL'] = $monthdL;
		$dates['yeard1'] = $yeard1;
		$dates['yeardL'] = $yeardL;

		$date_data = serialize($dates);

	}

	if($istype = !empty($_POST['testt'])){
		$test = $_POST['testt'];
	}

	if($ispat = !empty($_POST['patient'])){
		$patient = $_POST['patient'];
		$patient_array = explode(",", $patient);
		$patient_id = $patient_array[0];
		$plast = $patient_array[1];
		$pfirst = $patient_array[2];
	}





	$sql = "select count(*) as C from radiology_record ";

	if($nblank = ($isdate || $istype || $ispat)){
		$sql .= 'where ';
	}

	if($isdate){
		switch((int)$period){
			case 0: // Week
			if($dtype){ // Perscribing date
				$sql .= "prescribing_date >= TO_DATE('?----?', 'YYYY-MM-DD') and prescribing_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			} else{  //test date
				$sql .= "test_date >= TO_DATE('?----?', 'YYYY-MM-DD') and test_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			}

			$start = $weekd1;
			$end = $weekdL;

			break;
			case 1: // Month
			if($dtype){ // Perscribing date
				$sql .= "prescribing_date >= TO_DATE('?----?', 'YYYY-MM-DD') and prescribing_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			} else{  //test date
				$sql .= "test_date >= TO_DATE('?----?', 'YYYY-MM-DD') and test_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			}

			$start = $monthd1;
			$end = $monthdL;
			break;
			case 2: // Year
			if($dtype){ // Perscribing date
				$sql .= "prescribing_date >= TO_DATE('?----?', 'YYYY-MM-DD') and prescribing_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			} else{  //test date
				$sql .= "test_date >= TO_DATE('?----?', 'YYYY-MM-DD') and test_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			}

			$start = $yeard1;
			$end = $yeardL;
			break;
		}

		if($istype || $ispat){
			$sql .= "and ";
		}
	}

	if($istype){
		$sql .= "test_type = '".$test."' ";

		if($ispat){
			$sql .= "and ";
		}
	}

	if($ispat){
		$sql .= "patient_id='".$patient_id."' ";
	}


	if($isdate){
		$count = exec_count($sql, 1, $start, $end);
	} else {
		$count = exec_count($sql, 0,0,0);
	}

	$return = true;
	
} elseif(isset($_POST['week'])){

	$sql = stripslashes($_POST['query']);

	$count = exec_count($sql, 1, stripslashes($_POST["weekd1"]), stripslashes($_POST["weekdL"]));

	$s = stripslashes($_POST["s1"]);
	$reop = true;
	$return = true;
	$isdate = true;

	$s1 = stripslashes($_POST['s1']);
	$s2 = stripslashes($_POST['s2']);
	$s3 = stripslashes($_POST['s3']);

	$weekd1 = stripslashes($_POST["weekd1"]);
	$weekdL = stripslashes($_POST["weekdL"]);
	$monthd1 = stripslashes($_POST["monthd1"]);
	$monthdL = stripslashes($_POST["monthdL"]);
	$yeard1 = stripslashes($_POST["yeard1"]);
	$yeardL = stripslashes($_POST["yeardL"]);

	$period = "0";



} elseif(isset($_POST['month'])){
	$sql = stripslashes($_POST['query']);

	$count = exec_count($sql, 1, stripslashes($_POST["monthd1"]), stripslashes($_POST["monthdL"]));
	$s = stripslashes($_POST["s2"]);
	$reop = true;
	$return = true;
	$isdate = true;


	$s1 = stripslashes($_POST['s1']);
	$s2 = stripslashes($_POST['s2']);
	$s3 = stripslashes($_POST['s3']);

	$weekd1 = stripslashes($_POST["weekd1"]);
	$weekdL = stripslashes($_POST["weekdL"]);
	$monthd1 = stripslashes($_POST["monthd1"]);
	$monthdL = stripslashes($_POST["monthdL"]);
	$yeard1 = stripslashes($_POST["yeard1"]);
	$yeardL = stripslashes($_POST["yeardL"]);

	$period = "1";


} elseif(isset($_POST['year'])){

	$sql = stripslashes($_POST['query']);

	$count = exec_count($sql, 1, stripslashes($_POST["yeard1"]), stripslashes($_POST["yeardL"]));

	$s = stripslashes($_POST["s3"]);
	$reop = true;
	$return = true;
	$isdate = true;


	$s1 = stripslashes($_POST['s1']);
	$s2 = stripslashes($_POST['s2']);
	$s3 = stripslashes($_POST['s3']);

	$weekd1 = stripslashes($_POST["weekd1"]);
	$weekdL = stripslashes($_POST["weekdL"]);
	$monthd1 = stripslashes($_POST["monthd1"]);
	$monthdL = stripslashes($_POST["monthdL"]);
	$yeard1 = stripslashes($_POST["yeard1"]);
	$yeardL = stripslashes($_POST["yeardL"]);

	$period = "2";
}
?>
<html>
<head>
	<LINK rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div class="center">
			<form action="data.php" method="post">
				<label>Date: </label>
				<input type="date" name="date"> 
				<select name="period">
					<option value="0">Week</option>
					<option value="1">Month</option>
					<option value="2">Year</option>	
				</select>
				<select name="date_type">
					<option value="0">Test Date</option>
					<option value="1">Prescribing Date</option>
				</select><br>
				<label>Test Type: </label>
				<select name="testt">
					<option value=""></option>
					<?php
					$types = get_test_types();
					foreach ($types as $key => $value) {
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
					?>
				</select> <br>
				<label>Patient: </label>
				<select name="patient">
					<option value=""></option>
					<?php
					$patients = get_patients();
					foreach ($patients as $value) {
						echo '<option value="'.$value['PERSON_ID'].",".$value['LAST_NAME'].",".$value['FIRST_NAME'].'">'.$value['LAST_NAME'].', '.$value['FIRST_NAME'].'</option>';
					}
					?>
				</select> <br>
				<input type="submit" name="sub">
				<input type="submit" name="back" value="Back">
			</form>	
		</div>
		<div id="space"></div>
		
		<?php

		if($return){
			echo '<div class="center">';
			
			if(!$reop){
				$s = "COUNT OF RECORDS";

				if(!$nblank){
					$s.= ": ";
				} else {
					$s .= " ";
				}

				if($istype){
					$s .= "FOR THE TEST TYPE ".$test;
					if($isdate || $ispat){
						$s .= ", ";
					} else{
						$s.=": ";
					}
				}

				if($ispat){
					$s .= "FOR PATIENT ".$pfirst." ".$plast.": ";

					if($isdate){
						$s .= ", ";
					} else{
						$s.=": ";
					}
				}

				if($isdate){
					$s1 = $s."FOR THE WEEK OF ".$weekd1.": "; 
					$s2 = $s."FOR THE MONTH OF ".$monthd1.": ";
					$s3 = $s."FOR THE YEAR OF ".$yeard1.": ";

					switch((int)$period) {
						case 0: // Week
						$s = $s1;
						break;
						case 1: // Month
						$s = $s2;
						break;
						case 2: // Year
						$s = $s3;
						break;
					}
				}

			}

			echo "<label>".$s.$count." RECORD(S) FOUND.</label><br>";
			if($isdate){
				?>
				<form action="data.php" method ='post'>

					<input type="hidden" name="s1" value="<?php echo $s1 ?>">
					<input type="hidden" name="s2" value="<?php echo $s2 ?>">
					<input type="hidden" name="s3" value="<?php echo $s3 ?>">

					<input type="hidden" name="weekd1" value="<?php echo $weekd1 ?>">
					<input type="hidden" name="weekdL" value="<?php echo $weekdL ?>">
					<input type="hidden" name="monthd1" value="<?php echo $monthd1 ?>">
					<input type="hidden" name="monthdL" value="<?php echo $monthdL ?>">
					<input type="hidden" name="yeard1" value="<?php echo $yeard1 ?>">
					<input type="hidden" name="yeardL" value="<?php echo $yeardL ?>">

					<input type="hidden" name="query" value="<?php echo $sql ?>">
					<?php
						if((int)$period == 0){ // week
							?>
							<input type="submit" name="month" value="See Month">
							<input type="submit" name="year" value="See Year">
							<?php
						}elseif((int)$period == 1){ // month
							?>
							<input type="submit" name="week" value="See Week">
							<input type="submit" name="year" value="See Year">
							<?php
						} elseif((int)$period == 2){ //Year
							?>
							<input type="submit" name="week" value="See Week">
							<input type="submit" name="month" value="See Month">
							<?php
						}
						?>
					</form>
					<?php
				}

				echo "</div>";
			} 
			
			?>

		</body>
		</html>
