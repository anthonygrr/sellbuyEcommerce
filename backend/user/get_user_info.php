<?php
include __DIR__ . '/../_conection.php';
$response=new stdClass();

session_start();
$code=$_SESSION['code_user'];

//$dates=array();
$dates=[];
$i=0;
$sql="";
$sql="SELECT * from users WHERE code_user=$code";




$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)){
	$obj=new stdClass();

	// $obj->name_prod=utf8_decode($row['name_prod']);
	$obj->code_user=utf8_decode($row['code_user']);
	$obj->name_user=$row['name_user'];
	$obj->secondname_user=$row['secondname_user'];
	$obj->email_user=$row['email_user'];
	$obj->password_user=$row['password_user'];
	$dates[$i]=$obj;
	$i++;
}


$response->dates=$dates;
mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($response);

