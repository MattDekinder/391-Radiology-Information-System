<?php 
include('database.php');
include('date_creater.php');
session_start();
if(isset($_SESSION['USER_NAME'])){
		echo $_SESSION['USER_NAME']."<br>";
		echo $_SESSION['CLASS']."<br>";
		echo $_SESSION['PERSON_ID']."<br>";
		echo $_SESSION['FIRST_NAME']."<br>";
		echo $_SESSION['LAST_NAME']."<br>";
		echo $_SESSION['ADDRESS']."<br>";
		echo $_SESSION['EMAIL']."<br>";
		echo $_SESSION['PHONE']."<br>";
	}
?>

<http>
	<head>
		<title>Radiology Search</title>
		</head>
		<body>
			<h1 class="header">Radiology Search</h1>
			<form name="user_login" method="post" action="search.php">
				Search : <input type="text" name="search"> <br> 
<!-- insert some kind of date picker here-->
				<input type="submit" name="search" value="Search">
				<input type="submit" name="change" value="Change Password">
			</form>
			<?php if($search){ ?>
			<h2>Search Failed!(what does that even mean!! hoq does a search fail.)</h2>
			<?php } ?>

<!-- http://www.phpro.org/examples/Dynamic-Date-Time-Dropdown-List.html -->
<table>
<tr><td>Year</td><td>Month</td><td>Day</td><td>Hour</td><td>Minute</td></tr>
<tr>
<td><?php echo createYears(2000, 2020, 'start_year', 2010); ?></td>

<td><?php echo createMonths('start_month', 4); ?></td>

<td><?php echo createDays('start_day', 20); ?></td>

<td><?php echo createHours('start_hour', 4); ?></td>

<td><?php echo createMinutes('start_minute', 30); ?></td>

<td><?php echo createAmPm('start_ampm', 'am'); ?></td>

</tr>

</table>






<!-- http://stackoverflow.com/questions/18884713/dynamic-drop-down-list-using-html-and-php 

This method may be useful for dynamic drop downs of thumbnails-->
    <form id="form1" name="form1" method="post" action="<? $_SERVER['PHP_SELF']?>">
    
        <select id="year" name="year" onchange="run()">  
            <!--Call run() function-->
            <option value="1900">January</option>
            <option value="Februay">February</option>
            <option value="March">March</option>
            <option value="April">April</option>     
        </select><br><br>
        
    </form> 
</body>
</http>
