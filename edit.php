<?php

include "db_con.php"; // Using database connection file here
$conn = OpenCon();

$id = $_GET['id']; // get id through query string

$qry = mysqli_query($conn,"select Username, Comp_Name, Date, Time_In, Time_Out, DATE_FORMAT(Hours,'%H:%i') from tb_user_track where Track_ID='$id'"); // select query

$data = mysqli_fetch_array($qry); // fetch data

if(isset($_POST['update'])) // when click on Update button
{
    $Username = $_POST['Username'];
    $Comp_Name = $_POST['Comp_Name'];
	$Date = $_POST['Date'];
	$Time_In = $_POST['Time_In'];
	$Time_Out = $_POST['Time_Out'];

    $edit = "update tb_user_track set Username='$Username', Comp_Name='$Comp_Name', Date='$Date', Time_Out='$Time_In', Time_Out='$Time_Out' where Track_ID='$id'";
	$resultedit = mysqli_query($conn, $edit);

	$sqlcalculate  = "UPDATE tb_user_track SET Hours = TIMEDIFF(Time_Out, Time_In) WHERE Track_ID='$id'";
	$resultcalc = mysqli_query($conn, $sqlcalculate);

    if($resultedit)
    {
		if($resultcalc)
		{
        header("location:ADMINdashboard.php"); // redirects to all records page
        exit;
		}
    }
    else
    {
        echo "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
	<script src="jquery-3.5.1.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }

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
</head>
<body>
<div class="w3-container w3-2019-orange-tiger content" style='background-color:#f2552c' id="top">
		<img src="../FBlogo.png" width="100" height="50" class="center" />
		<h2 class="w3-center w3-opacity" style="text-shadow:1px 1px 0 #444">Fully Booked Online Time Clock</h2>
</div>
	<div class="w3-container content">
	<h2 class="w3-center w3-padding w3-red w3-opacity-min">Update Time-Sheet Information</h2>
	</div>
<br>
<div class="content2 w3-container w3-2019-orange-tiger content">
<h3 class="w3-center w3-padding w3-black w3-opacity-min">Update Data (Please Use Military Time)</h3>

<form method="POST">
  <input type="text" name="Username" value="<?php echo $data['Username'] ?>" placeholder="Enter Username" Required>
  <input type="text" name="Comp_Name" value="<?php echo $data['Comp_Name'] ?>" placeholder="Enter Deparmtment Name" Required>
  <input type="text" name="Date" value="<?php echo $data['Date'] ?>" placeholder="Enter Date" Required>
  <input type="text" name="Time_In" value="<?php echo $data['Time_In'] ?>" placeholder="Enter Time In" Required>
  <input type="text" name="Time_Out" value="<?php echo $data['Time_Out'] ?>" placeholder="Enter Time Out" Required>
	<p></p>
  <input type="submit" name="update" value="UPDATE" class="ui green button submit">
  <a href="ADMINDashboard.php" class="ui blue button submit">BACK</a>
</form>
</div>
