<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="w3.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<script src="tableExport/tableExport.js"></script>
<script type="text/javascript" src="tableExport/jquery.base64.js"></script>
<script src="js/export.js"></script>
<script src="js/export2.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="sweetalert2.all.min.js"></script>

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

$chooseset = "SELECT deptName from tb_dept";
$resultsetchoose = mysqli_query($conn, $chooseset);

$choosename = "SELECT * from tb_user";
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
<p class="w3-center w3-medium w3-black w3-padding">SELECT DEPARTMENT (All Records of Employees within the selected Department name)</p>
<form name="indexForm2" class="w3-container" method="post">
  <label>Date:</label>
   <input type="date" class="form-control" placeholder="Start"  name="dateA"/ required>
   <label>To</label>
   <input type="date" class="form-control" placeholder="End"  name="dateB"/ required>
   <p></p>
<input type="search" list="mylist3" class="w3-input w3-border w3-round-large" name="comp" placeholder="Department" onkeyup='saveValue(this);' id="comp_name" required>
			<datalist id='mylist3'>
				<?php
       				while ($row = $resultsetchoose->fetch_assoc())
       					{

         					echo '<option value="'.$row['deptName'].'"></option>';

						}
				?>
			</datalist>
<input class="w3-btn submit" name="submit2" type="submit" value="Next" style='background-color:#f2552c'>
<p></p><br>
	</form>

<!------------- PHP query for checking the date and displaying the result----------->
<?php

if(isset($_POST['submit2'])) {

  $dateA = date("Y-m-d", strtotime($_POST['dateA']));
  $dateB = date("Y-m-d", strtotime($_POST['dateB']));

$compname = $_POST['comp'];

$comp = "SELECT Track_ID, Username, Department, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In, DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, Hours, Note from tb_user_track where Department = '$compname' AND Date BETWEEN '$dateA' AND '$dateB' ORDER BY Username";
$resultset = mysqli_query($conn, $comp);
$number_of_results = mysqli_num_rows($resultset);

if (mysqli_num_rows($resultset) > 0) {

// Show the NAME of all employees who did not submit
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>COMPANY SELECTED :</b> " . $compname . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet1()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset1'>";
?>
<div style="overflow-x:auto;">
<table border='1' class='center w3-table w3-striped' id='dataTable'>
<thead>
    	<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>DEPARTMENT</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<th>HOURS</th>
      <th>NOTE</th>
			<th>EDIT</th>
			</tr>
</thead>

<?php
    while($row = mysqli_fetch_assoc($resultset)) {
?>
<tbody>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  	<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Department']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
    <td><small><?php echo $row['Note']; ?></small></td>
		<td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Update</a></small></td>
  		</tr>
</tbody>
    <?php

		}

	?>

	</table>
</div>

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

}
else if (mysqli_num_rows($resultset) == 0) {

  ?>
  <script> //popup message employee not yet registered
swal.fire({
text: "No Data found within this Date Range",
icon: "error",
});
  </script>

  <?php
}
}

?>
<!------------- PHP query for checking the date and displaying the result----------->
<p class="w3-center w3-medium w3-black w3-padding">SELECT DATE RANGE (All Records within that Date Range)</p>
<form name="indexForm" class="w3-container" method="post">
           <label>Date:</label>
            <input type="date" class="form-control" placeholder="Start" required name="date1"/>
            <label>To</label>
            <input type="date" class="form-control" placeholder="End" required name="date2"/>
<!-----<input type="date" name="today">------>
<input class="w3-btn submit" name="submit" type="submit" value="Next" style='background-color:#f2552c'>
<p></p><br>
</form>
<?php

