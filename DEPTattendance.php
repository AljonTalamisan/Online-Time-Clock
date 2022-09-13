<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: DEPTlogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<script src="jquery-3.5.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<!--- Responsive ---->
<meta name="viewport" content="width=device-width, initial-scale=1">
 <style>
.content {
  max-width: 800px;
  margin: auto;
  padding: 10px;
}
.content2 {
  max-width: 1000px;
  margin: auto;
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
body {
    margin-bottom:120px;
}
.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
}
h1
{
	margin:0px;
	margin-top:40px;
	color:#8181F7;
	font-size:45px;
}
#date
{
	color:gray;
}
#time
{
	color:darkred;
}
</style>
<title>Fullybooked Online Time Clock</title>
<body>
<script src="hhttps://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>


<!----------------------------------------------------- Header Design -------------------------------------------------------------------------------->

	<div class="w3-container w3-2019-orange-tiger content" style='background-color:#f2552c' id="top">
		<img src="../FBlogo.png" width="100" height="50" class="center" />
		<h2 class="w3-center w3-opacity" style="text-shadow:1px 1px 0 #444">Fully Booked Online Time Clock (DEPT HEAD)</h2>
    <a href="ADMINlogout.php" class="ui primary button w3-right">Sign Out</a>
    <h5 class="w3-left"> Welcome: <i><?php echo htmlspecialchars($_SESSION['FirstName']) . ' ' . htmlspecialchars($_SESSION['LastName']) ?></i> </h5>
	</div>

	<p></p>

	<div class="w3-container content">
	<h2 class="w3-center" id="date" name="date"></h2>
	<h2 class="w3-center" id="time" name="time"></h2>
   	</div>

<!----------------------------------------------------- Form for Registering Employees on a specific Company -------------------------------------------------------------------------------->

	<p></p>

<?php
include 'db_con.php';

$conn = OpenCon();

date_default_timezone_set("Asia/Manila");
$datenow = new DateTime(); // Date object using current date and time
$dt=date('Y-m-d');
$dm=date('H:i');

$username=$_SESSION['Username'];
$fullname=$_SESSION['FullName'];

$set = "SELECT Comp_Name from tb_comp_name"; //
$resultset = mysqli_query($conn, $set);

$latest = "SELECT Action,Date,DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out from tb_user_track where Track_ID = (SELECT Max(Track_ID) from tb_user_track) and FullName = '$fullname'";
$latestset = mysqli_query($conn, $latest);

	while($rowlatest = mysqli_fetch_assoc($latestset)) {
	?>
	<div class="w3-container content w3-light-gray w3-opacity-min">
	<h4 class="w3-center "><b class="w3-text-black">STATUS: </b><b class="w3-text-blue"><?php echo $rowlatest['Action']; ?></b></h4>
  <h4 class="w3-center "><b class="w3-text-black">DATE: </b><b class="w3-text-blue"><?php echo $rowlatest['Date']; ?></b></h4>

	</div>
	<?php

		}

	?>
<?php

$latest2 = "SELECT Action,Date,DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out from tb_user_track where Date = CURDATE() and FullName = '$fullname'";
$latestset2 = mysqli_query($conn, $latest2);

	while($rowlatest2 = mysqli_fetch_assoc($latestset2)) {
	?>
	<div class="w3-container content w3-light-gray w3-opacity-min">
	<h4 class="w3-center "><b class="w3-text-black"></b><b class="w3-text-green"><?php echo $rowlatest2['Time_In']; ?></b> - <b class="w3-text-red"><?php echo $rowlatest2['Time_Out']; ?></b></h4>
	</div>
	<?php

		}

	?>


<div class="ui inverted container segment text"><br>
<form name="Employee Form" class="w3-container" method="post">

<?php
echo '<input name="date" type="hidden" value= "' . $dt . '">';
echo '<input name="time" type="hidden" value= "' . $dm . '">';
?>

	<p><label><b>Deparment: </b><b class="w3-text-red">*</b></label></p>

	<input type=text name="company_list" class="w3-input w3-border w3-round-large" readonly required placeholder="Company Name" id="company_list" onblur="myFunction()" value="<?php echo htmlspecialchars($_SESSION['Department']) ?>"><br>
	<p></p>

	<p><label><b>Employee's Name: </b><b class="w3-text-red">*</b></label></p>
		<input type=text name="employee_name" class="w3-input w3-border w3-round-large" required readonly placeholder="Employee Name" id="employee_name" onblur="myFunction()" value="<?php echo htmlspecialchars($_SESSION['FullName']) ?>"><br>

	<input class="ui green button submit" name="submit2" type="submit" value="Clock In" id="submit2">
	<input class="ui red button submit" name="submit3" type="submit" value="Clock Out" id="submit3">
</form>
</div>
	<br><br><br><br>
<p></p>

<!----------------------------------------------------- PHP CODE For Employee's Clock In -------------------------------------------------------------------------------->

<?php


