


<?php
include 'db_con.php';
$conn = OpenCon();
 $query ="SELECT * FROM tb_user_track ORDER BY Track_ID";
 $result = mysqli_query($conn, $query);

 $chooseset = "SELECT deptName from tb_dept";
 $resultsetchoose = mysqli_query($conn, $chooseset);
 ?>
 <!DOCTYPE html>
 <html>
      <head>
           <title>Webslesson Tutorial | Datatables Jquery Plugin with Php MySql and Bootstrap</title>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
           <link rel="stylesheet" href="w3.css">
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
           <script src="https://cdn.datatables.net/plug-ins/1.11.5/filtering/row-based/range_dates.js"></script>
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

      </head>
      <body>
           <br /><br />
           <input type="search" list="mylist3" class="w3-input w3-border w3-round-large" name="comp" placeholder="Department" onkeyup='saveValue(this);' id="comp_name" required>
           			<datalist id='mylist3'>
           				<?php
                  				while ($row = $resultsetchoose->fetch_assoc())
                  					{

                    					echo '<option value="'.$row['deptName'].'"></option>';

           						}
           				?>
           			</datalist>
                <button type='button'>submit</button>

           <div class="container">
                <h3 align="center">Datatables Jquery Plugin with Php MySql and Bootstrap</h3>
                <br />
                <div class="table-responsive">


                     <table id="employee_data" class="table table-striped table-bordered">
                          <thead>
                               <tr>
                                 <tr>
                                 <th>ID</th>
                                 <th>USERNAME</th>
                                 <th>DEPARTMENT</th>
                                 <th>DATE</th>
                                 <th>TIME IN</th>
                                 <th>TIME OUT</th>
                                 <th>HOURS</th>
                                 <th>NOTE</th>

                                 </tr>
                               </tr>
                          </thead>
                          <?php


                          while($row = mysqli_fetch_array($result))
                                                    {
                                                         echo '
                                                         <tr>
                                                              <td>'.$row["Track_ID"].'</td>
                                                              <td>'.$row["Username"].'</td>
                                                              <td>'.$row["Department"].'</td>
                                                              <td>'.$row["Date"].'</td>
                                                              <td>'.$row["Time_In"].'</td>
                                                              <td>'.$row["Time_Out"].'</td>
                                                              <td>'.$row["Hours"].'</td>
                                                              <td>'.$row["Note"].'</td>
                                                         </tr>
                                                         ';
                                                    }

                          ?>
                     </table>
                </div>
           </div>
      </body>
 </html>


 <script>
 $(document).ready(function(){
      $('#employee_data').DataTable();
 });
 </script>
