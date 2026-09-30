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

  <!-- <div class="hero">
    <div class="left"  data-aos="fade-right">
      <span  data-aos="fade-right">Exclusive Sales</span>
      <h1>UP TO 50% OFF ON SALES</h1>
      <small>Get all exclusive offers for the season</small>
      <a href="#50%">View Collection </a>
    </div>
    <div class="right">
      <img src="/images/hero.png" alt="" />
    </div>
  </div> -->

  <!-- Promotion -->

  <!-- <section class="section promotion">
    <div class="title">
      <h2>Shop Collections</h2>
      <span>Select from the premium product and save plenty money</span>
    </div>

    <div class="promotion-layout container">

      <div class="promotion-item" data-aos="fade-right">
        <img src="/images/products/promotions/promo1.jpg" alt="" />
        <div class="promotion-content">
          <h3>FOR MEN</h3>
          <a href="">SHOP NOW</a>
        </div>
      </div>

      <div class="promotion-item" data-aos="zoom-in-up">
        <img src="/images/products/promotions/promo2.jpg" alt="" />
        <div class="promotion-content">
          <h3>CASUAL SHOES</h3>
          <a href="">SHOP NOW</a>
        </div>
      </div>

      <div class="promotion-item" data-aos="fade-left">
        <img src="/images/products/promotions/promo3.jpg" alt="" />
        <div class="promotion-content">
          <h3>FOR WOMEN</h3>
          <a href="">SHOP NOW</a>
        </div>
      </div>

      <div class="promotion-item" data-aos="fade-right">
        <img src="/images/products/promotions/promo4.jpg" alt="" />
        <div class="promotion-content">
          <h3>LEATHER BELTS</h3>
          <a href="">SHOP NOW</a>
        </div>
      </div>

      <div class="promotion-item" data-aos="zoom-in-up">
        <img src="/images/products/promotions/promo5.jpg" alt="" />
        <div class="promotion-content">
          <h3>DESIGNER BAGS</h3>
          <a href="">SHOP NOW</a>
        </div>
      </div>

      <div class="promotion-item" data-aos="fade-left">
        <img src="/images/products/promotions/promo6.jpg" alt="" />
        <div class="promotion-content">
          <h3>WATCHES</h3>
          <a href="">SHOP NOW</a>
        </div>
      </div>
    </div>
  </section> -->

  <!-- Products -->
  <section class="section products">
    <div class="title">
      <h2 id="resulTextH2">Results for</h2>
      <span id="resulText"> "<?php echo htmlspecialchars(isset($_GET['text']) && is_string($_GET['text']) ? $_GET['text'] : '', ENT_QUOTES, 'UTF-8'); ?>"</span>
    </div>

    <div class="product-layout" id="new_product-layout">

    

    </div>
  </section>




  
  <!-- ADVERT -->
  <section class="section advert" data-aos="fade-right">
    <div class="advert-layout container">
      <div class="item ">
        <img src="/images/products/promotions/promo7.jpg" alt="">
        <div class="content left">
          <span>Exclusive Sales</span>
          <h3>Spring Collections</h3>
          <a href="/pages/catalog/products.php">View Collection</a>
        </div>
      </div>
      <div class="item" data-aos="fade-left">
        <img src="/images/products/promotions/promo8.jpg" alt="">
        <div class="content  right">
          <span>New Trending</span>
          <h3>Designer Bags</h3>
          <a href="/pages/catalog/products.php">Shop Now </a>
        </div>
      </div>
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
let text = <?php echo json_encode($_GET['text'] ?? '', JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;
    $(document).ready(function(){
        let trimmedText = (typeof text === "string" ? text : "").trim();
        if (trimmedText === "") {
            document.getElementById("resulTextH2").innerHTML = "Search products";
            document.getElementById("resulText").innerHTML = "Type a query in the search bar to find products.";
            return;
        }
        $.ajax({
          url:'/backend/product/get_all_results.php',
          type:'POST',
        data:{
          text: text
        },
           success:function(data){
               console.log(data);

              let html='';
               

         for (var i = 0; i < data.datos.length; i++) {
                     html+=
                '<div class="product" data-aos="fade-up"'+
                  'data-aos-anchor-placement="center-bottom">'+
                     '<div class="img-container">'+
                     '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'"><img src="/images/products/'+data.datos[i].image_route+'" alt="" /></a>'+
                       '<div class="addCart">'+
                         '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'"><i class="fas fa-shopping-cart"></i> </a>'+
                      '</div>'+

                        '<ul class="side-icons">'+
            '<span><i class="fas fa-search"></i></span>'+
                      '<span><i class="far fa-heart"></i></span>'+
                         '<span><i class="fas fa-sliders-h"></i></span>'+
                         '</ul>'+
                          '</div>'+
                           '<div class="bottom">'+
                                 '<a href="/pages/catalog/productDetails.php?p='+data.datos[i].code_prod+'">'+data.datos[i].name_prod+'</a>'+
                           '<p>'+data.datos[i].description_prod+'</p>'+
                            '<div class="price">'+
                             '<span>$'+data.datos[i].price_prod+'</span>'+
                            '</div>'+
                         '</div>'+
                  '</div>';
                 }

                 if (html=='') {
                  
                  document.getElementById("resulTextH2").innerHTML="No RESULTS";
                  document.getElementById("resulText").innerHTML="";
                 }
                 else{
                  document.getElementById("new_product-layout").innerHTML=html;

                 }
        
             },
             error:function(err){
                 console.error(err);
             }
         });

    });

</script>
</body>

</html>

