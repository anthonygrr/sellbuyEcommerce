<?php
session_start();
header('Content-Type: application/json');

// Cart feed is per-user: without a logged user return an empty list, no query.
if (!isset($_SESSION['code_user'])) {
	echo json_encode((object)array('datos' => array()));
	exit;
}

$code_user=(int)$_SESSION['code_user'];
include __DIR__ . '/../_conection.php';
$response=new stdClass();

// The connection sets no explicit charset, so bytes may arrive as latin1.
// Convert only when they are NOT valid UTF-8: utf8_encode() would be
// deprecated (PHP 8.2) and double-encode an already-UTF-8 string.
function to_utf8($value){
	$value=(string)$value;
	return mb_check_encoding($value,'UTF-8') ? $value
		: mb_convert_encoding($value,'UTF-8','ISO-8859-1');
}

// One row per distinct product: N units of the same product become a
// single object with its aggregated quantity.
$datos=[];
$sql="SELECT prods.code_prod, prods.name_prod, prods.image_route, prods.price_prod, COUNT(*) AS qty
FROM orders ord
INNER JOIN products prods ON ord.code_prod = prods.code_prod
WHERE ord.state_order = 1 AND ord.code_user = ?
GROUP BY prods.code_prod, prods.name_prod, prods.image_route, prods.price_prod
ORDER BY MIN(ord.code_order) ASC";
$stmt=mysqli_prepare($con,$sql);
mysqli_stmt_bind_param($stmt,"i",$code_user);
mysqli_stmt_execute($stmt);
$result=mysqli_stmt_get_result($stmt);
while($row=mysqli_fetch_array($result)){
	$obj=new stdClass();
	$obj->code_prod=$row['code_prod'];
	$obj->name_prod=to_utf8($row['name_prod']);
	$obj->image_route=$row['image_route'];
	$obj->price_prod=$row['price_prod'];
	$obj->qty=(int)$row['qty'];
	$datos[]=$obj;
}
$response->datos=$datos;

mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($response);





// $datos=[];
// $i=0;
// $sql="select *,ped.estado estadoped from pedido ped
// inner join producto pro
// on ped.codpro=pro.codpro
// where ped.estado=1";

// $result=mysqli_query($con,$sql);
// while($row=mysqli_fetch_array($result)){
// 	$obj=new stdClass();
// 	$obj->codped=$row['codped'];
// 	$obj->codpro=$row['codpro'];
// 	$obj->nompro=utf8_encode($row['nompro']);
// 	$obj->prepro=$row['prepro'];
// 	$obj->rutimgpro=$row['rutimgpro'];
// 	$obj->fecped=$row['fecped'];
// 	$obj->dirusuped=utf8_encode($row['dirusuped']);
// 	$obj->telusuped=$row['telusuped'];
// 	$obj->estado=estado2texto($row['estadoped']);
// 	$datos[$i]=$obj;
// 	$i++;
// }



// $response->datos=$datos;

// mysqli_close($con);
// header('Content-Type: application/json');
// echo json_encode($response);
