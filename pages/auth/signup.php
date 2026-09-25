<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <link rel="stylesheet" href="/css/signup.css">
    <title>Sign Up</title>
    <link rel="shortcut icon" href="/images/hnet.com-image.ico" type="image/x-icon" />
</head>
<body>




    <div class="container">

        <div class="left">
          
            <!-- <img src="/images/product1.jpg" alt="" srcset=""> -->
            <img src="/images/login/signup.jpg" alt="" srcset="" class="bg-left">

        
            <a href="/pages/index.php"> <img src="/images/logoblanco.png" alt="" class="logo-left"></a>

            <h2>JOIN THE LARGEST WEBSITE COMMERCE IN THE WORLD</h2>

            <p>Explore the best prices & offers for the products. See our catalogue and enjoy buy by the safest mode </p>
        </div>

        <div class="right">

            <div class="formBox">
                <form action="/backend/auth/newProfile.php" method="POST">
                        <h3>Join to SELLBUY</h3>
                        <a href="/pages/index.php">
                        <img  src="/images/logonegro.png" alt="" class="img_hiden">
                        </a>
                        
                        <br>
                    <label for="firstname">First Name</label>
                    <input type="text" id="firstname" name="firstname" placeholder="Your name.."  class="details" required>
                
                    <label for="lastname">Last Name</label>
                    <input type="text" id="lastname" name="lastname" placeholder="Your last name.." class="details" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" class="details" required>

                    <!-- <label for="lcemail">Confirm Email</label>
                    <input type="email" id="lcemail" name="lastname" placeholder="Confirm Your password" class="details" required> -->

                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Your password" class="details" required>
                
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
                    <input type="submit" value="Sign Up">
                    <p>By clicking Sign Up, I confirm that I have read and agree to the SellBuy Terms of Service, Privacy Policy, and to receive emails and updates.</p>
                    <br>
                    <p>Have an account already? <a href="/pages/auth/signin.php">Sign In</a></p>
                  </form>

                
    
            </div>

            

        </div>
    </div>
</body>
</html>