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
  <title>How To Buy</title>
</head>

<body>
 
  <!-- Navigation -->
  <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>

  <!-- Product Details -->
  <section class="section product-detail" id="product-detail" >
<div class="details container" id="details-container">
<div class="right"> 
<h3>ORDER</h3>
    <h1 id="producttitle" >Step 1</h1> 
    <div style="width:300px" class="terms">	     
    Sign In or Sign Up for iniciate to buy
      </div>
  </div>
  <div class="left">
    <div class="main" style="background:#fff">
      <img id="productimage" src="/images/logistic/order05.png" alt="" />
      <img id="productimage" src="/images/logistic/order06.png" alt="" />
    </div>
  </div>
</div> 
</section>


<!-- STEP 2 -->
  <section class="section product-detail" id="product-detail" style="margin-top:70px">
<div class="details container" id="details-container">
<div class="right"> 
    <h1 id="producttitle" >Step 2</h1>
    <div style="width:300px" class="terms">	 
    Add some / some items to your Cart.
    <br>
    Select size, color or quantity if necessary. For some items, we usually recommend the size for you.
      <br>
      <br>
      Click on "Add To Cart".
      <br>
      <br>
      </div>
  </div>
  <div class="left">
    <div class="main" style="background:#fff">
      <img id="productimage" src="/images/logistic/order01.png" alt="" />
    </div>
  </div>
</div> 
</section>

<!-- STEP 3 -->
<section class="section product-detail" id="product-detail" style="margin-top:70px">
<div class="details container" id="details-container">
<div class="right"> 
    <h1 id="producttitle" >Step 3</h1>
    <div style="width:300px" class="terms">	 
    Check once the selection is complete.
    <br>
    Click on the cart icon to review the selected item.
     
      </div>
  </div>
  <div class="left">
    <div class="main" style="background:#fff">
      <img id="productimage" src="/images/logistic/order02.png" alt="" />
    </div>
  </div>
</div> 
</section>

<!-- STEP 4 -->
<section class="section product-detail" id="product-detail" style="margin-top:70px">
<div class="details container" id="details-container">
<div class="right"> 
    <h1 id="producttitle" >Step 4</h1>
    <div style="width:300px" class="terms">	 
    Check the info of the article do you want.
    Select the Pay Method
    <br>
    Fill the address, card and phone number if you want to pay by Credit / Debit card method.Then click on Process Buy Button
      <br>
      <br>
      If you want to pay by transference, just click on Process buy Button.
      <br>
      <br>
      </div>
  </div>
  <div class="left">
    <div class="main" style="background:#fff">
      <img id="productimage" src="/images/logistic/order03.png" alt="" />
    </div>
  </div>
</div> 
</section>

<!-- STEP 5 -->
<section class="section product-detail" id="product-detail" style="margin-top:70px">
<div class="details container" id="details-container">
<div class="right"> 
    <h1 id="producttitle" >Step 5</h1>
    <div style="width:300px" class="terms">	 
    Check the state.
    <br>
    To delivery means the articles are incoming.
      <br>
      <br>
      The total to pay means that you have to pay by transfer method, when an article is already paid,
 the state changes to delivery.
      
      </div>
  </div>
  <div class="left">
    <div class="main" style="background:#fff">
      <img id="productimage" src="/images/logistic/order04.png" alt="" />
    </div>
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