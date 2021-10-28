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
<?php
 
// Include config file
require_once "config.php";
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
if( isset($_POST['login_btn'])){  // someone click login btn
	
	    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    $username = $_POST['username']; 
    //clean is the custom function to remove all harmful code
    $password = $_POST['password'];


    // run query to get db username & password i am using prepare stmt for more secure , you can use mysqli_fetch_array , but need to implement mysql_real_escape_string for sql injection

    $stmt = mysqli_prepare($link,"SELECT User_ID,Comp_Name,Username,Password,Usertype FROM tb_user WHERE Username = ? ");

    //$connection is your db connection 
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $bind_id,$bind_compname,$bind_username,$hashed_password,$bind_usertype);

    while (mysqli_stmt_fetch($stmt)) {
		$id = $bind_id;
		$compname = $bind_compname;
        $db_username = $bind_username;
        $db_password = $hashed_password;
        $usertype   = $bind_usertype;
    }

    //  do form validation           
    if($username =="" or $password =="" ){
        echo ''; 
    }else{
    if( password_verify($password, $hashed_password)){
	session_start();
    // assuming your using password_hash function to verify , or you can just use simply compare $password == db_password                                           
    // if password_verify return true meaning correct password then save all necessary sessions
	$_SESSION["loggedin"] = true;
	$_SESSION['Comp_Name'] = $compname;
    $_SESSION['Username'] = $db_username ;
    $_SESSION['Usertype'] = $usertype ;
	$_SESSION['User_ID'] = $id ;

    // first method ->    header('Location: portal.php');      
    // you can now direct to portal page{1st method } where all admin or normal user can view 
    // or you can now do separate redirection (2nd method below )
    // remember $user_role  will == 'admin' or 'normal_user'
if( $usertype == 'admin' ){
    header('Location: ADMINattendance.php');
}elseif(  $usertype == 'user'  ){
    header('Location: attendance.php');
}else{
// Password is not valid, display a generic error message
 $login_err = "Invalid username or password.";
 }

}else{
?>
<script>
	
swal({
text: "Wrong Credentials!",
icon: "error",
});
	
</script>
<?php
    }

 }                                  
    }  //  end of post request 
?>	
	<p></p>
	
    <div class="wrapper w3-container content">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login" name="login_btn">
            </div>
        </form>
    </div>
	
	<footer class="w3-container" style='background-color:#f2552c'><p></p>
	<a href="#top"><img src="../FBlogo.png" width="150" height="25"/><p></p></a>
</footer>	
</body>
</html>