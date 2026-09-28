<?php

session_start();
include __DIR__ . '/../_conection.php';

if (!isset($_SESSION['code_user'])) {
	header('Location: /pages/auth/signin.php');
	exit;
}

$code=(int)$_SESSION['code_user'];

// Trim and truncate a POST field to fit its DB column length.
function readField($key,$maxLength){
	$value=isset($_POST[$key]) ? trim((string)$_POST[$key]) : "";
	if (function_exists("mb_substr")) {
		return mb_substr($value,0,$maxLength,"UTF-8");
	}
	return substr($value,0,$maxLength);
}

$newName=readField("newName",40);
$newSN=readField("newSN",40);
$newPassword=readField("newPassword",60);
$addressUser=readField("address_user",150);
$cityUser=readField("city_user",60);
$regionUser=readField("region_user",60);
$zipUser=readField("zip_user",10);
$countryUser=readField("country_user",60);
$phoneUser=readField("phone_user",15);

$sql="UPDATE users SET name_user=?, secondname_user=?, address_user=?, city_user=?, region_user=?, zip_user=?, country_user=?, phone_user=?";
$types="ssssssss";
$updatePassword=($newPassword!=="");
if ($updatePassword) {
	$sql.=", password_user=?";
	$types.="s";
}
$sql.=" WHERE code_user=?";
$types.="i";

$stmt=mysqli_prepare($con,$sql);
if ($stmt) {
	if ($updatePassword) {
		mysqli_stmt_bind_param($stmt,$types,$newName,$newSN,$addressUser,$cityUser,$regionUser,$zipUser,$countryUser,$phoneUser,$newPassword,$code);
	} else {
		mysqli_stmt_bind_param($stmt,$types,$newName,$newSN,$addressUser,$cityUser,$regionUser,$zipUser,$countryUser,$phoneUser,$code);
	}
	$updated=mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
} else {
	$updated=false;
}

mysqli_close($con);

if ($updated) {
	header('Location: /pages/account/userInfo.php?updated=1');
} else {
	header('Location: /pages/account/userInfo.php?updated=0');
}
exit;
