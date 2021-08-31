<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
	
$choosename = "SELECT Username from tb_user"; // 
$resultname = mysqli_query($conn, $choosename);
	
?>
<!------------------ Background Design for the title ------------------>	
<div class="w3-container w3-2019-orange-tiger content2" style='background-color:#f2552c'>
	<img src="../FBlogo.png" width="100" height="60" class="center2" />
<h2 class="w3-center w3-opacity" style="text-shadow:1px 1px 0 #444">FullyBooked Time Track Dashboard</h2>
<h1 class="w3-center w3-padding w3-black w3-opacity-min">REPORT</h1>
</div>
<!------------------ Design for Selecting a Specific Company ----------------------->	
<div class="w3-container content">
<p class="w3-center w3-medium w3-black w3-padding">SELECT COMPANY NAME</p>
<form name="indexForm2" class="w3-container" method="post">
<input type="search" list="mylist3" class="w3-input w3-border w3-round-large" name="comp" placeholder="Pick a Company" onkeyup='saveValue(this);' id="comp_name">
			<datalist id='mylist3'>
				<?php
       				while ($row = $resultsetchoose->fetch_assoc())
       					{
						
         					echo '<option value="'.$row['Comp_Name'].'"></option>';
						
						}
				?>
			</datalist>
<input class="w3-btn submit" name="submit2" type="submit" value="Next" style='background-color:#f2552c'>
<p></p>
	</form>

<!------------- PHP query for checking the date and displaying the result----------->
<?php

if(isset($_POST['submit2'])) {

$compname = $_POST['comp'];
	
$comp = "SELECT Track_ID, Username, Comp_Name, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In, DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, Hours from tb_user_track where Comp_Name = '$compname'";
$resultset = mysqli_query($conn, $comp);
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
			<td>Edit</td>
			</tr>
 
<p></p>
<?php
	
if (mysqli_num_rows($resultset) > 0) {

// Show the NAME of all employees who did not submit
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>COMPANY SELECTED :</b> " . $compname . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet1()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset1'>";

    while($row = mysqli_fetch_assoc($resultset)) {
?>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  		<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Comp_Name']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
		<td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Edit</a></small></td>
  		</tr>
		
<?php
		echo "</div>";
    }
	?>
	</table>
	
		<div class="w3-dropdown-hover">
  		<button class="w3-button" style='background-color:#f2552c'>EXPORT</button>
  		<div class="w3-dropdown-content w3-bar-block w3-border">
      		<a  class="w3-bar-item w3-button dataExport" data-type="csv">CSV</a>
      		<a  class="w3-bar-item w3-button dataExport" data-type="excel">XLS</a>
			<a  class="w3-bar-item w3-button dataExport" data-type="txt">TXT</a>
  		</div>
	</div>
	
	<?php
	
}
	
}
	
?> 
<!------------- PHP query for checking the date and displaying the result----------->	
<p class="w3-center w3-medium w3-black w3-padding">SELECT A DATE</p>
<form name="indexForm" class="w3-container" method="post">
<input type="date" name="today">
<input class="w3-btn submit" name="submit" type="submit" value="Next" style='background-color:#f2552c'>
<p></p>
</form>	
<?php
	
if(isset($_POST['today'])) {
    $date = date('Y-m-d', strtotime($_POST['today']));
	
$sqldate = "SELECT Track_ID, Username, Comp_Name, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In, DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, Hours from tb_user_track where Date='$date'";
$resultdate = mysqli_query($conn, $sqldate);
	
?>
<table border='1' class='center w3-table w3-striped' id='dataTable'>
			<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>COMPANY NAME</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<td>Edit</td>
			</tr>
 
<p></p>
<?php
	
	if (mysqli_num_rows($resultdate) >= 0) {
    // output data of each row
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>DATE SELECTED :</b> " . $date . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet2()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset2'>";

	
    while($row = mysqli_fetch_assoc($resultdate)) {
		 
?>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  		<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Comp_Name']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Edit</a></small></td>
  		</tr>
		
<?php
    }

	echo "</div>";
		?>
</table>
	
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
<!------------- PHP query for checking the specific employee and Date----------->	
	
<p class="w3-center w3-medium w3-black w3-padding">SELECT EMPLOYEE AND DATE</p>
<form name="indexForm2" class="w3-container" method="post">
<input type="search" list="mylist4" class="w3-input w3-border w3-round-large" name="emp" placeholder="Select Employee" onkeyup='saveValue(this);' id="comp_name">
			<datalist id='mylist4'>
				<?php
       				while ($row = $resultname->fetch_assoc())
       					{
						
         					echo '<option value="'.$row['Username'].'"></option>';
						
						}
				?>
			</datalist>
<input type="date" name="today2">
<input class="w3-btn submit" name="submit3" type="submit" value="Next" style='background-color:#f2552c'>
<p></p>
</form>		

<?php

if(isset($_POST['submit3'])) {

$date = date('Y-m-d', strtotime($_POST['today2']));	

$empname = $_POST['emp'];
	
$comp = "SELECT Track_ID, Username, Comp_Name, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In, DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, Hours from tb_user_track where Username = '$empname' AND Date='$date'"; 
$resultset2 = mysqli_query($conn, $comp);

	
if (mysqli_num_rows($resultset2) > 0) {

// Show the NAME of all employees who did not submit
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>EMPLOYEE SELECTED :</b> " . $empname . "</div>" . "<p></p>";
	echo "<div class='w3-center w3-medium'> <b>DATE SELECTED :</b> " . $date . "</div>" . "<p></p>";
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
			<td>Edit</td>
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
		<td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Edit</a></small></td>
  		</tr>
		
<?php

    }
	echo "</div>";
	?>
	</table>
	
	<div class="w3-dropdown-hover">
  		<button class="w3-button" style='background-color:#f2552c'>EXPORT</button>
  		<div class="w3-dropdown-content w3-bar-block w3-border">
      		<a  class="w3-bar-item w3-button dataExport" data-type="csv">CSV</a>
      		<a  class="w3-bar-item w3-button dataExport" data-type="excel">XLS</a>
			<a  class="w3-bar-item w3-button dataExport" data-type="txt">TXT</a>
  		</div>
	</div>
	
	<?php
	
}
	
}

	
?> 
<!------------- PHP query for checking an employee----------->

<p class="w3-center w3-medium w3-black w3-padding">SELECT EMPLOYEE</p>
<form name="indexForm2" class="w3-container" method="post">
<input type="search" list="mylist4" class="w3-input w3-border w3-round-large" name="emp" placeholder="Select Employee" onkeyup='saveValue(this);' id="comp_name">
			<datalist id='mylist4'>
				<?php
       				while ($row = $resultname->fetch_assoc())
       					{
						
         					echo '<option value="'.$row['Username'].'"></option>';
						
						}
				?>
			</datalist>

<input class="w3-btn submit" name="submit4" type="submit" value="Next" style='background-color:#f2552c'>
<p></p>
</form>		

<?php

if(isset($_POST['submit4'])) {


$empname2 = $_POST['emp'];
	
$comp2 = "SELECT Track_ID, Username, Comp_Name, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In, DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, Hours from tb_user_track where Username = '$empname2'"; 
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
			<td>Edit</td>
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
		<td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Edit</a></small></td>
  		</tr>
		
<?php

    }
	echo "</div>";
	?>
	</table>
	
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
        <a href="reset-password.php" class="btn btn-warning w3-button">Reset Password</a>
        <a href="logout.php" class="btn btn-danger ml-3 w3-button">Sign Out</a>
		<a href="attendance.php" class="btn btn-warning w3-button">Clock In</a>
</footer>

</html>