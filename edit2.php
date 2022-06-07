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
input, label {
    display:block;
}

    </style>
</head>
<body>
  <?php

  include "db_con.php"; // Using database connection file here
  $conn = OpenCon();

  $id = $_GET['id']; // get id through query string

  $qry = mysqli_query($conn,"select EmployeeNo, FirstName, MiddleName, LastName, Department, Username, Usertype, Note from tb_user where User_ID='$id'"); // select query

  $data = mysqli_fetch_array($qry); // fetch data

  if(isset($_POST['update'])) // when click on Update button
  {
    $EmployeeNo = $_POST['EmployeeNo'];
    $FirstName = $_POST['FirstName'];
  	$MiddleName = $_POST['MiddleName'];
  	$LastName = $_POST['LastName'];
  	$Department = $_POST['Department'];
    $Username = $_POST['Username'];
    $Usertype = $_POST['Usertype'];

    $edit = "update tb_user set EmployeeNo='$EmployeeNo', FirstName='$FirstName', MiddleName='$MiddleName', LastName='$LastName', Department='$Department', Username='$Username', Usertype='$Usertype' where User_ID='$id'";
  	$resultedit = mysqli_query($conn, $edit);


      if($resultedit)
      {

        ?>
        <script>

        swal({
            text: "Successfully Updated Track!",
            icon: "success",
              }).then(function() {
                window.location = "Masterlist.php";
                });

        </script>
        <?php
          // header("location:ADMINdashboard.php"); // redirects to all records page
          // exit;
  		}

      else
      {
          echo "error";
      }
  }
  ?>

<div class="w3-container w3-2019-orange-tiger content" style='background-color:#f2552c' id="top">
		<img src="../FBlogo.png" width="100" height="50" class="center" />
		<h2 class="w3-center w3-opacity" style="text-shadow:1px 1px 0 #444">Fully Booked Online Time Clock</h2>
</div>
	<div class="w3-container content">
	<h2 class="w3-center w3-padding w3-red w3-opacity-min">Update Time-Sheet Information</h2>
	</div>
<br>
<div class="content2 w3-container w3-2019-orange-tiger content">
<h3 class="w3-center w3-padding w3-black w3-opacity-min">Update Data</h3>

<form method="POST">
  <div style="float:left;">
      <label for="EmployeeNo">EmployeeNo</label>
      <input id="EmployeeNo" type="text" value="<?php echo $data['EmployeeNo'] ?>" name="EmployeeNo" readonly>
  </div>
  <div style="float:left;">
      <label for="FirstName">FirstName</label>
      <input id="FirstName" type="text" value="<?php echo $data['FirstName'] ?>" name="FirstName" >
  </div>
  <div style="float:left;">
      <label for="MiddleName">MiddleName</label>
      <input id="MiddleName" type="text" value="<?php echo $data['MiddleName'] ?>" name="MiddleName" >
  </div>
  <div style="float:left;">
      <label for="LastName">LastName</label>
      <input id="LastName" type="text" value="<?php echo $data['LastName'] ?>" name="LastName" Required>
  </div>
  <div style="float:left;">
      <label for="Department">Department</label>
      <input id="Department" type="text" value="<?php echo $data['Department'] ?>" name="Department"  Required>
  </div>
  <div style="float:left;">
      <label for="Username">Username</label>
      <input id="Username" type="text" value="<?php echo $data['Username'] ?>" name="Username" Required>
  </div>
  <div style="float:left;">
      <label for="Usertype">Usertype</label>

      <select id="Usertype" name="Usertype" Required>
        <option value="<?php echo $data['Usertype'] ?>"><?php echo $data['Usertype'] ?></option>
        <option value="admin">admin</option>
        <option value="user">user</option>
        <option value="head">head</option>
      </select>

  </div>

  <div class='w3-container'>
    <p></p>
    <input type="submit" name="update" value="UPDATE" class="ui green button submit">
    <a href="Masterlist.php" class="ui blue button submit">BACK</a>
  </div>
</form>

</div>
