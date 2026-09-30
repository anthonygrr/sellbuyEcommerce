<?php
include __DIR__ . '/../_conection.php';
$response=new stdClass();


//$datos=array();
$datos=[];
$text = $_POST['text'];
$i=0;
$sql="select * from products where state_prod=1 and name_prod LIKE '%$text%'";

$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)){
	$obj=new stdClass();
	$obj->code_prod=$row['code_prod'];
	$obj->name_prod=$row['name_prod'];
	$obj->description_prod=$row['description_prod'];
	$obj->price_prod=$row['price_prod'];
	$obj->image_route=$row['image_route'];
	$datos[$i]=$obj;
	$i++;
}



$response->datos=$datos;
mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($response);

