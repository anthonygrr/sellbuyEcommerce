  
<?php

session_start();
include __DIR__ . '/../_conection.php';
$response=new stdClass();
$code=$_SESSION['code_user'];

$name=$_POST['newName'];
$secondName=$_POST['newSN'];
$password=$_POST['newPassword'];

$sql="UPDATE users SET name_user='$name',secondname_user='$secondName',
password_user='$password'
where code_user='$code'";

 $result=mysqli_query($con,$sql);

   if ($result) {
	$response->state=true;
	header('Location: /pages/account/userInfo.php');
	$response->detail="Update Success :(";
}
else{
	$response->state=false;
	$response->detail="Update failed :(";

}

mysqli_close($con);

header('Content-Type: application/json');
echo json_encode($response);
