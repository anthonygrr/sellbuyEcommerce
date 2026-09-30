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
        $code_prod=intval($_POST['code_prod']);
        $quantity=isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        if ($quantity<1) {
            $quantity=1;
        }
        elseif ($quantity>99) {
            $quantity=99;
        }

        // ORDERS has no quantity column: N units become N identical rows
        // in a single multi-row INSERT. Values are ints after the casts.
        $tuples=array();
        for ($i=0; $i<$quantity; $i++) {
            $tuples[]="($code_user,$code_prod,now(),1,'','')";
        }

        $sql="INSERT INTO ORDERS(code_user,code_prod,date_order,state_order,address_order,phone_order) 
         VALUES
         ".implode(',',$tuples);
         $result=mysqli_query($con,$sql);
        // $response->state=true;
         //$response->detail="You are loged";

        if ($result) {
            $response->state=true;
            $response->detail="Added $quantity unit(s) to cart";
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
    