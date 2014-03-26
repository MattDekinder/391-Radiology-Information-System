<?php 
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
//TODO: create security for classes and add dates to search.
if(isset($_POST['search'])){

        } else{
                
        }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
  <meta name="generator" content="Bluefish 2.2.2" >
  <meta name="generator" content="Bluefish 2.2.2" >
  <meta name="generator" content="Bluefish 2.2.2" >

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
      <p>Search : <input type="text" name="keywords"><br>
      Start Date: <input type="date" name="date"><br>
      End Date: <input type="date" name="date"><br>
      <input type="submit" name="search" value="Search"><br></p>
    </form>
  </div>
</body>
</html>
