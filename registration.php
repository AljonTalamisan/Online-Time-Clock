<!DOCTYPE html>
<html>
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">

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
	<h1 class="w3-center w3-padding w3-red w3-opacity-min">Register Company</h1>
	</div>
<!----------------------------------------------------- Form Where your register the Company's Name -------------------------------------------------------------------------------->	
	
<div class="ui container segment text"><br>
<form name="Company Form" class="w3-container" method="post">

	<p><label><b>Company Name: </b><b class="w3-text-red">*</b></label></p>
		<input type=text name="company_name" class="w3-input w3-border w3-round-large" required placeholder="Company Name " id="company_name"><br>
	
	<p></p>
	<input class="ui orange button basic submit" name="submit" type="submit" value="Register Company" style='background-color:#f2552c'>
</form>
</div>
	<div class="w3-container"><p></p></div>
<p></p>

	
<!----------------------------------------------------- PHP CODE For Company Name Registration -------------------------------------------------------------------------------->	
	
<?php

include 'db_con.php';

$conn = OpenCon();

if(isset($_POST['submit'])){ // Fetching variables of the form which travels in URL
$company = mysqli_real_escape_string($conn, $_POST['company_name']);
    
//check if the name is already been registered on database
$sqlcheck = "SELECT * from tb_comp_name where Comp_Name = '$company'";	
$resultcheck = mysqli_query($conn, $sqlcheck); 	
	
if (mysqli_num_rows($resultcheck) > 0) {

?>
	<script> 
swal({
text: "This Company Name had already been Registered!",
icon: "error",
});
 
	</script>
	
<?php
	
  }
	
else
{
$sql = "insert into tb_comp_name(Comp_Name) values ('$company')";


if (mysqli_query($conn, $sql))
{	
?>
	<script> 
swal({
title: "SUCCESS",
text: "Company Details Registered Successfully!",
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
	
<!-----------------------------------------------------END:  PHP CODE For Company Name Registration -------------------------------------------------------------------------------->	
	
<!----------------------------------------------------- Form for Registering Employees on a specific Company -------------------------------------------------------------------------------->	

	<p></p>
	
	<div class="w3-container content">
	<h1 class="w3-center w3-padding w3-red w3-opacity-min">Register Employees</h1>
	</div>
	
	
<?php
	
$set = "SELECT Comp_Name from tb_comp_name"; // 
$resultset = mysqli_query($conn, $set);
	
?>
	
<div class="ui container segment text"><br>
<form name="Employee Form" class="w3-container" method="post">

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
		<input type=text name="employee_name" class="w3-input w3-border w3-round-large" required placeholder="Employee Name" id="employee_name"><br>
	
	<input class="ui orange button basic submit" name="submit2" type="submit" value="Register Employee" style='background-color:#f2552c'>
</form>
</div>
	<div class="w3-container"><p></p></div>
<p></p>

	
<!----------------------------------------------------- PHP CODE For Employee's Name Registration -------------------------------------------------------------------------------->	
	
<?php

if(isset($_POST['submit2'])){ // Fetching variables of the form which travels in URL
$companyname = mysqli_real_escape_string($conn, $_POST['company_list']);
$employeename = mysqli_real_escape_string($conn, $_POST['employee_name']);
    
//check if the name is already been registered on database
$sqlcheckemployee = "SELECT * from tb_user where Comp_Name = '$companyname' and Username = '$employeename'";	
$result = mysqli_query($conn, $sqlcheckemployee); 	
	
if (mysqli_num_rows($result) > 0) {

?>
	<script> 
swal({
text: "This Employee had already been registered with this Company!",
icon: "error",
});
 
	</script>
	
<?php
	
  }
	
else
{
$sql = "insert into tb_user(Comp_Name, Username) values ('$companyname', '$employeename')";


if (mysqli_query($conn, $sql))
{	
?>
	<script> 
swal({
title: "SUCCESS",
text: "Employee Details Registered Successfully!",
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
	
<p></p>
<div class="ui segment"></div>
<p></p>
<footer class="w3-container" style='background-color:#f2552c'><p></p>
	<a href="#top"><img src="../FBlogo.png" width="150" height="25"/><p></p></a>
	<a href="dashboard.php" class="btn btn-warning w3-button">Dashboard</a>
	<a href="register.php" class="btn btn-warning w3-button">Sign-Up</a>
	<a href="registration.php" class="btn btn-warning w3-button">Register Employee</a>
</footer>
</body>
</html>