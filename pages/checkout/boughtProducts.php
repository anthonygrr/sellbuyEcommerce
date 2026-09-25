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
  <!-- Glidejs -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.css">


  
  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="/css/styles.css" />
  <title>Ecommerce Website</title>

  <!-- AOS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>

<body>
  <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>
<!-- Navigation -->

<!-- 
<div class="search-menu">

  <input type="text" placeholder="Search all you want">
  <a href="#"> <i class="fas fa-search"></i></a>
</div> -->


  <!-- Promotion -->

  <!-- Products -->
  <!-- <section class="section products">
    <div class="title">
      <h2>New Products</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>

    <div class="product-layout" id="new_product-layout">

    

    </div>
  </section> -->



<!-- 
   50% off -->
  <section class="section products" id="50%">
    <div class="title">
      <h2>My Buys</h2>
      <span>There are all the products that you have bought</span>
    </div>

    <div class="product-layout" id="new_product-offer">



  
     

   
    
    </div>
  </section>

  


  <!-- BRANDS -->
  <section class="section brands" data-aos="fade-up"
  data-aos-anchor-placement="center-bottom">
    <div class="title">
      <h2>Shop by Brand</h2>
      <span>Select from the premium product brands and save plenty money</span>
    </div>

    <div class="brand-layout container">
      <div class="glide" id="glide1">
        <div class="glide__track" data-glide-el="track">
          <ul class="glide__slides">
            <li class="glide__slide">
              <img src="/images/brands/brand1.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="/images/brands/brand2.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="/images/brands/brand3.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="/images/brands/brand4.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="/images/brands/brand5.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="/images/brands/brand6.png" alt="">
            </li>
            <li class="glide__slide">
              <img src="/images/brands/brand7.png" alt="">
            </li>
            
            
          </ul>
        </div>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <?php include __DIR__ . "/../../backend/layouts/_footer.php"?>
  <!-- End Footer -->

  <!-- Glidejs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>

  <!-- Custom Scripts -->

  <script  src="/js/dark.js"></script>
  <script    src="/js/products.js"></script>
  <script   src="/js/slider.js"></script>
  <script    src="/js/index.js"></script>
  <script  type="text/javascript" src="/js/search.js"></script>

  <script type="text/javascript">
    AOS.init();
  </script>
  


  <script type="text/javascript">
 
    $(document).ready(function(){
        // $.ajax({
        //     url:'/backend/product/get_all_products.php',
        //     type:'POST',
        //     data:{},
        //     success:function(data){
        //         console.log(data);

        //         let html='';
               

        //         for (var i = 0; i < data.datos.length; i++) {
        //             html+=
        //             '<div class="product" data-aos="fade-up"'+
        //             'data-aos-anchor-placement="center-bottom">'+
        //               '<div class="img-container">'+
        //                 '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'"><img src="/images/products/'+data.datos[i].image_route+'" alt="" /></a>'+
        //                 '<div class="addCart">'+
        //                 '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'"><i class="fas fa-shopping-cart"></i> </a>'+
        //                 '</div>'+

        //                 '<ul class="side-icons">'+
        //           '<span><i class="fas fa-search"></i></span>'+
        //                 '<span><i class="far fa-heart"></i></span>'+
        //                   '<span><i class="fas fa-sliders-h"></i></span>'+
        //                   '</ul>'+
        //                   '</div>'+
        //                   '<div class="bottom">'+
        //                           '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'">'+data.datos[i].name_prod+'</a>'+
        //                     '<p>'+data.datos[i].description_prod+'</p>'+
        //                     '<div class="price">'+
        //                       '<span>$'+data.datos[i].price_prod+'</span>'+
        //                     '</div>'+
        //                   '</div>'+
        //           '</div>';
        //         }
        //    document.getElementById("new_product-layout").innerHTML=html;
        //      },
        //     error:function(err){
        //         console.error(err);
        //     }
        // });

        $.ajax({
          
            url:'/backend/order/get_all_orders.php',
            type:'POST',
            data:{
           
            },
            success:function(data){
                console.log(data);

                let offers='';
               

               
                  for (var i = 0; i < data.datos.length; i++) {
                  offers+=
                  '<div class="product" data-aos="fade-up" data-aos-duration="1000">'+
        '<div class="img-container">'+
        '<a href="/pages/checkout/order.php"><img src="/images/products/'+data.datos[i].image_route+'" alt="" /></a>'+
          '<div class="addCart">'+
          '<a href="/pages/checkout/order.php"><i class="fas fa-shopping-cart"></i> </a>'+
          '</div>'+
          '<ul class="side-icons">'+
            '<span><i class="fas fa-search"></i></span>'+
            '<span><i class="far fa-heart"></i></span>'+
            '<span><i class="fas fa-sliders-h"></i></span>'+
          '</ul>'+
        '</div>'+
        '<div class="bottom">'+
          '<a href="/pages/checkout/order.php">'+data.datos[i].name_prod+'</a>'+
          '<p>'+data.datos[i].description_prod+'</p>'+
          '<p>State: '+data.datos[i].state_order+'</p>'+
          '<p>Date: '+data.datos[i].date_order+'</p>'+
          '<p>Address: '+data.datos[i].address_order+'</p>'+
          '<div class="price">'+
            '<span>$'+data.datos[i].price_prod+'</span>'+
          '</div>'+
        '</div>'+
      '</div>';
              
                }
                document.getElementById("new_product-offer").innerHTML=offers;
             },
            error:function(err){
                console.error(err);
            }
        });
    });





    
    




  
 // OFFERS
      //          

     


</script>
</body>

</html>

