<?php
include __DIR__ . '/../_conection.php';
$response=new stdClass();

session_start();
$code_user=$_SESSION['code_user'];

//$datos=array();
$datos=[];
$i=0;
$sql="";


	$sql="SELECT ord.*,prod. *,
	CASE WHEN ord.state_order=2 THEN
	'To Pay'
	ELSE
				CASE WHEN ord.state_order=3 THEN
				'To Deliver'
				ELSE
				'Other'
				END 


	END stateText
	 FROM orders ord
	inner join products prod on
	ord.code_prod=prod.code_prod
	WHERE ord.code_user=$code_user";




$result=mysqli_query($con,$sql);
while($row=mysqli_fetch_array($result)){
	$obj=new stdClass();

	$obj->name_prod=utf8_decode($row['name_prod']);
	$obj->description_prod=utf8_decode($row['description_prod']);
	$obj->price_prod=$row['price_prod'];
	$obj->image_route=$row['image_route'];
	$obj->date_order=$row['date_order'];
	$obj->address_order=$row['address_order'];
	$obj->phone_order=$row['phone_order'];
	$obj->state_order=$row['stateText'];
	$datos[$i]=$obj;
	$i++;
}


$response->datos=$datos;
//  $response2->offers=$offers;
mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($response);
// echo json_encode($response2);
