<?php

//action.php

include('db_con.php');
$conn = OpenCon();

if($_POST['action'] == 'edit')
{
  $User_ID = $_POST['User_ID'];
  $FirstName = $_POST['FirstName'];
  $MiddleName = $_POST['MiddleName'];
  $LastName = $_POST['LastName'];
  $Department = $_POST['Department'];
  $Username = $_POST['Username'];
  $Usertype = $_POST['Usertype'];

  $edit = "update tb_user set FirstName='$FirstName', MiddleName='$MiddleName', LastName='$LastName', Department='$Department', Username='$Username', Usertype='$Usertype' where User_ID='$User_ID'";
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
