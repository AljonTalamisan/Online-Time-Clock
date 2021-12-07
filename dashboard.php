<?php
session_start();


if(!isset($_SESSION["Username"]))
{
	header("location:index.php");
}

?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="w3.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<script src="js/export2.js"></script>
<!--- Responsive ---->
<meta name="viewport" content="width=device-width, initial-scale=1">
 <style>
.content {
  max-width: 1000px;
  margin: auto;
  background: white;
  padding: 10px;
}
.content2 {
  max-width: 1000px;
  margin: auto;
  background: white;
  padding: 10px;
}
table.center {
  margin-left: auto;
  margin-right: auto;
}
footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
   text-align: center;
}
.center2 {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
body {
    margin-bottom:100px;
}

</style>
<title>FullyBooked Dashboard</title>
<body class="w3-theme-l2" id="top">

<?php

include 'db_con.php';

$conn = OpenCon();

$chooseset = "SELECT Comp_Name from tb_comp_name"; //
$resultsetchoose = mysqli_query($conn, $chooseset);

$choosename = "SELECT Username from tb_user where Username='".$_SESSION['Username']."'"; //
$resultname = mysqli_query($conn, $choosename);

?>
<!------------------ Background Design for the title ------------------>
<div class="w3-container w3-2019-orange-tiger content2" style='background-color:#f2552c'>
	<img src="../FBlogo.png" width="100" height="60" class="center2" />
<h2 class="w3-center w3-opacity" style="text-shadow:1px 1px 0 #444">FullyBooked Time Track Dashboard</h2>
<h1 class="w3-center w3-padding w3-black w3-opacity-min">REPORT</h1>
<a href="ADMINlogout.php" class="ui primary button w3-right">Sign Out</a>
<h5 class="w3-left"> Welcome <i><?php echo htmlspecialchars($_SESSION['Username']) ?></i> </h5>
</div>
<!------------------ Design for Selecting a Specific Company ----------------------->
<div class="w3-container content">

<!------------- PHP query for checking the date and displaying the result----------->
<p class="w3-center w3-medium w3-black w3-padding">SELECT A DATE</p>
<form name="indexForm" class="w3-container" method="post">
           <label>Date:</label>
            <input type="date" class="form-control" placeholder="Start"  name="date1"/>
            <label>To</label>
            <input type="date" class="form-control" placeholder="End"  name="date2"/>
<!-----<input type="date" name="today">------>
<input class="w3-btn submit" name="submit" type="submit" value="Next" style='background-color:#f2552c'>
<p></p>
</form>
<?php

if(isset($_POST['submit'])) {

$date1 = date("Y-m-d", strtotime($_POST['date1']));
$date2 = date("Y-m-d", strtotime($_POST['date2']));

$sqldate = "SELECT Track_ID, Username, Comp_Name, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,  DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(Hours,'%H:%i') as Hours from tb_user_track where Date BETWEEN '$date1' AND '$date2' and Username='".$_SESSION['Username']."'";
$resultdate = mysqli_query($conn, $sqldate);

	if (mysqli_num_rows($resultdate) >= 0) {
    // output data of each row
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>DATE SELECTED :</b> " . $date1 .' to: '. $date2 . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet2()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset2'>";
?>
<table border='1' class='center w3-table w3-striped' id='dataTable'>
			<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>COMPANY NAME</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<th>HOURS</th>
			</tr>

<p></p>
<?php

    while($row = mysqli_fetch_assoc($resultdate)) {

?>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  		<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Comp_Name']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
  		</tr>

    <?php

		}

	?>

	</table>

	<?php

	echo "</div>";

	?>
	<div class="w3-dropdown-hover">
  		<button class="w3-button" style='background-color:#f2552c'>EXPORT</button>
  		<div class="w3-dropdown-content w3-bar-block w3-border">
      		<a  class="w3-bar-item w3-button dataExport" data-type="csv">CSV</a>
      		<a  class="w3-bar-item w3-button dataExport" data-type="excel">XLS</a>
			<a  class="w3-bar-item w3-button dataExport" data-type="txt">TXT</a>
  		</div>
	</div>

	<?php

	echo "<br>"."<p class='w3-center'>";
	echo "</p>";


}
}

?>

<!------------- PHP query for checking an employee----------->

<p class="w3-center w3-medium w3-black w3-padding">SELECT EMPLOYEE</p>
<form name="indexForm2" class="w3-container" method="post">
		<input type=text name="emp" class="w3-input w3-border w3-round-large" required placeholder="Employee Name" id="employee_name" onblur="myFunction()" value="<?php echo htmlspecialchars($_SESSION['Username']) ?>"><br>

<input class="w3-btn submit" name="submit4" type="submit" value="Next" style='background-color:#f2552c'>
<p></p>
</form>

<?php

if(isset($_POST['submit4'])) {


$empname2 = $_POST['emp'];

$comp2 = "SELECT Track_ID, Username, Comp_Name, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In, DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(Hours,'%H:%i') as Hours from tb_user_track where Username = '$empname2'";
$resultset2 = mysqli_query($conn, $comp2);


if (mysqli_num_rows($resultset2) > 0) {

// Show the NAME of all employees who did not submit
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>EMPLOYEE SELECTED :</b> " . $empname2 . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet3()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset3'>";

?>
<table border='1' class='center w3-table w3-striped' id='dataTable'>
			<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>COMPANY NAME</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<th>HOURS</th>
			</tr>

<p></p>
<?php
    while($row = mysqli_fetch_assoc($resultset2)) {

?>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  		<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Comp_Name']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
  		</tr>

    <?php

		}

	?>

	</table>

	<?php

	echo "</div>";

	?>
	<div class="w3-dropdown-hover">
  		<button class="w3-button" style='background-color:#f2552c'>EXPORT</button>
  		<div class="w3-dropdown-content w3-bar-block w3-border">
      		<a  class="w3-bar-item w3-button dataExport" data-type="csv">CSV</a>
      		<a  class="w3-bar-item w3-button dataExport" data-type="excel">XLS</a>
			<a  class="w3-bar-item w3-button dataExport" data-type="txt">TXT</a>
  		</div>
	</div>
	</div>
	<?php

}

}


?>

<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function myFunction2() {
  var x = document.getElementById("myDIV2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function myFunction3() {
  var x = document.getElementById("myDIV3");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function myFunctionSet1() {
  var x = document.getElementById("myDIVset1");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function myFunctionSet2() {
  var x = document.getElementById("myDIVset2");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
function myFunctionSet3() {
  var x = document.getElementById("myDIVset3");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

</script>

</body>
<footer class="w3-container" style='background-color:#f2552c'>
  <h6></h6>
<a href="#top"><img src="../FBlogo.png" width="150" height="25"/>
	<p></p></a>
		<a href="reset-password2.php" class="btn btn-warning w3-button">Reset Password</a>
		<a href="attendance.php" class="btn btn-warning w3-button">Clock In</a>
        <a href="logout.php" class="btn btn-danger ml-3 w3-button">Sign Out</a>
</footer>

</html>
