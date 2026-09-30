<?php 

    session_start();
    if (!isset($_SESSION['code_user'])) {
       header('location: /pages/index.php');
    }

    // Lazy reconciliation of an interrupted Mercado Pago return: the toast
    // promises "your order will update shortly" — this is what makes it true.
    // The gate above does not exit, so guard the session user access too.
    if (!empty($_SESSION['mp_pending_ref']) && !empty($_SESSION['code_user'])) {
        require_once __DIR__ . '/../../backend/payment/mp_reconcile.php';
        $pendingRef = (string)$_SESSION['mp_pending_ref'];
        $pendingUser = (int)$_SESSION['code_user'];
        if (isset($_GET['mp']) && $_GET['mp'] === 'cancel') {
            // Explicit cancel: no payment is coming, stop checking.
            unset($_SESSION['mp_pending_ref']);
        } elseif (mp_ref_matches_user($pendingRef, $pendingUser)
            && mp_ref_is_fresh($pendingRef)
            && mp_reconcile_mark_paid($pendingRef)) {
            unset($_SESSION['mp_pending_ref']);
            header('Location: /pages/checkout/order.php?mp=success');
            exit;
        } elseif (!mp_ref_is_fresh($pendingRef) || !mp_ref_matches_user($pendingRef, $pendingUser)) {
            // Stale or foreign ref: drop it, never keep checking.
            unset($_SESSION['mp_pending_ref']);
        }
        // Fresh, matching, but not paid yet: keep the ref, render normally.
    }

    ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- Favicon -->
    <link rel="shortcut icon" href="/images/hnet.com-image.ico" type="image/x-icon" />
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
    />

    <!-- Custom StyleSheet -->
    <link rel="stylesheet" href="/css/styles.css" />
    <title>Cart</title>
  </head>

  <body>

    <!-- Navigation -->
    <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>
    <!-- Cart Items -->
    <div class="container cart" id="cart_prods">

    <table>
    <tr>
          <th>Product</th>
          <!-- <th>Quantity</th> -->
          <th>Subtotal</th>
        </tr>

    </table>

<div class="container" id="tableprods">
  <table> 
       
        <!-- <tr>
          <td>
            <div class="cart-info">
              <img src="/images/products/product1.jpg" alt="" />
              <div>
                <p>Bambi Print Mini Backpack</p>
                <span>Price: $500.00</span>
                <p>Date: 25-10-2021</p>
                <p>State: 1</p>
                <p>Address: 8 de Mayo</p>
                <p>Phone: +527861234567</p>
           
                <a href="#">remove</a>
              </div>
            </div>
          </td>
           <td><input type="number" value="1" min="1" /></td>
          <td>$50.00</td>
        </tr>   
 -->

      </table>
</div>

<!-- 
      <table > 
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>

        <tr>
          <td>
            <div class="cart-info">
              <img src="/images/products/product1.jpg" alt="" />
              <div>
                <p>Bambi Print Mini Backpack</p>
                <span>Price: $500.00</span>
                <p>Date: 25-10-2021</p>
                <p>State: 1</p>
                <p>Address: 8 de Mayo</p>
                <p>Phone: +527861234567</p>
           
                <a href="#">remove</a>
              </div>
            </div>
          </td>
          <td><input type="number" value="1" min="1" /></td>
          <td>$50.00</td>
        </tr>   
      </table> -->
<div class="container">

<!-- <h3>Datos de Pago</h3> -->
        <!-- <div class="p-line">  <div>   TOTAL:    </div> $ <span id="montototal"></span> </div>
        <div class="p-line">  <div>  BANCO:    </div> BANAMEX </div>
        <div class="p-line">  <div>N° de Cuenta:         </div>192-4567845-006  </div>
        <div class="p-line">  <div>  Representante:    </div>Encargado de ventas  </div> -->
        <p class="note-detail"> <b>NOTE: </b>  To confirm the purchase you must make the deposit for the total amount and send the voucher to the following email example@gmail.com or whatsapp number 999 666 33
        </p>
</div>

      <div class="total-price">
        <table>


          <!-- <tr>
            <td>Subtotal</td>
            <td>$200</td>
          </tr>
          <tr>
            <td>Tax</td>
            <td>$50</td>
          </tr> -->

          <tr>
            <td >Total</td>
            <td id="mtotal">$250</td>   
          </tr>

          <tr>
            <td>BANK</td>
            <td>BANAMEX</td>   
          </tr>

          <tr>
            <td>N° Account</td>
            <td>192-4567845-006</td>   
          </tr>

          <tr>
            <td>Representant</td>
            <td>Manager</td>   
          </tr>
        
        
        </table>
       
        <a href="#" class="checkout btn" >Proceed To Checkout</a>
        
      </div> 
    

    </div>


<!-- 
    <div class="container cart "> 
      
    </div> -->

     <!-- Footer -->
     <?php include __DIR__ . "/../../backend/layouts/_footer.php"?>
  <!-- End Footer -->

    <!-- Custom Scripts -->
    <script src="/js/dark.js"></script>
    <script src="/js/products.js"></script>
    <script src="/js/slider.js"></script>
    <script src="/js/index.js"></script>
    <script  type="text/javascript" src="/js/search.js"></script>


    <script type="text/javascript">

$(document).ready(function(){

    // Mercado Pago Checkout Pro result toasts (back_urls land on ?mp=...).
    var mpResult = new URLSearchParams(window.location.search).get('mp');
    if (mpResult === 'success') {
        notifySuccess("Payment approved - your order is on its way");
    } else if (mpResult === 'unverified') {
        notifyWarning("Payment not verified yet - your order will update shortly");
    } else if (mpResult === 'pending') {
        notifyInfo("Payment pending confirmation");
    } else if (mpResult === 'cancel') {
        notifyInfo("Payment cancelled");
    }

    $.ajax({
        url:'/backend/order/get_processed.php',
        type:'POST',
        data:{},
        success:function(data){
            console.log(data);

            let monto= 0;

            let html='';

            for (var i = 0; i < data.datos.length; i++) {
                html+=
                '<table>'+
                '<tr>'+              
          '<td>'+ 
            '<div class="cart-info">'+ 
              '<img src="/images/products/'+data.datos[i].image_route+'" alt="" />'+ 
              '<div>'+ 
                '<p>'+data.datos[i].name_prod+'</p>'+ 
                '<span>Price: $'+data.datos[i].price_prod+'</span>'+ 
                '<p>Date: '+data.datos[i].date_order+'</p>'+ 
                '<p>State: '+data.datos[i].state_order_text+'</p>'+ 
                '<p>Address: '+data.datos[i].address_order+'</p>'+ 
                '<p>Phone: '+data.datos[i].phone_order+'</p>'+ 
                '<p>Card: '+data.datos[i].card_order+'</p>'+ 
                '</div>'+ 
            '</div>'+ 
          '</td>'+ 
          // <td><input type="number" value="1" min="1" /></td>'+ 
          '<td>$'+data.datos[i].price_prod+'</td>'+ 
        '</tr>'+
        '</table>';
        if (data.datos[i].state_order=="2") {
          monto+=parseFloat(data.datos[i].price_prod);
        }
    
            }
          document.getElementById("mtotal").innerHTML=monto;
            document.getElementById("tableprods").innerHTML=html;
         },
        error:function(err){
            console.error(err);
        }
    });
});






</script>

  </body>
</html>
