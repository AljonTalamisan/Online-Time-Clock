<?php

//action.php

include('db_con.php');
$conn = OpenCon();

if($_POST['action'] == 'edit')
{
  $User_ID = $_POST['User_ID'];
  $Department = $_POST['Department'];
  $Username = $_POST['Username'];
  $Password = $_POST['Password'];
  $Usertype = $_POST['Usertype'];
  $Status = $_POST['Status'];

  $edit = "update tb_user set Department='$Department', Username='$Username', Password='$Password', Usertype='$Usertype', Status='$Status' where User_ID='$User_ID'";
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
