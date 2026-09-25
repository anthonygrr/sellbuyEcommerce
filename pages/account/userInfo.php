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
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="/css/styles.css" />
  <link rel="stylesheet" href="/css/info.css">
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
        
        <div class="container" id="userInfo">

        <h1>Profile Info</h1>
            
            <h2 id="nameUser"> </h2>
            
            <h2 id="uuuu"> </h2>
            

            <h4 class="about-title" id="emailUser"> </h4>
        </div>
    
                        <form action="/backend/user/modifyProfile.php" method="POST">
 
                <input type="text" placeholder="Name" name="newName" id="newName" required>

                <input type="text" placeholder="Second Name" name="newSN"id="newSN" required>

                <input type="password" placeholder="Password" name="newPassword" id="newPassword" required>

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
    
        $.ajax({
            url:'/backend/user/get_user_info.php',
            type:'POST',
            data:{

            },
            success:function(data){
                console.log(data);

                let html='';
                for (var i = 0; i < data.dates.length; i++) {
                  html+='<div class="1" id="userInfo">'+
                      '<h1>Profile Info</h1>'+
                      '<h2 id="nameUser"> Name: '+data.dates[i].name_user+'</h2>'+
                      '<h2 id="uuuu">SecondName: '+data.dates[i].secondname_user+'</h2>'+
                       '<h4 class="about-title" id="emailUser">E-mail: '+data.dates[i].email_user+'</h4>'+
                       '</div>';

                 }
                 document.getElementById("userInfo").innerHTML=html;
              
             },
             error:function(err){
                console.error(err);
            }
        });
    });
  
   

//  function check_Info(){
//         let name=document.getElementById("newName").value;
//         let secondName=document.getElementById("newSN").value;
//         let password=document.getElementById("newPassword").value;
     
//       if (Name==""||Password=="" || secondName=="") {
//         alert("Please fill all the fields");
//       } else {
//         alert("Your information has been modified succefully!");
//       }
//     }
    </script> 
 
</body>

</html>