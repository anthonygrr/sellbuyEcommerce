<?php 
 session_start();
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="/css/styles.css" />
  <title>Product Details</title>
</head>

<body>
 
  <!-- Navigation -->
  <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>

  <!-- Product Details -->
  <section class="section product-detail" id="product-detail">

    <div class="details container" id="details-container">
      <div class="left">
        <div class="main">
          <img id="productimage" src="" alt="" />
        </div>


        <div class="thumbnails" id="thumbnails">
          <div class="thumbnail">
            <img src="/images/products/bee-white-tenis.jpg" alt="" />
          </div>
          <div class="thumbnail">
            <img src="/images/products/blue-shirt.jpg" alt="" />
          </div>
          <div class="thumbnail">
            <img src="/images/products/blue-tenis.jpg" alt="" />
          </div>
          <div class="thumbnail">
            <img src="/images/products/fancy-shirt.jpg" alt="" />
          </div>
        </div>



      </div>
      <div class="right">
        <span>Home/T-shirt</span>
        <h1 id="producttitle" >Bambi Print Mini Backpack</h1>
        <div class="price" id="productprice">$50</div>

      <br>
        <div style="width:300px" class="terms">	
          
        Free shipping
        <br>
Free standard shipping for orders over $ MXN399.00
Estimated delivery on 06/12/2021 - 12/12/2021.
<br>
<br>
Free Return
<br>
<br>
</div>
        <form>
          <div>
           <select>
              <option value="Select Size" selected disabled>
                Select Size
              </option>
              <option value="1">32</option>
              <option value="2">42</option>
              <option value="3">52</option>
              <option value="4">62</option>
            </select> 
            <span><i class="fas fa-chevron-down"></i></span>
          </div>
        </form>

        <form class="form">
          <input type="text" placeholder="1" />
          <a href="#" class="addCart" onclick="iniciate_buy()">Add To Cart</a>
        </form>
        <h3>Product Detail</h3>
        <p id="productdesc">
          Lorem
        </p>
      </div>
    </div> 


  </section>

  <!-- Related Products -->
  <section class="section related-products">
    <div class="title">
      <h2>Related Products</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>
    <div class="product-layout container" id="relprod">

   

     
      
   
    </div>
  </section>

  <!-- Footer -->
  <?php include __DIR__ . "/../../backend/layouts/_footer.php"?>
  <!-- End Footer -->

  <!-- Custom Scripts -->
  <script src="/js/dark.js"></script>
  <script src="/js/products.js"></script>
  <script src="/js/slider.js"></script>
  <script src="/js/index.js"></script>
  <script  type="text/javascript" src="/js/search.js"></script>
  <script  type="text/javascript">
        var p='<?php echo $_GET["p"]; ?>'
    </script>

  <script type="text/javascript">
let charge=1;
    $(document).ready(function(){
        $.ajax({
            url:'/backend/product/get_all_products.php',
            type:'POST',
            data:{
                charge:1
            },
            success:function(data){
                console.log(data);

                let html='';

                
                for (var i = 0; i < data.datos.length; i++) {
                  if (data.datos[i].code_prod==p) {
                    document.getElementById("productimage").src="/images/products/"+data.datos[i].image_route;
                    document.getElementById("producttitle").innerHTML=data.datos[i].name_prod;
                    document.getElementById("productprice").innerHTML="$"+data.datos[i].price_prod;
                    document.getElementById("productdesc").innerHTML=data.datos[i].description_prod;
                  }
                     html+=
                      
      '<div class="product">'+
        '<div class="img-container">'+
        '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'"><img src="/images/products/'+data.datos[i].image_route+'" alt="" /></a>'+
          '<div class="addCart">'+
            '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'"><i class="fas fa-shopping-cart"></i></a>'+
          '</div>'+
          '<ul class="side-icons">'+
            '<span><i class="fas fa-search"></i></span>'+
            '<span><i class="far fa-heart"></i></span>'+
            '<span><i class="fas fa-sliders-h"></i></span>'+
          '</ul>'+
        '</div>'+
        '<div class="bottom">'+
          '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'">'+data.datos[i].name_prod+'</a>'+
          '<div class="price">'+
            '<span>$'+data.datos[i].price_prod+'</span>'+
          '</div>'+
        '</div>'+
      '</div>';

                }
                document.getElementById("relprod").innerHTML=html;
             },
            error:function(err){
                console.error(err);
            }
        });

        
          
        $.ajax({
            url:'/backend/product/get_all_offers.php',
            type:'POST',
            data:{},
            success:function(data){
                console.log(data);

                let html2='';

                
                for (var i = 0; i < data.offers.length; i++) {
                  if (data.offers[i].code_prod==p) {
                    document.getElementById("productimage").src="/images/products/"+data.offers[i].image_route;
                    document.getElementById("producttitle").innerHTML=data.offers[i].name_prod;
                    document.getElementById("productprice").innerHTML="$"+data.offers[i].price_prod;
                    document.getElementById("productdesc").innerHTML=data.offers[i].description_prod;
                  }
                     html2+=
                      
      '<div class="product">'+
        '<div class="img-container">'+
        '<a href="/pages/catalog/productDetails.php?p='+data.offers[i].code_prod+'"><img src="/images/products/'+data.offers[i].image_route+'" alt="" /></a>'+
          '<div class="addCart">'+
            '<a href="/pages/catalog/productDetails.php?p='+data.offers[i].code_prod+'"><i class="fas fa-shopping-cart"></i></a>'+
          '</div>'+
          '<ul class="side-icons">'+
            '<span><i class="fas fa-search"></i></span>'+
            '<span><i class="far fa-heart"></i></span>'+
            '<span><i class="fas fa-sliders-h"></i></span>'+
          '</ul>'+
        '</div>'+
        '<div class="bottom">'+
          '<a href="/pages/catalog/productDetails.php?p='+data.offers[i].code_prod+'">'+data.offers[i].name_prod+'</a>'+
          '<div class="price">'+
            '<span>$'+data.offers[i].price_prod+'</span>'+
          '</div>'+
        '</div>'+
      '</div>';

                }
                document.getElementById("relprod").innerHTML=html2;
             },
            error:function(err){
                console.error(err);
            }
        });




    });



    function iniciate_buy(){

      $.ajax({
            url:'/backend/auth/verify_login-buy.php',
            type:'POST',
            data:{
              code_prod:p
            },
            success:function(data){
                console.log(data);
                          if (data.state) {
                            notifySuccess(data.detail);
                          }else{
                            notifyError(data.detail);
                            if (data.open_login) {
                              open_login();
                            }
                            else{

                            }
                          }      
             },
            error:function(err){
                console.error(err);
            }
        });

    }

    function open_login() {
          window.location.href="/pages/auth/signin.php";
    }
    </script> 

</body>

</html>