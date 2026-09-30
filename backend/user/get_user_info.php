<?php
include __DIR__ . '/../_conection.php';
$response=new stdClass();

session_start();

if (!isset($_SESSION['code_user'])) {
	$response->state=false;
	$response->open_login=true;
	header('Content-Type: application/json');
	echo json_encode($response);
	exit;
}

$code=(int)$_SESSION['code_user'];
$dates=[];
$i=0;
$sql="SELECT * from users WHERE code_user=?";

$stmt=mysqli_prepare($con,$sql);
mysqli_stmt_bind_param($stmt,"i",$code);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_array($result)){
	$obj=new stdClass();

	$obj->code_user=$row['code_user'];
	$obj->name_user=$row['name_user'];
	$obj->secondname_user=$row['secondname_user'];
	$obj->email_user=$row['email_user'];
	$obj->address_user=$row['address_user'] ?? "";
	$obj->city_user=$row['city_user'] ?? "";
	$obj->region_user=$row['region_user'] ?? "";
	$obj->zip_user=$row['zip_user'] ?? "";
	$obj->country_user=$row['country_user'] ?? "";
	$obj->phone_user=$row['phone_user'] ?? "";
	$dates[$i]=$obj;
	$i++;
}


$response->dates=$dates;
mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($response);
