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
          <div class="qty-stepper">
            <button type="button" class="qty-btn qty-dec" aria-label="Decrease quantity">&minus;</button>
            <input type="text" id="qtyInput" class="qty-value" value="1" inputmode="numeric" aria-label="Quantity" readonly />
            <button type="button" class="qty-btn qty-inc" aria-label="Increase quantity">+</button>
          </div>
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
              code_prod:p,
              quantity:get_valid_qty()
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

  <script type="text/javascript">
    /* Quantity stepper: +/- controls clamped to integers 1..99. */
    function get_valid_qty() {
      var input = document.getElementById("qtyInput");
      if (!input) return 1;
      var n = parseInt(input.value, 10);
      if (isNaN(n) || n < 1) n = 1;
      if (n > 99) n = 99;
      input.value = n;
      return n;
    }

    function step_qty(delta) {
      var n = get_valid_qty() + delta;
      if (n < 1) n = 1;
      if (n > 99) n = 99;
      var input = document.getElementById("qtyInput");
      if (input) input.value = n;
    }

    (function () {
      var dec = document.querySelector(".qty-dec");
      var inc = document.querySelector(".qty-inc");
      var input = document.getElementById("qtyInput");
      if (!dec || !inc || !input) return;
      dec.addEventListener("click", function () { step_qty(-1); });
      inc.addEventListener("click", function () { step_qty(1); });
      input.addEventListener("change", get_valid_qty);
      input.addEventListener("blur", get_valid_qty);
    })();

    /* Hover-lens zoom (Amazon-style) on the main product image. */
    (function () {
      var ZOOM = 2;    /* preview scale factor */
      var LENS = 120;  /* lens size in px */
      var PANEL = 300; /* preview panel size in px */
      var GAP = 16;    /* gap between the image and the panel */

      var main = document.querySelector(".product-detail .left .main");
      var img = document.getElementById("productimage");
      if (!main || !img) return;

      var lens = document.createElement("div");
      lens.className = "zoom-lens";
      lens.setAttribute("aria-hidden", "true");
      var panel = document.createElement("div");
      panel.className = "zoom-preview";
      panel.setAttribute("aria-hidden", "true");
      main.appendChild(lens);
      main.appendChild(panel);

      var activeSrc = "";

      /* The img frame uses object-fit: contain, so the visible picture can be
         letterboxed inside it. Returns that rect relative to .main (the
         absolute-positioning parent of lens/panel), or null if not measurable. */
      function image_rect() {
        var frameW = img.clientWidth, frameH = img.clientHeight;
        var natW = img.naturalWidth, natH = img.naturalHeight;
        if (!frameW || !frameH || !natW || !natH) return null;
        var scale = Math.min(frameW / natW, frameH / natH);
        var w = natW * scale, h = natH * scale;
        var imgBox = img.getBoundingClientRect();
        var mainBox = main.getBoundingClientRect();
        return {
          w: w,
          h: h,
          x: imgBox.left - mainBox.left + (frameW - w) / 2,
          y: imgBox.top - mainBox.top + (frameH - h) / 2
        };
      }

      function ready() {
        return !!img.getAttribute("src") && img.naturalWidth > 0;
      }

      function hide() {
        lens.style.display = "none";
        panel.style.display = "none";
        activeSrc = "";
      }

      function show(e) {
        if (!ready()) { hide(); return; }
        var rect = image_rect();
        if (!rect) { hide(); return; }
        activeSrc = img.src;
        panel.style.backgroundImage = 'url("' + img.src + '")';
        panel.style.backgroundSize = (rect.w * ZOOM) + "px " + (rect.h * ZOOM) + "px";
        lens.style.display = "block";
        panel.style.display = "block";
        update(e);
      }

      function update(e) {
        if (!activeSrc || img.src !== activeSrc || !ready()) { hide(); return; }
        var rect = image_rect();
        if (!rect) { hide(); return; }
        var mainBox = main.getBoundingClientRect();

        /* Cursor relative to .main (the origin used by absolutely positioned children). */
        var cx = e.clientX - mainBox.left;
        var cy = e.clientY - mainBox.top;
        /* Cursor relative to the visible picture. */
        var ix = cx - rect.x;
        var iy = cy - rect.y;

        /* Lens follows the cursor, clamped inside the image bounds. */
        var lx = Math.min(Math.max(ix - LENS / 2, 0), Math.max(rect.w - LENS, 0));
        var ly = Math.min(Math.max(iy - LENS / 2, 0), Math.max(rect.h - LENS, 0));
        lens.style.left = (rect.x + lx) + "px";
        lens.style.top = (rect.y + ly) + "px";

        /* Cursor percentage over the image drives the preview background-position. */
        var px = Math.min(Math.max(ix, 0), rect.w);
        var py = Math.min(Math.max(iy, 0), rect.h);
        panel.style.backgroundPosition =
          (px / rect.w) * 100 + "% " + (py / rect.h) * 100 + "%";

        /* Preview sits beside the image (right side, left fallback on overflow). */
        var left = rect.x + rect.w + GAP;
        if (mainBox.left + left + PANEL > window.innerWidth) left = rect.x - GAP - PANEL;
        if (mainBox.left + left < 0) left = 0;
        var top = Math.min(Math.max(cy - PANEL / 2, 0), Math.max(main.clientHeight - PANEL, 0));
        panel.style.left = left + "px";
        panel.style.top = top + "px";
      }

      function on_move(e) {
        if (!ready()) { hide(); return; }
        if (img.src !== activeSrc) { show(e); return; }
        update(e);
      }

      /* Listeners live on .main because the img src is filled asynchronously. */
      main.addEventListener("mouseenter", show);
      main.addEventListener("mousemove", on_move);
      main.addEventListener("mouseleave", hide);

      /* Hide/cleanup also when the src changes after the zoom is active. */
      if (window.MutationObserver) {
        new MutationObserver(hide).observe(img, {
          attributes: true,
          attributeFilter: ["src"]
        });
      }
    })();
  </script>

</body>

</html>