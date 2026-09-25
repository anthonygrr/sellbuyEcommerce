<?php
include __DIR__ . '/../_conection.php';
// $response=new stdClass();
$response2=new stdClass();

//$datos=array();
// $datos=[];
// $i=0;
// $sql="select * from products where offer_prod=0";
// $result=mysqli_query($con,$sql);
// while($row=mysqli_fetch_array($result)){
// 	$obj=new stdClass();
// 	$obj->code_prod=$row['code_prod'];
// 	$obj->name_prod=$row['name_prod'];
// 	$obj->description_prod=$row['description_prod'];
// 	$obj->price_prod=$row['price_prod'];
// 	$obj->image_route=$row['image_route'];

// 	$datos[$i]=$obj;
// 	$i++;
// }


$offers=[];
$e=0;
$sqloffers="select * from products where offer_prod=1";
$result2=mysqli_query($con,$sqloffers);
while($row=mysqli_fetch_array($result2)){
	$obj2=new stdClass();
	$obj2->code_prod=$row['code_prod'];
	$obj2->name_prod=$row['name_prod'];
	$obj2->description_prod=$row['description_prod'];
	$obj2->price_prod=$row['price_prod'];
	$obj2->image_route=$row['image_route'];
	$obj2->offer_prod=$row['offer_prod'];
	$offers[$e]=$obj2;
	$e++;
}

// $response->datos=$datos;
 $response2->offers=$offers;
mysqli_close($con);
header('Content-Type: application/json');
// echo json_encode($response);
echo json_encode($response2);