if(isset($_POST['submit'])) {

$date1 = date("Y-m-d", strtotime($_POST['date1']));
$date2 = date("Y-m-d", strtotime($_POST['date2']));

$sqldate = "SELECT Track_ID, Username, Department, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,  DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(Hours,'%H:%i') as Hours, Note from tb_user_track where Date BETWEEN '$date1' AND '$date2'";
$resultdate = mysqli_query($conn, $sqldate);

	if (mysqli_num_rows($resultdate) > 0) {
    // output data of each row
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>DATE SELECTED :</b> " . $date1 .' to: '. $date2 . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet2()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset2'>";
?>
<div style="overflow-x:auto;">
<table border='1' class='center w3-table w3-striped' id='dataTable'>
  <thead>
			<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>DEPARTMENT</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<th>HOURS</th>
      <th>NOTE</th>
      <th>Edit</th>
			</tr>
</thead>
<p></p>
<?php

    while($row = mysqli_fetch_assoc($resultdate)) {

?>
<tbody>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  	<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Department']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
    <td><small><?php echo $row['Note']; ?></small></td>
    <td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Update</a></small></td>
  		</tr>
</tbody>
    <?php

		}

	?>

	</table>
</div>

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
else if (mysqli_num_rows($resultdate) == 0) {

  ?>
  <script> //popup message when selecting date range with no data/records
swal.fire({
text: "No Data found within this Date Range",
icon: "error",
});
  </script>

  <?php
}
}

?>
<!------------- PHP query for checking the specific employee and Date----------->

<p class="w3-center w3-medium w3-black w3-padding">SELECT EMPLOYEE AND DATE (Specific Date Range for a specific employee)</p>
<form name="indexForm2" class="w3-container" method="post">
<input required type="search" list="mylist4" class="w3-input w3-border w3-round-large" name="emp" placeholder="Select Employee" onkeyup='saveValue(this);' id="comp_name">
			<datalist id='mylist4'>
				<?php
		while($row = mysqli_fetch_array($resultname)) {
		echo '<option value="'.$row['Username'].'"></option>';
    }
				?>
			</datalist>
	<br>
	        <label>Date:</label>
            <input type="date" class="form-control" placeholder="Start" required name="date3"/>
            <label>To</label>
            <input type="date" class="form-control" placeholder="End" required name="date4"/>

<input class="w3-btn submit" name="submit3" type="submit" value="Next" style='background-color:#f2552c'>
<p></p><br><br>
</form>

<?php

if(isset($_POST['submit3'])) {

$date3 = date('Y-m-d', strtotime($_POST['date3']));
$date4 = date('Y-m-d', strtotime($_POST['date4']));

$empname = $_POST['emp'];

$sqldate2 = "SELECT Track_ID, Username, Department, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,  DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(Hours,'%H:%i') as Hours, Note from tb_user_track where Date BETWEEN '$date3' AND '$date4' AND Username='$empname'";
$resultset2 = mysqli_query($conn, $sqldate2);


if (mysqli_num_rows($resultset2) > 0) {

// Show the NAME of all employees who did not submit
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>EMPLOYEE SELECTED :</b> " . $empname . "</div>" . "<br>";
	echo "<div class='w3-center w3-medium'> <b>DATE SELECTED :</b> " . $date3 .' to: '. $date4 . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet3()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset3'>";

?>
<div style="overflow-x:auto;">
<table border='1' class='center w3-table w3-striped' id='dataTable'>
  <thead>
			<tr>
			<th>ID</th>
			<th>USERNAME</th>
			<th>DEPARTMENT</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<th>HOURS</th>
      <th>NOTE</th>
			<th>Edit</th>
			</tr>
</thead>
<p></p>
<?php
    while($row = mysqli_fetch_assoc($resultset2)) {

?>
<tbody>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  	<td><small><?php echo $row['Username']; ?></small></td>
		<td><small><?php echo $row['Department']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
    <td><small><?php echo $row['Note']; ?></small></td>
		<td class="w3-text-red"><small><a href="edit.php?id=<?php echo $row['Track_ID']; ?>">Update</a></small></td>
  		</tr>
</tbody>
    <?php

		}

	?>

	</table>
</div>

	<?php



	?>
  <br>
	<div class="w3-dropdown-hover">
	  <button class="w3-button" style='background-color:#f2552c'>EXPORT</button>
	  <div class="w3-dropdown-content w3-bar-block w3-border">
	    <a class="w3-bar-item w3-button dataExport" data-type="csv">CSV</a>
	    <a class="w3-bar-item w3-button dataExport" data-type="excel">XLS</a>
	    <a class="w3-bar-item w3-button dataExport" data-type="txt">TXT</a>
	  </div>
      <br>  <br>   <br>   <br>   <br>
	</div>


	<?php
	echo "</div>";
}
else if (mysqli_num_rows($resultset2) == 0) {

  ?>
  <script> //popup message when selecting date range with no data/records
swal.fire({
text: "No Data found with this Parameter",
icon: "error",
});
  </script>

  <?php
}

}


?>
<br><br>
</div>
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
        <a href="reset-password.php" class="btn btn-warning w3-button">Change Password</a>
		<a href="ADMINattendance.php" class="btn btn-warning w3-button">Clock In</a>
		<a href="ADMINregister2.php" class="btn btn-warning w3-button">Add User</a>
    <a href="Masterlist.php" class="btn btn-warning w3-button">Masterlist</a>
</footer>

</html>
