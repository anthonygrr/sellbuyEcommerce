<?php 

    session_start();
    if (!isset($_SESSION['code_user'])) {
       header('location: /pages/index.php');
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
         <!--  <tr>
            <td>Total</td>
            <td>$250</td>

          
             
          </tr> -->
        
        
        </table>
        <input type="text" placeholder="Address" class="address_inputs" id="address_user">   
             <input type="text" placeholder="Phone" class="address_inputs" id="phone_user">  
             <input type="text" placeholder="Credit/Debit Card" class="address_inputs" id="card_user">  
         <div class="container-type" id="payMethod"> 
  <h4 class="address_inputs-h4">
     <a href="/pages/checkout/payMethods.php">Pay Methods</a> </h4>

             <input class="address_inputs-radio" type="radio" name="typeMethod" value="1" id="type1">
          <label class="address_inputs-label" for="type1">Transference</label> 
          <br>
          <input class="address_inputs-radio" type="radio" name="typeMethod" value="2" id="type2">
          <label class="address_inputs-label" for="type2" title="Credit/Debit Card"> Card  </label> 
     </div>
        <a href="#" class="checkout btn" onclick="process_buy()">Process Buy</a>
        
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
    $.ajax({
        url:'/backend/order/to_process.php',
        type:'POST',
        data:{},
        success:function(data){
            console.log(data);

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
                '<p>State: '+data.datos[i].state_order+'</p>'+ 
                '<p>Address: '+data.datos[i].address_order+'</p>'+ 
                '<p>Phone: '+data.datos[i].phone_order+'</p>'+ 
                '<a href="#">remove</a>'+ 
              '</div>'+ 
            '</div>'+ 
          '</td>'+ 
          // <td><input type="number" value="1" min="1" /></td>'+ 
          '<td>$'+data.datos[i].price_prod+'</td>'+ 
        '</tr>'+
        '</table>';
            }
            document.getElementById("tableprods").innerHTML=html;
         },
        error:function(err){
            console.error(err);
        }
    });
});

function process_buy() {
  let address_user=document.getElementById("address_user").value;
  let phone_user=document.getElementById("phone_user").value;
  let card_user=document.getElementById("card_user").value;
  let pay_type=1;

  if (document.getElementById("type2").checked) {
    pay_type=2;
  }

			if (phone_user=="" || address_user=="") {
				notifyWarning("Please fill the address and phone fields");
			}else{
        if (!document.getElementById("type1").checked && !document.getElementById("type2").checked) {
              notifyWarning("Select the pay Method");
                }
                else{
                   if (pay_type==2) {
                      if (card_user=="") {
                        notifyWarning("if you want to pay with a credit or debit card you must fill the Card field");
                      }else{
                        $.ajax({
                              url:'/backend/order/confirm.php',
                              type:'POST',
                              data:{
                                address_user:address_user,
                                phone_user:phone_user,
                                pay_type:3,
                                card_user:card_user
                              
                                //token:''
                              },
                              success:function(data){
                                console.log(data);
                                if (data.state) {
                                  window.location.href="/pages/checkout/order.php";
                                }else{
                                  notifyError(data.detail);
                                }
                              },
                              error:function(err){
                                console.error(err);
                              }
                            });


                      }
                   }
                   else{ //Method 1 - pay by Transference
                    $.ajax({
                              url:'/backend/order/confirm.php',
                              type:'POST',
                              data:{
                                address_user:address_user,
                                phone_user:phone_user,
                                pay_type:1,
                                card_user:card_user
                              
                                //token:''
                              },
                              success:function(data){
                                console.log(data);
                                if (data.state) {
                                  window.location.href="/pages/checkout/order.php";
                                }else{
                                  notifyError(data.detail);
                                }
                              },
                              error:function(err){
                                console.error(err);
                              }
                            });

                   }
                

                }	
			}
}





</script>

  </body>
</html>
