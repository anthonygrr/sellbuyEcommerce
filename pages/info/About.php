<?php 

session_start();

    ?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="/images/hnet.com-image.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="/css/styles.css" />
  <title>About Us</title>
</head>

<body>
 
  <!-- Navigation -->
  <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>
  <!-- Product Details -->
  <section class="section product-detail">
    <div class="details container">
      <div class="left">
        <div class="main-abt">
          <img src="/images/about-logo.png" alt="" />
        </div>
      
      </div>
      <div class="right">
        
        <h1>About Us</h1>
       
        <p>
          WE ARE SELLBUY we are an online store of B2C fashion of e-commerce. Our online store is mainly focused on men's and women's youth clothing, but also offers items and accessories, shoes, bags and other fashion items. Our online store has a presence throughout the national territory. The brand was created in October 2021, in Ciudad Hidalgo, mich, with the slogan "everyone has the right to enjoy the beauty of fashion".
        </p>
<br>

        <h2 class="about-title">Our Vision</h2>
<br>
        <p>Our Vision is To be the best purchase option offering you different brands and the originality of products of well-known brands in the commercial market at the best price, with shipments throughout the country.</p>

<br>
        <h2 class="about-title">Our Mission</h2>
<br>
        <p>Commit to finding fashion and style within reach of your bags such as clothes, footwear, articles and accessories, with quality products for your day to day, and accompany you in your needs and desires, bringing you closer to a world of possibilities.</p>
 <br>
 <!--
        <h2 class="about-title">Objectives</h2>
      
        <ul>
          <li>Reduce Order management Costs & Repurpose Staff</li>
        <li>Eliminate Order Errors</li>
        <li>Increase Order Numbers</li>
        <li>Improve Customer Experience</li>
        <li> Differentiate and Personalize</li>
      </ul>
      <br> -->

        <h2 class="about-title">Values</h2>
        <br>
        <p>Productivity, teamwork, innovation, integrity, trust, attention and service</p>
      </div>
    </div>
  </section>

  <!-- Related Products -->

  <!-- Footer -->
  <?php include __DIR__ . "/../../backend/layouts/_footer.php"?>
  <!-- End Footer -->

  <!-- Custom Scripts -->
  <script src="/js/dark.js"></script>
  <script src="/js/products.js"></script>
  <script src="/js/slider.js"></script>
  <script src="/js/index.js"></script>
  <script  type="text/javascript" src="/js/search.js"></script>
</body>

</html>