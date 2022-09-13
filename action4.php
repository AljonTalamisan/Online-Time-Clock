<?php

//action.php

include('db_con.php');
$conn = OpenCon();

if($_POST['action'] == 'edit')
{
  $Time_In = $_POST['Time_In'];
  $Time_Out = $_POST['Time_Out'];
  $Approval = $_POST['Approval'];
  $Note = $_POST['Note'];
  $Track_ID = $_POST['Track_ID'];

  $edit = "update tb_user_track set Time_In='$Time_In', Time_Out='$Time_Out', Approval='$Approval', Note='$Note' where Track_ID='$Track_ID'";
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
