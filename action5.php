<?php

//action.php

include('db_con.php');
$conn = OpenCon();

if($_POST['action'] == 'edit')
{
  $User_ID = $_POST['User_ID'];
  $ShiftSchedule = $_POST['ShiftSchedule'];

  $edit = "update tb_user set ShiftSchedule='$ShiftSchedule' where User_ID='$User_ID'";
  $resultedit = mysqli_query($conn, $edit);

 echo json_encode($_POST);
}

if($_POST['action'] == 'delete')
{
 $query1 = "
 DELETE FROM tb_user
 WHERE User_ID = '".$_POST["User_ID"]."'
 ";
 $statement = $conn->prepare($query1);
 $statement->execute();
 echo json_encode($_POST);
}


?>
