<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

include('database.php');

//Go to search.php upon pressing of the 'back' button
if(isset($_POST['back'])){
	header("Location: http://consort.cs.ualberta.ca/~dekinder/website/391-Radiology-Information-System/search.php");
}

//true if a count is returned. 
$return = false;

// Not blank (indicates at least one search field is present)
$nblank = false;

//Indicates a re-query for a different time period
$reop = false;

$count = 0;

$start = '';
$end = '';

if(isset($_POST['sub'])){

	// Logic executed if a date range is set
	if($isdate = !empty($_POST['date'])){

	// The posted html date ("YYYY-MM-DD")
		$d = $_POST['date'];

	// Explodes date into array of (year, month, day)
		$date_array = explode("-", $d);

	// Creates a date indicating the selected day
		$date  = mktime(0, 0, 0, $date_array[1], $date_array[2], $date_array[0]);

	// Day of year (0-365) of the selected date
		$day_of_year  = (int)date('z', $date);

	//4 digit year of selected date
		$year = (int)date('Y', $date);

	// Day of week (0-sunday to 6-saturday) of selected date
		$dayw = $day_of_year - (int)date('w', $date);

	// The first sunday coming BEFORE the current date
		$sunday1 = date_create_from_format('z Y', strval($dayw).' '.strval($year));

	//The sunday 7 days later (the next sunday)
		$day = date_create_from_format('z Y', strval($dayw).' '.strval($year));
		$sunday2 = $day->add(date_interval_create_from_date_string('7 days'));

	//$sunday1 to $sunday2 is one week.

	// First and last day of week inclusive, indicated as "YYYY-MM-DD"
		$weekd1 =  $sunday1->format('Y-m-d');
		$weekdL =  $sunday2->format('Y-m-d');

	// Selected month of year (01-12)
		$month_of_y = (int)date('m', $date);

	// Number of days in the selected month.
		// $month_days = (int)date("t", $date);

	// First day of the selected month
		$daym1 = date_create_from_format('d m Y', "01 ".strval($month_of_y).' '.strval($year));

		//Logic dealing with wraping around to the next year.
		if($month_of_y == 12){
			$daymL = date_create_from_format('d m Y', "01 ".strval(1).' '.strval($year+1));
		} else{
			$daymL = date_create_from_format('d m Y', "01 ".strval($month_of_y+1).' '.strval($year));
		}


	//First and last day of month inclusive, indicated as "YYYY-MM-DD"
		$monthd1 = $daym1->format('Y-m-d');
		$monthdL = $daymL->format('Y-m-d');

	// First day of the year
		$dayy1 = date_create_from_format('z Y', '00 '.strval($year));

	// Exactly one year later.
		$dayyL = date_create_from_format('z Y', '00 '.strval($year+1));

	//First and last day of year inclusive, indicated as "YYYY-MM-DD"
		$yeard1 = $dayy1->format('Y-m-d');
		$yeardL = $dayyL->format('Y-m-d');

	//Selected period (week, month, year)
		$period = $_POST['period'];

	// Selected date type (test date, or perscription date)
		$dtype = $_POST['date_type'];

	}

	// Logic executed if a specific test type is set
	if($istype = !empty($_POST['testt'])){
		$test = $_POST['testt'];
	}

	// Logic executed is a patient is selected
	if($ispat = !empty($_POST['patient'])){
		$patient = $_POST['patient'];

	//$patient contains information seperated by commas, expload toget it. 
		$patient_array = explode(",", $patient);

	// Selected patient id
		$patient_id = $patient_array[0];

	// Selected patient last name
		$plast = $patient_array[1];

	// Selected patient first name
		$pfirst = $patient_array[2];
	}

	// The base query. 
	$sql = "select count(*) as C from radiology_record ";


	// If there are further stipulations then a where clause is needed.
	if($nblank = ($isdate || $istype || $ispat)){
		$sql .= 'where ';
	}

	// If there is a date range selected
	if($isdate){

		// The date values of the query depend on the period (week, month, or year)
		switch((int)$period){
			case 0: // Week

			// The dates are left blank with the stand in "?----?" to be filled with the date before execution
			if($dtype){ // Perscribing date
				$sql .= "prescribing_date >= TO_DATE('?----?', 'YYYY-MM-DD') and prescribing_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			} else{  //test date
				$sql .= "test_date >= TO_DATE('?----?', 'YYYY-MM-DD') and test_date < TO_DATE('?----?', 'YYYY-MM-DD') ";
			}

			// The start and end dates to be passed in. 
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

		// If there are yet more parameters we need to add an and
		if($istype || $ispat){
			$sql .= "and ";
		}
	}

	// If there is a specified test type. 
	if($istype){

		// Add the test stipulation
		$sql .= "test_type = '".$test."' ";

		// If a patient is yet to be added we need an and
		if($ispat){
			$sql .= "and ";
		}
	}

	// If there is a patient the stipulation must be added to the query. 
	if($ispat){
		$sql .= "patient_id='".$patient_id."' ";
	}

	// If there is a date to be specified, we say as such to the query executing function and pass in the dates
	if($isdate){
		$count = exec_count($sql, 1, $start, $end);
	} else {
		$count = exec_count($sql, 0,0,0);
	}

	// We have a count
	$return = true;
	
// We are re-querying with a week period
} elseif(isset($_POST['week'])){

	// Reloads the query (with '?----?' in place of date)
	$sql = stripslashes($_POST['query']);

	$count = exec_count($sql, 1, stripslashes($_POST["weekd1"]), stripslashes($_POST["weekdL"]));

	// The string to display is $s1
	$s = stripslashes($_POST["s1"]);

	// We are reoperating, returning a count, and there is a specified date.
	$reop = true;
	$return = true;
	$isdate = true;

	// The possiable display strings reloaded
	$s1 = stripslashes($_POST['s1']);
	$s2 = stripslashes($_POST['s2']);
	$s3 = stripslashes($_POST['s3']);

	// The dates reloaded
	$weekd1 = stripslashes($_POST["weekd1"]);
	$weekdL = stripslashes($_POST["weekdL"]);
	$monthd1 = stripslashes($_POST["monthd1"]);
	$monthdL = stripslashes($_POST["monthdL"]);
	$yeard1 = stripslashes($_POST["yeard1"]);
	$yeardL = stripslashes($_POST["yeardL"]);

	// The period is 'week'
	$period = "0";


// We are re-querying with a month period
} elseif(isset($_POST['month'])){
	$sql = stripslashes($_POST['query']);

	$count = exec_count($sql, 1, stripslashes($_POST["monthd1"]), stripslashes($_POST["monthdL"]));

	// The string to display is $s2
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

	// The period is 'month'
	$period = "1";

// We are re-querying with a year period
} elseif(isset($_POST['year'])){

	$sql = stripslashes($_POST['query']);

	$count = exec_count($sql, 1, stripslashes($_POST["yeard1"]), stripslashes($_POST["yeardL"]));

	// The string to display is $s3
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

	// The period is 'year'
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
					// Gets and prints all possiable types into a select statement
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
					// Gets and prints all possiable patients into a select statement
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
		// If there is a count
		if($return){
			echo '<div class="center">';
			
			// If we are not reoperating (drilling up or rowling down) we construct the string from scratch
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
					// Three strings are sonstructed (week, month, and year). We don't need to regenerate on reoperation.
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
				<!-- Hidden metadata to allow for requerying-->
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
