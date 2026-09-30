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
  <title>Contact</title>
</head>

<body>
 
  <!-- Navigation -->
  <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>
  <!-- Product Details -->
  <div class="contact-bg">
    
      <div class="contact_form-div">
        <div class="icon-form">
        <i class="far fa-envelope"></i>
        </div>
      <h1 class="contact-title">Drop Us a Message</h1>
        <form action="">
          <input type="text" class="contact_formInputsUser"placeholder="NAME" id="nameContact"required> 
          <input type="email" class="contact_formInputsUser"placeholder="EMAIL" id="mailContact" required >
          <!-- <input type="text"class="contact_formTextsUser" placeholder="EMAIL"> -->
<textarea class="contact_formTextsUser" name="" id="textContact" cols="30" rows="10" placeholder="Write Us a Message" required></textarea>
                <button  class="contact_formButtonRed" onclick="sendMSG()">Send</button>
                <!-- <input class="contact_formButtonRed" type="button" value="Sumbit"> -->
        </form>
   
      </div>
      
    
  </div>

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


    function sendMSG() {
      let nameContact=document.getElementById("nameContact").value;
     let mailContact=document.getElementById("mailContact").value;
     let textContact=document.getElementById("textContact").value;

      if (nameContact=="" || mailContact=="" || textContact=="") {
        notifyWarning("Please fill the required elements");
      }
      else{
      notifySuccess("Message sent successfully");
    }
    }
</script>
</body>

</html>