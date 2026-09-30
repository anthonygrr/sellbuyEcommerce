<?php
session_start();
$response=new stdClass();
if (!isset ($_SESSION['code_user'])) {
    $response->state=false;
    $response->detail="You are not logged";
    $response->open_login=true;
}
else{
    include_once __DIR__ . '/../_conection.php';
    $code_user=intval($_SESSION['code_user']);
    $code_prod=intval($_POST['code_prod']);

    // Both values are ints after the casts: bind both as "i".
    $sql="DELETE FROM orders WHERE code_user=? AND code_prod=? AND state_order=1";
    $stmt=mysqli_prepare($con,$sql);
    mysqli_stmt_bind_param($stmt,"ii",$code_user,$code_prod);
    $result=mysqli_stmt_execute($stmt);

    if ($result) {
        $response->state=true;
        $response->detail="Product removed from cart";
    }
    else{
        $response->state=false;
        $response->detail="Failed to remove the product";
    }
    mysqli_close($con);

}

header('Content-Type: application/json');
echo json_encode($response);
