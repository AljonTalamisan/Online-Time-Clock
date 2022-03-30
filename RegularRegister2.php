<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = $confirm_password = $department = $usertype = $firstname = $middlename = $lastname = $employee_number ="";
$username_err = $password_err = $confirm_password_err = $department_err = $usertype_err = $firstname_err = $middlename_err = $lastname_err = $employee_number_err ="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT User_ID FROM tb_user WHERE Username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

	    // Validate department
    if(empty(trim($_POST["department"]))){
        $department_err = "Please select a Department.";
    } else{
        $department = trim($_POST["department"]);
    }

      // Validate Usertype
	    if(empty(trim($_POST["usertype"]))){
        $usertype_err = "Please select a Usertype.";
    } else{
        $usertype = trim($_POST["usertype"]);
    }

    // Validate firstname
  if(empty(trim($_POST["firstname"]))){
      $firstname_err = "Please enter your Firstname.";
  } else{
      $firstname = trim($_POST["firstname"]);
  }

  // Validate middlename
if(empty(trim($_POST["middlename"]))){
    $middlename_err = "Please enter your Middlename.";
} else{
    $middlename = trim($_POST["middlename"]);
}

// Validate lastname
if(empty(trim($_POST["lastname"]))){
  $lastname_err = "Please enter your Lastname.";
} else{
  $lastname = trim($_POST["lastname"]);
}

// Validate employee number
if(empty(trim($_POST["employee_number"]))){
  $employee_number_err = "Please enter your Employee Number.";
} else{
  $employee_number = trim($_POST["employee_number"]);
}

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO tb_user (EmployeeNo, Firstname, Middlename, Lastname, Department, Username, Password, Usertype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_emp_number, $param_firstname, $param_middlename, $param_lastname, $param_department, $param_username, $param_password, $param_usertype);

            // Set parameters
			$param_department = $department;
			$param_usertype = $usertype;
      $param_emp_number = $employee_number;
      $param_firstname = $firstname;
      $param_middlename = $middlename;
      $param_lastname = $lastname;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: ADMINlogin.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
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
    <a href="ADMINlogout.php" class="ui primary button w3-right">Sign Out</a>
	</div>

	<p></p>

    <div class="wrapper w3-container content">
        <h2>Sign Up (Regular Account)</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<?php

			$set = "SELECT deptName from tb_dept"; //
			$resultset = mysqli_query($link, $set);

			?>

			<div class="form-group">
				<label>Department</label>
			   	<input type="search" list="company_list" class="form-control" name="department" placeholder="Choose Department" required>

				<datalist id='company_list'>
				<?php
       				while ($row = $resultset->fetch_assoc())
       					{

         					echo '<option value="'.$row['deptName'].'"></option>';

						}
				?>
				</datalist>
			<p></p>
			</div>
      <div class="form-group">
          <label>Employee Number</label>
          <input type="text" required name="employee_number" class="form-control <?php echo (!empty($employee_number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $employee_number; ?>">
          <span class="invalid-feedback"><?php echo $employee_number_err; ?></span>
      </div>
      <div class="form-group">
          <label>Firstname</label>
          <input type="text" required name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $firstname; ?>">
          <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
      </div>
      <div class="form-group">
          <label>Middle Name</label>
          <input type="text" name="middlename" class="form-control <?php echo (!empty($middlename_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $middlename; ?>">
          <span class="invalid-feedback"><?php echo $middlename_err; ?></span>
      </div>
      <div class="form-group">
          <label>Lastname</label>
          <input type="text" required name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $lastname; ?>">
          <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
      </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" required name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" required name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" required name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
		 	<div class="form-group">
                <input type="hidden" required name="usertype" class="form-control <?php echo (!empty($usertype_err_err)) ? 'is-invalid' : ''; ?>" value="user">
                <span class="invalid-feedback"><?php echo $usertype_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>

        </form>
    </div>
<br>  <br>   <br>   <br>   <br>

<footer class="w3-container" style='background-color:#f2552c'><p></p>
	<a href="#top"><img src="../FBlogo.png" width="150" height="25"/><p></p></a>
        <a href="reset-password.php" class="btn btn-warning w3-button">Change Password</a>
		<a href="ADMINdashboard.php" class="btn btn-warning w3-button">Dashboard</a>
		<a href="ADMINattendance.php" class="btn btn-warning w3-button">Clock In</a>
		<a href="ADMINregister2.php" class="btn btn-warning w3-button">Create Admin Account</a>
    <a href="DEPTregister.php" class="btn btn-warning w3-button">Create Dept Head Account</a>
    <a href="Masterlist.php" class="btn btn-warning w3-button">Masterlist</a>
</footer>
</body>
</html>