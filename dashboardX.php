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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
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
<h5 class="w3-left"> Welcome <i><?php echo htmlspecialchars($_SESSION['FirstName']) . ' ' . htmlspecialchars($_SESSION['LastName']) ?></i> </h5>
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
<br><br><br><br><br><br><br><br>
<?php

if(isset($_POST['submit'])) {

$date1 = date("Y-m-d", strtotime($_POST['date1']));
$date2 = date("Y-m-d", strtotime($_POST['date2']));

//$sqldate = "SELECT Track_ID, FirstName, LastName, Username, Department, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,  DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(Hours,'%H:%i') as Hours from tb_user_track where Date BETWEEN '$date1' AND '$date2' and Username='".$_SESSION['Username']."'";
$sqldate = "SELECT tb_user_track.Track_ID, tb_user.FirstName, tb_user.LastName, tb_user_track.Username, tb_user_track.Department, tb_user_track.Date, DATE_FORMAT(tb_user_track.Time_In,'%h:%i %p') as Time_In,  DATE_FORMAT(tb_user_track.Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(tb_user_track.Hours,'%H:%i') as Hours,tb_user_track.Note from tb_user_track
INNER JOIN tb_user ON tb_user_track.Username=tb_user.Username
where tb_user_track.Date BETWEEN '$date1' AND '$date2' and tb_user_track.Username='".$_SESSION['Username']."'";
$resultdate = mysqli_query($conn, $sqldate);

	if (mysqli_num_rows($resultdate) >= 0) {
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
			<th>NAME</th>
			<th>DEPARTMENT</th>
			<th>DATE</th>
			<th>TIME IN</th>
			<th>TIME OUT</th>
			<th>HOURS</th>
			<th>NOTE</th>
			<th>ADD NOTE</th>
			</tr>
</thead>
<p></p>
<?php

    while($row = mysqli_fetch_assoc($resultdate)) {

?>
<tbody>
       <tr>
		<td><small><?php echo $row['Track_ID']; ?></small></td>
  	<td><small><?php echo $row['FirstName'] . ' ' . $row['LastName'] ; ?></small></td>
		<td><small><?php echo $row['Department']; ?></small></td>
		<td><small><?php echo $row['Date']; ?></small></td>
		<td><small><?php echo $row['Time_In']; ?></small></td>
		<td><small><?php echo $row['Time_Out']; ?></small></td>
		<td><small><?php echo $row['Hours']; ?></small></td>
		<td><small><?php echo $row['Note']; ?></small></td>
		<td class="w3-text-red"><small><a href="edit3.php?id=<?php echo $row['Track_ID']; ?>">Add Note</a></small></td>
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
			<br>  <br>   <br>   <br>   <br>
	</div>

	<?php

	echo "<br>"."<p class='w3-center'>";
	echo "</p>";


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
