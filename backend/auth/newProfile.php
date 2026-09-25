  
<?php
include __DIR__ . '/../_conection.php';
$response=new stdClass();

$name=$_POST['firstname'];
$secondName=$_POST['lastname'];
$email=$_POST['email'];
$password=$_POST['password'];

$sql = "INSERT INTO users (name_user, secondname_user, email_user, password_user, state_user)
 VALUES('$name', '$secondName', '$email', '$password', 1)";


 $result=mysqli_query($con,$sql);

   if ($result) {
	$response->state=true;
	header('Location: /pages/index.php');
	$response->detail="User Inserted :(";
}
else{
	$response->state=false;
	$response->detail="Insert failed :(";

}

mysqli_close($con);
header('Content-Type: application/json');
echo json_encode($response);
