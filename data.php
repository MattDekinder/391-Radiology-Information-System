<?php
ini_set('display_errors',1); 
error_reporting(E_ALL);

include('database.php');



if(isset($_POST['sub'])){

	
	if(($isdate = !empty($_POST['date']) ) ){

		echo "date";

		$d = $_POST['date'];

		$duedt = explode("-", $d);
		$date  = mktime(0, 0, 0, $duedt[1], $duedt[2], $duedt[0]);
		$dayy  = (int)date('z', $date);
	//The search year
		$year = (int)date('Y', $date);

	//The day in letters
		$day_nice = (int)date('D', $date);
	//The day in numbers
		$day_nice_num = (int)date('d', $date);

	//Week number
		$week_num = (int)date('W', $date);

	//Sets to nerest lower sunday
		$dayw = $dayy - (int)date('w', $date);

		$sunday1 = date_create_from_format('z Y', strval($dayw).' '.strval($year));
		echo $dayw;
		if($dayw >= 0){
			$sunday1 = date_create_from_format('z Y', strval($dayw).' '.strval($year));
			$day = date_create_from_format('z Y', strval($dayw).' '.strval($year));
		} else{
			$dayw = 365+$dayw;
			$sunday1 = date_create_from_format('z Y', strval($dayw).' '.strval($year));
			$day = date_create_from_format('z Y', strval($dayw).' '.strval($year-1));
		}

		$sunday2 = $day->add(date_interval_create_from_date_string('7 days'));



	//First and last day of week inclusive
		$weekd1 =  $sunday1->format('Y-m-d');
		$weekdL =  $sunday2->format('Y-m-d');

		$monthy = (int)date('m', $date);
		$monthd = (int)date("t", $date);

		$daym1 = date_create_from_format('z m Y', "00 ".strval($monthy).' '.strval($year));
		$daymL = date_create_from_format('z m Y',  strval($monthd-1)." ".strval($monthy).' '.strval($year));

	//First and last day of month inclusive
		$monthd1 = $daym1->format('Y-m-d');
		$monthdL = $daymL->format('Y-m-d');

		$leap = (int)date("L", $date);

		$dayy1 = date_create_from_format('z Y', strval(0).' '.strval($year));
		$dayyL = date_create_from_format('z Y', '00 '.strval($year+1));


	//First and last day of year inclusive
		$yeard1 = $dayy1->format('Y-m-d');
		$yeardL = $dayyL->format('Y-m-d');

		$period = $_POST['period'];

	}
	
	if( ($istest = !empty($_POST['testt']) ) ){
		echo "test";
	}

	if( ($ispat = !empty($_POST['patient'])) ){
		echo "patient";
	}

	$sql = "select count(*) from radiology_record ";

	if($isdate || $istest || $ispat){
		$sql.='where ';
	}

	if($isdate){
		switch ((int)$period){
			case 0: //week
			$sql.='';
			echo "The ".$week_num."th week of ".$year.".";
			break;
			case 1: //month
			$sql.='';
			echo "month";
			break;
			case 2: //year
			$sql.='';
			echo "year";
			break;

		}
	}

	if($istest){
		$sql.='';
	}

	if($ispat){
		$sql.='';
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
					<option value="0">Week</option>
					<option value="1">Month</option>
					<option value="2">Year</option>	
				</select><br>
				<label>Test Type: </label>
				<select name="testt">
					<option value=""></option>
					<?php
					//$types = get_test_types();
					foreach ($types as $key => $value) {
						echo '<option value="'.$value.'">'.$value.'</option>';
					}
					?>
				</select> <br>
				<label>Patient: </label>
				<select name="patient">
					<option value=""></option>
					<?php
					//$patients = get_patients();
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
