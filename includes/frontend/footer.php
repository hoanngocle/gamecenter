<!-- Footer -->	
<div class="footer">
    <div class="footer-middle">
        <div class="container">
            <div class="footer-middle-in">
                <h6>About us</h6>
                <p style="text-align: justify">A global multichannel video game, consumer electronics and wireless services retailer with more than 6,600 stores worldwide.</p>
            </div>
            <div class="footer-middle-in">
                <h6>Information</h6>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Delivery Information</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>
            <div class="footer-middle-in">
                <h6>Customer Service</h6>
                <ul>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li><a href="#">Returns</a></li>
                    <li><a href="contact.html">Site Map</a></li>
                </ul>
            </div>
            <div class="footer-middle-in">
                <h6>My Account</h6>
                <ul>
                    <?php if (isset($_SESSION['fullname'])) { ?>
                        <li><a href="#" >Hi, <?= $_SESSION['fullname'] ?></a></li>    
                        <li><a href="#" id="modaltrigger">Full Profile</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    <?php } else { ?>
                        <li><a href="#" >Hi, Anonymous!</a></li>
                        <li><a href="#loginmodal" id="modaltrigger">Sign In</a></li>
                        <li><a href="#registermodal" id="reg">Sign Up</a></li>
                    <?php } ?>



                </ul>
            </div>
            <div class="footer-middle-in">
                <h6>Extras</h6>
                <ul>
                    <li><a href="#">Affiliates</a></li>
                    <li><a href="#">Specials</a></li>
                </ul>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>	
    <!---------------------------- Register Form Popup [start] --------------------------> 
    <div id="registermodal" style="display:none; width: 350px; font-family: 'Roboto'; margin-top: -286px;">
        <h1>Sign Up</h1>
        <h4>It's free and always will be.</h4>
        <form id="registerform" name="registerform" method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" name="username" size="20" maxlength="60" id="username" class="txtfield" tabindex="1" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">

            <label for="password">Password:</label>
            <input type="password" name="password" size="20" maxlength="60" id="password" class="txtfield" tabindex="2" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">

            <label for="email">Email:</label>
            <input type="password" name="email" size="20" maxlength="60" id="password" class="txtfield" tabindex="2" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">

            <label for="reemail">Confirm Email:</label>
            <input type="text" name="email" size="20" maxlength="60" id="password" class="txtfield" tabindex="2" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">

            <input type="radio" name="gender" value="male">  Male 
            <input type="radio" name="gender" value="female">  Female

            <label>Date Of Birth: </label>
            <input style="line-height: 20px" type="date" name="dateOfBirth" value=""><br>
            <h5>Have an account?<a href="#loginform" id="modaltrigger">Login</a> now!</h5>
            <br>
            <div class="center"><input type="submit" name="loginbtn" id="loginbtn" class="flatbtn-blu hidemodal" value="Sign Up" tabindex="3"></div>
        </form>
    </div>  

    <script type="text/javascript">
        $(function () {
            $('#registerform').submit(function (e) {
                return false;
            });

            $('#reg').leanModal({top: 50, overlay: 0.45, closeButton: ".hidemodal"});
        });
    </script>
    <!---------------------------- Register Form Popup [end] --------------------------> 

    <!---------------------------- Login Form Popup [start] -------------------------->    
    
    <div id="loginmodal" style="display:none; width: 350px; font-family: 'Roboto'; margin-top: -160px;">
        <h1>Sign In</h1>
        <form id="loginform" name="loginform" method="post" action="" >
            <label for="username">Username:</label>
            <input type="text" name="username" size="20" maxlength="60" id="username" class="txtfield" tabindex="1" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>">
            <div id="error"></div>

            <label for="password">Password:</label>
            <input type="password" name="password" size="20" maxlength="60" id="password" class="txtfield" tabindex="2" value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>">
            <div id="error"></div>

            <div class="center"><input type="submit" name="loginbtn" id="loginbtn" class="flatbtn-blu hidemodal" value="Log In" tabindex="3"></div>
        </form>
    </div>
    <script>
         $(function () {
            $('#loginform').submit(function (e) {
                return false;
            });

            $('#modaltrigger').leanModal({top: 50, overlay: 0.45, closeButton: ".hidemodal"});
        });
    </script>
    
    <!---------------------------- Login Form Popup [end] -------------------------->    

    <p class="footer-class">
        Copyright © 2015 - Game Center. All rights reserved<br>
        Design by  <a href="http://facebook.com/beo.sagittarius.93" target="_blank">Béo Sagitarius</a>
    </p>

    <!-------------------------------- onTop Button ------------------------------->
    <div id="goTop">  	
        <script type="text/javascript">
            $(function () {
                $(window).scroll(function () {
                    if ($(this).scrollTop() > 100)
                        $('#goTop').fadeIn();
                    else
                        $('#goTop').fadeOut();
                });
                $('#goTop').click(function () {
                    $('body,html').animate({scrollTop: 0}, 'slow');
                });
            });
        </script>
    </div>

    <!-------------------------------- onTop Button ------------------------------->
</div> 
</body>
</html>