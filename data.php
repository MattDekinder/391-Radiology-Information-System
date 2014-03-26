<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

include('database.php');



if(isset($_POST['sub'])){

	
	if($istime = !empty($_POST['date'])){

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

		echo "Week to week ".$weekd1.' '.$weekdL.'<br>';
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

		echo "Month to month ".$monthd1.' '.$monthdL.'<br>';

	// Is it a leap year (0 or 1)?
		$leap = (int)date("L", $date);

		$dayy1 = date_create_from_format('z Y', strval(0).' '.strval($year));
		$dayyL = date_create_from_format('z Y', '00 '.strval($year+1));

	//First and last day of year inclusive
		$yeard1 = $dayy1->format('Y-m-d');
		$yeardL = $dayyL->format('Y-m-d');

	//Selected period 
		$period = $_POST['period'];

		echo "Year to Year ".$yeard1.' '.$yeardL.'<br>';
	}

	if($istype = !empty($_POST['testt'])){
		$test = $_POST['testt'];
	}

	if($ispat = !empty($_POST['patient'])){
		$patient = $_POST['patient'];
	}
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
					<option value="week">Week</option>
					<option value="month">Month</option>
					<option value="year">Year</option>	
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
						echo '<option value="'.$value['PERSON_ID'].'">'.$value['LAST_NAME'].', '.$value['FIRST_NAME'].'</option>';
					}
					?>
				</select> <br>
				<input type="submit" name="sub">
			</form>
		</div>
	</body>
	</html>
