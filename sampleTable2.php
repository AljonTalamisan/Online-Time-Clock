<?php
include 'db_con.php';
$conn = OpenCon();
 $query ="SELECT * FROM tb_user_track ORDER BY Track_ID";
 $result = mysqli_query($conn, $query);
?>

<html>
 <head>
  <title>Date Range Search in Datatables using PHP Ajax</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <style></style>



       <h3 align="center">Datatables Jquery Plugin with Php MySql and Bootstrap</h3>
       <br />

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
            <table id="example" class="display" style="width:100%">
                 <thead>

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

                 </thead>
                 <tbody>
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
                 </tbody>
            </table>




    </body>
    <script>

    $(document).ready(function () {

            $.fn.dataTable.ext.search.push(
                function (settings, data, dataIndex) {
                    var min = $('#min').datepicker("getDate");
                    var max = $('#max').datepicker("getDate");
										var startDate = new Date(data[4])
                    if (min == null && max == null) { return true; }
                    if (min == null && startDate <= max) { return true;}
                    if(max == null && startDate >= min) {return true;}
                    if (startDate <= max && startDate >= min) { return true; }
                    return false;
                }
            );


            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true , dateFormat:"yy/mm/dd"});
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true, dateFormat:"yy/mm/dd" });
            var table = $('#example').DataTable();

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                table.draw();
            });
        });

        </script>
   </html>
