<nav class="nav">
  <div class="wrapper container">
    <div class="logo"><a href="/pages/index.php">
      <img src="/images/logonegro.png" alt="" srcset="" id="sellbuy"> 
    </a>
  
    
  </div>
    <ul class="nav-list">
      <div class="top">
        <label for="" class="btn close-btn"><i class="fas fa-times"></i></label>
      
      </div>
      <li><a href="/pages/index.php">Home</a></li>
      <li><a href="/pages/catalog/products.php">Products</a></li>

<!--
      <li>
        <a href="" class="desktop-item">Shop <span>
          <i class="fas fa-chevron-down"></i> 
        
        </span></a>
        <input type="checkbox" id="showMega" />
        <label for="showMega" class="mobile-item">Shop <span><i class="fas fa-chevron-down"></i></span></label>
         <div class="mega-box">
          <div class="content">
            <div class="row">
              <img src="/images/woman.jpg" alt="" />
            </div>
            <div class="row">
              <header>Shop Layout</header>
              <ul class="mega-links">
                <li><a href="#">Shop With Background</a></li>
                <li><a href="#">Shop Mini Categories</a></li>
                <li><a href="#">Shop Only Categories</a></li>
                <li><a href="#">Shop Icon Categories</a></li>
              </ul>
            </div>
            <div class="row">
              <header>Filter Layout</header>
              <ul class="mega-links">
                <li><a href="#">Sidebar</a></li>
                <li><a href="#">Filter Default</a></li>
                <li><a href="#">Filter Drawer</a></li>
                <li><a href="#">Filter Dropdown</a></li>
              </ul>
            </div>
            <div class="row">
              <header>Product Layout</header>
              <ul class="mega-links">
                <li><a href="#">Layout Zoom</a></li>
                <li><a href="#">Layout Sticky</a></li>
                <li><a href="#">Layout Sticky 2</a></li>
                <li><a href="#">Layout Scroll</a></li>
              </ul>
            </div>
          </div>
        </div> 
      </li>
      <li><a href="">Blog</a></li>
   
      <li>
        <a href="" class="desktop-item">Vendors
            <span><i class="fas fa-chevron-down"></i></span>
          </a>
       <input type="checkbox" id="showdrop1" />
        <label for="showdrop1" class="mobile-item">Vendors <span><i class="fas fa-chevron-down"></i></span></label>
        <ul class="drop-menu1">
          <li><a href="">Vendor Store listings</a></li>
          <li><a href="">Store Details</a></li>
        </ul>
      </li>
      -->
      
      <li>
        <a href="" class="desktop-item">Page <span><i class="fas fa-chevron-down"></i></span></a>
        <input type="checkbox" id="showdrop2" />
        <label for="showdrop2" class="mobile-item">Page <span><i class="fas fa-chevron-down"></i></span></label>
        <ul class="drop-menu2">
          <li><a href="/pages/info/About.php">About</a></li>
          <li><a href="/pages/info/Contact.php">Contact</a></li>
          <li><a href="">Faq</a></li>
          <li><a href="/pages/info/404.php">Page 404</a></li>
         
          
        </ul>
      </li>
     

     
      <!-- <li>  <a href="#"> <i class="fas fa-search" id="search_bar"></i></a></li> -->
 

      <?php
        if (isset($_SESSION['code_user'])) {
        
        // echo '<h5 class="user_name-index">''</h5>';

  
        echo '<li>
                <a href="" class="desktop-item"> 
                    <i class="fas fa-user"> ' .$_SESSION['name_user']. '</i> 
                    <span>
                    <i class="fas fa-chevron-down"></i>
                    </span>
                </a>
                <input type="checkbox" id="showdrop3" />
                <label for="showdrop3" class="mobile-item"> 
                <i class="fas fa-user"> ' .$_SESSION['name_user']. '</i> 
                    <span><i class="fas fa-chevron-down"></i>
                    </span>
                </label>
                    <ul class="drop-menu3">
                              <li><a href="/pages/account/userInfo.php">My Profile</a></li>
                          <li><a href="/pages/checkout/boughtProducts.php">Buy History</a></li>
                          <li><a href="/pages/checkout/cart.php">My Cart</a></li>
                          <li><a href="/pages/checkout/order.php">My Pendient Orders</a></li>
                          <li><a href="">Faq</a>
                          </li><li><a href="/pages/auth/_logout.php">Log out</a></li>
                    </ul>
             </li>';


      //  echo'<li><a href="#" ><i class="fas fa-user"> </i> ' .$_SESSION['name_user'].'</a></li>';
          echo ' <li>  <a href="/pages/checkout/cart.php" > <i class="fas fa-shopping-cart"></i></a></li>';
      }else{
        ?>
        <li>
                <a href="/pages/auth/signin.php" class="desktop-item"> 
                    <i class="fas fa-user"></i> 
                    <span>
                    <i class="fas fa-chevron-down"></i>
                    </span>
                </a>
                <input type="checkbox" id="showdrop3" />
                <label for="showdrop3" class="mobile-item">
                <i class="fas fa-user"></i> 
                    <span><i class="fas fa-chevron-down"></i>
                    </span>
                </label>
                    <ul class="drop-menu3">
                          <li><a href="/pages/auth/signin.php">SignIn</a></li>
                          <li><a href="/pages/auth/signup.php">SignUp</a></li>
                    </ul>
             </li>
        <!-- <li>  <a href="/pages/auth/signin.php" > <i class="fas fa-user"> </i></a></li> -->
      

        <?php
      }
     ?>



    
 
     <li> <button class="switch" id="switch">
       <span><i class="fas fa-sun"></i></span>
       <span><i class="fas fa-moon"></i></span>
       
            </button> 
           
      </li>
  
     
      <!-- icons -->
      <!-- <li class="icons">
        <span>
          <img src="/images/shoppingBag.svg" alt="" />
          <small class="count d-flex">0</small>
        </span>
      <span> <a href="#"> <i class="fas fa-user"></i></a></span>
      </li> -->
    
    </ul>
    <div class="search-box">
      <input type="text" class="search_text" placeholder="Search products" id="searchID" value="<?php echo isset($_GET['text']) && is_string($_GET['text']) ? htmlspecialchars($_GET['text'], ENT_QUOTES, 'UTF-8') : ''; ?>">
      <a href="#" class="search-btn" onclick="searchProduct(); return false;" aria-label="Search"><i class="fas fa-search search_icon"></i></a>
    </div>
    <label for="" class="btn open-btn"><i class="fas fa-bars"></i></label>
    
  </div>
 
 
 
</div>
</nav>
<script>
/* Apply saved theme before first paint */
(function () {
  var savedTheme = null;
  try {
    savedTheme = localStorage.getItem('sellbuy-theme');
  } catch (e) {
    savedTheme = null;
  }

  if (savedTheme !== 'dark') {
    return; /* 'light' or absent: default markup is already light */
  }

  document.body.classList.add('dark');

  var switchBtn = document.getElementById('switch');
  if (switchBtn) {
    switchBtn.classList.add('active');
  }

  var logo = document.getElementById('sellbuy');
  if (logo && logo.src.indexOf('logonegro.png') !== -1) {
    logo.src = '/images/logoblanco.png';
  }
})();
</script>
