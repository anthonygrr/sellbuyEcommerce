<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="/css/signin.css">
    <link rel="shortcut icon" href="/images/hnet.com-image.ico" type="image/x-icon" />
    <title>Sign In</title>
</head>
<body>




    <div class="container">

        <div class="left">
          
            <!-- <img src="/images/product1.jpg" alt="" srcset=""> -->
            <img src="/images/login/signin.jpg" alt="" srcset="" class="bg-left">

           <a href="/pages/index.php"> <img src="/images/logonegro.png" alt="" class="logo-left"></a>

            <h2>JOIN THE LARGEST WEBSITE COMMERCE IN THE WORLD</h2>

            <p>Explore the best prices & offers for the products. See our catalogue and enjoy buy by the safest mode </p>
        </div>

        <div class="right">

            <div class="formBox">
                <form action="/backend/auth/login.php" method="POST">
                        <h3>Sing In to SellBuy</h3>
                        <a href="/pages/index.php">
                        <img  src="/images/logonegro.png" alt="" class="img_hiden">
                        </a>
                        
                        <br>
                    <label for="email_u">Email</label>
                    <input type="email" id="email_u" name="email_u" placeholder=""  class="details" required>
                
                   
                   

                    <!-- <label for="lcemail">Confirm Email</label>
                    <input type="email" id="lcemail" name="lastname" placeholder="Confirm Your password" class="details" required> -->

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password_u" placeholder="" class="details" required>
                
<!--                     
                    <label for="birthday">Birthday</label>
                    <br>
                    <select id="month" name="country">
                      <option value="australia">Januaru</option>
                      <option value="canada">Canada</option>
                      <option value="usa">USA</option>
                    </select>
                    <select id="country" name="country">
                        <option value="australia">Australia</option>
                        <option value="canada">Canada</option>
                        <option value="usa">USA</option>
                      </select> -->
                  <br>
                    <input type="submit" value="Sign In">
                    <p>By clicking Join, I confirm that I have read and agree to the SellBuy Terms of Service, Privacy Policy, and to receive emails and updates.</p>
                    <br>

                    <?php 
                  if (isset($_GET['e'])) {
                      switch ($_GET['e']) {
                          case '1':
                            echo '<p>Conection Error</p>';
                              break;

                          case '2':
                            echo '<p>Invalid email</p>';
                                break;

                          case '3':
                            echo '<p>Incorrect Password</p>';
                                break;
                          
                      }
                  }
                  ?>
                    
                    <p>I Have no account. <a href="/pages/auth/signup.php">Sign Up</a></p>
                  </form>

                  

                
    
            </div>

            

        </div>
    </div>
</body>
</html>