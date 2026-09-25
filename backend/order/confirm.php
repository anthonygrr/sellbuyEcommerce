<?php 
    session_start();
    $response=new stdClass();
        include_once __DIR__ . '/../_conection.php';
        $code_user=$_SESSION['code_user'];
        $address_order=$_POST['address_user'];
        $phone_order=$_POST['phone_user'];
        $pay_type=$_POST['pay_type'];
        $card_user=$_POST['card_user'];   


        
if ($pay_type==1) {
            $state_order=2; //to process
        }else{
            $state_order=3; //to deliver
        }

        $sql="UPDATE orders SET address_order='$address_order',phone_order='$phone_order',state_order=$state_order, card_order='$card_user'
        where state_order=1";

         $result=mysqli_query($con,$sql);

           if ($result) {
            $response->state=true;
        }
        else{
            $response->state=false;
            $response->detail="No se pudo actualizar el pedido. Intente mas tarde";

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
    