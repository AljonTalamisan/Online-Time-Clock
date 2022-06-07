<?php

//action.php

include('db_con.php');
$conn = OpenCon();

if($_POST['action'] == 'edit')
{

  $Note = $_POST['Note'];
  $Track_ID = $_POST['Track_ID'];

  $edit = "update tb_user_track set Note='$Note' where Track_ID='$Track_ID'";
  $resultedit = mysqli_query($conn, $edit);

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
