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

$chooseset = "SELECT deptName from tb_dept2";
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
<p class="w3-center w3-medium w3-black w3-padding">SELECT DEPARTMENT</p>
<form name="indexForm2" class="w3-container" method="post">

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

$compname = $_POST['comp'];

$comp = "SELECT User_ID,EmployeeNo, FirstName, MiddleName, LastName, Department, Username from tb_user where Department = '$compname' OR NOT EXISTS(
        SELECT User_ID,EmployeeNo, FirstName, MiddleName, LastName, Department, Username
        FROM tb_user
				WHERE Department = 'All'
			)";
$resultset = mysqli_query($conn, $comp);
$number_of_results = mysqli_num_rows($resultset);

if (mysqli_num_rows($resultset) >= 0) {

// Show the NAME of all employees who did not submit
	echo "<div class='w3-container content w3-center'>";
	echo "<div class='w3-center w3-medium'> <b>DEPARTMENT SELECTED :</b> " . $compname . "</div>" . "<p></p>";
	echo "<button onclick='myFunctionSet1()' class='w3-button w3-border w3-hover-deep-orange'>HIDE / SHOW</button>";
	echo "</div>";
	echo "<div class='w3-container content' id='myDIVset1'>";
?>
<div style="overflow-x:auto;">
<table border='1' class='center w3-table w3-striped' id='dataTable'>
<thead>
    	<tr>
			<th>EMPLOYEE NO.</th>
			<th>FIRSTNAME</th>
			<th>MIDDLENAME</th>
			<th>LASTNAME</th>
			<th>DEPARTMENT</th>
			<th>USERNAME</th>
			<th>UPDATE</th>
			</tr>
</thead>

<?php
    while($row = mysqli_fetch_assoc($resultset)) {
?>
<tbody>
       <tr>
		<td><small><?php echo $row['EmployeeNo']; ?></small></td>
  	<td><small><?php echo $row['FirstName']; ?></small></td>
		<td><small><?php echo $row['MiddleName']; ?></small></td>
		<td><small><?php echo $row['LastName']; ?></small></td>
		<td><small><?php echo $row['Department']; ?></small></td>
		<td><small><?php echo $row['Username']; ?></small></td>
		<td class="w3-text-red"><small><a href="edit2.php?id=<?php echo $row['User_ID']; ?>">Update</a></small></td>
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
<br><br><br><br><br><br>
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
				<a href="ADMINdashboard.php" class="btn btn-warning w3-button">Dashboard</a>
		<a href="ADMINattendance.php" class="btn btn-warning w3-button">Clock In</a>
		<a href="RegularRegister2.php" class="btn btn-warning w3-button">Register Regular User</a>
		<a href="ADMINregister2.php" class="btn btn-warning w3-button">Create Admin Account</a>
    <a href="DEPTregister.php" class="btn btn-warning w3-button">Create Dept Head Account</a>
</footer>

</html>
