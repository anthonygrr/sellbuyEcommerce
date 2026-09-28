<?php

session_start();

if (!isset($_SESSION['code_user'])) {
    header('Location: /pages/auth/signin.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Favicon -->
  <link rel="shortcut icon" href="/images/hnet.com-image.ico" type="image/x-icon" />
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="/css/styles.css" />
  <link rel="stylesheet" href="/css/info.css">
  <title>Profile Info</title>
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
        
        <div class="container" id="userInfo">

        <h1>Profile Info</h1>
            
            <h2 id="nameUser"> </h2>
            
            <h2 id="uuuu"> </h2>
            

            <h4 class="about-title" id="emailUser"> </h4>
        </div>
    
                        <form action="/backend/user/modifyProfile.php" method="POST">
 
                <input type="text" placeholder="Name" name="newName" id="newName" required>

                <input type="text" placeholder="Second Name" name="newSN" id="newSN" required>

                <input type="password" placeholder="New password (leave empty to keep current)" name="newPassword" id="newPassword">

                <input type="text" placeholder="Address (street)" name="address_user" id="address_user">

                <input type="text" placeholder="City" name="city_user" id="city_user">

                <input type="text" placeholder="Region / State" name="region_user" id="region_user">

                <input type="text" placeholder="Zip Code" name="zip_user" id="zip_user">

                <input type="text" placeholder="Country" name="country_user" id="country_user">

                <input type="text" placeholder="Phone" name="phone_user" id="phone_user">

                <button > Update Info</button>
                </form>
               


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



    <script type="text/javascript">
    $(document).ready(function(){

        // Redirect result toasts (?updated=1 success, ?updated=0 failure).
        var params = new URLSearchParams(window.location.search);
        if (params.get('updated') === '1') {
            notifySuccess("Profile updated successfully");
        } else if (params.get('updated') === '0') {
            notifyError("Profile update failed");
        }

        $.ajax({
            url:'/backend/user/get_user_info.php',
            type:'POST',
            data:{

            },
            success:function(data){
                if (!data || !data.dates || data.dates.length === 0) {
                    return;
                }

                var user = data.dates[0];
                var html='';
                for (var i = 0; i < data.dates.length; i++) {
                  html+='<div class="1" id="userInfo">'+
                      '<h1>Profile Info</h1>'+
                      '<h2 id="nameUser"> Name: '+data.dates[i].name_user+'</h2>'+
                      '<h2 id="uuuu">SecondName: '+data.dates[i].secondname_user+'</h2>'+
                       '<h4 class="about-title" id="emailUser">E-mail: '+data.dates[i].email_user+'</h4>'+
                       '</div>';

                 }
                 document.getElementById("userInfo").innerHTML=html;

                 // Prefill the edit form (password is never prefilled).
                 $('#newName').val(user.name_user || '');
                 $('#newSN').val(user.secondname_user || '');
                 $('#newPassword').val('');
                 $('#address_user').val(user.address_user || '');
                 $('#city_user').val(user.city_user || '');
                 $('#region_user').val(user.region_user || '');
                 $('#zip_user').val(user.zip_user || '');
                 $('#country_user').val(user.country_user || '');
                 $('#phone_user').val(user.phone_user || '');

             },
             error:function(err){
                console.error(err);
            }
        });
    });
    </script> 
 
</body>

</html>
