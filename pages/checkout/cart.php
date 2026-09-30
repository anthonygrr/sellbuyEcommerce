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
        <thead>
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody id="cartRows"></tbody>
      </table>

      <div class="delivery-box">
        <h4>Delivery address</h4>
        <p id="deliveryText"></p>
      </div>

      <div class="total-price">
     
        <table></table>

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
         <button type="button" class="checkout btn" id="payMP" onclick="pay_with_mp()"
           style="display:inline-block;background-color:#000;color:#fff;padding:0.7rem 1.6rem;font-weight:700;border-radius:3rem;border:none;font-size:1.6rem;cursor:pointer;margin-top:1rem;">Pay with Mercado Pago</button>
        
      </div> 
     

    </div>


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

// Renders the cart: one row per product (quantity, unit price and line
// subtotal), the cart total and the empty state.
// Escapes DB-sourced values before they go into innerHTML strings.
function esc(value) {
    return String(value).replace(/[&<>"']/g, function (c) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
    });
}

function loadCart() {
    $.ajax({
        url:'/backend/order/to_process.php',
        type:'POST',
        data:{},
        success:function(data){
            var items = (data && data.datos) ? data.datos : [];
            var html='';
            var totalItems=0;
            var totalAmount=0;

            for (var i = 0; i < items.length; i++) {
                var item=items[i];
                var price=parseFloat(item.price_prod);
                if (isNaN(price)) { price=0; }
                var qty=parseInt(item.qty,10);
                if (isNaN(qty) || qty<0) { qty=0; }
                var codeProd=parseInt(item.code_prod,10);
                if (isNaN(codeProd)) { codeProd=0; }
                var subtotal=price*qty;
                totalItems+=qty;
                totalAmount+=subtotal;

                html+=
                '<tr>'+
                  '<td>'+
                    '<div class="cart-info">'+
                      '<img src="/images/products/'+esc(item.image_route)+'" alt="" />'+
                      '<div>'+
                        '<strong>'+esc(item.name_prod)+'</strong>'+
                        '<span>Unit price: $'+esc(item.price_prod)+'</span>'+
                        '<a href="#" class="cart-remove" data-code-prod="'+codeProd+'">Remove</a>'+
                      '</div>'+
                    '</div>'+
                  '</td>'+
                  '<td class="cart-qty">'+qty+'</td>'+
                  '<td>$'+subtotal.toFixed(2)+'</td>'+
                '</tr>';
            }

            if (!items.length) {
                html='<tr><td colspan="3" class="cart-empty">Your cart is empty</td></tr>';
            }
            document.getElementById("cartRows").innerHTML=html;

            $(".total-price table").html(
                '<tr>'+
                  '<td>Total ('+totalItems+' items)</td>'+
                  '<td>$'+totalAmount.toFixed(2)+'</td>'+
                '</tr>'
            );
        },
        error:function(err){
            console.error(err);
        }
    });
}

// Asks for confirmation first, then hits the removal endpoint.
function remove_from_cart(codeProd) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon:'question',
            title:'Remove this product?',
            text:'This product will be removed from your cart.',
            showCancelButton:true,
            confirmButtonText:'Remove',
            cancelButtonText:'Cancel'
        }).then(function(result){
            if (result.isConfirmed) {
                doRemoveFromCart(codeProd);
            }
        });
    }
    else{
        if (confirm('Remove this product from your cart?')) {
            doRemoveFromCart(codeProd);
        }
    }
}

function doRemoveFromCart(codeProd) {
    $.ajax({
        url:'/backend/order/remove_from_cart.php',
        type:'POST',
        data:{code_prod:codeProd},
        success:function(data){
            if (data.state) {
                notifySuccess(data.detail);
                loadCart();
            }
            else if (data.open_login) {
                window.location.href="/pages/auth/signin.php";
            }
            else{
                notifyError(data.detail);
            }
        },
        error:function(err){
            console.error(err);
        }
    });
}

$(document).ready(function(){
    loadCart();

    // Delegated: rows are re-rendered on every loadCart().
    $('#cartRows').on('click','a.cart-remove',function(event){
        event.preventDefault();
        remove_from_cart($(this).attr('data-code-prod'));
    });

    // Prefill delivery data from the profile, only into fields the user
    // has not filled in yet (never clobbers what is typed afterwards).
    // The same response also feeds the delivery address box.
    $.ajax({
        url:'/backend/user/get_user_info.php',
        type:'POST',
        data:{},
        success:function(data){
            var profile = (data.dates && data.dates.length) ? data.dates[0] : null;
            var addressInput = document.getElementById("address_user");
            var phoneInput = document.getElementById("phone_user");
            var deliveryEl = document.getElementById("deliveryText");

            var addressParts = [];
            var addressFields = ['address_user','city_user','region_user','zip_user','country_user'];
            var phoneText = "";
            if (profile) {
                for (var a = 0; a < addressFields.length; a++) {
                    var part = (profile[addressFields[a]] || "").trim();
                    if (part !== "") {
                        addressParts.push(part);
                    }
                }
                phoneText = (profile.phone_user || "").trim();
            }
            var addressText = addressParts.join(", ");

            if (profile && addressInput && addressInput.value === "") {
                addressInput.value = addressText;
            }
            if (profile && phoneInput && phoneInput.value === "") {
                phoneInput.value = phoneText;
            }

            if (deliveryEl) {
                if (addressParts.length) {
                    var deliveryText = addressText;
                    if (phoneText !== "") {
                        deliveryText += " \u2014 phone: " + phoneText;
                    }
                    deliveryEl.textContent = deliveryText;
                }
                else{
                    deliveryEl.textContent = "No delivery address saved in your profile yet. Fill it below or in your profile.";
                }
            }
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


// Mercado Pago Checkout Pro: create a preference server-side and leave
// the site for the hosted checkout (redirect flow). The manual
// process_buy() flow above stays untouched.
function pay_with_mp() {
  var btn = document.getElementById("payMP");
  if (btn.disabled) {
    return;
  }
  btn.disabled = true;
  btn.style.opacity = "0.6";

  $.ajax({
    url:'/backend/payment/create_preference.php',
    type:'POST',
    data:{},
    success:function(data){
      if (data.state && data.init_point) {
        window.location.href = data.init_point;
        return;
      }
      if (data.open_login) {
        window.location.href = "/pages/auth/signin.php";
        return;
      }
      notifyError(data.detail || "Could not start the payment");
      btn.disabled = false;
      btn.style.opacity = "1";
    },
    error:function(err){
      console.error(err);
      notifyError("Could not start the payment. Please try again");
      btn.disabled = false;
      btn.style.opacity = "1";
    }
  });
}





</script>

  </body>
</html>
