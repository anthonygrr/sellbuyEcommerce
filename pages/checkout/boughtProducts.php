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
    <title>Buy History</title>
  </head>

  <body>

    <!-- Navigation -->
    <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>
    <!-- Bought Products -->
    <div class="container cart" id="cart_prods">

      <table class="bought-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody id="boughtRows"></tbody>
      </table>

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

// Renders the buy history: one row per bought product (quantity, line
// subtotal and status), the total spent and the empty state.
// Escapes DB-sourced values before they go into innerHTML strings.
function esc(value) {
    return String(value).replace(/[&<>"']/g, function (c) {
        return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
    });
}

function loadBoughtProducts() {
    $.ajax({
        url:'/backend/order/get_bought_products.php',
        type:'POST',
        data:{},
        success:function(data){
            var items = (data && data.datos) ? data.datos : [];
            var html='';
            var totalAmount=0;

            for (var i = 0; i < items.length; i++) {
                var item=items[i];
                var price=parseFloat(item.price_prod);
                if (isNaN(price)) { price=0; }
                var qty=parseInt(item.qty,10);
                if (isNaN(qty) || qty<0) { qty=0; }

                var subtotalText=(item.subtotal !== undefined && item.subtotal !== null && item.subtotal !== '')
                    ? String(item.subtotal)
                    : price.toFixed(2);
                var subtotal=parseFloat(subtotalText);
                if (isNaN(subtotal)) { subtotal=0; }
                totalAmount+=subtotal;

                html+=
                '<tr>'+
                  '<td>'+
                    '<div class="cart-info">'+
                      '<img src="/images/products/'+esc(item.image_route)+'" alt="" />'+
                      '<div>'+
                        '<p><strong>'+esc(item.name_prod)+'</strong></p>'+
                        '<span>Unit price: $'+esc(item.price_prod)+'</span>'+
                        '<p>Bought: '+esc(item.date)+'</p>'+
                      '</div>'+
                    '</div>'+
                  '</td>'+
                  '<td class="cart-qty">'+qty+'</td>'+
                  '<td>$'+esc(subtotalText)+'</td>'+
                  '<td>'+esc(item.state_order_text)+'</td>'+
                '</tr>';
            }

            if (!items.length) {
                html='<tr><td colspan="4"><p>No purchases yet - your bought products will appear here.</p></td></tr>';
            }
            else{
                html+=
                '<tr>'+
                  '<td colspan="2">Total spent</td>'+
                  '<td>$'+number_format(totalAmount, 2)+'</td>'+
                  '<td></td>'+
                '</tr>';
            }
            document.getElementById("boughtRows").innerHTML=html;
        },
        error:function(err){
            console.error(err);
        }
    });
}

// Formats a number like PHP number_format($n, 2, '.', ''):
// always two decimals, dot as decimal separator, no thousands grouping.
function number_format(number, decimals) {
    var value=parseFloat(number);
    if (isNaN(value)) { value=0; }
    return value.toFixed(decimals);
}

$(document).ready(function(){
    loadBoughtProducts();
});

</script>

  </body>
</html>
