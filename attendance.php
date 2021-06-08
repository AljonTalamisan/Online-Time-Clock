<!DOCTYPE html>
<html>
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
<script src="jquery-3.5.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
<body class="w3-theme-l2">
<script src="hhttps://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
	
	
<!----------------------------------------------------- Header Design -------------------------------------------------------------------------------->	

	<div class="w3-container w3-2019-orange-tiger content" style='background-color:#f2552c' id="top">
		<img src="../FBlogo.png" width="100" height="50" class="center" />
		<h2 class="w3-center w3-opacity" style="text-shadow:1px 1px 0 #444">Fully Booked Online Time Clock</h2>
	</div>
	     
	<p></p>
	
	<div class="w3-container content">
	<h2 class="w3-center w3-padding w3-red w3-opacity-min">Clock In / Clock Out</h2>
	</div>
	
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
	
$set = "SELECT Comp_Name from tb_comp_name"; // 
$resultset = mysqli_query($conn, $set);
	
?>

<div class="ui inverted container segment text"><br>
<form name="Employee Form" class="w3-container" method="post">
	
<?php	
echo '<input name="date" type="hidden" value= "' . $dt . '">';
echo '<input name="time" type="hidden" value= "' . $dm . '">';
?>
	
	<p><label><b>Choose Company Name: </b><b class="w3-text-red">*</b></label></p>
	
			   <input type="search" list="company_list" class="w3-input w3-border w3-round-large" name="company_list" placeholder="Choose Company Name">
			<datalist id='company_list'>
				<?php
       				while ($row = $resultset->fetch_assoc())
       					{
						
         					echo '<option value="'.$row['Comp_Name'].'"></option>';
						
						}
				?>
			</datalist>
	<p></p>
	
	<p><label><b>Employee Name: </b><b class="w3-text-red">*</b></label></p>
		<input type=text name="employee_name" class="w3-input w3-border w3-round-large" required placeholder="Employee Name" id="employee_name" onblur="myFunction()"><br>
	
	<input class="ui orange button basic submit" name="submit2" type="submit" value="Clock In" style='background-color:#f2552c' id="submit2">
	<input class="ui orange button basic submit" name="submit3" type="submit" value="Clock Out" style='background-color:#f2552c' id="submit3">
</form>
</div>
	<div class="w3-container"><p></p></div>
<p></p>

	
<!----------------------------------------------------- PHP CODE For Employee's Clock In -------------------------------------------------------------------------------->	
	
<?php


if(isset($_POST['submit2'])){ // Fetching variables of the form which travels in URL
$companyname = mysqli_real_escape_string($conn, $_POST['company_list']);
$employeename = mysqli_real_escape_string($conn, $_POST['employee_name']);
$date = date('Y-m-d');
$time = date('H:i');
    
//check if the employee had already clocked in today
$sqlcheckemployee = "SELECT Comp_Name, Username, Date, Action FROM tb_user_track WHERE Date = '$date' AND Username = '$employeename' AND Action = 'IN'";	
$result = mysqli_query($conn, $sqlcheckemployee);
	
	
//check if the name is already been registered on database
$sqlcheckemployee2 = "SELECT Comp_Name, Username FROM tb_user WHERE Comp_Name = '$companyname' AND Username = '$employeename'";	
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
$sql = "insert into tb_user_track(Comp_Name, Username, Date, Time_In, Action) values ('$companyname', '$employeename', '$date', '$time', 'IN')";


if (mysqli_query($conn, $sql))
{	
?>
	<script> 
swal({
title: "SUCCESS",
text: "Employee Successfully Clocked In!",
icon: "success"
});
	</script>
	
<?php
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
$sqlout = "SELECT Comp_Name, Username, Date, Action, Time_Out FROM tb_user_track WHERE Date = '$date2' AND Username = '$employeename2' AND Action = 'IN'";	
$result = mysqli_query($conn, $sqlout);	

if (mysqli_num_rows($result) > 0) {

$sql = "UPDATE tb_user_track SET Time_Out= '$time2', Action = 'OUT' WHERE Date = '$date2' AND Username = '$employeename2' AND ACTION = 'IN'";
$sqlcalculate  = "UPDATE tb_user_track SET Hours = TIMEDIFF(Time_Out, Time_In) WHERE Date = '$date2' AND Username = '$employeename2' AND ACTION = 'OUT'";

if (mysqli_query($conn, $sql))
{
	if(mysqli_query($conn, $sqlcalculate)){
?>
	<script> 
swal({
title: "SUCCESS",
text: "Employee Successfully Clocked Out!",
icon: "success"
});
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
		
	  var hour = d.getHours();
  	  var ampm = hour >= 12 ? 'PM' : 'AM';
		hour = hour % 12;
		hour = hour ? hour : 12; // the hour '0' should be '12'
	
	  document.getElementById("date").innerHTML=day+", "+date+" "+month+" "+year;
	  document.getElementById("time").innerHTML=hour+":"+min+":"+sec+" "+ampm;
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
</footer>
</body>
</html>