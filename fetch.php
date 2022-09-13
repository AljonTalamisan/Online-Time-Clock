<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "db_form");

$column = array("tb_user.Username", "tb_user_track.Department", "tb_user_track.Date", "tb_user_track.Time_In", "tb_user_track.Time_Out", "tb_user_track.Hours", "tb_user_track.Note");
$query = "
SELECT * FROM tb_user_track

";
$query .= " WHERE ";
if(isset($_POST["is_username"]))
{
 $query .= "tb_user_track.Username = '".$_POST["is_username"]."' AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(tb_user_track.Track_ID LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR tb_user.Username LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR tb_user_track.Department LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR tb_user_track.Date LIKE "%'.$_POST["search"]["value"].'%") ';
 $query .= 'OR tb_user_track.Time_In LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR tb_user_track.Time_Out LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR tb_user_track.Hours LIKE "%'.$_POST["search"]["value"].'%" ';
 $query .= 'OR tb_user_track.Note LIKE "%'.$_POST["search"]["value"].'%") ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY tb_user_track.Track_ID DESC ';
}

$query1 = '';

if($_POST["length"] != 1)
{
 $query1 .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$resultSet = mysqli_query($connect, $query);
var_dump($resultSet);

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

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

function get_all_data($connect)
{
 $query = "SELECT * FROM tb_user_track";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>
