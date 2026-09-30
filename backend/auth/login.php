  
<?php
//1: Error de conexion
//2: Email invalido
//3: Contraseña incorrecta
include __DIR__ . '/../_conection.php';
$email_u=$_POST['email_u'];
$sql="SELECT * FROM USERS WHERE email_user='$email_u'";
$result=mysqli_query($con,$sql);
if ($result) {
	$row=mysqli_fetch_array($result);
	$count=mysqli_num_rows($result);
	if ($count!=0) {
		$password_u=$_POST['password_u'];
		if ($row['password_user']!=$password_u) {
			header('Location: /pages/auth/signin.php?e=3');
		}else{
			session_start();
			$_SESSION['code_user']=$row['code_user'];
			$_SESSION['email_user']=$row['email_user'];
			$_SESSION['name_user']=$row['name_user'];
			header('Location: /pages/index.php');
		}
	}else{
		header('Location: /pages/auth/signin.php?e=2');
	}
}else{
	header('Location: /pages/auth/signin.php?e=1');
}