<?php 
    session_start();
    $response=new stdClass();
    header('Content-Type: application/json');

    if (!isset($_SESSION['code_user'])) {
        $response->state=false;
        $response->detail="You are not logged";
        $response->open_login=true;
        echo json_encode($response);
        exit;
    }

        include_once __DIR__ . '/../_conection.php';
        $code_user=(int)$_SESSION['code_user'];
        $address_order=isset($_POST['address_user']) ? (string)$_POST['address_user'] : '';
        $phone_order=isset($_POST['phone_user']) ? (string)$_POST['phone_user'] : '';
        $pay_type=isset($_POST['pay_type']) ? $_POST['pay_type'] : 1;
        $card_user=isset($_POST['card_user']) ? (string)$_POST['card_user'] : '';


        
if ($pay_type==1) {
            $state_order=2; //to process
        }else{
            $state_order=3; //to deliver
        }

        // Scoped to the logged user's pending cart rows only (state 1).
        $sql="UPDATE orders SET address_order=?,phone_order=?,state_order=?,card_order=?
        where state_order=1 and code_user=?";

         $stmt=mysqli_prepare($con,$sql);
         mysqli_stmt_bind_param($stmt,"ssisi",$address_order,$phone_order,$state_order,$card_user,$code_user);
         $result=mysqli_stmt_execute($stmt);

           if ($result) {
            $response->state=true;
        }
        else{
            $response->state=false;
            $response->detail="Could not update the order. Please try again later";

        }
        
        


        // $sql="UPDATE orders SET address_order='$address_order',phone_order='$telusu',state_order=$estado
        // where state_order=1";

        // $result=mysqli_query($con,$sql);

        // if ($result) {
        //     $response->state=true;
        // }
        // else{
        //     $response->state=false;
        //     $response->detail="No se pudo actualizar el pedido. Intente mas tarde";

        // }
        
        mysqli_close($con);
    //mysqli_close($con);
    header('Content-Type: application/json');
    echo json_encode($response);
    