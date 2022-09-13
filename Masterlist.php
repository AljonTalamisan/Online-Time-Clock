<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["Username"]))
{
	header("location:index.php");
}
else {
$value = $_SESSION['Username'];
}



?>
<!DOCTYPE html>
<html>
 <head>
	 <link rel="stylesheet" href="w3.css">

<!-- Responsive-->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Masterlist</title>

  <!-- CSS REFERENCES -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>

  <!-- jQuery Library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

  <!-- jQuery UI CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker-standalone.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

  <!-- Responsive CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

  <!-- jQuery UI JS -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>

  <!-- Responsive JS-->
  <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>


</head>
  <style>

body{ font: 14px sans-serif; }

footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: white;
   text-align: center;
}
  </style>
  <body>

  <div class="card container" style='background-color:#f2552c' id="top">
    <img src="../FBlogo.png" class="img-fluid rounded mx-auto d-block" alt="...">
		<h2 class="h2 text-center text-light">Fully Booked Online Time Clock (Masterlist)</h2>
		  <h5 class="w3-left w3-text-white"> Welcome <i><?php echo htmlspecialchars($_SESSION['Username']) ?></i> </h5>
	</div>


		<div class="d-grid gap-2 d-md-block container">
	 	<a href="ADMINlogout.php" class="btn btn-primary" type="button">Sign Out</a>
	 	</div>


<!-- Main Dashboard Datatable Headers-->
<div class="container">
  <div class="row">
     <div>
		 </br>
          <table id="empTable" class="table table-striped table-bordered dataTable display compact responsive" cellspacing="0" style="width:100%">
                <thead>

                    <tr>
                      <th>#</th>
                      <th>Emp. No</th>
											<th>Fullname</th>
                			<th>Firstname</th>
                			<th>Lastname</th>
                			<th>Department</th>
                			<th>Username</th>
											<th>Password</th>
                      <th>Type</th>
											<th>Status</th>
                    </tr>

                 </thead>
          </table>
    </div>
</div>
<br><br><br><br><br>
    </body>
    <script>

  $(document).ready(function(){

       // Datepicker
       $( ".datepicker" ).datepicker({
          "dateFormat": "yy-mm-dd",
          changeYear: true
       });

       // DataTable
       var dataTable = $('#empTable').DataTable({
         'processing': true,
         'serverSide': true,
         'serverMethod': 'post',
         'searching': true,
				 lengthMenu: [
						 [10, 50, 100, 150, 200, 500, 1000, -1],
						 [10, 50, 100, 150, 200, 500, 1000],
				 ],
         dom: 'Blfrtip',
         buttons: [
          {
           extend: 'excel',
           title: 'Excel Data Export'
         },
          {
           extend: 'pdf',
           title: 'FullyBooked Timesheet',
           filename: 'PDF Export'
         },
          {
           extend: 'csv',
           title: 'CSV Data Export'
         },
         {
          extend: 'print',
        },
         {
          extend: 'copy',
         }

         ],
          // Set false to Remove default Search Control
         'ajax': {
           'url':'ajaxfile4.php',
         },
         'columns': [
            { data: 'User_ID' },
            { data: 'EmployeeNo' },
						{ data: 'FullName' },
            { data: 'FirstName' },
            { data: 'LastName' },
            { data: 'Department' },
            { data: 'Username' },
						{ data: 'Password' },
            { data: 'Usertype' },
						{ data: 'Status' },
         ]
      });
 $('#empTable').on('draw.dt', function(){
 $('#empTable').Tabledit({
  'url':'action3.php',
  'dataType':'json',
  'columns':{
   'identifier' : [0, "User_ID"],
   'editable':[[5, "Department" , '{"Business Technology": "Business Technology", "Doriana Foods": "Doriana Foods", "Mobelwerke": "Mobelwerke", "Direct Sales": "Direct Sales", "Executive Office": "Executive Office", "Finance and Accounting": "Finance and Accounting", "MPC": "MPC", "Marketing": "Marketing", "Operations": "Operations", "People Management": "People Management", "Property Management": "Property Management", "Purchasing": "Purchasing", "Warehouse": "Warehouse"}'], [6, "Username"], [7, "Password"], [8, "Usertype" , '{"admin": "admin", "user": "user", "head": "head"}'], [9, "Status" , '{"active": "active", "inactive": "inactive"}'],]
 },
// Set Datepicker when Editing the date
  // onDraw: function() {
  //       $('table tr td:nth-child(4) input').each(function() { $(this).datepicker({ dateFormat: 'yy-mm-dd', todayHighlight: true, autoclose: true }); });
  //   },

// Edit and Delete Reload or Refresh
  restoreButton:false,
  onSuccess:function(data, textStatus, jqXHR)
  {
   if(data.action == 'edit')
   {
    $('#empTable').DataTable().ajax.reload();
   }
	 if(data.action == 'delete')
   {
    $('#' + data.id).remove();
    $('#empTable').DataTable().ajax.reload();
   }
  }
 });
});

      // Search button
      $('#btn_search').click(function(){
         dataTable.draw();
      });

    });


        </script>

<!-- Footer -->
<br><br>
        <!-- <div class="card ">
          <div class="card-header" style='background-color:#f2552c'>
            <a href="#top"><img src="../FBlogo.png" width="150" height="25"/>
          </div>
            <div class="card-body">
              <a href="reset-password.php" class="btn btn-primary">Change Password</a>
              <a href="ADMINattendance.php" class="btn btn-primary">Clock In</a>
              <a href="ADMINregister2.php" class="btn btn-primary">Add User</a>
              <a href="Masterlist.php" class="btn btn-primary">Masterlist</a>
            </div>
        </div> -->
				<footer class="w3-container" style='background-color:#f2552c'>
				  <h6></h6>
				<a href="#top"><img src="../FBlogo.png" width="150" height="25"/>
					<p></p></a>
          <br>
          <a href="reset-password.php" class="ui primary button">Change Password</a>
          <a href="ADMINattendance.php" class="ui primary button">Clock In</a>
        	<a href="ADMINdashboard.php" class="ui primary button">Dashboard</a>
        	<a href="ADMINregister2.php" class="ui primary button">Add User</a>
          <a href="Masterlist.php" class="ui primary button">Masterlist</a>
					<a href="schedule.php" class="ui primary button">Schedule</a>
				</footer>
   </html>
