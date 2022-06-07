<?php
//fetch.php
include 'db_con.php';
$conn = OpenCon();
$columns = array('Track_ID', 'Username', 'Department', 'Date', 'Time_In', 'Time_Out', 'Hours', 'Note');

$query = "SELECT * FROM tb_user_track WHERE ";

if($_POST["is_date_search"] == "yes")
{
 $query .= 'Date BETWEEN "'.$_POST["start_date"].'" AND "'.$_POST["end_date"].'" AND ';
}

if(isset($_POST["search"]["value"]))
{
 $query .= '
  (Track_ID LIKE "%'.$_POST["search"]["value"].'%"
  OR Username LIKE "%'.$_POST["search"]["value"].'%"
  OR Department LIKE "%'.$_POST["search"]["value"].'%"
  OR Date LIKE "%'.$_POST["search"]["value"].'%"
  OR Time_In LIKE "%'.$_POST["search"]["value"].'%"
  OR Time_Out LIKE "%'.$_POST["search"]["value"].'%"
  OR Hours LIKE "%'.$_POST["search"]["value"].'%"
  OR Note LIKE "%'.$_POST["search"]["value"].'%")
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].'
 ';
}
else
{
 $query .= 'ORDER BY Track_ID DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = mysqli_num_rows(mysqli_query($conn, $query));

$result = mysqli_query($conn, $query . $query1);

$data = array();

while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["Track_ID"];
 $sub_array[] = $row["Username"];
 $sub_array[] = $row["Department"];
 $sub_array[] = $row["Date"];
 $sub_array[] = $row["Time_In"];
 $sub_array[] = $row["Time_Out"];
 $sub_array[] = $row["Hours"];
 $sub_array[] = $row["Note"];
 $data[] = $sub_array;
}

function get_all_data($conn)
{
 $query = "SELECT * FROM tb_user_track";
 $result = mysqli_query($conn, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($conn),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>

<?php
$query2 = "
 SELECT * FROM tb_user_track
 INNER JOIN tb_dept
 ON tb_dept.dept_Name = tb_user_track.Department
";
$query2 .= " WHERE ";
if(isset($_POST["is_department"]))
{
 $query2 .= "tb_user_track.deptName = '".$_POST["is_department"]."' AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query2 .= '(tb_user_track.Track_ID LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Username LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Department LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Date LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Time_In LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Time_Out LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Hours LIKE "%'.$_POST["search"]["value"].'%" ';
 $query2 .= 'OR tb_user_track.Note LIKE "%'.$_POST["search"]["value"].'%") ';
}

?>
