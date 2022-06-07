<?php

//action.php

include('db_con.php');
$conn = OpenCon();

if($_POST['action'] == 'edit')
{
  $Username = $_POST['Username'];
  $Comp_Name = $_POST['Department'];
  $Date = $_POST['Date'];
  $Time_In = $_POST['Time_In'];
  $Time_Out = $_POST['Time_Out'];
  $Hours = $_POST['Hours'];
  $Note = $_POST['Note'];
  $Track_ID = $_POST['Track_ID'];

  $edit = "update tb_user_track set Username='$Username', Department='$Comp_Name', Date='$Date', Time_In='$Time_In', Time_Out='$Time_Out', Note='$Note' where Track_ID='$Track_ID'";
  $resultedit = mysqli_query($conn, $edit);

  $sqlcalculate  = "UPDATE tb_user_track SET Hours = TIMEDIFF(Time_Out, Time_In) WHERE Track_ID='$Track_ID'";
  $resultcalc = mysqli_query($conn, $sqlcalculate);

 echo json_encode($_POST);
}

if($_POST['action'] == 'delete')
{
 $query1 = "
 DELETE FROM tb_user_track
 WHERE Track_ID = '".$_POST["Track_ID"]."'
 ";
 $statement = $conn->prepare($query1);
 $statement->execute();
 echo json_encode($_POST);
}


?>
