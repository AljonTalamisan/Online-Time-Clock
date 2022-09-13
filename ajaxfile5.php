<?php
session_start();

if(!isset($_SESSION["Department"]))
{
	header("location:index.php");
}

include 'db_con.php';
$con = OpenCon();

## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

## Date search value
// $searchByFromdate = mysqli_real_escape_string($con,$_POST['searchByFromdate']);
// $searchByTodate = mysqli_real_escape_string($con,$_POST['searchByTodate']);

## Search
$searchQuery = " ";
if($searchValue != ''){
    $searchQuery = " and (User_ID like '%".$searchValue."%' or Department like '%".$searchValue."%' or FullName like '%".$searchValue."%') ";
}

// // Date filter
// if($searchByFromdate != '' && $searchByTodate != ''){
//     $searchQuery .= " and (Date between '".$searchByFromdate."' and '".$searchByTodate."' ) ";
// }

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from tb_user");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel2 = mysqli_query($con,"select count(*) as allcount from tb_user WHERE 1 ".$searchQuery);
$records2 = mysqli_fetch_assoc($sel2);
$totalRecordwithFilter = $records2['allcount'];

## Fetch records
$empQuery = "SELECT User_ID, EmployeeNo, FullName, Department, ShiftSchedule from tb_user
 WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
      "User_ID"=>$row['User_ID'],
      "EmployeeNo"=>$row['EmployeeNo'],
			"FullName"=>$row['FullName'],
      "Department"=>$row['Department'],
			"ShiftSchedule"=>$row['ShiftSchedule'],
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
die;
?>
