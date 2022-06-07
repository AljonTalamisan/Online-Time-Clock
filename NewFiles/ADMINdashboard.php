<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.js"></script>

  <!-- bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>



  <!-- jQuery Library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js" integrity="sha512-s5u/JBtkPg+Ff2WEr49/cJsod95UgLHbC00N/GglqdQuLnYhALncz8ZHiW/LxDRGduijLKzeYb7Aal9h3codZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>


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
  <body class="">

  <div class="" style='background-color:#f2552c' id="top">
    <img src="../FBlogo.png" class="img-fluid rounded mx-auto d-block" alt="...">
		<h2 class="h2 text-center text-light">Fully Booked Online Time Clock</h2>
	</div>

  <div class="d-grid gap-2 d-md-block container">
  <a href="ADMINlogout.php" class="btn btn-primary" type="button">Sign Out</a>
  </div>


       <br />
       <div class="container">
         <div class="row">
            <div class="col-lg-12">
       <table>
       <tr>
         <td>
            <input type='text' readonly id='search_fromdate' class="datepicker" placeholder='From date'>
         </td>
         <td>
            <input type='text' readonly id='search_todate' class="datepicker" placeholder='To date'>
         </td>
         <td>
            <input type='button' id="btn_search" value="Search">
         </td>
       </tr>
     </table>
          </div>
        </div>
     </div>




<div class="container">
  <div class="row">
     <div class="col-lg-12">
            <table id="empTable" class="table table-striped table-bordered dataTable display nowrap responsive" cellspacing="0" style="width:100%">
                 <thead>

                        <tr>
                        <th>#</th>
                        <th>USERNAME</th>
                        <th>DEPARTMENT</th>
                        <th>DATE</th>
                        <th>TIME IN</th>
                        <th>TIME OUT</th>
                        <th>HOURS</th>
                        <th>NOTE</th>

                        </tr>

                 </thead>

            </table>
    </div>
</div>


    </body>

    <script type="text/javascript">
          $(function () {
              $('#datetimepicker3').datetimepicker({
                  icons: {
                      time: "fa fa-clock",
                      date: "fa fa-calendar",
                      up: "fa fa-arrow-up",
                      down: "fa fa-arrow-down"
                  }
              });
          });
       </script>



    <script>

    $(document).ready(function(){

       // Datapicker
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
         dom: 'Blfrtip',
         buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print'
         ],
          // Set false to Remove default Search Control
         'ajax': {
           'url':'ajaxfile.php',
           'data': function(data){
              // Read values
              var from_date = $('#search_fromdate').val();
              var to_date = $('#search_todate').val();

              // Append to data
              data.searchByFromdate = from_date;
              data.searchByTodate = to_date;
           }
         },
         'columns': [
            { data: 'Track_ID' },
            { data: 'Username' },
            { data: 'Department' },
            { data: 'Date' },
            { data: 'Time_In' },
            { data: 'Time_Out' },
            { data: 'Hours' },
            { data: 'Note' },
         ]
      });
 $('#empTable').on('draw.dt', function(){
 $('#empTable').Tabledit({
  'url':'action.php',
  'dataType':'json',
  'columns':{
   'identifier' : [0, "Track_ID"],
   'editable':[[1, "Username"], [2, "Department"], [3, "Date"], [4, "Time_In"], [5, "Time_Out"], [6, "Hours"], [7, "Note"]]
  },
  onDraw: function() {
        $('table tr td:nth-child(4) input').each(function() { $(this).datepicker({ dateFormat: 'yy-mm-dd', todayHighlight: true, autoclose: true }); });
    },

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



        <div class="card ">
          <div class="card-header" style='background-color:#f2552c'>
            <a href="#top"><img src="../FBlogo.png" width="150" height="25"/>
          </div>
            <div class="card-body">
              <a href="reset-password.php" class="btn btn-primary">Change Password</a>
              <a href="ADMINattendance.php" class="btn btn-primary">Clock In</a>
              <a href="ADMINregister2.php" class="btn btn-primary">Add User</a>
              <a href="Masterlist.php" class="btn btn-primary">Masterlist</a>
            </div>
        </div>
   </html>
