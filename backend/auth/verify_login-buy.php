<?php 
    session_start();
    $response=new stdClass();
    if (!isset ($_SESSION['code_user'])) {
        $response->state=false;
        $response->detail="You are not loged";
        $response->open_login=true;
    }
    else{
        include_once __DIR__ . '/../_conection.php';
        $code_user=$_SESSION['code_user'];
        $code_prod=$_POST['code_prod'];
         

        $sql="INSERT INTO ORDERS(code_user,code_prod,date_order,state_order,address_order,phone_order) 
         VALUES
         ($code_user,$code_prod,now(),1,'','')";
         $result=mysqli_query($con,$sql);
        // $response->state=true;
         //$response->detail="You are loged";

        if ($result) {
            $response->state=true;
            $response->detail="Product Added succefully";
        }
        else{
            $response->state=false;
            $response->detail="Failed Action";

        }
        mysqli_close($con);

    }

    //mysqli_close($con);
    header('Content-Type: application/json');
    echo json_encode($response);
    