if(isset($_POST['submit2'])){ // Fetching variables of the form which travels in URL
$companyname = mysqli_real_escape_string($conn, $_POST['company_list']);
$employeename = mysqli_real_escape_string($conn, $_POST['employee_name']);
$date = date('Y-m-d');
$time = date('H:i');

//check if the employee had already clocked in today
$sqlcheckemployee = "SELECT Department, FullName, Date, Action FROM tb_user_track WHERE Date = '$date' AND FullName = '$employeename' AND Action = 'IN'";
$result = mysqli_query($conn, $sqlcheckemployee);


//check if the name is already been registered on database
$sqlcheckemployee2 = "SELECT Department, FullName FROM tb_user WHERE Department = '$companyname' AND FullName = '$employeename'";
$result2 = mysqli_query($conn, $sqlcheckemployee2);

if (mysqli_num_rows($result) > 0) {

?>
	<script> //popup message had already clocked in
swal({
text: "This Employee had already Clocked In!",
icon: "error",
});

	</script>

<?php

  }

else if (mysqli_num_rows($result2) == 0) {

	?>
	<script> //popup message employee not yet registered
swal({
text: "This Employee is not yet Registered!",
icon: "error",
});
	</script>

	<?php
}

else
{
$sql = "insert into tb_user_track(Department, FullName, Date, Time_In, Action) values ('$companyname', '$employeename', '$date', '$time', 'IN')";
$lateearly = "UPDATE tb_user_track t1 JOIN tb_user t2 ON t2.FullName = t1.FullName SET t1.Late_EarlyHours = TIMEDIFF(t2.ShiftSchedule, Time_In) WHERE t1.Date = '$date' AND t1.FullName = '$employeename'";

if (mysqli_query($conn, $sql))
   if (mysqli_query($conn, $lateearly)){
{
?>
	<script>
swal({
title: "SUCCESS",
text: "Employee Successfully Clocked In!",
icon: "success"
}).then(function(){
   location.reload();
   }
);
	</script>

<?php
}
}

else
{
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

?>

<!----------------------------------------------------- PHP CODE For Employee's Clock Out-------------------------------------------------------------------------------->


<?php


if(isset($_POST['submit3'])){ // Fetching variables of the form which travels in URL
$companyname2 = mysqli_real_escape_string($conn, $_POST['company_list']);
$employeename2 = mysqli_real_escape_string($conn, $_POST['employee_name']);
$date2 = date('Y-m-d');
$time2 = date('H:i');

//check if the employee had already clocked in today
$sqlout = "SELECT Department, FullName, Date, Action, Time_Out FROM tb_user_track WHERE Date = '$date2' AND FullName = '$employeename2' AND Action = 'IN'";
$result = mysqli_query($conn, $sqlout);

if (mysqli_num_rows($result) > 0) {

$sql = "UPDATE tb_user_track SET Time_Out= '$time2', Action = 'OUT' WHERE Date = '$date2' AND FullName = '$employeename2' AND ACTION = 'IN'";
$sqlcalculate  = "UPDATE tb_user_track SET Hours = TIMEDIFF(Time_Out, Time_In) WHERE Date = '$date2' AND FullName = '$employeename2' AND ACTION = 'OUT'";

if (mysqli_query($conn, $sql))
{
	if(mysqli_query($conn, $sqlcalculate)){
?>
	<script>
swal({
title: "SUCCESS",
text: "Employee Successfully Clocked Out!",
icon: "success"
}).then(function(){
   location.reload();
   }
);
	</script>

<?php
	}
}
}

else {

?>
	<script> //popup message had already clocked in
swal({
text: "This Employee had already Clocked Out!",
icon: "error",
});

	</script>

<?php

  }

}



?>



	<!----------------------------------------------------- PHP CODE For Employee's Name Registration -------------------------------------------------------------------------------->


<script type="text/javascript">
    window.onload = setInterval(clock,1000);

    function clock()
    {
	  var d = new Date();

	  var date = d.getDate();

	  var month = d.getMonth();
	  var montharr =["Jan","Feb","Mar","April","May","June","July","Aug","Sep","Oct","Nov","Dec"];
	  month=montharr[month];

	  var year = d.getFullYear();

	  var day = d.getDay();
	  var dayarr =["Sun","Mon","Tues","Wed","Thurs","Fri","Sat"];
	  day=dayarr[day];

      var min = d.getMinutes();
	  var sec = d.getSeconds();

   var hour   = d.getHours();
   var minute = d.getMinutes();
   var second = d.getSeconds();
   var ap = "AM";
   if (hour   > 11) { ap = "PM";             }
   if (hour   > 12) { hour = hour - 12;      }
   if (hour   == 0) { hour = 12;             }
   if (hour   < 10) { hour   = "0" + hour;   }
   if (minute < 10) { minute = "0" + minute; }
   if (second < 10) { second = "0" + second; }

	  document.getElementById("date").innerHTML=day+", "+date+" "+month+" "+year;
	  document.getElementById("time").innerHTML=hour+":"+minute+":"+second+" "+ap;
    }
  </script>

<script>
function myFunction() {
  $("submit2").prop('disabled', true);
}
</script>

<p></p>
<footer class="w3-container" style='background-color:#f2552c'><p></p>
	<a href="#top"><img src="../FBlogo.png" width="150" height="25"/><p></p></a>
  <br>
  <a href="reset-password3.php" class="ui primary button">Reset Password</a>
	<a href="DEPTattendance.php" class="ui primary button">Clock In</a>
	<a href="DEPTdashboard.php" class="ui primary button">Dashboard</a>
</footer>
</body>
</html>
