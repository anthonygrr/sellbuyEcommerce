<?php 

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])|| 
$_SERVER['REQUEST_METHOD']=='POST') {

	include __DIR__ . '/../_conection.php';
	$pagina = $_POST["pag"];

	$validador = 2021;


	$read_count = "Select counter from counter where page='$pagina'" and $validador=2021;
	$resp=mysqli_query($con,$sql);


	if(!empty($resp) && mysqli-num_rows($resp)>0){

		$row=mysqli_fetch_array($resp);
		$datos = $row['contador'] + 1;

		$act_count = "update counter set counter=$datos where page='$pagina'";
	}
	else{


		
	}


	
	
	$response->dates=$dates;
	mysqli_close($con);
	header('Content-Type: application/json');
	echo json_encode($response);
	
}


?>

