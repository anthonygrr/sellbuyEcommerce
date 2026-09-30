<?php
session_start();
header('Content-Type: application/json');

// Buy History is per-user: without a logged user return an empty list, no query.
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

function state2text($id){
	switch ((string)$id) {
		case '2':
			return 'To Pay';
		case '3':
			return 'To Deliver';
		case '4':
			return 'Incoming';
		case '5':
			return 'Delivered';
		default:
			return '';
	}
}

// Bought products, grouped per product and state: repeated purchases of the
// same product collapse into a single row with the aggregated quantity.
$datos=[];
$sql="SELECT ord.code_prod, prods.name_prod, prods.image_route, prods.price_prod,
       ord.state_order, COUNT(*) AS qty, MAX(ord.date_order) AS last_date
FROM orders ord
INNER JOIN products prods ON ord.code_prod = prods.code_prod
WHERE ord.state_order != 1 AND ord.code_user = ?
GROUP BY ord.code_prod, ord.state_order
ORDER BY last_date DESC";
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
	$obj->subtotal=number_format((float)$row['price_prod'] * (int)$row['qty'], 2, '.', '');
	$obj->state_order=$row['state_order'];
	$obj->state_order_text=state2text($row['state_order']);
	$obj->date=$row['last_date'];
	$datos[]=$obj;
}
$response=(object)['datos' => $datos];

mysqli_close($con);
echo json_encode($response);
