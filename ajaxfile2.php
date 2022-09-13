<?php
session_start();

if(!isset($_SESSION["Username"]))
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
$searchByFromdate = mysqli_real_escape_string($con,$_POST['searchByFromdate']);
$searchByTodate = mysqli_real_escape_string($con,$_POST['searchByTodate']);

## Search
$searchQuery = " ";

// Date filter
if($searchByFromdate != '' && $searchByTodate != ''){
    $searchQuery .= " and (Date between '".$searchByFromdate."' and '".$searchByTodate."' ) ";
}

## Total number of records without filtering
$sel = mysqli_query($con,"select count(*) as allcount from tb_user_track");
$records = mysqli_fetch_assoc($sel);
$totalRecords = $records['allcount'];

## Total number of records with filtering
$sel2 = mysqli_query($con,"select count(*) as allcount from tb_user_track WHERE 1 ".$searchQuery);
$records2 = mysqli_fetch_assoc($sel2);
$totalRecordwithFilter = $records2['allcount'];

## Fetch records
$empQuery = "SELECT Track_ID, FullName, Department, Date, DATE_FORMAT(Time_In,'%h:%i %p') as Time_In,  DATE_FORMAT(Time_Out,'%h:%i %p') as Time_Out, DATE_FORMAT(Hours,'%H:%i') as Hours, Late_EarlyHours, Approval, Note from tb_user_track
WHERE 1 ".$searchQuery." AND FullName='".$_SESSION['FullName']."' order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
$empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row = mysqli_fetch_assoc($empRecords)) {
    $data[] = array(
      "Track_ID"=>$row['Track_ID'],
      "FullName"=>$row['FullName'],
      "Department"=>$row['Department'],
      "Date"=>$row['Date'],
      "Time_In"=>$row['Time_In'],
      "Time_Out"=>$row['Time_Out'],
      "Hours"=>$row['Hours'],
			"Late_EarlyHours"=>$row['Late_EarlyHours'],
			"Approval"=>$row['Approval'],
      "Note"=>$row['Note']
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
